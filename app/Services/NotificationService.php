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
                    'parameters' => [ ['type' => 'text', 'text' => $demande->reference ?? ('REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT)) ],
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
        // Priorité 1: Meta WhatsApp Cloud API (n'exige pas que le client écrive en premier, via template)
        if (env('WHATSAPP_ACCESS_TOKEN') && env('WHATSAPP_PHONE_NUMBER_ID')) {
            self::envoyerWhatsAppMeta($user, $demande, $message);
            return;
        }
        // Priorité 2: Twilio
        if (env('TWILIO_SID') && env('TWILIO_AUTH_TOKEN') && env('TWILIO_WHATSAPP_NUMBER')) {
            self::envoyerWhatsAppTwilio($user, $demande, $message);
            return;
        }
        // Priorité 3: CallMeBot (dépannage/démo; nécessite autorisation manuelle côté utilisateur)
        if (env('CALLMEBOT_API_KEY')) {
            self::envoyerWhatsAppCallMeBot($user, $demande, $message);
            return;
        }
        throw new \Exception('Aucun service WhatsApp configuré (Meta Cloud API recommandé, sinon Twilio).');
    }

    /**
     * Créer template HTML pour email
     */
    private static function creerTemplateEmail(User $user, DemandeTransport $demande, string $titre, string $message): string
    {
        $reference = $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT);
        
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
                    <div class='logo'>🚛 NIF CARGO</div>
                    <h2 style='margin: 10px 0 0 0;'>{$titre}</h2>
                </div>
                
                <div class='content'>
                    <p>Bonjour <strong>{$user->name}</strong>,</p>
                    <p>{$message}</p>
                    
                    <div class='info-box'>
                        <strong>📦 Référence :</strong> {$reference}<br>
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
                    <p>📞 <strong>Contact :</strong> +228 97 31 11 58 | 📧 contact@nifgroupecargo.com</p>
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
        $reference = $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT);

        // Messages selon le statut
        $messagesStatut = [
            'en_attente' => "🔄 L'étape '{nomEtape}' de votre demande {reference} est en attente de traitement.",
            'en_cours' => "🚀 Bonne nouvelle ! Votre demande {reference} pour {marchandise} est maintenant à l'étape: {nomEtape}.",
            'terminee' => "✅ Excellente nouvelle ! L'étape '{nomEtape}' de votre demande {reference} a été complétée avec succès."
        ];

        $titre = "Mise à jour NIF Cargo - Étape: {$nomEtape}";
        $message = $messagesStatut[$statut] ?? "📦 Votre demande {reference} pour {marchandise} vient de passer à l'étape: {nomEtape}.";

        // Remplacer les variables
        $message = str_replace(
            ['{nomEtape}', '{marchandise}', '{reference}', '{origine}', '{destination}'],
            [$nomEtape, $demande->marchandise ?? 'votre marchandise', $reference, $demande->origine ?? 'N/A', $demande->destination ?? 'N/A'],
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
        $reference = $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT);
        
        $messages = [
            'en_attente' => "🔄 Votre demande {$reference} est en attente de traitement.",
            'validee' => "✅ Excellente nouvelle ! Votre demande {$reference} a été validée.",
            'en_cours' => "🚀 Votre demande {$reference} est maintenant en cours de traitement.",
            'en_transit' => "🚛 Votre marchandise {$demande->marchandise} est en transit vers {$demande->destination}.",
            'livree' => "🎉 Félicitations ! Votre marchandise {$demande->marchandise} a été livrée avec succès.",
            'terminee' => "✅ Votre demande {$reference} a été traitée avec succès.",
            'annulee' => "❌ Votre demande {$reference} a été annulée.",
            'refusee' => "❌ Nous regrettons, votre demande {$reference} n'a pas pu être acceptée."
        ];

        $message = $messages[$newStatus] ?? "📦 Le statut de votre demande {$reference} a été mis à jour vers: {$newStatus}.";
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

            $reference = $demande->reference ?? 'REF-' . str_pad($demande->id, 6, '0', STR_PAD_LEFT);
            $client = $demande->user;

            $titre = "Nouvelle demande de transport créée ({$reference})";
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
}