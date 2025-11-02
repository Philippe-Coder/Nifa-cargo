<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeTransport;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DemandeTransportController extends Controller
{
    public function index(Request $request)
    {
        $query = DemandeTransport::with('user');

        // Filtrage par statut
        if ($request->filled('statut') && $request->statut !== 'tous') {
            $query->where('statut', $request->statut);
        }

        // Recherche par référence, nom client, email, ou numéro de tracking
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                    $q->where('numero_tracking', 'like', "%{$searchTerm}%")
                  ->orWhere('numero_tracking', 'like', "%{$searchTerm}%")
                  ->orWhere('marchandise', 'like', "%{$searchTerm}%")
                  ->orWhere('origine', 'like', "%{$searchTerm}%")
                  ->orWhere('destination', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%")
                               ->orWhere('email', 'like', "%{$searchTerm}%")
                               ->orWhere('telephone', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filtrage par période
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $demandes = $query->latest()->paginate(15)->withQueryString();

        // Statistiques pour les cartes
        $totalDemandes = DemandeTransport::count();
        $enAttente = DemandeTransport::where('statut', 'en_attente')->count();
        $enCours = DemandeTransport::whereIn('statut', ['en_cours', 'en_transit'])->count();
        $livrees = DemandeTransport::where('statut', 'livree')->count();

        return view('admin.demandes.index', compact(
            'demandes', 
            'totalDemandes', 
            'enAttente', 
            'enCours', 
            'livrees'
        ));
    }

    public function show($id)
    {
        $demande = DemandeTransport::with([
            'user', 
            'etapes.agent',
            'etapes.documents.user',
            'documents.uploadedBy'
        ])->findOrFail($id);
        return view('admin.demandes.show', compact('demande'));
    }

    public function updateStatut(Request $request, $id)
    {
        $demande = DemandeTransport::findOrFail($id);
        $ancienStatut = $demande->statut;
        
        // Exiger un numéro de suivi pour traiter la demande (changer le statut hors "en attente")
        $nouveauStatut = $request->statut;
        if ($nouveauStatut !== 'en attente' && empty($demande->numero_tracking)) {
            return redirect()->back()->with('error', "Vous devez d'abord définir le numéro de suivi (max 7 chiffres) avant de traiter la demande.");
        }

        // Mettre à jour le statut
        $demande->update(['statut' => $request->statut]);
        
        // Envoyer une notification à l'utilisateur
        if ($demande->user_id) {
            switch ($request->statut) {
                case 'en_cours':
                    NotificationService::notifyStatusChange($demande, $ancienStatut, 'en_cours');
                    break;
                case 'terminee':
                    NotificationService::notifyStatusChange($demande, $ancienStatut, 'terminee');
                    break;
                case 'annulee':
                    NotificationService::notifyStatusChange($demande, $ancienStatut, 'annulee');
                    break;
                case 'refusee':
                    $raison = $request->input('raison', '');
                    NotificationService::notifyDemandeRefusee($demande, $raison);
                    break;
            }
        }
        return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
    }

    /**
     * Télécharger la demande en PDF
     */
    public function downloadPDF($id)
    {
        $demande = DemandeTransport::with([
            'user', 
            'etapes.agent',
            'etapes.documents.user'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('admin.demandes.pdf', compact('demande'))
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true
            ]);

        $filename = 'demande-' . ($demande->numero_tracking ?? 'TRK-' . $demande->id) . '.pdf';
        
        return $pdf->download($filename);
    }

    public function destroy($id)
    {
        DemandeTransport::destroy($id);
        return redirect()->back()->with('success', 'Demande supprimée.');
    }

    /**
     * Mettre à jour le numéro de suivi (7 chiffres max)
     */
    public function updateTracking(Request $request, $id)
    {
        $demande = DemandeTransport::findOrFail($id);

        $validated = $request->validate([
            'numero_tracking' => ['required', 'regex:/^\d{1,7}$/', 'unique:demande_transports,numero_tracking,' . $demande->id],
        ], [
            'numero_tracking.required' => 'Le numéro de suivi est obligatoire.',
            'numero_tracking.regex' => 'Le numéro de suivi doit contenir uniquement des chiffres (max 7).',
            'numero_tracking.unique' => 'Ce numéro de suivi est déjà utilisé.',
        ]);

        $demande->numero_tracking = $validated['numero_tracking'];
        $demande->save();

        // Notifier le client par Email + WhatsApp
        try {
            \App\Services\NotificationService::notifyTrackingUpdated($demande);
        } catch (\Throwable $e) {
            // Ne pas bloquer le flux si l'envoi échoue
        }

        return redirect()->back()->with('success', 'Numéro de suivi mis à jour avec succès. Le client a été notifié.');
    }

    /**
     * Exporter les demandes en CSV
     */
    public function export(Request $request)
    {
        $query = DemandeTransport::with('user');

        // Appliquer les mêmes filtres que l'index
        if ($request->filled('statut') && $request->statut !== 'tous') {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                    $q->where('numero_tracking', 'like', "%{$searchTerm}%")
                  ->orWhere('numero_tracking', 'like', "%{$searchTerm}%")
                  ->orWhere('marchandise', 'like', "%{$searchTerm}%")
                  ->orWhere('origine', 'like', "%{$searchTerm}%")
                  ->orWhere('destination', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%")
                               ->orWhere('email', 'like', "%{$searchTerm}%")
                               ->orWhere('telephone', 'like', "%{$searchTerm}%");
                  });
            });
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $demandes = $query->latest()->get();

        $filename = 'demandes-' . date('Y-m-d-H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($demandes) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'Numéro de suivi',
                'Client',
                'Email Client', 
                'Téléphone Client',
                'Type',
                'Marchandise',
                'Poids (kg)',
                'Volume',
                'Origine',
                'Destination',
                'Statut',
                'Date Création',
                'Date Souhaitée',
                'Valeur',
                'Fragile'
            ]);

            // Données
            foreach ($demandes as $demande) {
                fputcsv($file, [
                    $demande->numero_tracking ?? '',
                    $demande->user->name ?? '',
                    $demande->user->email ?? '',
                    $demande->user->telephone ?? '',
                    $demande->type ?? '',
                    $demande->marchandise ?? '',
                    $demande->poids ?? '',
                    $demande->volume ?? '',
                    $demande->origine ?? '',
                    $demande->destination ?? '',
                    ucfirst($demande->statut),
                    $demande->created_at->format('d/m/Y H:i'),
                    $demande->date_souhaitee ? \Carbon\Carbon::parse($demande->date_souhaitee)->format('d/m/Y') : '',
                    $demande->valeur ?? '',
                    $demande->fragile ? 'Oui' : 'Non'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPDF(Request $request)
    {
        $query = DemandeTransport::with('user');

        // Appliquer les mêmes filtres que l'export CSV
        if ($request->filled('statut') && $request->statut !== 'tous') {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('numero_tracking', 'like', "%{$searchTerm}%")
                  ->orWhere('marchandise', 'like', "%{$searchTerm}%")
                  ->orWhere('origine', 'like', "%{$searchTerm}%")
                  ->orWhere('destination', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%")
                               ->orWhere('email', 'like', "%{$searchTerm}%")
                               ->orWhere('telephone', 'like', "%{$searchTerm}%");
                  });
            });
        }
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $demandes = $query->latest()->get();

        $pdf = Pdf::loadView('admin.demandes.pdf', compact('demandes'));
        return $pdf->download('demandes_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
