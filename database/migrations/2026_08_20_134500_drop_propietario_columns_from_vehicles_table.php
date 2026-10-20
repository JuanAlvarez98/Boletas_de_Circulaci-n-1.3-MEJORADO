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
        Schema::table('vehicles', function (Blueprint $table) {
            if (Schema::hasColumn('vehicles', 'propietario_nombre')) {
                $table->dropColumn('propietario_nombre');
            }
            if (Schema::hasColumn('vehicles', 'propietario_identidad')) {
                $table->dropColumn('propietario_identidad');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('propietario_nombre')->nullable();
            $table->string('propietario_identidad')->nullable();
        });
    }
};
