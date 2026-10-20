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
        // 1. Tabla de Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ejemplo: Administrador, Operador, Supervisor
            $table->string('slug')->unique(); // Ejemplo: admin, operator, supervisor
            $table->string('description')->nullable(); // Descripción detallada
            $table->timestamps();
        });

        // 2. Tabla Pivot Intermedia (Relación Muchos a Muchos entre User y Role)
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->primary(['user_id', 'role_id']); // Evita duplicados redundantes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
};
