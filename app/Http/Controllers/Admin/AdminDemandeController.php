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
        return view('admin.demandes.create-simple');
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
    private function findOrCreateClient($data): User
    {
        // Chercher d'abord par email
        $client = User::where('email', $data['email'])->first();
        
        if ($client) {
            // Mettre à jour les informations si nécessaire
            $client->update([
                'name' => $data['name'],
                'telephone' => $data['telephone'],
            ]);
            return $client;
        }

        // Créer un nouveau client avec mot de passe temporaire
        $temporaryPassword = $this->generateTemporaryPassword();
        
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

        return $client;
    }

    /**
     * Envoie les notifications de bienvenue avec les identifiants
     */
    private function sendWelcomeNotifications(User $client, string $password)
    {
        // Créer une demande temporaire pour les notifications
        $tempDemande = new DemandeTransport([
            'marchandise' => 'Nouveau compte client',
            'origine' => 'NIF CARGO',
            'destination' => 'Espace client',
        ]);

        $message = "🎉 Bienvenue chez NIF CARGO!\n\n" .
                  "Votre compte a été créé avec succès par notre équipe.\n\n" .
                  "📧 Email de connexion: {$client->email}\n" .
                  "🔐 Mot de passe temporaire: {$password}\n\n" .
                  "🌐 Connectez-vous sur: " . route('login') . "\n\n" .
                  "Vous pouvez modifier votre mot de passe après votre première connexion.\n\n" .
                  "Merci de nous faire confiance pour vos expéditions! 🚚📦";

        $titre = 'Bienvenue chez NIF CARGO - Vos identifiants de connexion';

        // Utiliser le service de notification existant
        NotificationService::envoyerNotification($client, $tempDemande, $titre, $message);
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
            $client = $this->findOrCreateClient([
                'name' => $request->client_name,
                'email' => $request->client_email,
                'telephone' => $request->client_telephone,
            ]);

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
        $message = "📦 Nouvelle expédition créée!\n\n" .
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

        $titre = 'Nouvelle demande de transport créée - ' . $demande->numero_tracking;

        // Utiliser le service de notification existant
        NotificationService::envoyerNotification($client, $demande, $titre, $message);
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