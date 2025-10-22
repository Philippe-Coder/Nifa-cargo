<?php

namespace App\Observers;

use App\Models\DemandeTransport;
use App\Services\NotificationService;

class DemandeTransportObserver
{
    /**
     * Handle the DemandeTransport "created" event.
     */
    public function created(DemandeTransport $demandeTransport): void
    {
        // Créer les étapes par défaut
        $demandeTransport->creerEtapesParDefaut();
        
        // Envoyer notification de création
        $notificationService = new NotificationService();
        $notificationService->envoyerNotificationEtape(
            $demandeTransport, 
            'Demande créée', 
            'en_attente'
        );
    }

    /**
     * Handle the DemandeTransport "updated" event.
     */
    public function updated(DemandeTransport $demandeTransport): void
    {
        // Vérifier si le statut a changé
        if ($demandeTransport->isDirty('statut')) {
            $ancienStatut = $demandeTransport->getOriginal('statut');
            $nouveauStatut = $demandeTransport->statut;
            
            // Envoyer notification de changement de statut
            NotificationService::notifyStatusChange($demandeTransport, $ancienStatut, $nouveauStatut);
        }
    }

    /**
     * Handle the DemandeTransport "deleted" event.
     */
    public function deleted(DemandeTransport $demandeTransport): void
    {
        //
    }

    /**
     * Handle the DemandeTransport "restored" event.
     */
    public function restored(DemandeTransport $demandeTransport): void
    {
        //
    }

    /**
     * Handle the DemandeTransport "force deleted" event.
     */
    public function forceDeleted(DemandeTransport $demandeTransport): void
    {
        //
    }
}
