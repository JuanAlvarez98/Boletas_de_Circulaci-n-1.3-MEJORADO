<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actas_entrega', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique(); // Ej. AE-2026-000001

            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('boleta_id')->nullable()->constrained('boletas_circulacion')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Funcionario que registra el acta

            // Quién entrega (institución) y quién recibe (propietario/representante)
            $table->string('entrega_nombre'); // Funcionario o dependencia que entrega
            $table->string('recibe_nombre');
            $table->string('recibe_identidad')->nullable();

            $table->date('fecha_entrega');
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actas_entrega');
    }
};
