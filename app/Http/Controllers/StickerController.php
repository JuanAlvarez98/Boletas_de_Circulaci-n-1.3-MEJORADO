<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelDocumentRequest;
use App\Http\Requests\StoreStickerRequest;
use App\Models\Sticker;
use App\Models\Vehicle;
use App\Services\AuditService;
use App\Services\DocumentSequenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StickerController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->get('q', ''));
        $stickers = Sticker::with(['vehicle', 'emisor'])
            ->when($query !== '', fn ($builder) => $builder->where(fn ($sub) => $sub
                ->where('codigo', 'like', "%{$query}%")
                ->orWhereHas('vehicle', fn ($vehicle) => $vehicle->where('placa', 'like', "%{$query}%"))))
            ->when($request->filled('estado'), fn ($builder) => $builder->where('estado', $request->string('estado')))
            ->latest('fecha_emision')->paginate(15)->withQueryString();

        return view('stickers.index', compact('stickers', 'query'));
    }

    public function create(Request $request): View
    {
        $vehicle = $request->filled('vehicle_id') ? Vehicle::find($request->integer('vehicle_id')) : null;
        $query = trim((string) $request->get('q', ''));
        $resultados = (! $vehicle && $query !== '') ? Vehicle::where(fn ($builder) => $builder
            ->where('placa', 'like', "%{$query}%")->orWhere('chasis', 'like', "%{$query}%"))
            ->orderBy('placa')->limit(10)->get() : collect();
        $boletas = $vehicle?->boletas()->where('estado', 'vigente')->whereDate('fecha_vigencia', '>=', today())->latest('fecha_emision')->get() ?? collect();

        return view('stickers.create', compact('vehicle', 'resultados', 'query', 'boletas'));
    }

    public function store(StoreStickerRequest $request, DocumentSequenceService $sequences, AuditService $audit): RedirectResponse
    {
        $data = $request->validated();
        $sticker = Sticker::create([
            'codigo' => $sequences->next('sticker', 'STK'), 'vehicle_id' => $data['vehicle_id'],
            'boleta_id' => $data['boleta_id'] ?? null, 'user_id' => Auth::id(),
            'fecha_emision' => now(), 'estado' => 'activo', 'verification_token' => (string) Str::uuid(),
        ]);
        $audit->record('sticker.emitido', $sticker, [], $sticker->toArray());

        return redirect()->route('stickers.show', $sticker)->with('status', 'Sticker generado exitosamente.');
    }

    public function show(Sticker $sticker): View
    {
        $sticker->load(['vehicle', 'boleta', 'emisor']);

        return view('stickers.show', compact('sticker'));
    }

    public function verifyPublic(string $token): View
    {
        $sticker = Sticker::with('vehicle')->where('verification_token', $token)->firstOrFail();

        return view('stickers.verify', compact('sticker'));
    }

    public function destroy(CancelDocumentRequest $request, Sticker $sticker, AuditService $audit): RedirectResponse
    {
        abort_if($sticker->estado === 'anulado', 409, 'El sticker ya se encuentra anulado.');
        $old = $sticker->toArray();
        $sticker->update(['estado' => 'anulado', 'motivo_anulacion' => $request->validated('motivo_anulacion'),
            'anulado_por' => Auth::id(), 'anulado_at' => now()]);
        $audit->record('sticker.anulado', $sticker, $old, $sticker->fresh()->toArray());

        return redirect()->route('stickers.index')->with('status', 'Sticker anulado; se conservó el historial.');
    }
}
