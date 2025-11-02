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
        Schema::create('etape_logistiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_transport_id')->constrained()->onDelete('cascade');
            $table->string('nom'); // enregistrement, transit, dédouanement, livraison
            $table->text('description')->nullable();
            $table->enum('statut', ['en_attente', 'en_cours', 'terminee'])->default('en_attente');
            $table->datetime('date_debut')->nullable();
            $table->datetime('date_fin')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('commentaire')->nullable();
            $table->integer('ordre')->default(1); // ordre d'exécution des étapes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etape_logistiques');
    }
};
