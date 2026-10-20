<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stickers', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // Ej. STK-2026-000001, se codifica también en el QR

            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('boleta_id')->nullable()->constrained('boletas_circulacion')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Funcionario que lo emite

            $table->date('fecha_emision');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stickers');
    }
};
