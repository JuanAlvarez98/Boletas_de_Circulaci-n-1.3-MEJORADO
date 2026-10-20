<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelDocumentRequest;
use App\Http\Requests\StoreBoletaRequest;
use App\Models\BoletaCirculacion;
use App\Models\Vehicle;
use App\Services\AuditService;
use App\Services\DocumentSequenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BoletaCirculacionController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->get('q', ''));
        $boletas = BoletaCirculacion::with(['vehicle', 'emisor'])
            ->when($query !== '', fn ($builder) => $builder->where(fn ($sub) => $sub
                ->where('folio', 'like', "%{$query}%")
                ->orWhereHas('vehicle', fn ($vehicle) => $vehicle->where('placa', 'like', "%{$query}%"))))
            ->when($request->filled('estado'), fn ($builder) => $builder->where('estado', $request->string('estado')))
            ->when($request->filled('desde'), fn ($builder) => $builder->whereDate('fecha_emision', '>=', $request->date('desde')))
            ->when($request->filled('hasta'), fn ($builder) => $builder->whereDate('fecha_emision', '<=', $request->date('hasta')))
            ->latest('fecha_emision')->paginate(15)->withQueryString();

        return view('boletas.index', compact('boletas', 'query'));
    }

    public function create(Request $request): View
    {
        $vehicle = $request->filled('vehicle_id') ? Vehicle::find($request->integer('vehicle_id')) : null;
        $query = trim((string) $request->get('q', ''));
        $resultados = (! $vehicle && $query !== '') ? Vehicle::where(fn ($builder) => $builder
            ->where('placa', 'like', "%{$query}%")->orWhere('chasis', 'like', "%{$query}%"))
            ->orderBy('placa')->limit(10)->get() : collect();

        return view('boletas.create', compact('vehicle', 'resultados', 'query'));
    }

    public function store(StoreBoletaRequest $request, DocumentSequenceService $sequences, AuditService $audit): RedirectResponse
    {
        $data = $request->validated();
        $boleta = DB::transaction(function () use ($data, $sequences) {
            $vehicle = Vehicle::query()->lockForUpdate()->findOrFail($data['vehicle_id']);
            $vehicle->boletas()->where('estado', 'vigente')->update(['estado' => 'vencida']);

            return BoletaCirculacion::create([
                'folio' => $sequences->next('boleta', 'BC'),
                'vehicle_id' => $vehicle->id,
                'user_id' => Auth::id(),
                'fecha_emision' => $data['fecha_emision'],
                'fecha_vigencia' => $data['fecha_vigencia'],
                'estado' => 'vigente',
                'observaciones' => $data['observaciones'] ?? null,
            ]);
        });
        $audit->record('boleta.emitida', $boleta, [], $boleta->toArray());

        return redirect()->route('boletas.show', $boleta)->with('status', 'Boleta emitida exitosamente.');
    }

    public function show(BoletaCirculacion $boleta): View
    {
        $boleta->load(['vehicle', 'emisor']);

        return view('boletas.show', compact('boleta'));
    }

    public function destroy(CancelDocumentRequest $request, BoletaCirculacion $boleta, AuditService $audit): RedirectResponse
    {
        abort_if($boleta->estado === 'anulada', 409, 'La boleta ya se encuentra anulada.');
        $old = $boleta->toArray();
        $boleta->update([
            'estado' => 'anulada',
            'motivo_anulacion' => $request->validated('motivo_anulacion'),
            'anulada_por' => Auth::id(),
            'anulada_at' => now(),
        ]);
        $audit->record('boleta.anulada', $boleta, $old, $boleta->fresh()->toArray());

        return redirect()->route('boletas.index')->with('status', 'Boleta anulada; se conservó el historial.');
    }
}
