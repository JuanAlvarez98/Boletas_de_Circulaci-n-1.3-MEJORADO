<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear o actualizar roles por defecto
        $admin = Role::updateOrCreate(['slug' => 'admin'], [
            'name' => 'Administrador',
            'description' => 'Acceso total al sistema, gestión de usuarios, roles y configuración global.',
        ]);

        $operator = Role::updateOrCreate(['slug' => 'operador-emisor'], [
            'name' => 'Operador / Emisor',
            'description' => 'Acceso exclusivo al Panel de Control, Ficha de Vehículo, Boletas de Circulación y Actas de Entrega con permisos completos de emisión y gestión operativa.',
        ]);

        $supervisor = Role::updateOrCreate(['slug' => 'supervisor'], [
            'name' => 'Supervisor / Auditor',
            'description' => 'Visualización de reportes, control administrativo y auditoría de boletas y actas emitidas (solo lectura).',
        ]);

        // 2. Buscar o crear el usuario principal para que tenga permisos de una vez
        $user = User::where('email', 'juan.alvarez@seguridad.gob.hn')->first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Juan Álvarez',
                'email' => 'juan.alvarez@seguridad.gob.hn',
                'username' => 'juan.alvarez',
                'password' => Hash::make('Segura123!'),
            ]);
        }

        // 3. Vincular al usuario principal con el rol de Administrador
        if (!$user->roles()->where('role_id', $admin->id)->exists()) {
            $user->roles()->attach($admin->id);
        }
    }
}
