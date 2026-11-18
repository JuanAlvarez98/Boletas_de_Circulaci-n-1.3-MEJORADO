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
            $table->string('placa')->nullable()->change();
            $table->string('chasis')->nullable()->change();
            $table->string('marca')->nullable()->change();
            $table->string('modelo')->nullable()->change();

            if (!Schema::hasColumn('vehicles', 'dependencia')) {
                $table->string('dependencia')->nullable()->after('naturaleza_origen');
            }
            if (!Schema::hasColumn('vehicles', 'denominacion')) {
                $table->string('denominacion')->nullable()->after('dependencia');
            }
            if (!Schema::hasColumn('vehicles', 'estado_sap')) {
                $table->string('estado_sap')->nullable()->after('denominacion');
            }
            if (!Schema::hasColumn('vehicles', 'tipo_equipo')) {
                $table->string('tipo_equipo')->nullable()->after('estado_sap');
            }
            if (!Schema::hasColumn('vehicles', 'centro_costo')) {
                $table->string('centro_costo')->nullable()->after('tipo_equipo');
            }
            if (!Schema::hasColumn('vehicles', 'centro')) {
                $table->string('centro')->nullable()->after('centro_costo');
            }
            if (!Schema::hasColumn('vehicles', 'kilometraje')) {
                $table->string('kilometraje')->nullable()->after('centro');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'dependencia',
                'denominacion',
                'estado_sap',
                'tipo_equipo',
                'centro_costo',
                'centro',
                'kilometraje',
            ]);
        });
    }
};
