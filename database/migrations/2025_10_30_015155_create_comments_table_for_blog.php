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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annonce_id')->constrained('annonces')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nom')->nullable(); // Pour les visiteurs non connectés
            $table->string('email')->nullable(); // Pour les visiteurs non connectés
            $table->text('contenu');
            $table->boolean('approuve')->default(false);
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // Pour les réponses
            $table->timestamps();
            
            $table->index(['annonce_id', 'approuve']);
            $table->index(['parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
