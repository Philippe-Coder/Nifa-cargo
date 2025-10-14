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
        $demande = $etape->demandeTransport;
        $client = $demande->user;
        
        $etape->update([
            'statut' => $request->statut,
            'commentaire' => $request->commentaire,
            'date_debut' => $request->statut === 'en_cours' && !$etape->date_debut ? now() : $etape->date_debut,
            'date_fin' => $request->statut === 'terminee' ? now() : null,
            'agent_id' => $request->statut !== 'en_attente' ? auth()->id() : $etape->agent_id
        ]);

        // Envoyer notification si le statut a changé
        if ($ancienStatut !== $request->statut) {
            $notificationService = new NotificationService();
            
            // Déterminer le message selon le statut
            $statutMessages = [
                'en_attente' => "L'étape '{$etape->nom}' est en attente de traitement.",
                'en_cours' => "L'étape '{$etape->nom}' est maintenant en cours.",
                'terminee' => "L'étape '{$etape->nom}' a été complétée avec succès."
            ];
            
            $messageEtape = $statutMessages[$request->statut] ?? "L'étape '{$etape->nom}' a été mise à jour.";
            
            // Envoyer les notifications
            $emailEnvoye = false;
            $whatsappEnvoye = false;
            
            try {
                $notificationService->envoyerNotificationEtape($demande, $etape->nom, $request->statut);
                $emailEnvoye = true;
                
                // Vérifier si WhatsApp a été envoyé
                if (isset($client->telephone) && !empty($client->telephone)) {
                    $whatsappEnvoye = true;
                }
            } catch (\Exception $e) {
                \Log::error('Erreur envoi notification étape: ' . $e->getMessage());
            }
            
            // Message de confirmation pour l'admin
            $confirmationMessage = "Étape mise à jour avec succès. ";
            
            if ($emailEnvoye && $whatsappEnvoye) {
                $confirmationMessage .= "✅ Notifications envoyées à {$client->name} :\n";
                $confirmationMessage .= "📧 Email : {$client->email}\n";
                $confirmationMessage .= "📱 WhatsApp : {$client->telephone}";
            } elseif ($emailEnvoye) {
                $confirmationMessage .= "✅ Email envoyé à : {$client->email}\n";
                $confirmationMessage .= "⚠️ WhatsApp non envoyé (numéro manquant ou invalide)";
            } else {
                $confirmationMessage .= "⚠️ Erreur lors de l'envoi des notifications. Vérifiez les logs.";
            }
            
            return redirect()->back()->with('success', $confirmationMessage);
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
