<?php

namespace App\Http\Controllers;

use App\Models\ActaEntrega;
use App\Models\BoletaCirculacion;
use App\Models\Vehicle;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        BoletaCirculacion::where('estado', 'vigente')->whereDate('fecha_vigencia', '<', today())->update(['estado' => 'vencida']);
        $stats = ['vehiculos' => Vehicle::count(), 'vigentes' => BoletaCirculacion::where('estado', 'vigente')->count(),
            'por_vencer' => BoletaCirculacion::where('estado', 'vigente')->whereBetween('fecha_vigencia', [today(), today()->addDays(30)])->count(),
            'vencidas' => BoletaCirculacion::where('estado', 'vencida')->count(), 'anuladas' => BoletaCirculacion::where('estado', 'anulada')->count(),
            'actas' => ActaEntrega::whereIn('estado', ['registrada', 'entregada'])->count()];
        $proximas = BoletaCirculacion::with('vehicle')->where('estado', 'vigente')->whereBetween('fecha_vigencia', [today(), today()->addDays(30)])->orderBy('fecha_vigencia')->limit(10)->get();

        return view('dashboard', compact('stats','proximas'));
    }
}
