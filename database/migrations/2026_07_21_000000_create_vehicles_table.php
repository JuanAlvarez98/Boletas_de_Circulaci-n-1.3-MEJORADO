<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Esta tabla simula localmente el maestro de vehículos que en producción
     * se consultará mediante API contra SAP. Mientras no exista la conexión
     * real, estos datos se administran en MySQL vía phpMyAdmin.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            // Identificación principal (usada para búsquedas tipo SAP)
            $table->string('placa')->unique();
            $table->string('chasis')->unique();
            $table->string('motor')->nullable();

            // Datos generales del vehículo
            $table->string('marca');
            $table->string('modelo');
            $table->string('linea')->nullable(); // Tipo/línea (sedán, pick-up, motocicleta, etc.)
            $table->unsignedSmallInteger('anio')->nullable();
            $table->string('color')->nullable();
            $table->string('cilindraje')->nullable();
            $table->string('combustible')->nullable(); // Gasolina, Diésel, Eléctrico, Híbrido

            // Datos del propietario
            $table->string('propietario_nombre');
            $table->string('propietario_identidad')->nullable();


            // Código de referencia SAP (para cuando se conecte la API real)
            $table->string('sap_codigo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
