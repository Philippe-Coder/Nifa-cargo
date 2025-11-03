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
            $table->boolean('created_by_admin')->default(false)->after('numero_tracking')->comment('Indique si la demande a été créée par un admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_transports', function (Blueprint $table) {
            $table->dropColumn('created_by_admin');
        });
    }
};
