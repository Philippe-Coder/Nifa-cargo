<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EtapeLogistique;
use App\Models\DemandeTransport;
use App\Services\NotificationService;

class EtapeLogistiqueController extends Controller
{
    /**
     * Mettre à jour le statut d'une étape
     */
    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,terminee',
            'commentaire' => 'nullable|string|max:1000'
        ]);

        $etape = EtapeLogistique::findOrFail($id);
        $ancienStatut = $etape->statut;
        
        $etape->update([
            'statut' => $request->statut,
            'commentaire' => $request->commentaire,
            'date_debut' => $request->statut === 'en_cours' && !$etape->date_debut ? now() : $etape->date_debut,
            'date_fin' => $request->statut === 'terminee' ? now() : null,
            'agent_id' => $request->statut !== 'en_attente' ? auth()->id() : $etape->agent_id
        ]);

        // Envoyer notification si étape terminée
        if ($request->statut === 'terminee' && $ancienStatut !== 'terminee') {
            $notificationService = new NotificationService();
            $notificationService->envoyerNotificationEtape(
                $etape->demandeTransport,
                $etape->nom
            );
        }

        return redirect()->back()->with('success', 'Étape mise à jour avec succès.');
    }

    /**
     * Assigner un agent à une étape
     */
    public function assignerAgent(Request $request, $id)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id'
        ]);

        $etape = EtapeLogistique::findOrFail($id);
        $etape->update([
            'agent_id' => $request->agent_id
        ]);

        return redirect()->back()->with('success', 'Agent assigné avec succès.');
    }

    /**
     * Voir les détails d'une étape
     */
    public function show($id)
    {
        $etape = EtapeLogistique::with(['demandeTransport.user', 'agent'])->findOrFail($id);
        return view('admin.etapes.show', compact('etape'));
    }
}
