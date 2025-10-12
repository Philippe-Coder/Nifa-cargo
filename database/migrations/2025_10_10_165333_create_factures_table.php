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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numero_facture')->unique(); // F-2024-001
            $table->foreignId('demande_transport_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // client
            $table->decimal('montant_ht', 10, 2); // montant hors taxes
            $table->decimal('taux_tva', 5, 2)->default(18.00); // taux TVA en %
            $table->decimal('montant_tva', 10, 2); // montant TVA
            $table->decimal('montant_ttc', 10, 2); // montant toutes taxes comprises
            $table->text('description')->nullable();
            $table->json('details')->nullable(); // détails des lignes de facturation
            $table->enum('statut', ['brouillon', 'envoyee', 'payee', 'annulee'])->default('brouillon');
            $table->date('date_emission');
            $table->date('date_echeance');
            $table->string('devise', 3)->default('XOF'); // Franc CFA
            $table->string('chemin_pdf')->nullable(); // chemin vers le PDF généré
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
