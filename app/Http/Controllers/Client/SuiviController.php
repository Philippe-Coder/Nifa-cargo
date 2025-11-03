<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemandeTransport;
use Illuminate\Support\Facades\Auth;

class SuiviController extends Controller
{
    /**
     * Afficher toutes les demandes du client
     */
    public function index()
    {
        $demandes = DemandeTransport::with(['etapes', 'documents'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('client.mes-demandes.index', compact('demandes'));
    }

    /**
     * Afficher les détails d'une demande spécifique
     */
    public function show($id)
    {
        $demande = DemandeTransport::with([
            'etapes.agent',
            'etapes.documents.user',
            'documents.uploadedBy',
            'notifications' => function($query) {
                $query->where('notifiable_type', DemandeTransport::class)
                      ->where('user_id', Auth::id())
                      ->latest();
            }
        ])
        ->where('user_id', Auth::id())
        ->findOrFail($id);
        
        return view('client.mes-demandes.show', compact('demande'));
    }

    /**
     * Afficher le formulaire d'édition d'une demande
     */
    public function edit($id)
    {
        $demande = DemandeTransport::where('user_id', Auth::id())->findOrFail($id);
        
        return view('client.mes-demandes.edit', compact('demande'));
    }

    /**
     * Mettre à jour une demande
     */
    public function update(Request $request, $id)
    {
        $demande = DemandeTransport::where('user_id', Auth::id())->findOrFail($id);
        
        // Validation des données
        $validatedData = $request->validate([
            // Informations de contact (toujours modifiables)
            'nom_expediteur' => 'required|string|max:255',
            'telephone_expediteur' => 'required|string|max:20',
            'nom_destinataire' => 'required|string|max:255',
            'telephone_destinataire' => 'required|string|max:20',
            'instructions_speciales' => 'nullable|string',
            
            // Informations du colis (modifiables selon le statut)
            'type_colis' => in_array($demande->statut, ['en_attente', 'confirmee']) ? 'required|in:document,colis_standard,colis_volumineux,marchandise' : 'nullable',
            'poids' => in_array($demande->statut, ['en_attente', 'confirmee']) ? 'required|numeric|min:0' : 'nullable',
            'nombre_cartons' => 'nullable|integer|min:0|max:9999',
            'valeur_declaree' => 'nullable|numeric|min:0',
            'description' => in_array($demande->statut, ['en_attente', 'confirmee']) ? 'required|string' : 'nullable',
            
            // Adresses (modifiables selon le statut)
            'adresse_enlevement' => in_array($demande->statut, ['en_attente', 'confirmee']) ? 'required|string' : 'nullable',
            'ville_enlevement' => in_array($demande->statut, ['en_attente', 'confirmee']) ? 'required|string|max:255' : 'nullable',
            'code_postal_enlevement' => in_array($demande->statut, ['en_attente', 'confirmee']) ? 'required|string|max:10' : 'nullable',
            'adresse_livraison' => in_array($demande->statut, ['en_attente', 'confirmee']) ? 'required|string' : 'nullable',
            'ville_livraison' => in_array($demande->statut, ['en_attente', 'confirmee']) ? 'required|string|max:255' : 'nullable',
            'code_postal_livraison' => in_array($demande->statut, ['en_attente', 'confirmee']) ? 'required|string|max:10' : 'nullable',
        ]);

        // Mise à jour des données
        $demande->update($validatedData);

        return redirect()->route('mes-demandes.show', $demande->id)
                        ->with('success', 'Votre demande a été mise à jour avec succès.');
    }

    /**
     * Annuler une demande
     */
    public function cancel(Request $request, $id)
    {
        $demande = DemandeTransport::where('user_id', Auth::id())->findOrFail($id);
        
        // Vérifier si la demande peut être annulée
        if (!in_array($demande->statut, ['en_attente', 'confirmee'])) {
            return redirect()->back()->with('error', 'Cette demande ne peut plus être annulée.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string',
            'cancellation_comment' => 'nullable|string|max:1000'
        ]);

        $demande->update([
            'statut' => 'annulee',
            'cancellation_reason' => $request->cancellation_reason,
            'cancellation_comment' => $request->cancellation_comment,
            'cancelled_at' => now()
        ]);

        return redirect()->route('mes-demandes.index')
                        ->with('success', 'Votre demande a été annulée avec succès.');
    }

    /**
     * Uploader un document pour une demande
     */
    public function uploadDocument(Request $request, $id)
    {
        $demande = DemandeTransport::where('user_id', Auth::id())->findOrFail($id);
        
        // Rediriger vers le contrôleur de documents
        return app(\App\Http\Controllers\DocumentController::class)->store($request, $id);
    }
}
