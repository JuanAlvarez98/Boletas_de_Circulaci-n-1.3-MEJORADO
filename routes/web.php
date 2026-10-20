<?php

use App\Http\Controllers\StickerController;
use Illuminate\Support\Facades\Route;

Route::get('/verificar-sticker/{token}', [StickerController::class, 'verifyPublic'])
    ->middleware('throttle:60,1')->name('stickers.verify');

Route::get('/', function () {
    return view('welcome');

});

// Rutas de autenticación y 2FA
require __DIR__.'/auth_routes_append.php';
require __DIR__.'/role_routes_append.php';
require __DIR__.'/vehiculos_routes_append.php';
