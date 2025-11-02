<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Augmenter la précision des colonnes monétaires et ajouter volume si manquant
        if (Schema::hasTable('demande_transports')) {
            // valeur => DECIMAL(15,2)
            if (Schema::hasColumn('demande_transports', 'valeur')) {
                DB::statement("ALTER TABLE `demande_transports` MODIFY COLUMN `valeur` DECIMAL(15,2) NULL");
            }
            // montant => DECIMAL(15,2)
            if (Schema::hasColumn('demande_transports', 'montant')) {
                DB::statement("ALTER TABLE `demande_transports` MODIFY COLUMN `montant` DECIMAL(15,2) NULL");
            }
            // frais_expedition => créer si manquant, sinon élargir
            if (Schema::hasColumn('demande_transports', 'frais_expedition')) {
                DB::statement("ALTER TABLE `demande_transports` MODIFY COLUMN `frais_expedition` DECIMAL(15,2) NULL");
            } else {
                DB::statement("ALTER TABLE `demande_transports` ADD COLUMN `frais_expedition` DECIMAL(15,2) NULL AFTER `valeur`");
            }
            // volume => ajouter si manquant
            if (!Schema::hasColumn('demande_transports', 'volume')) {
                DB::statement("ALTER TABLE `demande_transports` ADD COLUMN `volume` DECIMAL(10,2) NULL AFTER `poids`");
            }
        }
    }

    public function down(): void
    {
        // Pas de réduction de précision pour éviter perte de données
    }
};
