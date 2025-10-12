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
            $table->string('type_transport')->nullable()->after('type');
            $table->string('marchandise')->nullable()->after('type_transport');
            $table->decimal('poids', 10, 2)->nullable()->after('marchandise');
            $table->string('origine')->nullable()->after('poids');
            $table->string('destination')->nullable()->after('origine');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_transports', function (Blueprint $table) {
            $table->dropColumn(['type_transport', 'marchandise', 'poids', 'origine', 'destination']);
        });
    }
};
