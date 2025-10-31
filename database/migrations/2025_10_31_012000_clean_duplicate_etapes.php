<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Nettoyer les étapes dupliquées
        DB::statement("
            DELETE t1 FROM etape_logistiques t1
            INNER JOIN etape_logistiques t2 
            WHERE t1.id > t2.id 
            AND t1.demande_transport_id = t2.demande_transport_id 
            AND t1.nom = t2.nom
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Pas de rollback nécessaire pour un nettoyage
    }
};