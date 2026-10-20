<?php

use App\Models\BoletaCirculacion;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::call(fn () => BoletaCirculacion::where('estado', 'vigente')
    ->whereDate('fecha_vigencia', '<', today())->update(['estado' => 'vencida']))
    ->dailyAt('00:05')->name('actualizar-boletas-vencidas')->withoutOverlapping();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
