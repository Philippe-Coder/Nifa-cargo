<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Corriger l'ordre des étapes de transport:
     * - Ancien ordre: 1=Enregistrement, 2=Dédouanement, 3=Transit, 4=Livraison
     * - Nouvel ordre: 1=Enregistrement, 2=Transit, 3=Dédouanement, 4=Livraison
     */
    public function up(): void
    {
        // Mettre à jour l'ordre des étapes existantes
        DB::statement("
            UPDATE etape_logistiques 
            SET ordre = CASE 
                WHEN nom = 'Enregistrement' THEN 1
                WHEN nom = 'Transit' THEN 2  
                WHEN nom = 'Dédouanement' THEN 3
                WHEN nom = 'Livraison' THEN 4
                ELSE ordre
            END
        ");
        
        // Mettre à jour les étapes avec les anciens ordres hardcodés
        DB::statement("
            UPDATE etape_logistiques 
            SET ordre = CASE 
                WHEN ordre = 2 AND nom != 'Transit' THEN 3 -- Ancien dédouanement (ordre 2) devient ordre 3
                WHEN ordre = 3 AND nom != 'Dédouanement' THEN 2 -- Ancien transit (ordre 3) devient ordre 2
                ELSE ordre
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * Revenir à l'ancien ordre en cas de rollback:
     * - Nouvel ordre: 1=Enregistrement, 2=Transit, 3=Dédouanement, 4=Livraison
     * - Ancien ordre: 1=Enregistrement, 2=Dédouanement, 3=Transit, 4=Livraison
     */
    public function down(): void
    {
        // Restaurer l'ancien ordre
        DB::statement("
            UPDATE etape_logistiques 
            SET ordre = CASE 
                WHEN nom = 'Enregistrement' THEN 1
                WHEN nom = 'Dédouanement' THEN 2  
                WHEN nom = 'Transit' THEN 3
                WHEN nom = 'Livraison' THEN 4
                ELSE ordre
            END
        ");
    }
};