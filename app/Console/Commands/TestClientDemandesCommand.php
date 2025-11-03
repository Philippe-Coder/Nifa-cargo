<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\DemandeTransport;
use Illuminate\Support\Facades\Hash;

class TestClientDemandesCommand extends Command
{
    protected $signature = 'test:client-demandes';
    protected $description = 'Tester la visibilité des demandes côté client';

    public function handle()
    {
        $this->info("=== TEST : Visibilité des demandes côté client ===\n");

        // 1. Vérifier les utilisateurs
        $this->info("1. Utilisateurs dans la base :");
        $users = User::select('id', 'name', 'email', 'role')->get();
        foreach ($users as $user) {
            $this->line("   - ID: {$user->id} | {$user->name} ({$user->email}) - Rôle: {$user->role}");
        }

        // 2. Vérifier les demandes
        $this->info("\n2. Demandes dans la base :");
        $demandes = DemandeTransport::select('id', 'user_id', 'numero_tracking', 'marchandise', 'created_by_admin')->get();
        foreach ($demandes as $demande) {
            $user = User::find($demande->user_id);
            $userName = $user ? $user->name : 'UTILISATEUR INTROUVABLE';
            $createdBy = $demande->created_by_admin ? 'Admin' : 'Client';
            $this->line("   - ID: {$demande->id} | Tracking: {$demande->numero_tracking} | User: {$userName} (ID: {$demande->user_id}) | Créée par: {$createdBy}");
        }

        // 3. Test pour chaque client
        $clients = User::where('role', 'client')->get();
        $this->info("\n3. Test visibilité pour chaque client :");
        
        foreach ($clients as $client) {
            $clientDemandes = DemandeTransport::where('user_id', $client->id)->get();
            $this->line("   - Client: {$client->name} (ID: {$client->id})");
            if ($clientDemandes->count() > 0) {
                foreach ($clientDemandes as $demande) {
                    $createdBy = $demande->created_by_admin ? ' [Créée par Admin]' : ' [Créée par Client]';
                    $this->line("     → Demande: {$demande->numero_tracking}{$createdBy}");
                }
            } else {
                $this->line("     → Aucune demande visible");
            }
        }

        // 4. Test création d'une demande par l'admin pour un client
        $this->info("\n4. Création d'une demande de test par l'admin :");
        $testClient = User::where('role', 'client')->first();
        
        if ($testClient) {
            $testDemande = DemandeTransport::create([
                'user_id' => $testClient->id,
                'type' => 'express',
                'type_transport' => 'aerien',
                'marchandise' => 'Test Admin Creation',
                'nature_colis' => 'Test Admin Creation',
                'nombre_cartons' => 1,
                'poids' => 5.0,
                'origine' => 'Lomé',
                'destination' => 'Paris',
                'ville_depart' => 'Lomé',
                'ville_destination' => 'Paris',
                'description' => 'Demande de test créée par l\'admin via command',
                'statut' => 'en_attente',
                'numero_tracking' => 'TEST' . rand(1000, 9999),
                'created_by_admin' => true,
            ]);
            
            $this->line("   ✅ Demande test créée avec succès !");
            $this->line("   - ID: {$testDemande->id}");
            $this->line("   - Tracking: {$testDemande->numero_tracking}");
            $this->line("   - Assignée au client: {$testClient->name} (ID: {$testClient->id})");
            $this->line("   - Marquée comme créée par admin: " . ($testDemande->created_by_admin ? 'OUI' : 'NON'));
        } else {
            $this->error("   ❌ Aucun client trouvé pour le test");
        }

        // 5. Vérification finale
        $this->info("\n5. Vérification finale :");
        $totalDemandes = DemandeTransport::count();
        $demandesAdmin = DemandeTransport::where('created_by_admin', true)->count();
        $demandesClient = DemandeTransport::where('created_by_admin', false)->count();
        
        $this->line("   - Total demandes: {$totalDemandes}");
        $this->line("   - Créées par admin: {$demandesAdmin}");
        $this->line("   - Créées par client: {$demandesClient}");

        $this->info("\n✅ Test terminé ! Vérifiez maintenant l'interface client sur http://127.0.0.1:8000");
        $this->info("Connectez-vous avec : {$testClient->email} (mot de passe par défaut)");

        return 0;
    }
}