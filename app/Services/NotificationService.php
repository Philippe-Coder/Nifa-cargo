<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\DemandeTransport;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;

class NotificationService
{
    /**
     * Normaliser un numéro en E.164 (ex: +22897311158)
     */
    private static function formatPhoneE164(string $phone): string
    {
        $p = preg_replace('/[^0-9+]/', '', $phone ?? '');
        if (!$p) {
            throw new \Exception('Numéro de téléphone manquant');
        }
        if (str_starts_with($p, '+')) {
            return $p;
        }
        $defaultCc = env('DEFAULT_PHONE_COUNTRY_CODE'); // ex: +228
        if ($defaultCc) {
            $cc = '+' . ltrim($defaultCc, '+');
            // retirer 0 de tête le cas échéant
            $local = ltrim($p, '0');
            return $cc . $local;
        }
        throw new \Exception('Le numéro doit être au format E.164 (ex: +228XXXXXXXX). Définissez DEFAULT_PHONE_COUNTRY_CODE dans .env');
    }
    /**
     * Créer une notification en base de données
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
     * Envoyer notification complète (Email + WhatsApp)
     */
    public static function envoyerNotification(User $user, DemandeTransport $demande, string $titre, string $message)
    {
        $results = [
            'email' => false,
            'whatsapp' => false,
            'errors' => []
        ];

        // Envoi Email
        try {
            self::envoyerEmail($user, $demande, $titre, $message);
            $results['email'] = true;
            Log::info("✅ Email envoyé avec succès à {$user->email}");
        } catch (\Exception $e) {
            $results['errors'][] = "Email: " . $e->getMessage();
            Log::error('❌ Erreur envoi email: ' . $e->getMessage());
        }

        // Envoi WhatsApp (si numéro disponible)
        if (!empty($user->telephone)) {
            try {
                self::envoyerWhatsApp($user, $demande, $message);
                $results['whatsapp'] = true;
                Log::info("✅ WhatsApp envoyé avec succès à {$user->telephone}");
            } catch (\Exception $e) {
                $results['errors'][] = "WhatsApp: " . $e->getMessage();
                Log::error('❌ Erreur envoi WhatsApp: ' . $e->getMessage());
            }
        }

        return $results;
    }

    /**
     * Envoyer Email via Gmail SMTP
     */
    private static function envoyerEmail(User $user, DemandeTransport $demande, string $titre, string $message)
    {
        $notification = self::create($user, 'email', $demande, $message);

        try {
            Log::info("📧 Tentative d'envoi email", [
                'destinataire' => $user->email,
                'nom' => $user->name,
                'titre' => $titre
            ]);

            // Template HTML pour l'email
            $htmlMessage = self::creerTemplateEmail($user, $demande, $titre, $message);

            Mail::html($htmlMessage, function ($mail) use ($user, $titre) {
                $mail->to($user->email, $user->name)
                     ->subject($titre)
                     ->from(config('mail.from.address'), config('mail.from.name'));
            });

            $notification->marquerEnvoyee();
            
        } catch (\Exception $e) {
            $notification->marquerEchouee($e->getMessage());
            throw $e;
        }
    }

    /**
     * Envoyer WhatsApp - Méthode 1: CallMeBot (Gratuit)
     */
    private static function envoyerWhatsAppCallMeBot(User $user, DemandeTransport $demande, string $message)
    {
        $notification = self::create($user, 'whatsapp', $demande, $message);
        
        try {
            $apiKey = env('CALLMEBOT_API_KEY'); // Votre clé API CallMeBot
            $phone = preg_replace('/[^0-9]/', '', $user->telephone); // Nettoyer le numéro (format CallMeBot sans +)
            
            if (empty($apiKey)) {
                throw new \Exception('Clé API CallMeBot manquante');
            }

            $url = "https://api.callmebot.com/whatsapp.php";
            
            $response = Http::get($url, [
                'phone' => $phone,
                'text' => $message,
                'apikey' => $apiKey
            ]);

            if ($response->successful()) {
                $notification->marquerEnvoyee();
            } else {
                throw new \Exception('Erreur API CallMeBot: ' . $response->body());
            }
            
        } catch (\Exception $e) {
            $notification->marquerEchouee($e->getMessage());
            throw $e;
        }
    }

    /**
     * Envoyer WhatsApp - Méthode 2: Meta WhatsApp Cloud API (Officiel, pas besoin de message préalable, nécessite Template approuvé pour démarrer la conversation)
     */
    private static function envoyerWhatsAppMeta(User $user, DemandeTransport $demande, string $message)
    {
        $notification = self::create($user, 'whatsapp', $demande, $message);
        try {
            $accessToken = env('WHATSAPP_ACCESS_TOKEN');
            $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
            $templateName = env('WHATSAPP_TEMPLATE_NAME'); // ex: shipment_update
            $templateLang = env('WHATSAPP_TEMPLATE_LANG', 'fr');

            if (!$accessToken || !$phoneNumberId) {
                throw new \Exception('Configuration WhatsApp Cloud API incomplète');
            }

            $to = self::formatPhoneE164($user->telephone);
            $url = sprintf('https://graph.facebook.com/v20.0/%s/messages', $phoneNumberId);

            // Si un template est défini, on l'utilise pour initier la conversation
            if ($templateName) {
                // Construire un template simple avec paramètres optionnels
                $components = [];
                // Si on souhaite injecter le message dans le body (si le template attend des variables)
                $components[] = [
                    'type' => 'body',
                    'parameters' => [ ['type' => 'text', 'text' => ($demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT))) ],
                                      ['type' => 'text', 'text' => $demande->marchandise ?? 'Marchandise' ],
                                      ['type' => 'text', 'text' => $message ] ]
                ];

                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $to,
                    'type' => 'template',
                    'template' => [
                        'name' => $templateName,
                        'language' => ['code' => $templateLang],
                        'components' => $components
                    ]
                ];
            } else {
                // Sinon on tente un simple message texte (réussira si la fenêtre de 24h est ouverte)
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $to,
                    'type' => 'text',
                    'text' => ['body' => $message]
                ];
            }

            $response = Http::withToken($accessToken)
                ->acceptJson()
                ->post($url, $payload);

            if ($response->successful()) {
                $notification->marquerEnvoyee();
            } else {
                throw new \Exception('Erreur WhatsApp Cloud API: ' . $response->body());
            }
        } catch (\Exception $e) {
            $notification->marquerEchouee($e->getMessage());
            throw $e;
        }
    }

    /**
     * Envoyer WhatsApp - Méthode 3: Twilio (Payant; pour initier une conversation, utiliser un template approuvé via Twilio Content API)
     */
    private static function envoyerWhatsAppTwilio(User $user, DemandeTransport $demande, string $message)
    {
        $notification = self::create($user, 'whatsapp', $demande, $message);
        
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_AUTH_TOKEN');
            $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER');
            
            if (!$sid || !$token || !$twilioWhatsAppNumber) {
                throw new \Exception('Configuration Twilio incomplète');
            }

            $twilio = new \Twilio\Rest\Client($sid, $token);
            
            $phone = self::formatPhoneE164($user->telephone);
            if (!str_starts_with($phone, 'whatsapp:')) {
                $phone = 'whatsapp:' . $phone;
            }

            // NOTE: Ce simple body fonctionne si une session 24h existe déjà.
            // Pour initier la conversation côté Twilio, utilisez un Messaging Service avec Content API (contentSid) et un template approuvé.
            $twilio->messages->create($phone, [
                'from' => $twilioWhatsAppNumber,
                'body' => $message
                // 'contentSid' => env('TWILIO_CONTENT_SID'),
                // 'contentVariables' => json_encode(["1" => $demande->reference, "2" => $demande->marchandise])
            ]);

            $notification->marquerEnvoyee();
            
        } catch (\Exception $e) {
            $notification->marquerEchouee($e->getMessage());
            throw $e;
        }
    }

    /**
     * Envoyer WhatsApp - Sélection automatique de la méthode
     */
    private static function envoyerWhatsApp(User $user, DemandeTransport $demande, string $message)
    {
        // Priorité 1: 360dialog API (Sandbox)
        if (env('WHATSAPP_360_API_KEY')) {
            \Illuminate\Support\Facades\Log::info("📱 Utilisation 360dialog pour WhatsApp dans NotificationService");
            self::envoyer360Dialog($user, $demande, $message);
            return;
        }
        // Priorité 2: Meta WhatsApp Cloud API (n'exige pas que le client écrive en premier, via template)
        if (env('WHATSAPP_ACCESS_TOKEN') && env('WHATSAPP_PHONE_NUMBER_ID')) {
            self::envoyerWhatsAppMeta($user, $demande, $message);
            return;
        }
        // Priorité 3: Twilio
        if (env('TWILIO_SID') && env('TWILIO_AUTH_TOKEN') && env('TWILIO_WHATSAPP_NUMBER')) {
            self::envoyerWhatsAppTwilio($user, $demande, $message);
            return;
        }
        // Priorité 4: CallMeBot (dépannage/démo; nécessite autorisation manuelle côté utilisateur)
        if (env('CALLMEBOT_API_KEY')) {
            self::envoyerWhatsAppCallMeBot($user, $demande, $message);
            return;
        }
        throw new \Exception('Aucun service WhatsApp configuré (360dialog, Meta Cloud API, ou Twilio requis).');
    }

    /**
     * Envoyer WhatsApp - Méthode 360dialog API (Sandbox)
     */
    private static function envoyer360Dialog(User $user, DemandeTransport $demande, string $message)
    {
        $notification = self::create($user, 'whatsapp', $demande, $message);
        
        try {
            $apiKey = env('WHATSAPP_360_API_KEY');
            $baseUrl = env('WHATSAPP_360_BASE_URL', 'https://waba-sandbox.360dialog.io');
            
            if (!$apiKey) {
                throw new \Exception('Configuration 360dialog incomplète - API Key manquante');
            }
            
            $phone = self::formatPhoneE164($user->telephone);
            $url = $baseUrl . '/v1/messages';

            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ];

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'D360-API-KEY' => $apiKey,
                'Content-Type' => 'application/json'
            ])->post($url, $payload);

            if ($response->successful()) {
                $notification->marquerEnvoyee();
                \Illuminate\Support\Facades\Log::info("📱 WhatsApp 360dialog envoyé avec succès à {$phone}");
            } else {
                throw new \Exception('Erreur 360dialog API: ' . $response->body());
            }
            
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Gestion spéciale pour les erreurs sandbox 360dialog
            if (str_contains($errorMessage, 'can only send to your verified number') || 
                str_contains($errorMessage, 'Forbidden')) {
                
                \Illuminate\Support\Facades\Log::warning('⚠️ 360dialog Sandbox: Numéro non vérifié, tentative fallback vers CallMeBot', [
                    'phone' => $phone,
                    'error' => $errorMessage
                ]);
                
                // Tentative de fallback automatique vers CallMeBot
                try {
                    $apiKey = env('CALLMEBOT_API_KEY');
                    if ($apiKey) {
                        \Illuminate\Support\Facades\Log::info('🔄 Fallback automatique vers CallMeBot pour ' . $phone);
                        self::envoyerWhatsAppCallMeBot($user, $demande, $message);
                        return; // Succès avec CallMeBot
                    } else {
                        \Illuminate\Support\Facades\Log::info('💡 CallMeBot non configuré, numéro ignoré en mode sandbox');
                        $notification->marquerEchouee('Sandbox 360dialog: Numéro non vérifié (' . $phone . ')');
                        return; // Pas d'erreur fatale en sandbox
                    }
                } catch (\Exception $fallbackError) {
                    \Illuminate\Support\Facades\Log::error('❌ Erreur fallback CallMeBot: ' . $fallbackError->getMessage());
                }
            }
            
            $notification->marquerEchouee($errorMessage);
            \Illuminate\Support\Facades\Log::error("❌ Erreur WhatsApp 360dialog: " . $errorMessage);
            throw $e;
        }
    }

    /**
     * Créer template HTML pour email
     */
    private static function creerTemplateEmail(User $user, DemandeTransport $demande, string $titre, string $message): string
    {
    $tracking = $demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT));
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>{$titre}</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
                .container { background-color: white; max-width: 600px; margin: 0 auto; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                .header { background: linear-gradient(135deg, #1e3a8a, #dc2626); color: white; padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 20px; }
                .content { padding: 20px 0; line-height: 1.6; color: #333; }
                .info-box { background-color: #f8f9fa; padding: 15px; border-left: 4px solid #1e3a8a; margin: 15px 0; }
                .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; color: #666; }
                .logo { font-size: 24px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <div class='logo'> NIF CARGO</div>
                    <h2 style='margin: 10px 0 0 0;'>{$titre}</h2>
                </div>
                
                <div class='content'>
                    <p>Bonjour <strong>{$user->name}</strong>,</p>
                    <p>{$message}</p>
                    
                    <div class='info-box'>
                        <strong>� Numéro de suivi :</strong> {$tracking}<br>
                        <strong>📋 Marchandise :</strong> {$demande->marchandise}<br>
                        <strong>📍 Origine :</strong> {$demande->origine}<br>
                        <strong>🎯 Destination :</strong> {$demande->destination}
                    </div>
                    
                    <p>Vous pouvez suivre votre colis en temps réel sur notre site :</p>
                    <p style='text-align: center;'>
                        <a href='" . url('/suivi') . "' style='background: linear-gradient(135deg, #1e3a8a, #dc2626); color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                            🔍 Suivre mon colis
                        </a>
                    </p>
                </div>
                
                <div class='footer'>
                    <p>📞 <strong>Contact :</strong> +228 99 25 25 31 | 📧 contact@nifgroupecargo.com</p>
                    <p>🏢 Totsi, Lomé - Togo</p>
                    <p style='font-size: 12px; color: #999;'>© " . date('Y') . " NIF CARGO - Transport et Logistique</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }

    /**
     * Notification lors d'une mise à jour d'étape
     */
    public function envoyerNotificationEtape(DemandeTransport $demande, string $nomEtape, string $statut = 'en_cours')
    {
        $user = $demande->user;
        $tracking = $demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT));

        // Messages selon le statut
        $messagesStatut = [
            'en_attente' => "🔄 L'étape '{nomEtape}' de votre envoi {tracking} est en attente de traitement.",
            'en_cours' => "🚀 Bonne nouvelle ! Votre envoi {tracking} pour {marchandise} est maintenant à l'étape: {nomEtape}.",
            'terminee' => "✅ Excellente nouvelle ! L'étape '{nomEtape}' de votre envoi {tracking} a été complétée avec succès."
        ];

        $titre = "Mise à jour NIF Cargo - Étape: {$nomEtape}";
        $message = $messagesStatut[$statut] ?? "📦 Votre envoi {tracking} pour {marchandise} vient de passer à l'étape: {nomEtape}.";

        // Remplacer les variables
        $message = str_replace(
            ['{nomEtape}', '{marchandise}', '{tracking}', '{origine}', '{destination}'],
            [$nomEtape, $demande->marchandise ?? 'votre marchandise', $tracking, $demande->origine ?? 'N/A', $demande->destination ?? 'N/A'],
            $message
        );

        return self::envoyerNotification($user, $demande, $titre, $message);
    }

    /**
     * Notification de changement de statut de demande
     */
    public static function notifyStatusChange(DemandeTransport $demande, string $oldStatus, string $newStatus): void
    {
        $user = $demande->user;
        $tracking = $demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT));
        
        $messages = [
            'en_attente' => "🔄 Votre envoi {$tracking} est en attente de traitement.",
            'validee' => "✅ Excellente nouvelle ! Votre envoi {$tracking} a été validé.",
            'en_cours' => "🚀 Votre envoi {$tracking} est maintenant en cours de traitement.",
            'en_transit' => "🚛 Votre marchandise {$demande->marchandise} est en transit vers {$demande->destination}.",
            'livree' => "🎉 Félicitations ! Votre marchandise {$demande->marchandise} a été livrée avec succès.",
            'terminee' => "✅ Votre envoi {$tracking} a été traité avec succès.",
            'annulee' => "❌ Votre envoi {$tracking} a été annulé.",
            'refusee' => "❌ Nous regrettons, votre envoi {$tracking} n'a pas pu être accepté."
        ];

        $message = $messages[$newStatus] ?? "📦 Le statut de votre envoi {$tracking} a été mis à jour vers: {$newStatus}.";
        $titre = "Mise à jour NIF Cargo - Statut: " . ucfirst($newStatus);

        self::envoyerNotification($user, $demande, $titre, $message);
    }

    /**
     * Notifier l'administrateur lors de la création d'une nouvelle demande
     */
    public static function notifyDemandeCreated(DemandeTransport $demande): void
    {
        try {
            // Récupérer les administrateurs
            $admins = User::where('role', 'admin')->get();

            if ($admins->isEmpty()) {
                Log::warning('Aucun administrateur trouvé pour notifier la création de demande', [
                    'demande_id' => $demande->id,
                ]);
                return;
            }

            $tracking = $demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT));
            $client = $demande->user;

            $titre = "Nouvelle demande de transport créée (Suivi: {$tracking})";
            $message = "🆕 Une nouvelle demande de transport vient d'être créée.\n" .
                "👤 Client: " . ($client->name ?? 'N/A') . " (" . ($client->email ?? 'N/A') . ")\n" .
                "📞 Téléphone: " . ($client->telephone ?? 'N/A') . "\n" .
                "📦 Marchandise: " . ($demande->marchandise ?? 'N/A') . " | Poids: " . ($demande->poids ?? 'N/A') . "\n" .
                "🌍 Origine: " . ($demande->origine ?? 'N/A') . " → Destination: " . ($demande->destination ?? 'N/A') . "\n" .
                "🗓️ Date souhaitée: " . ($demande->date_souhaitee ?? 'N/A');

            foreach ($admins as $admin) {
                try {
                    self::envoyerNotification($admin, $demande, $titre, $message);
                } catch (\Exception $e) {
                    Log::error('Erreur lors de la notification admin pour demande créée: ' . $e->getMessage(), [
                        'admin_id' => $admin->id,
                        'demande_id' => $demande->id,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('Erreur notifyDemandeCreated: ' . $e->getMessage(), [
                'demande_id' => $demande->id ?? null,
            ]);
        }
    }

    /**
     * Notifier le client quand le numéro de suivi est défini ou modifié
     */
    public static function notifyTrackingUpdated(DemandeTransport $demande): void
    {
        $user = $demande->user;
        if (!$user) {
            Log::warning('notifyTrackingUpdated: aucun utilisateur lié à la demande', ['demande_id' => $demande->id]);
            return;
        }

        $tracking = $demande->numero_tracking ?: '—';

        $titre = "Votre numéro de suivi a été mis à jour";
        $message = "🔎 Numéro de suivi: {$tracking}\n" .
                   "📍 Trajet: " . ($demande->origine ?? 'N/A') . " → " . ($demande->destination ?? 'N/A') . "\n\n" .
                   "Vous pouvez suivre votre colis depuis votre espace client.";

        try {
            self::envoyerNotification($user, $demande, $titre, $message);
        } catch (\Throwable $e) {
            Log::error('Erreur notifyTrackingUpdated: ' . $e->getMessage(), [
                'demande_id' => $demande->id,
                'user_id' => $user->id,
            ]);
        }
    }

    /**
     * Notifier le client qu'une demande a été modifiée par l'admin
     */
    public static function notifyDemandeModified(DemandeTransport $demande, array $oldData, array $newData): void
    {
        $user = $demande->user;
        if (!$user) {
            Log::warning('notifyDemandeModified: aucun utilisateur lié à la demande', ['demande_id' => $demande->id]);
            return;
        }

        $tracking = $demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT));

        $titre = "Modification de votre demande - NIF Cargo";
        $changes = [];
        
        if ($oldData['statut'] !== $newData['statut']) {
            $changes[] = "Statut: {$oldData['statut']} → {$newData['statut']}";
        }
        if ($oldData['origine'] !== $newData['origine']) {
            $changes[] = "Origine: {$oldData['origine']} → {$newData['origine']}";
        }
        if ($oldData['destination'] !== $newData['destination']) {
            $changes[] = "Destination: {$oldData['destination']} → {$newData['destination']}";
        }

        $message = "📝 Votre demande {$tracking} a été modifiée par notre équipe.\n\n";
        $message .= "Modifications apportées:\n" . implode("\n", $changes);
        $message .= "\n\nVous pouvez consulter les détails dans votre espace client.";

        try {
            self::envoyerNotification($user, $demande, $titre, $message);
            
            // Notifier aussi les admins de la modification
            self::notifyAdminsDemandeModified($demande, $oldData, $newData);
            
        } catch (\Throwable $e) {
            Log::error('Erreur notifyDemandeModified: ' . $e->getMessage(), [
                'demande_id' => $demande->id,
                'user_id' => $user->id,
            ]);
        }
    }

    /**
     * Notifier le client qu'une demande a été supprimée
     */
    public static function notifyDemandeSupprimee(DemandeTransport $demande): void
    {
        $user = $demande->user;
        if (!$user) {
            Log::warning('notifyDemandeSupprimee: aucun utilisateur lié à la demande', ['demande_id' => $demande->id]);
            return;
        }

        $tracking = $demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT));

        $titre = "Suppression de votre demande - NIF Cargo";
        $message = "❌ Nous vous informons que votre demande {$tracking} pour {$demande->marchandise} a été supprimée.\n\n";
        $message .= "Motif: Action administrative\n";
        $message .= "Si vous avez des questions, n'hésitez pas à nous contacter.";

        try {
            self::envoyerNotification($user, $demande, $titre, $message);
        } catch (\Throwable $e) {
            Log::error('Erreur notifyDemandeSupprimee: ' . $e->getMessage(), [
                'demande_id' => $demande->id,
                'user_id' => $user->id,
            ]);
        }
    }

    /**
     * Notifier les admins qu'un client a annulé sa demande
     */
    public static function notifyAdminsDemandeAnnulee(DemandeTransport $demande): void
    {
        try {
            $admins = User::where('role', 'admin')->get();

            if ($admins->isEmpty()) {
                Log::warning('Aucun administrateur trouvé pour notifier l\'annulation', [
                    'demande_id' => $demande->id,
                ]);
                return;
            }

            $tracking = $demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT));
            $client = $demande->user;

            $titre = "Demande annulée par le client - {$tracking}";
            $message = "🚫 Un client vient d'annuler sa demande de transport.\n\n" .
                "👤 Client: " . ($client->name ?? 'N/A') . " (" . ($client->email ?? 'N/A') . ")\n" .
                "📦 Marchandise: " . ($demande->marchandise ?? 'N/A') . "\n" .
                "🌍 Trajet: " . ($demande->origine ?? 'N/A') . " → " . ($demande->destination ?? 'N/A') . "\n" .
                "📅 Date d'annulation: " . now()->format('d/m/Y H:i');

            foreach ($admins as $admin) {
                try {
                    self::envoyerNotification($admin, $demande, $titre, $message);
                } catch (\Exception $e) {
                    Log::error('Erreur lors de la notification admin pour annulation: ' . $e->getMessage(), [
                        'admin_id' => $admin->id,
                        'demande_id' => $demande->id,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('Erreur notifyAdminsDemandeAnnulee: ' . $e->getMessage(), [
                'demande_id' => $demande->id ?? null,
            ]);
        }
    }

    /**
     * Notifier les admins qu'un client a modifié sa demande
     */
    public static function notifyAdminsDemandeModifiedByClient(DemandeTransport $demande, array $oldData, array $newData): void
    {
        try {
            $admins = User::where('role', 'admin')->get();

            if ($admins->isEmpty()) {
                Log::warning('Aucun administrateur trouvé pour notifier la modification client', [
                    'demande_id' => $demande->id,
                ]);
                return;
            }

            $tracking = $demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT));
            $client = $demande->user;

            $changes = [];
            if ($oldData['type_transport'] !== $newData['type_transport']) {
                $changes[] = "Type: {$oldData['type_transport']} → {$newData['type_transport']}";
            }
            if ($oldData['origine'] !== $newData['origine']) {
                $changes[] = "Origine: {$oldData['origine']} → {$newData['origine']}";
            }
            if ($oldData['destination'] !== $newData['destination']) {
                $changes[] = "Destination: {$oldData['destination']} → {$newData['destination']}";
            }
            if ($oldData['marchandise'] !== $newData['marchandise']) {
                $changes[] = "Marchandise: {$oldData['marchandise']} → {$newData['marchandise']}";
            }

            $titre = "Modification client - {$tracking}";
            $message = "✏️ Un client vient de modifier sa demande de transport.\n\n" .
                "👤 Client: " . ($client->name ?? 'N/A') . " (" . ($client->email ?? 'N/A') . ")\n" .
                "📦 Numéro de suivi: {$tracking}\n\n" .
                "Modifications apportées:\n" . implode("\n", $changes) . "\n\n" .
                "📅 Modifiée le: " . now()->format('d/m/Y H:i');

            foreach ($admins as $admin) {
                try {
                    self::envoyerNotification($admin, $demande, $titre, $message);
                } catch (\Exception $e) {
                    Log::error('Erreur lors de la notification admin pour modification client: ' . $e->getMessage(), [
                        'admin_id' => $admin->id,
                        'demande_id' => $demande->id,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('Erreur notifyAdminsDemandeModifiedByClient: ' . $e->getMessage(), [
                'demande_id' => $demande->id ?? null,
            ]);
        }
    }

    /**
     * Notifier les admins qu'une demande a été modifiée
     */
    private static function notifyAdminsDemandeModified(DemandeTransport $demande, array $oldData, array $newData): void
    {
        try {
            $admins = User::where('role', 'admin')->get();

            if ($admins->isEmpty()) {
                return;
            }

            $tracking = $demande->numero_tracking ?: ('TRK-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT));
            $client = $demande->user;

            $titre = "Demande modifiée - {$tracking}";
            $message = "📝 Une demande vient d'être modifiée.\n\n" .
                "👤 Client: " . ($client->name ?? 'N/A') . "\n" .
                "📦 Marchandise: " . ($demande->marchandise ?? 'N/A') . "\n" .
                "📅 Modifiée le: " . now()->format('d/m/Y H:i');

            foreach ($admins as $admin) {
                try {
                    self::envoyerNotification($admin, $demande, $titre, $message);
                } catch (\Exception $e) {
                    Log::error('Erreur notification admin modification: ' . $e->getMessage(), [
                        'admin_id' => $admin->id,
                        'demande_id' => $demande->id,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('Erreur notifyAdminsDemandeModified: ' . $e->getMessage());
        }
    }

    /**
     * Notifier le client que son compte a été modifié
     */
    public static function notifyClientAccountModified(User $client, array $oldData, array $newData): void
    {
        $titre = "Modification de votre compte - NIF Cargo";
        $changes = [];
        
        if ($oldData['name'] !== $newData['name']) {
            $changes[] = "Nom: {$oldData['name']} → {$newData['name']}";
        }
        if ($oldData['email'] !== $newData['email']) {
            $changes[] = "Email: {$oldData['email']} → {$newData['email']}";
        }
        if ($oldData['telephone'] !== $newData['telephone']) {
            $changes[] = "Téléphone: " . ($oldData['telephone'] ?: 'Non renseigné') . " → " . ($newData['telephone'] ?: 'Non renseigné');
        }

        $message = "📝 Votre compte NIF Cargo a été modifié par notre équipe administrateur.\n\n";
        if (!empty($changes)) {
            $message .= "Modifications apportées:\n" . implode("\n", $changes) . "\n\n";
        }
        $message .= "Si vous n'êtes pas à l'origine de ces modifications ou si vous avez des questions, contactez-nous immédiatement.";

        try {
            // Créer une demande fictive pour le template
            $demandeFictive = new \App\Models\DemandeTransport();
            $demandeFictive->id = 0;
            $demandeFictive->marchandise = 'Notification compte';
            
            self::envoyerNotification($client, $demandeFictive, $titre, $message);
        } catch (\Throwable $e) {
            Log::error('Erreur notifyClientAccountModified: ' . $e->getMessage(), [
                'client_id' => $client->id,
            ]);
        }
    }

    /**
     * Notifier le client que son compte a été suspendu
     */
    public static function notifyClientAccountSuspended(User $client): void
    {
        $titre = "Suspension de votre compte - NIF Cargo";
        $message = "🚫 Nous vous informons que votre compte NIF Cargo a été temporairement suspendu par notre équipe.\n\n";
        $message .= "Pendant la suspension, vous ne pourrez pas:\n";
        $message .= "• Créer de nouvelles demandes\n";
        $message .= "• Modifier vos demandes existantes\n";
        $message .= "• Accéder à certaines fonctionnalités\n\n";
        $message .= "Pour plus d'informations ou pour contester cette décision, contactez notre service client.";

        try {
            $demandeFictive = new \App\Models\DemandeTransport();
            $demandeFictive->id = 0;
            $demandeFictive->marchandise = 'Notification compte';
            
            self::envoyerNotification($client, $demandeFictive, $titre, $message);
        } catch (\Throwable $e) {
            Log::error('Erreur notifyClientAccountSuspended: ' . $e->getMessage(), [
                'client_id' => $client->id,
            ]);
        }
    }

    /**
     * Notifier le client que son compte a été réactivé
     */
    public static function notifyClientAccountActivated(User $client): void
    {
        $titre = "Réactivation de votre compte - NIF Cargo";
        $message = "✅ Excellente nouvelle ! Votre compte NIF Cargo a été réactivé.\n\n";
        $message .= "Vous pouvez maintenant:\n";
        $message .= "• Créer de nouvelles demandes de transport\n";
        $message .= "• Modifier vos demandes existantes\n";
        $message .= "• Accéder à toutes nos fonctionnalités\n\n";
        $message .= "Merci de votre patience et bienvenue de nouveau sur NIF Cargo !";

        try {
            $demandeFictive = new \App\Models\DemandeTransport();
            $demandeFictive->id = 0;
            $demandeFictive->marchandise = 'Notification compte';
            
            self::envoyerNotification($client, $demandeFictive, $titre, $message);
        } catch (\Throwable $e) {
            Log::error('Erreur notifyClientAccountActivated: ' . $e->getMessage(), [
                'client_id' => $client->id,
            ]);
        }
    }

    /**
     * Notifier le client que son compte va être supprimé
     */
    public static function notifyClientAccountDeleted(User $client): void
    {
        $titre = "Suppression de votre compte - NIF Cargo";
        $message = "❌ Nous vous informons que votre compte NIF Cargo a été supprimé par notre équipe administrative.\n\n";
        $message .= "Cette action est définitive. Toutes vos données personnelles et historiques de demandes ont été supprimées.\n\n";
        $message .= "Si vous souhaitez utiliser nos services à l'avenir, vous devrez créer un nouveau compte.\n\n";
        $message .= "Pour toute question concernant cette suppression, contactez notre service client.";

        try {
            $demandeFictive = new \App\Models\DemandeTransport();
            $demandeFictive->id = 0;
            $demandeFictive->marchandise = 'Notification compte';
            
            self::envoyerNotification($client, $demandeFictive, $titre, $message);
        } catch (\Throwable $e) {
            Log::error('Erreur notifyClientAccountDeleted: ' . $e->getMessage(), [
                'client_id' => $client->id,
            ]);
        }
    }

    /**
     * Envoyer un email de notification générique
     */
    public static function sendNotificationEmail(string $email, string $title, string $message, string $type = 'info'): void
    {
        try {
            $typeIcons = [
                'info' => '📢',
                'reminder' => '⏰',
                'warning' => '⚠️',
                'promotion' => '🎉'
            ];

            $typeColors = [
                'info' => '#3b82f6',
                'reminder' => '#f59e0b',
                'warning' => '#ef4444',
                'promotion' => '#10b981'
            ];

            $icon = $typeIcons[$type] ?? '📢';
            $color = $typeColors[$type] ?? '#3b82f6';

            $htmlMessage = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>{$title}</title>
            </head>
            <body style='font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; background-color: #f8fafc;'>
                <div style='max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);'>
                    <!-- Header -->
                    <div style='background: linear-gradient(135deg, {$color}, #667eea); padding: 30px; text-align: center;'>
                        <div style='font-size: 48px; margin-bottom: 15px;'>{$icon}</div>
                        <h1 style='color: white; margin: 0; font-size: 24px; font-weight: bold;'>{$title}</h1>
                    </div>
                    
                    <!-- Content -->
                    <div style='padding: 30px;'>
                        <div style='background: #f8fafc; padding: 20px; border-radius: 8px; border-left: 4px solid {$color}; margin-bottom: 20px;'>
                            <p style='margin: 0; font-size: 16px; color: #374151; white-space: pre-line;'>{$message}</p>
                        </div>
                        
                        <div style='text-align: center; margin-top: 30px;'>
                            <a href='" . config('app.url') . "' style='background: {$color}; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>
                                Accéder à mon compte
                            </a>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div style='background: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;'>
                        <p style='margin: 0; font-size: 14px; color: #6b7280;'>
                            <strong>NIF Cargo</strong><br>
                            Votre partenaire de confiance pour le transport<br>
                            📱 +33 X XX XX XX XX | ✉️ contact@nifcargo.com
                        </p>
                    </div>
                </div>
            </body>
            </html>";

            Mail::send([], [], function ($message) use ($email, $title, $htmlMessage) {
                $message->to($email)
                        ->subject($title)
                        ->html($htmlMessage);
            });

            Log::info('Email de notification envoyé', [
                'email' => $email,
                'type' => $type,
                'title' => $title
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur envoi email notification: ' . $e->getMessage(), [
                'email' => $email,
                'type' => $type
            ]);
        }
    }

    /**
     * Envoyer un message WhatsApp générique
     */
    public static function sendWhatsAppMessage(string $phone, string $message): void
    {
        try {
            // Normaliser le numéro de téléphone
            $phone = self::normalizePhoneNumber($phone);
            
            // Créer une notification temporaire pour utiliser la méthode existante
            $notification = new \App\Models\Notification([
                'type' => 'custom_whatsapp',
                'data' => ['message' => $message]
            ]);

            // Utiliser l'API 360dialog directement
            $response = Http::withHeaders([
                'D360-API-KEY' => config('services.whatsapp.360dialog.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.whatsapp.360dialog.webhook_url') . '/messages', [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $phone,
                'type' => 'text',
                'text' => ['body' => $message]
            ]);

            if (!$response->successful()) {
                throw new \Exception('Échec envoi 360dialog: ' . $response->body());
            }

            Log::info('Message WhatsApp personnalisé envoyé', [
                'phone' => $phone,
                'message_length' => strlen($message)
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur envoi WhatsApp personnalisé: ' . $e->getMessage(), [
                'phone' => $phone
            ]);
        }
    }

    /**
     * Normaliser un numéro de téléphone
     */
    private static function normalizePhoneNumber(string $phone): string
    {
        // Supprimer tous les espaces et caractères spéciaux
        $phone = preg_replace('/[^\d+]/', '', $phone);
        
        // Ajouter le préfixe +228 si nécessaire (Togo par défaut)
        if (!str_starts_with($phone, '+')) {
            $phone = '+228' . ltrim($phone, '0');
        }
        
        return $phone;
    }
}