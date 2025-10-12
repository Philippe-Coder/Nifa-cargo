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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // demande_acceptee, demande_refusee, statut_modifie, etc.
            $table->string('message');
            $table->string('notifiable_type');
            $table->unsignedBigInteger('notifiable_id');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            
            // Index pour la relation polymorphe
            $table->index(['notifiable_type', 'notifiable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
