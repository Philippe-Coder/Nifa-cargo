<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Galerie;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Créer quelques galeries de test si elles n'existent pas
        if (Galerie::count() === 0) {
            $admin = User::where('role', 'admin')->first();
            $userId = $admin ? $admin->id : 1;
            
            $galeries = [
                [
                    'titre' => 'Notre équipe logistique au travail',
                    'description' => 'Découvrez notre équipe professionnelle en action dans nos entrepôts modernes.',
                    'image' => 'galerie/team-work.jpg',
                    'categorie' => 'equipe',
                    'active' => true,
                    'mise_en_avant' => true,
                    'user_id' => $userId,
                    'ordre' => 10,
                    'alt_text' => 'Équipe NIF Cargo travaillant dans l\'entrepôt'
                ],
                [
                    'titre' => 'Flotte de véhicules modernes',
                    'description' => 'Nos camions et véhicules de transport dernière génération pour vos marchandises.',
                    'image' => 'galerie/vehicles-fleet.jpg',
                    'categorie' => 'vehicules',
                    'active' => true,
                    'mise_en_avant' => true,
                    'user_id' => $userId,
                    'ordre' => 9,
                    'alt_text' => 'Flotte de véhicules NIF Cargo'
                ],
                [
                    'titre' => 'Opérations de transport maritime',
                    'description' => 'Nos activités de transport maritime vers l\'Afrique et l\'Europe.',
                    'image' => 'galerie/maritime-transport.jpg',
                    'categorie' => 'transport',
                    'active' => true,
                    'mise_en_avant' => true,
                    'user_id' => $userId,
                    'ordre' => 8,
                    'alt_text' => 'Conteneurs en cours de chargement'
                ],
                [
                    'titre' => 'Entrepôt sécurisé et moderne',
                    'description' => 'Nos installations de stockage équipées des dernières technologies.',
                    'image' => 'galerie/warehouse-modern.jpg',
                    'categorie' => 'entrepots',
                    'active' => true,
                    'mise_en_avant' => false,
                    'user_id' => $userId,
                    'ordre' => 7,
                    'alt_text' => 'Entrepôt NIF Cargo avec équipements modernes'
                ],
                [
                    'titre' => 'Nos locaux et bureaux',
                    'description' => 'Visitez nos locaux modernes où notre équipe vous accueille.',
                    'image' => 'galerie/office-building.jpg',
                    'categorie' => 'entreprise',
                    'active' => true,
                    'mise_en_avant' => false,
                    'user_id' => $userId,
                    'ordre' => 6,
                    'alt_text' => 'Bureaux de NIF Cargo'
                ],
                [
                    'titre' => 'Services d\'importation',
                    'description' => 'Nos services spécialisés pour l\'importation de marchandises.',
                    'image' => 'galerie/import-services.jpg',
                    'categorie' => 'import',
                    'active' => true,
                    'mise_en_avant' => false,
                    'user_id' => $userId,
                    'ordre' => 5,
                    'alt_text' => 'Services d\'importation NIF Cargo'
                ],
                [
                    'titre' => 'Partenaires de confiance',
                    'description' => 'Nos clients et partenaires qui nous font confiance.',
                    'image' => 'galerie/trusted-partners.jpg',
                    'categorie' => 'clients',
                    'active' => true,
                    'mise_en_avant' => false,
                    'user_id' => $userId,
                    'ordre' => 4,
                    'alt_text' => 'Partenaires et clients de NIF Cargo'
                ],
                [
                    'titre' => 'Services d\'exportation',
                    'description' => 'Expertise en exportation vers tous les continents.',
                    'image' => 'galerie/export-services.jpg',
                    'categorie' => 'export',
                    'active' => true,
                    'mise_en_avant' => false,
                    'user_id' => $userId,
                    'ordre' => 3,
                    'alt_text' => 'Services d\'exportation NIF Cargo'
                ]
            ];
            
            foreach ($galeries as $galerie) {
                Galerie::create($galerie);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ne rien faire - on ne veut pas supprimer les galeries existantes
    }
};