<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación Segura y 2FA
|--------------------------------------------------------------------------
| Puedes copiar y pegar estas rutas directamente en tu archivo routes/web.php
*/

Route::middleware('guest')->group(function () {
    // 1. Inicio de Sesión
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // 2. Autenticación de Dos Factores (2FA) - Acceso Temporal
    Route::get('two-factor', [TwoFactorController::class, 'showForm'])->name('auth.two-factor');
    Route::post('two-factor', [TwoFactorController::class, 'verify'])->name('auth.two-factor.verify');
    Route::post('two-factor/resend', [TwoFactorController::class, 'resend'])->name('auth.two-factor.resend');

    // 3. Recuperación de Contraseña
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Cierre de Sesión y Dashboard (Requiere estar autenticado)
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('dashboard', DashboardController::class)->name('dashboard');
});
