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
        Schema::table('users', function (Blueprint $table) {
            // Permitir nombre de usuario para inicio de sesión dual
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('name');
            }

            // Campos para 2FA por correo electrónico
            if (! Schema::hasColumn('users', 'two_factor_code')) {
                $table->string('two_factor_code')->nullable()->after('password');
                $table->dateTime('two_factor_expires_at')->nullable()->after('two_factor_code');
            }

            // Campos para 2FA por App Autenticadora (TOTP)
            if (! Schema::hasColumn('users', 'two_factor_secret')) {
                $table->text('two_factor_secret')->nullable()->after('two_factor_expires_at');
                $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'two_factor_code',
                'two_factor_expires_at',
                'two_factor_secret',
                'two_factor_recovery_codes',
            ]);
        });
    }
};
