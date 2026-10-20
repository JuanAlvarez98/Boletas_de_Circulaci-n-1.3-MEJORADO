<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boletas_circulacion', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique(); // Ej. BC-2026-000001

            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Funcionario que la emite

            $table->date('fecha_emision');
            $table->date('fecha_vigencia'); // Fecha hasta la que la boleta es válida

            $table->enum('estado', ['vigente', 'vencida', 'anulada'])->default('vigente');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boletas_circulacion');
    }
};
