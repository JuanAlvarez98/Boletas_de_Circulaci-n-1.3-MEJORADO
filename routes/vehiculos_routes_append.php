<?php

use App\Http\Controllers\ActaEntregaController;
use App\Http\Controllers\BoletaCirculacionController;
use App\Http\Controllers\StickerController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas de los Módulos Operativos
|--------------------------------------------------------------------------
| Ficha de Vehículo, Boleta de Circulación, Sticker de Identificación (QR)
| y Acta de Entrega.
|
| - admin y operator: pueden buscar vehículos, emitir e imprimir documentos.
| - supervisor: acceso de solo lectura para auditoría (listados y detalle).
|
| Nota: la "búsqueda" de vehículos hoy consulta la tabla local `vehicles`
| (MySQL / phpMyAdmin). Cuando se conecte la API de SAP, VehicleController
| se ajustará para consumir el servicio externo en lugar de la tabla local.
*/

Route::middleware(['auth', 'role:admin,operator,supervisor'])->group(function () {

    // Ficha de Vehículo (búsqueda + detalle, solo lectura para todos los roles)
    Route::get('vehiculos', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('vehiculos/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

    // Boletas de Circulación (listado + detalle/impresión)
    Route::get('boletas', [BoletaCirculacionController::class, 'index'])->name('boletas.index');
    Route::get('boletas/{boleta}', [BoletaCirculacionController::class, 'show'])->name('boletas.show');

    // Stickers de Identificación (listado + detalle/impresión con QR)
    Route::get('stickers', [StickerController::class, 'index'])->name('stickers.index');
    Route::get('stickers/{sticker}', [StickerController::class, 'show'])->name('stickers.show');

    // Actas de Entrega (listado + detalle/impresión)
    Route::get('actas-entrega', [ActaEntregaController::class, 'index'])->name('actas.index');
    Route::get('actas-entrega/{acta}', [ActaEntregaController::class, 'show'])->name('actas.show');
});

// Acciones de escritura: solo admin y operador pueden registrar/emitir/anular
Route::middleware(['auth', 'role:admin,operator'])->group(function () {

    // Administración local del maestro de vehículos (mientras no exista SAP)
    Route::get('vehiculos-nuevo', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('vehiculos', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('vehiculos/{vehicle}/editar', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('vehiculos/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('vehiculos/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

    // Emisión de boletas
    Route::get('boletas-nueva', [BoletaCirculacionController::class, 'create'])->name('boletas.create');
    Route::post('boletas', [BoletaCirculacionController::class, 'store'])->name('boletas.store');
    Route::delete('boletas/{boleta}', [BoletaCirculacionController::class, 'destroy'])->name('boletas.destroy');

    // Emisión de stickers
    Route::get('stickers-nuevo', [StickerController::class, 'create'])->name('stickers.create');
    Route::post('stickers', [StickerController::class, 'store'])->name('stickers.store');
    Route::delete('stickers/{sticker}', [StickerController::class, 'destroy'])->name('stickers.destroy');

    // Registro y entrega por correo de actas de entrega
    Route::get('actas-entrega-nueva', [ActaEntregaController::class, 'create'])->name('actas.create');
    Route::post('actas-entrega', [ActaEntregaController::class, 'store'])->name('actas.store');
    Route::post('actas-entrega/{acta}/enviar-correo', [ActaEntregaController::class, 'sendEmail'])->name('actas.send-email');
    Route::delete('actas-entrega/{acta}', [ActaEntregaController::class, 'destroy'])->name('actas.destroy');
});

