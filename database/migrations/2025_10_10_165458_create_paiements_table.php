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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->string('reference_paiement')->unique(); // P-2024-001
            $table->foreignId('facture_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->string('devise', 3)->default('XOF');
            $table->enum('methode_paiement', [
                'carte_bancaire', 'mobile_money', 'flooz', 'tmoney', 
                'moov_money', 'orange_money', 'paypal', 'stripe', 
                'virement', 'especes'
            ]);
            $table->enum('statut', ['en_attente', 'en_cours', 'reussi', 'echec', 'rembourse'])->default('en_attente');
            $table->string('transaction_id')->nullable(); // ID de la transaction externe
            $table->string('gateway_reference')->nullable(); // référence de la passerelle
            $table->json('gateway_response')->nullable(); // réponse complète de la passerelle
            $table->datetime('date_paiement')->nullable();
            $table->text('note')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
