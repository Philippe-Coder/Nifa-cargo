<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facture;
use App\Models\Paiement;
use App\Services\PaiementService;
use Illuminate\Support\Facades\Auth;

class PaiementController extends Controller
{
    protected $paiementService;

    public function __construct(PaiementService $paiementService)
    {
        $this->paiementService = $paiementService;
    }

    /**
     * Afficher la page de paiement pour une facture
     */
    public function show(Facture $facture)
    {
        // Vérifier que l'utilisateur peut payer cette facture
        if (Auth::id() !== $facture->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Non autorisé');
        }

        if ($facture->estPayee()) {
            return redirect()->route('client.suivi.show', $facture->demande_transport_id)
                ->with('info', 'Cette facture est déjà payée.');
        }

        $methodesDisponibles = PaiementService::getMethodesDisponibles();
        
        return view('paiement.show', compact('facture', 'methodesDisponibles'));
    }

    /**
     * Initier un paiement
     */
    public function initier(Request $request, Facture $facture)
    {
        $request->validate([
            'methode_paiement' => 'required|string',
            'phone' => 'nullable|string|max:20'
        ]);

        // Vérifier les permissions
        if (Auth::id() !== $facture->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Non autorisé');
        }

        if ($facture->estPayee()) {
            return response()->json([
                'success' => false,
                'error' => 'Cette facture est déjà payée'
            ]);
        }

        $donneesClient = [
            'phone' => $request->phone,
            'email' => Auth::user()->email,
            'name' => Auth::user()->name
        ];

        $resultat = $this->paiementService->initierPaiement(
            $facture,
            $request->methode_paiement,
            $donneesClient
        );

        return response()->json($resultat);
    }

    /**
     * Page de succès
     */
    public function success(Request $request)
    {
        $message = 'Paiement effectué avec succès !';
        
        // Traiter le callback Stripe si présent
        if ($request->has('session_id')) {
            $this->paiementService->traiterCallback('stripe', [
                'session_id' => $request->session_id
            ]);
        }

        return view('paiement.success', compact('message'));
    }

    /**
     * Page d'annulation
     */
    public function cancel()
    {
        $message = 'Paiement annulé.';
        return view('paiement.cancel', compact('message'));
    }

    /**
     * Callback pour Flooz
     */
    public function callbackFlooz(Request $request)
    {
        $this->paiementService->traiterCallback('flooz', $request->all());
        return response()->json(['status' => 'ok']);
    }

    /**
     * Callback pour T-Money
     */
    public function callbackTMoney(Request $request)
    {
        $this->paiementService->traiterCallback('tmoney', $request->all());
        return response()->json(['status' => 'ok']);
    }

    /**
     * Webhook Stripe
     */
    public function webhookStripe(Request $request)
    {
        // Vérifier la signature Stripe ici
        $this->paiementService->traiterCallback('stripe', $request->all());
        return response()->json(['status' => 'ok']);
    }

    /**
     * Historique des paiements pour un client
     */
    public function historique(Request $request)
    {
        // Récupérer les paramètres de filtrage
    $reference = $request->input('reference');
        $statut = $request->input('statut');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        
        // Construire la requête avec les filtres
        $query = Paiement::with(['facture.demandeTransport'])
            ->where('user_id', Auth::id())
            ->when($reference, function($q) use ($reference) {
                return $q->where(function ($sub) use ($reference) {
                    $sub->where('reference_paiement', 'like', "%{$reference}%")
                        ->orWhere('gateway_reference', 'like', "%{$reference}%");
                });
            })
            ->when($statut, function($q) use ($statut) {
                return $q->where('statut', $statut);
            })
            ->when($dateDebut, function($q) use ($dateDebut) {
                return $q->whereDate('created_at', '>=', $dateDebut);
            })
            ->when($dateFin, function($q) use ($dateFin) {
                return $q->whereDate('created_at', '<=', $dateFin);
            });
        
        // Calculer les statistiques
        $stats = [
            'total_payes' => (clone $query)->where('statut', 'payé')->sum('montant'),
            'count_payes' => (clone $query)->where('statut', 'payé')->count(),
            'total_en_attente' => (clone $query)->where('statut', 'en_attente')->sum('montant'),
            'count_en_attente' => (clone $query)->where('statut', 'en_attente')->count(),
            'total_echoues' => (clone $query)->whereIn('statut', ['échoué', 'annulé'])->sum('montant'),
            'count_echoues' => (clone $query)->whereIn('statut', ['échoué', 'annulé'])->count(),
        ];
        
        // Récupérer les paiements paginés
        $paiements = $query->latest()->paginate(15);
        
        // Si c'est une requête AJAX, retourner la vue partielle
        if ($request->ajax()) {
            return [
                'html' => view('paiements.partials.table', compact('paiements'))->render(),
                'pagination' => (string) $paiements->links()
            ];
        }
        
        return view('paiements.historique', compact('paiements', 'stats'));
    }
}
