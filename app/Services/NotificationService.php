<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\DemandeTransport;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;

class NotificationService
{
    private static string $twilioSid;
    private static string $twilioToken;
    private static string $twilioWhatsAppNumber;

    public function __construct()
    {
        self::$twilioSid = env('TWILIO_SID'); // SID Twilio
        self::$twilioToken = env('TWILIO_AUTH_TOKEN'); // Token Auth Twilio
        self::$twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER'); // Numéro Twilio WhatsApp (ex: 'whatsapp:+14155238886')
    }

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

    // --- Notifications email + WhatsApp combinées ---
    public static function envoyerNotification(User $user, DemandeTransport $demande, string $titre, string $message)
    {
        self::envoyerEmail($user, $demande, $titre, $message);

        if (!empty($user->telephone)) {
            self::envoyerWhatsApp($user, $demande, $message);
        }
    }

    // --- Email ---
    private static function envoyerEmail(User $user, DemandeTransport $demande, string $titre, string $message)
    {
        try {
            Log::info("📧 Tentative d'envoi email", [
                'destinataire' => $user->email,
                'nom' => $user->name,
                'titre' => $titre
            ]);

            $notification = self::create($user, 'email', $demande, $message);

            Mail::raw($message, function ($mail) use ($user, $titre) {
                $mail->to($user->email)
                     ->subject($titre);
            });

            $notification->marquerEnvoyee();
            Log::info("✅ Email envoyé avec succès à {$user->email}");
        } catch (\Exception $e) {
            Log::error('Erreur envoi email: ' . $e->getMessage());
            if (isset($notification)) $notification->marquerEchouee($e->getMessage());
        }
    }

    // --- WhatsApp via Twilio ---
    private static function envoyerWhatsApp(User $user, DemandeTransport $demande, string $message)
    {
        try {
            Log::info("📱 Tentative d'envoi WhatsApp", [
                'destinataire' => $user->telephone,
                'nom' => $user->name
            ]);

            $notification = self::create($user, 'whatsapp', $demande, $message);

            $client = new Client(self::$twilioSid, self::$twilioToken);

            $client->messages->create(
                "whatsapp:+{$user->telephone}",
                [
                    'from' => self::$twilioWhatsAppNumber,
                    'body' => $message
                ]
            );

            $notification->marquerEnvoyee();
            Log::info("✅ WhatsApp envoyé avec succès à {$user->telephone}");
        } catch (\Exception $e) {
            Log::error('Erreur envoi WhatsApp: ' . $e->getMessage());
            if (isset($notification)) $notification->marquerEchouee($e->getMessage());
        }
    }

    // --- Statut ---
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

        $message = str_replace(':id', $demande->id, $messages[$newStatus] ?? 'Le statut de votre demande #:id a été mis à jour.');
        $titre = "Mise à jour - Statut demande #{$demande->id}";
        self::envoyerNotification($user, $demande, $titre, $message);
    }

    // --- Nouvelle demande ---
    public static function notifyDemandeCreated(DemandeTransport $demande): void
    {
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $message = 'Nouvelle demande de transport #' . $demande->id . ' créée par ' . $demande->user->name;
            self::envoyerNotification($admin, $demande, "Nouvelle demande créée", $message);
        }
    }

    // --- Paiement reçu ---
    public static function notifyPaiementReceived(DemandeTransport $demande): void
    {
        $message = 'Paiement reçu pour la demande #' . $demande->id;
        self::envoyerNotification($demande->user, $demande, "Paiement reçu", $message);
    }

    // --- Livraison effectuée ---
    public static function notifyLivraisonEffectuee(DemandeTransport $demande): void
    {
        $message = 'Votre colis pour la demande #' . $demande->id . ' a été livré avec succès.';
        self::envoyerNotification($demande->user, $demande, "Livraison effectuée", $message);
    }

    // --- Demande acceptée ---
    public static function notifyDemandeAcceptee(DemandeTransport $demande): void
    {
        $message = 'Votre demande #' . $demande->id . ' a été acceptée.';
        self::envoyerNotification($demande->user, $demande, "Demande acceptée", $message);
    }

    // --- Demande refusée ---
    public static function notifyDemandeRefusee(DemandeTransport $demande, string $raison = ''): void
    {
        $message = 'Votre demande #' . $demande->id . ' a été refusée' . ($raison ? ' : ' . $raison : '.');
        self::envoyerNotification($demande->user, $demande, "Demande refusée", $message);
    }

    // --- Notification étape ---
    public function envoyerNotificationEtape(DemandeTransport $demande, string $nomEtape, string $statut = 'en_cours')
    {
        $user = $demande->user;
        $reference = $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT);

        $messagesStatut = [
            'en_attente' => "Bonjour {nom_client}, l'étape '{etape}' de votre demande {reference} est en attente de traitement.",
            'en_cours' => "Bonjour {nom_client}, votre demande {reference} pour {marchandise} est maintenant à l'étape: {etape}.",
            'terminee' => "Excellente nouvelle {nom_client} ! L'étape '{etape}' de votre demande {reference} a été complétée avec succès."
        ];

        $titre = "Mise à jour - Étape: {$nomEtape}";
        $message = $messagesStatut[$statut] ?? "Votre demande {reference} pour {marchandise} vient de passer à l'étape: {etape}.";

        $message = str_replace(
            ['{nom_client}', '{marchandise}', '{etape}', '{reference}', '{origine}', '{destination}'],
            [$user->name, $demande->marchandise ?? 'votre marchandise', $nomEtape, $reference, $demande->origine ?? 'N/A', $demande->destination ?? 'N/A'],
            $message
        );

        self::envoyerNotification($user, $demande, $titre, $message);
    }

    // --- Messages prédéfinis par statut ---
    private function getMessagesStatut()
    {
        return [
            'en attente' => 'Bonjour {nom_client}, votre demande de transport pour {marchandise} de {origine} vers {destination} a été reçue et est en cours de traitement.',
            'validée' => 'Excellente nouvelle {nom_client} ! Votre demande de transport pour {marchandise} a été validée.',
            'en transit' => 'Votre marchandise {marchandise} est maintenant en transit de {origine} vers {destination}.',
            'livrée' => 'Félicitations {nom_client} ! Votre marchandise {marchandise} a été livrée avec succès à {destination}.',
            'refusée' => 'Nous regrettons de vous informer que votre demande de transport pour {marchandise} n\'a pas pu être acceptée.'
        ];
    }
}
