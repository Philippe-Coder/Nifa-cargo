<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('demande_transports') && Schema::hasColumn('demande_transports', 'reference')) {
            // Supprimer l'unicité si elle existe (MySQL ne permet pas de supprimer l'index implicite sans nom explicite, donc on tente DROP INDEX si besoin)
            try {
                DB::statement("ALTER TABLE `demande_transports` DROP INDEX `demande_transports_reference_unique`");
            } catch (\Throwable $e) {
                // ignore si l'index n'existe pas
            }
            // Supprimer la colonne
            DB::statement("ALTER TABLE `demande_transports` DROP COLUMN `reference`");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('demande_transports') && !Schema::hasColumn('demande_transports', 'reference')) {
            DB::statement("ALTER TABLE `demande_transports` ADD COLUMN `reference` VARCHAR(255) NULL");
            try {
                DB::statement("ALTER TABLE `demande_transports` ADD UNIQUE `demande_transports_reference_unique` (`reference`)");
            } catch (\Throwable $e) {
                // ignore if add unique fails
            }
        }
    }
};
