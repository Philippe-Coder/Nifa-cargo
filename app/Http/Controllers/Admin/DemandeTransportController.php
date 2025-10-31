<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeTransport;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DemandeTransportController extends Controller
{
    public function index()
    {
        $demandes = DemandeTransport::with('user')->latest()->paginate(15);
        return view('admin.demandes.index', compact('demandes'));
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
}
