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
| - operator / operador-emisor: acceso exclusivo a Ficha de Vehículo
|   (consulta de solo lectura en el Web Service de SAP).
| - supervisor: acceso de solo lectura para auditoría (listados, detalle y consulta SAP).
| - admin: acceso completo para consultar, emitir, sincronizar y anular documentos.
*/

// Módulo Ficha de Vehículo y consulta en vivo al Web Service SAP (admin, operador y supervisor)
Route::middleware(['auth', 'role:admin,operator,supervisor'])->group(function () {
    Route::get('vehiculos', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::post('sap/consultar', [VehicleController::class, 'consultarSap'])->name('sap.consultar');
});

// Listados y detalles operativos de auditoría (solo admin y supervisor)
Route::middleware(['auth', 'role:admin,supervisor'])->group(function () {

    // Detalle local de vehículo con historial de boletas y actas
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

// Acciones de escritura: solo admin puede sincronizar/registrar/emitir/anular
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Integración SAP API: Sincronización y actualización en base de datos local
    Route::post('sap/sincronizar', [VehicleController::class, 'sincronizarSap'])->name('sap.sincronizar');
    Route::post('vehiculos/{vehicle}/actualizar-sap', [VehicleController::class, 'actualizarDesdeSap'])->name('vehicles.actualizar-sap');

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

