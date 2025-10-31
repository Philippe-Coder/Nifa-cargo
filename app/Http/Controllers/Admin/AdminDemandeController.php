<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeTransport;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminDemandeController extends Controller
{
    // Pas d'injection de dépendance, on utilisera les méthodes statiques

    /**
     * Affiche le formulaire de création d'une demande par l'admin
     */
    public function create()
    {
        return view('admin.demandes.create');
    }

    /**
     * Recherche de clients existants via AJAX
     */
    public function searchClients(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $clients = User::where('role', 'client')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('telephone', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email', 'telephone']);

        return response()->json($clients);
    }

    /**
     * Génère un numéro de tracking unique
     */
    private function generateTrackingNumber(): string
    {
        do {
            $trackingNumber = 'TRK' . date('Ym') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (DemandeTransport::where('numero_tracking', $trackingNumber)->exists());

        return $trackingNumber;
    }

    /**
     * Génère un mot de passe temporaire
     */
    private function generateTemporaryPassword(): string
    {
        return 'NIF' . date('Y') . mt_rand(1000, 9999);
    }

    /**
     * Crée ou trouve un client existant
     */
    private function findOrCreateClient($data)
    {
        // Chercher d'abord par email
        $client = User::where('email', $data['email'])->first();
        $isNewClient = false;
        $temporaryPassword = null;
        
        if ($client) {
            // Mettre à jour les informations si nécessaire
            $client->update([
                'name' => $data['name'],
                'telephone' => $data['telephone'],
            ]);
        } else {
            // Créer un nouveau client avec mot de passe temporaire
            $temporaryPassword = $this->generateTemporaryPassword();
            $isNewClient = true;
            
            $client = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'telephone' => $data['telephone'],
                'password' => Hash::make($temporaryPassword),
                'role' => 'client',
                'email_verified_at' => now(), // Auto-vérifier le compte créé par admin
            ]);

            // Envoyer les identifiants par email et WhatsApp
            $this->sendWelcomeNotifications($client, $temporaryPassword);
        }

        return ['client' => $client, 'isNew' => $isNewClient, 'password' => $temporaryPassword];
    }

    /**
     * Envoie les notifications de bienvenue avec les identifiants
     */
    private function sendWelcomeNotifications(User $client, string $password)
    {
        try {
            \Illuminate\Support\Facades\Log::info("🚀 Début envoi notifications de bienvenue pour {$client->email}");
            
            // Envoi d'email de bienvenue avec template Blade
            \Illuminate\Support\Facades\Mail::send('emails.welcome-client', [
                'client_name' => $client->name,
                'email' => $client->email,
                'password' => $password,
                'login_url' => route('login')
            ], function ($mail) use ($client) {
                $mail->to($client->email, $client->name)
                     ->subject('🎉 Bienvenue chez NIF CARGO - Vos identifiants de connexion')
                     ->from(config('mail.from.address'), config('mail.from.name'));
            });
            \Illuminate\Support\Facades\Log::info("📧 Email envoyé à {$client->email}");

            // Envoyer aussi par WhatsApp si numéro disponible
            if ($client->telephone) {
                \Illuminate\Support\Facades\Log::info("📱 Tentative WhatsApp pour {$client->telephone}");
                
                $whatsappMessage = "🎉 Bienvenue chez NIF CARGO!\n\n" .
                                 "Votre compte a été créé avec succès par notre équipe.\n\n" .
                                 "📧 Email de connexion: {$client->email}\n" .
                                 "🔐 Mot de passe temporaire: {$password}\n\n" .
                                 "🌐 Connectez-vous sur: " . route('login') . "\n\n" .
                                 "Vous pouvez modifier votre mot de passe après votre première connexion.\n\n" .
                                 "Merci de nous faire confiance pour vos expéditions! 🚚📦";

                $this->sendWhatsAppMessage($client, $whatsappMessage);
                \Illuminate\Support\Facades\Log::info("📱 WhatsApp traité pour {$client->telephone}");
            } else {
                \Illuminate\Support\Facades\Log::info("📱 Pas de numéro WhatsApp pour {$client->email}");
            }
            
            \Illuminate\Support\Facades\Log::info("✅ Notifications de bienvenue envoyées à {$client->email}");
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("❌ Erreur notifications de bienvenue pour {$client->email}: " . $e->getMessage());
            \Illuminate\Support\Facades\Log::error("❌ Stack trace: " . $e->getTraceAsString());
        }
    }



    /**
     * Envoie un message WhatsApp
     */
    private function sendWhatsAppMessage(User $client, string $message)
    {
        try {
            // Priorité: 360dialog > Meta WhatsApp > Twilio > CallMeBot
            if (env('WHATSAPP_360_API_KEY')) {
                // Méthode 360dialog (Recommandée)
                \Illuminate\Support\Facades\Log::info("📱 Utilisation 360dialog pour WhatsApp");
                $this->sendWhatsAppMeta($client, $message);
            } elseif (env('WHATSAPP_ACCESS_TOKEN') && env('WHATSAPP_PHONE_NUMBER_ID')) {
                // Méthode Meta WhatsApp Cloud API
                \Illuminate\Support\Facades\Log::info("📱 Utilisation Meta WhatsApp Cloud API");
                $this->sendWhatsAppMeta($client, $message);
            } elseif (env('TWILIO_SID') && env('TWILIO_AUTH_TOKEN')) {
                // Méthode Twilio
                \Illuminate\Support\Facades\Log::info("📱 Utilisation Twilio WhatsApp");
                $this->sendWhatsAppTwilio($client, $message);
            } elseif (env('CALLMEBOT_API_KEY')) {
                // Méthode CallMeBot
                \Illuminate\Support\Facades\Log::info("📱 Utilisation CallMeBot WhatsApp");
                $this->sendWhatsAppCallMeBot($client, $message);
            } else {
                \Illuminate\Support\Facades\Log::warning("📱 Aucune configuration WhatsApp trouvée");
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("❌ Erreur WhatsApp pour {$client->telephone}: " . $e->getMessage());
        }
    }

    /**
     * Envoie WhatsApp via 360dialog API
     */
    private function sendWhatsAppMeta(User $client, string $message)
    {
        $apiKey = env('WHATSAPP_360_API_KEY');
        $baseUrl = env('WHATSAPP_360_BASE_URL', 'https://waba-sandbox.360dialog.io');
        
        if (!$apiKey) {
            \Illuminate\Support\Facades\Log::warning("360dialog API Key manquante");
            return;
        }
        
        $phone = $this->formatPhoneE164($client->telephone);
        $url = $baseUrl . '/v1/messages';

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ];

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'D360-API-KEY' => $apiKey,
                'Content-Type' => 'application/json'
            ])->post($url, $payload);

            if ($response->successful()) {
                \Illuminate\Support\Facades\Log::info("📱 WhatsApp envoyé via 360dialog à {$phone}");
            } else {
                \Illuminate\Support\Facades\Log::error("❌ Erreur 360dialog: " . $response->body());
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("❌ Erreur WhatsApp 360dialog: " . $e->getMessage());
        }
    }

    /**
     * Envoie WhatsApp via Twilio
     */
    private function sendWhatsAppTwilio(User $client, string $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER');
        
        $twilio = new \Twilio\Rest\Client($sid, $token);
        
        $phone = 'whatsapp:' . $this->formatPhoneE164($client->telephone);

        $twilio->messages->create($phone, [
            'from' => $twilioWhatsAppNumber,
            'body' => $message
        ]);
    }

    /**
     * Envoie WhatsApp via CallMeBot
     */
    private function sendWhatsAppCallMeBot(User $client, string $message)
    {
        $apiKey = env('CALLMEBOT_API_KEY');
        $phone = preg_replace('/[^0-9]/', '', $client->telephone);
        
        $url = "https://api.callmebot.com/whatsapp.php";
        
        \Illuminate\Support\Facades\Http::get($url, [
            'phone' => $phone,
            'text' => $message,
            'apikey' => $apiKey
        ]);
    }

    /**
     * Normalise le numéro de téléphone au format E.164
     */
    private function formatPhoneE164(string $phone): string
    {
        $p = preg_replace('/[^0-9+]/', '', $phone ?? '');
        if (!$p) {
            throw new \Exception('Numéro de téléphone manquant');
        }
        if (str_starts_with($p, '+')) {
            return $p;
        }
        $defaultCc = env('DEFAULT_PHONE_COUNTRY_CODE', '+228');
        $cc = '+' . ltrim($defaultCc, '+');
        $local = ltrim($p, '0');
        return $cc . $local;
    }

    /**
     * Enregistre une nouvelle demande créée par l'admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_telephone' => 'required|string|max:20',
            'type' => 'required|in:maritime,aérien,routier',
            'type_transport' => 'required|string|max:255',
            'origine' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'ville_depart' => 'required|string|max:255',
            'ville_destination' => 'required|string|max:255',
            'poids' => 'required|numeric|min:0',
            'volume' => 'nullable|numeric|min:0',
            'nature_colis' => 'required|string|max:500',
            'frais_expedition' => 'nullable|numeric|min:0',
            'statut' => 'required|in:en attente,en cours,en transit,livrée,annulée',
            'description' => 'nullable|string|max:1000',
            'date_souhaitee' => 'nullable|date|after_or_equal:today',
            'valeur' => 'nullable|numeric|min:0',
            'fragile' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Créer ou trouver le client
            $clientData = $this->findOrCreateClient([
                'name' => $request->client_name,
                'email' => $request->client_email,
                'telephone' => $request->client_telephone,
            ]);
            
            $client = $clientData['client'];
            $isNewClient = $clientData['isNew'];

            // Créer la demande
            $demande = DemandeTransport::create([
                'user_id' => $client->id,
                'type' => $request->type,
                'type_transport' => $request->type_transport,
                'marchandise' => $request->nature_colis, // On utilise nature_colis pour marchandise
                'poids' => $request->poids,
                'volume' => $request->volume,
                'nature_colis' => $request->nature_colis,
                'origine' => $request->origine,
                'destination' => $request->destination,
                'ville_depart' => $request->ville_depart,
                'ville_destination' => $request->ville_destination,
                'description' => $request->description,
                'statut' => $request->statut,
                'date_souhaitee' => $request->date_souhaitee,
                'valeur' => $request->valeur,
                'fragile' => $request->boolean('fragile'),
                'frais_expedition' => $request->frais_expedition,
                'numero_tracking' => $this->generateTrackingNumber(),
                'created_by_admin' => true,
            ]);

            // Créer les étapes par défaut
            $demande->creerEtapesParDefaut();

            // Envoyer notification de création de demande au client
            $this->sendDemandeCreationNotification($client, $demande);

            DB::commit();

            return redirect()
                ->route('admin.demandes.show', $demande->id)
                ->with('success', 'Demande créée avec succès! Le client a été notifié par email et WhatsApp.');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création de la demande: ' . $e->getMessage());
        }
    }

    /**
     * Envoie les notifications de création de demande
     */
    private function sendDemandeCreationNotification(User $client, DemandeTransport $demande)
    {
        try {
            \Illuminate\Support\Facades\Log::info("🚀 Envoi notification demande créée pour {$client->email} - Tracking: {$demande->numero_tracking}");
            
            // Envoi d'email avec template Blade  
            \Illuminate\Support\Facades\Mail::send('emails.demande-created-by-admin', [
                'client_name' => $client->name,
                'demande' => $demande,
                'tracking_number' => $demande->numero_tracking,
                'suivi_url' => route('suivi.public') . '?tracking=' . $demande->numero_tracking,
                'login_url' => route('login')
            ], function ($mail) use ($client, $demande) {
                $mail->to($client->email, $client->name)
                     ->subject('📦 Nouvelle demande de transport créée - ' . $demande->numero_tracking)
                     ->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            // Message WhatsApp
            $whatsappMessage = "📦 Nouvelle expédition créée!\n\n" .
                              "Bonjour {$client->name},\n\n" .
                              "Une nouvelle demande de transport a été créée pour vous:\n\n" .
                              "🔍 N° de suivi: {$demande->numero_tracking}\n" .
                              "📍 Trajet: {$demande->ville_depart} → {$demande->ville_destination}\n" .
                              "📦 Nature: {$demande->nature_colis}\n" .
                              "⚖️ Poids: {$demande->poids} kg\n" .
                              "📊 Statut: " . ucfirst($demande->statut) . "\n\n" .
                              "Suivez votre colis sur: " . route('suivi.public') . "\n" .
                              "Ou connectez-vous à votre espace: " . route('login') . "\n\n" .
                              "NIF CARGO - Transport & Logistique 🚚";

            // Envoyer WhatsApp si numéro disponible
            if ($client->telephone) {
                $this->sendWhatsAppMessage($client, $whatsappMessage);
            }
            
            \Illuminate\Support\Facades\Log::info("✅ Notifications demande créée envoyées à {$client->email}");
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("❌ Erreur notification demande créée pour {$client->email}: " . $e->getMessage());
        }
    }

    /**
     * Récupère les informations d'un client par ID
     */
    public function getClient(Request $request, $id)
    {
        $client = User::where('role', 'client')->findOrFail($id);
        
        return response()->json([
            'id' => $client->id,
            'name' => $client->name,
            'email' => $client->email,
            'telephone' => $client->telephone,
        ]);
    }
}