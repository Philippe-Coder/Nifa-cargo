<?php

namespace App\Http\Controllers;

use App\Models\DemandeTransport;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuiviController extends Controller
{
    /**
     * Afficher les demandes du client connecté
     */
    public function index()
    {
        $demandes = DemandeTransport::where('user_id', Auth::id())
            ->with('etapes')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.mes-demandes.index', compact('demandes'));
    }

    /**
     * Afficher les détails d'une demande
     */
    public function show(DemandeTransport $demande)
    {
        // Vérifier que la demande appartient au client connecté
        if ($demande->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette demande.');
        }

        $demande->load(['etapes' => function($query) {
            $query->orderBy('ordre');
        }, 'user']);

        return view('client.mes-demandes.show', compact('demande'));
    }

    /**
     * Afficher le formulaire d'édition d'une demande côté client
     */
    public function edit(DemandeTransport $demande)
    {
        // Vérifier que la demande appartient au client connecté
        if ($demande->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette demande.');
        }

        // Vérifier que la demande peut être modifiée (seulement si en attente)
        if (!in_array($demande->statut, ['en_attente', 'en_cours'])) {
            return redirect()->route('mes-demandes.show', $demande)
                ->with('error', 'Cette demande ne peut plus être modifiée car elle est déjà ' . $demande->statut . '.');
        }

        return view('client.mes-demandes.edit', compact('demande'));
    }

    /**
     * Mettre à jour une demande côté client
     */
    public function update(Request $request, DemandeTransport $demande)
    {
        // Vérifier que la demande appartient au client connecté
        if ($demande->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette demande.');
        }

        // Vérifier que la demande peut être modifiée
        if (!in_array($demande->statut, ['en_attente', 'en_cours'])) {
            return redirect()->route('mes-demandes.show', $demande)
                ->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'type_transport' => 'required|string',
            'marchandise' => 'required|string|max:255',
            'poids' => 'nullable|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
            'origine' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'ville_depart' => 'nullable|string|max:255',
            'ville_destination' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date_souhaitee' => 'nullable|date',
            'dimensions' => 'nullable|string|max:255',
            'valeur' => 'nullable|numeric|min:0|max:999999999999.99',
            'fragile' => 'nullable|boolean'
        ]);

        // Stocker les anciennes valeurs pour la notification
        $oldData = $demande->only(['type_transport', 'marchandise', 'origine', 'destination']);
        
        // Mettre à jour la demande (sans pouvoir changer le statut)
        $demande->update($validated);

        // Notifier les admins de la modification client
        if ($this->hasClientSignificantChanges($oldData, $validated)) {
            NotificationService::notifyAdminsDemandeModifiedByClient($demande, $oldData, $validated);
        }

        return redirect()->route('mes-demandes.show', $demande)
            ->with('success', 'Votre demande a été mise à jour avec succès.');
    }

    /**
     * Annuler une demande côté client
     */
    public function cancel(DemandeTransport $demande)
    {
        // Vérifier que la demande appartient au client connecté
        if ($demande->user_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette demande.');
        }

        // Vérifier que la demande peut être annulée (pas encore livrée)
        if (in_array($demande->statut, ['livree', 'annulee'])) {
            return redirect()->route('mes-demandes.show', $demande)
                ->with('error', 'Cette demande ne peut plus être annulée.');
        }

        // Marquer comme annulée
        $demande->update(['statut' => 'annulee']);

        // Notifier les administrateurs
        NotificationService::notifyAdminsDemandeAnnulee($demande);

        return redirect()->route('mes-demandes.index')
            ->with('success', 'Votre demande a été annulée avec succès. Nos équipes ont été notifiées.');
    }

    /**
     * Vérifier si les modifications client sont significatives
     */
    private function hasClientSignificantChanges($oldData, $newData)
    {
        $significantFields = ['type_transport', 'marchandise', 'origine', 'destination'];
        
        foreach ($significantFields as $field) {
            if ($oldData[$field] !== $newData[$field]) {
                return true;
            }
        }
        
        return false;
    }
}