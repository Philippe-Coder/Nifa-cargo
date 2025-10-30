<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Renommer les champs existants pour correspondre à notre modèle
            $table->renameColumn('content', 'contenu');
            $table->renameColumn('is_approved', 'approuve');
            
            // Ajouter les champs pour les invités
            $table->string('nom')->nullable()->after('user_id');
            $table->string('email')->nullable()->after('nom');
            
            // Permettre à user_id d'être nullable
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Supprimer les champs ajoutés
            $table->dropColumn(['nom', 'email']);
            
            // Renommer les champs pour revenir à l'ancien état
            $table->renameColumn('contenu', 'content');
            $table->renameColumn('approuve', 'is_approved');
            
            // Rendre user_id obligatoire
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
