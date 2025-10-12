<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DemandeTransport;
use App\Models\User;

class DemandeTransportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer l'utilisateur client de test
        $client = User::where('email', 'client@nifa.com')->first();
        
        if ($client) {
            // Créer quelques demandes de test
            DemandeTransport::create([
                'user_id' => $client->id,
                'type' => 'import',
                'type_transport' => 'import',
                'marchandise' => 'Électronique',
                'poids' => 150.50,
                'origine' => 'Chine',
                'destination' => 'Bénin',
                'ville_depart' => 'Shanghai',
                'ville_destination' => 'Cotonou',
                'description' => 'Importation de matériel électronique',
                'statut' => 'en attente',
                'reference' => 'NIFA-' . date('Y') . '-001',
                'date_souhaitee' => now()->addDays(30),
                'dimensions' => '120x80x60 cm',
                'valeur' => 15000.00,
                'fragile' => true,
                'montant' => 2500.00,
            ]);

            DemandeTransport::create([
                'user_id' => $client->id,
                'type' => 'export',
                'type_transport' => 'export',
                'marchandise' => 'Produits agricoles',
                'poids' => 2000.00,
                'origine' => 'Bénin',
                'destination' => 'France',
                'ville_depart' => 'Cotonou',
                'ville_destination' => 'Marseille',
                'description' => 'Export de produits agricoles locaux',
                'statut' => 'validée',
                'reference' => 'NIFA-' . date('Y') . '-002',
                'date_souhaitee' => now()->addDays(15),
                'dimensions' => '200x150x100 cm',
                'valeur' => 8000.00,
                'fragile' => false,
                'montant' => 3500.00,
            ]);

            DemandeTransport::create([
                'user_id' => $client->id,
                'type' => 'import',
                'type_transport' => 'import',
                'marchandise' => 'Véhicules',
                'poids' => 1500.00,
                'origine' => 'Allemagne',
                'destination' => 'Bénin',
                'ville_depart' => 'Hamburg',
                'ville_destination' => 'Cotonou',
                'description' => 'Importation de véhicules d\'occasion',
                'statut' => 'livrée',
                'reference' => 'NIFA-' . date('Y') . '-003',
                'date_souhaitee' => now()->subDays(5),
                'dimensions' => '450x180x150 cm',
                'valeur' => 25000.00,
                'fragile' => false,
                'montant' => 5000.00,
            ]);
        }
    }
}
