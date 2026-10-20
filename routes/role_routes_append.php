<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de Administración de Roles y Usuarios
|--------------------------------------------------------------------------
| Estas rutas permiten administrar los perfiles de acceso de la aplicación.
| Solo los usuarios autenticados con el rol de 'admin' (Administrador)
| pueden acceder a estos módulos.
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // CRUD Completo de Roles
    Route::resource('roles', RoleController::class)->except(['show']);

    // Rutas para asignar roles a los usuarios
    Route::get('users', [UserRoleController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [UserRoleController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [UserRoleController::class, 'update'])->name('users.update');

});
