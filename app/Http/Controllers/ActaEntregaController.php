<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelDocumentRequest;
use App\Http\Requests\StoreActaRequest;
use App\Mail\ActaEntregaMail;
use App\Models\ActaEntrega;
use App\Models\Vehicle;
use App\Services\AuditService;
use App\Services\DocumentSequenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ActaEntregaController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->get('q', ''));
        $actas = ActaEntrega::with(['vehicle', 'registradoPor'])
            ->when($query !== '', fn ($builder) => $builder->where(fn ($sub) => $sub
                ->where('folio', 'like', "%{$query}%")
                ->orWhere('recibe_nombre', 'like', "%{$query}%")
                ->orWhere('recibe_email', 'like', "%{$query}%")
                ->orWhereHas('vehicle', fn ($vehicle) => $vehicle->where('placa', 'like', "%{$query}%"))))
            ->when($request->filled('estado'), fn ($builder) => $builder->where('estado', $request->string('estado')))
            ->latest('fecha_entrega')->paginate(15)->withQueryString();

        return view('actas.index', compact('actas', 'query'));
    }

    public function create(Request $request): View
    {
        $vehicle = $request->filled('vehicle_id') ? Vehicle::find($request->integer('vehicle_id')) : null;
        $query = trim((string) $request->get('q', ''));
        $resultados = (! $vehicle && $query !== '') ? Vehicle::where(fn ($builder) => $builder
            ->where('placa', 'like', "%{$query}%")->orWhere('chasis', 'like', "%{$query}%"))
            ->orderBy('placa')->limit(10)->get() : collect();
        if ($vehicle) {
            $vehicle->load(['boletas' => fn ($builder) => $builder->where('estado', 'vigente')
                ->whereDate('fecha_vigencia', '>=', today())->latest('fecha_emision')]);
        }

        return view('actas.create', compact('vehicle', 'resultados', 'query'));
    }

    public function store(StoreActaRequest $request, DocumentSequenceService $sequences, AuditService $audit): RedirectResponse
    {
        $data = $request->validated();
        $acta = ActaEntrega::create([
            'folio' => $sequences->next('acta', 'AE'),
            'vehicle_id' => $data['vehicle_id'],
            'boleta_id' => $data['boleta_id'] ?? null,
            'user_id' => Auth::id(),
            'entrega_nombre' => $data['entrega_nombre'],
            'recibe_nombre' => $data['recibe_nombre'],
            'recibe_identidad' => $data['recibe_identidad'] ?? null,
            'recibe_email' => $data['recibe_email'] ?? null,
            'fecha_entrega' => $data['fecha_entrega'],
            'observaciones' => $data['observaciones'] ?? null,
            'estado' => 'registrada',
        ]);

        $audit->record('acta.registrada', $acta, [], $acta->toArray());

        $statusMessage = 'Acta de entrega registrada exitosamente.';

        // Envío automatizado e inmediato por correo electrónico si se proveyó dirección
        if (! empty($acta->recibe_email)) {
            try {
                Mail::to($acta->recibe_email)->send(new ActaEntregaMail($acta));
                $acta->update(['enviado_email_at' => now()]);
                $audit->record('acta.email_enviado', $acta, [], ['email' => $acta->recibe_email]);
                $statusMessage = "Acta registrada exitosamente y enviada automáticamente por correo a {$acta->recibe_email}.";
            } catch (\Throwable $e) {
                $statusMessage = "Acta registrada exitosamente (no se pudo enviar el correo: {$e->getMessage()}).";
            }
        }

        return redirect()->route('actas.show', $acta)->with('status', $statusMessage);
    }

    public function sendEmail(Request $request, ActaEntrega $acta, AuditService $audit): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:150'],
        ]);

        $email = trim((string) $validated['email']);

        try {
            Mail::to($email)->send(new ActaEntregaMail($acta));
            $acta->update([
                'recibe_email' => $email,
                'enviado_email_at' => now(),
            ]);
            $audit->record('acta.email_reenviado', $acta, [], ['email' => $email]);

            return back()->with('status', "Acta de entrega enviada exitosamente por correo a {$email}.");
        } catch (\Throwable $e) {
            return back()->withErrors(['email' => "Error al enviar el correo electrónico: {$e->getMessage()}"]);
        }
    }

    public function show(ActaEntrega $acta): View
    {
        $acta->load(['vehicle', 'boleta', 'registradoPor']);

        return view('actas.show', compact('acta'));
    }

    public function destroy(CancelDocumentRequest $request, ActaEntrega $acta, AuditService $audit): RedirectResponse
    {
        abort_if($acta->estado === 'anulada', 409, 'El acta ya se encuentra anulada.');
        $old = $acta->toArray();
        $acta->update([
            'estado' => 'anulada',
            'motivo_anulacion' => $request->validated('motivo_anulacion'),
            'anulada_por' => Auth::id(),
            'anulada_at' => now(),
        ]);
        $audit->record('acta.anulada', $acta, $old, $acta->fresh()->toArray());

        return redirect()->route('actas.index')->with('status', 'Acta anulada; se conservó el historial.');
    }
}



