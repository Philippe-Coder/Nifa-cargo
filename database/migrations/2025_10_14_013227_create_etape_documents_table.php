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
        Schema::create('etape_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etape_logistique_id')->constrained('etape_logistiques')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Qui a uploadé le document
            $table->string('nom'); // Nom du fichier
            $table->string('chemin'); // Chemin de stockage
            $table->string('type')->nullable(); // Type MIME
            $table->integer('taille')->nullable(); // Taille en octets
            $table->text('description')->nullable(); // Description optionnelle
            $table->enum('visibilite', ['admin', 'client', 'tous'])->default('tous'); // Qui peut voir ce document
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etape_documents');
    }
};
