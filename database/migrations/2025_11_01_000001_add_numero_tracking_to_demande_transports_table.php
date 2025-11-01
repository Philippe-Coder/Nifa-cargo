<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('demande_transports', function (Blueprint $table) {
            if (!Schema::hasColumn('demande_transports', 'numero_tracking')) {
                $table->string('numero_tracking', 7)->nullable()->unique()->after('reference');
            }
        });
    }

    public function down(): void
    {
        Schema::table('demande_transports', function (Blueprint $table) {
            if (Schema::hasColumn('demande_transports', 'numero_tracking')) {
                $table->dropUnique(['numero_tracking']);
                $table->dropColumn('numero_tracking');
            }
        });
    }
};
