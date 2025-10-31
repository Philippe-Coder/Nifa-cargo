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
                $q->where('reference', 'like', "%{$searchTerm}%")
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
                $q->where('reference', 'like', "%{$searchTerm}%")
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
                'Référence',
                'Client',
                'Email Client', 
                'Téléphone Client',
                'Numéro Tracking',
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
                    $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT),
                    $demande->user->name ?? '',
                    $demande->user->email ?? '',
                    $demande->user->telephone ?? '',
                    $demande->numero_tracking ?? '',
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
}
