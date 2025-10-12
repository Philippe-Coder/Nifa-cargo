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
        Schema::create('galeries', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('image'); // Chemin vers l'image
            $table->string('categorie')->default('transport'); // transport, import, export, entreprise, equipe
            $table->boolean('active')->default(true);
            $table->boolean('mise_en_avant')->default(false); // pour mettre en avant sur la page d'accueil
            $table->unsignedBigInteger('user_id'); // admin qui a ajouté la photo
            $table->integer('ordre')->default(0); // pour l'ordre d'affichage
            $table->string('alt_text')->nullable(); // texte alternatif pour l'accessibilité
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['active', 'categorie', 'mise_en_avant', 'ordre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeries');
    }
};
