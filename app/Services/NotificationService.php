<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\DemandeTransport;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class NotificationService
{
    /**
     * Envoyer une notification lors du changement de statut
     */
    /**
     * Créer une nouvelle notification
     */
    public static function create(User $user, string $type, Model $notifiable, string $message): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'message' => $message,
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id
        ]);
    }

    /**
     * Notifier un changement de statut de demande
     */
    public static function notifyStatusChange(DemandeTransport $demande, string $oldStatus, string $newStatus): void
    {
        $user = $demande->user;
        
        $messages = [
            'en_attente' => 'Votre demande #:id est en attente de traitement.',
            'en_cours' => 'Votre demande #:id est en cours de traitement.',
            'terminee' => 'Votre demande #:id a été traitée avec succès.',
            'annulee' => 'Votre demande #:id a été annulée.',
            'refusee' => 'Votre demande #:id a été refusée.'
        ];
        
        $message = $messages[$newStatus] ?? 'Le statut de votre demande #:id a été mis à jour.';
        $message = str_replace(':id', $demande->id, $message);
        
        self::create($user, 'statut_modifie', $demande, $message);
    }
    
    /**
     * Envoyer une notification de demande créée
     */
    public static function notifyDemandeCreated(DemandeTransport $demande): void
    {
        $admin = User::where('role', 'admin')->first();
        
        if ($admin) {
            self::create(
                $admin,
                'nouvelle_demande',
                $demande,
                'Nouvelle demande de transport #' . $demande->id . ' créée par ' . $demande->user->name
            );
        }
    }
    
    /**
     * Envoyer une notification de paiement reçu
     */
    public static function notifyPaiementReceived(DemandeTransport $demande): void
    {
        self::create(
            $demande->user,
            'paiement_effectue',
            $demande,
            'Paiement reçu pour la demande #' . $demande->id
        );
    }
    
    /**
     * Envoyer une notification de livraison effectuée
     */
    public static function notifyLivraisonEffectuee(DemandeTransport $demande): void
    {
        self::create(
            $demande->user,
            'livraison_effectuee',
            $demande,
            'Votre colis pour la demande #' . $demande->id . ' a été livré avec succès.'
        );
    }
    
    /**
     * Envoyer une notification de demande acceptée
     */
    public static function notifyDemandeAcceptee(DemandeTransport $demande): void
    {
        self::create(
            $demande->user,
            'demande_acceptee',
            $demande,
            'Votre demande #' . $demande->id . ' a été acceptée.'
        );
    }
    
    /**
     * Envoyer une notification de demande refusée
     */
    public static function notifyDemandeRefusee(DemandeTransport $demande, string $raison = ''): void
    {
        $message = 'Votre demande #' . $demande->id . ' a été refusée';
        $message .= $raison ? ' : ' . $raison : '.';
        
        self::create(
            $demande->user,
            'demande_refusee',
            $demande,
            $message
        );
    }
    
    /**
     * @deprecated Utiliser les méthodes spécifiques à la place
     */
    public function envoyerNotificationChangementStatut(DemandeTransport $demande, string $ancienStatut, string $nouveauStatut)
    {
        $user = $demande->user;
        
        // Créer le message personnalisé
        $messages = $this->getMessagesStatut();
        $titre = "Mise à jour de votre demande de transport";
        $message = $messages[$nouveauStatut] ?? "Votre demande de transport a été mise à jour.";
        
        // Remplacer les variables dans le message
        $message = str_replace([
            '{nom_client}',
            '{marchandise}',
            '{statut}',
            '{origine}',
            '{destination}'
        ], [
            $user->name,
            $demande->marchandise,
            ucfirst($nouveauStatut),
            $demande->origine,
            $demande->destination
        ], $message);

        // Envoyer email
        $this->envoyerEmail($user, $demande, $titre, $message);
        
        // Envoyer WhatsApp si numéro disponible
        if (isset($user->telephone) && !empty($user->telephone)) {
            $this->envoyerWhatsApp($user, $demande, $message);
        }
    }

    /**
     * Envoyer notification email
     */
    private function envoyerEmail(User $user, DemandeTransport $demande, string $titre, string $message)
    {
        try {
            // Créer la notification en base
            $notification = Notification::create([
                'user_id' => $user->id,
                'demande_transport_id' => $demande->id,
                'type' => 'email',
                'titre' => $titre,
                'message' => $message,
                'statut' => 'en_attente'
            ]);

            // Envoyer l'email
            Mail::raw($message, function ($mail) use ($user, $titre) {
                $mail->to($user->email)
                     ->subject($titre);
            });

            // Marquer comme envoyée
            $notification->marquerEnvoyee();
            
        } catch (\Exception $e) {
            Log::error('Erreur envoi email: ' . $e->getMessage());
            if (isset($notification)) {
                $notification->marquerEchouee($e->getMessage());
            }
        }
    }

    /**
     * Envoyer notification WhatsApp
     */
   private function envoyerWhatsApp(User $user, DemandeTransport $demande, string $message)
{
    try {
        $notification = Notification::create([
            'user_id' => $user->id,
            'demande_transport_id' => $demande->id,
            'type' => 'whatsapp',
            'titre' => 'Notification WhatsApp',
            'message' => $message,
            'statut' => 'en_attente'
        ]);

        // Construire le lien API CallMeBot
        $url = 'https://api.callmebot.com/whatsapp.php';
        $params = [
            'phone' => $user->telephone,    // Numéro du client (ex: 22897311158)
            'text'  => $message,            // Le message (sera encodé automatiquement par Http::get)
            'apikey'=> '9540134'            // Clé CallMeBot
        ];

        // Envoi de la requête
        $response = Http::get($url, $params);

        // Vérifier si succès
        if ($response->successful()) {
            Log::info("WhatsApp envoyé à {$user->telephone}");
            $notification->marquerEnvoyee();
        } else {
            Log::error("Échec WhatsApp: " . $response->body());
            $notification->marquerEchouee($response->body());
        }

    } catch (\Exception $e) {
        Log::error('Erreur envoi WhatsApp: ' . $e->getMessage());
        if (isset($notification)) {
            $notification->marquerEchouee($e->getMessage());
        }
    }
}


    /**
     * Messages prédéfinis par statut
     */
    private function getMessagesStatut()
    {
        return [
            'en attente' => 'Bonjour {nom_client}, votre demande de transport pour {marchandise} de {origine} vers {destination} a été reçue et est en cours de traitement.',
            'validée' => 'Excellente nouvelle {nom_client} ! Votre demande de transport pour {marchandise} a été validée. Nous procédons maintenant aux démarches logistiques.',
            'en transit' => 'Votre marchandise {marchandise} est maintenant en transit de {origine} vers {destination}. Vous serez informé dès son arrivée.',
            'livrée' => 'Félicitations {nom_client} ! Votre marchandise {marchandise} a été livrée avec succès à {destination}. Merci de votre confiance.',
            'refusée' => 'Nous regrettons de vous informer que votre demande de transport pour {marchandise} n\'a pas pu être acceptée. Contactez-nous pour plus d\'informations.'
        ];
    }

    /**
     * Envoyer notification pour nouvelle étape
     */
    public function envoyerNotificationEtape(DemandeTransport $demande, string $nomEtape)
    {
        $user = $demande->user;
        $titre = "Nouvelle étape: {$nomEtape}";
        $message = "Votre demande de transport pour {marchandise} vient de passer à l'étape: {$nomEtape}.";
        
        $message = str_replace([
            '{nom_client}',
            '{marchandise}',
            '{etape}'
        ], [
            $user->name,
            $demande->marchandise,
            $nomEtape
        ], $message);

        $this->envoyerEmail($user, $demande, $titre, $message);
        
        if (isset($user->telephone) && !empty($user->telephone)) {
            $this->envoyerWhatsApp($user, $demande, $message);
        }
    }
}
