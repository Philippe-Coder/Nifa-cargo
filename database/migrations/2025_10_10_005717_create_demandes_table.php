<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type_transport'); // import / export
            $table->string('marchandise');
            $table->float('poids')->nullable();
            $table->string('origine');
            $table->string('destination');
            $table->text('description')->nullable();
            $table->string('statut')->default('en_attente'); // en_attente, valide, en_transit, livre
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
