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
        Schema::table('demande_transports', function (Blueprint $table) {
            $table->string('ville_depart')->nullable()->after('origine');
            $table->string('ville_destination')->nullable()->after('destination');
            $table->string('reference')->nullable()->unique()->after('id');
            $table->date('date_souhaitee')->nullable()->after('description');
            $table->string('dimensions')->nullable()->after('poids');
            $table->decimal('valeur', 10, 2)->nullable()->after('dimensions');
            $table->boolean('fragile')->default(false)->after('valeur');
            $table->decimal('montant', 10, 2)->nullable()->after('fragile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_transports', function (Blueprint $table) {
            $table->dropColumn([
                'ville_depart',
                'ville_destination', 
                'reference',
                'date_souhaitee',
                'dimensions',
                'valeur',
                'fragile',
                'montant'
            ]);
        });
    }
};
