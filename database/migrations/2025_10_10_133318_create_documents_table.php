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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_transport_id')->constrained()->onDelete('cascade');
            $table->string('nom'); // nom du fichier original
            $table->string('type'); // facture_proforma, bordereau, connaissement, etc.
            $table->string('chemin'); // chemin de stockage du fichier
            $table->string('extension'); // pdf, jpg, png, etc.
            $table->bigInteger('taille'); // taille en bytes
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
