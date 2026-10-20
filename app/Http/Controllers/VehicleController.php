<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador de Vehículos.
 *
 * IMPORTANTE: En producción, la búsqueda de vehículos se hará llamando a la
 * API de SAP (solo consulta, no se editará información desde aquí). Mientras
 * esa integración no esté disponible, los datos se leen/administran en una
 * tabla local de MySQL (vehicles) para poder maquetar y probar el resto de
 * módulos (boleta, sticker, acta).
 */
class VehicleController extends Controller
{
    /**
     * Buscador de vehículos (simula la consulta contra SAP).
     */
    public function index(Request $request): View
    {
        $query = trim((string) $request->get('q', ''));

        $vehicles = Vehicle::query()
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($sub) use ($query) {
                    $sub->where('placa', 'like', "%{$query}%")
                        ->orWhere('numero_equipo', 'like', "%{$query}%")
                        ->orWhere('chasis', 'like', "%{$query}%")
                        ->orWhere('marca', 'like', "%{$query}%")
                        ->orWhere('modelo', 'like', "%{$query}%");
                });
            })
            ->orderBy('placa')
            ->paginate(10)
            ->withQueryString();

        return view('vehicles.index', compact('vehicles', 'query'));
    }

    /**
     * Ficha completa del vehículo.
     */
    public function show(Vehicle $vehicle): View
    {
        $vehicle->load(['boletas' => function ($q) {
            $q->latest('fecha_emision');
        }, 'stickers', 'actasEntrega']);

        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Formulario para registrar un vehículo en la base local
     * (mientras no exista la conexión real con SAP).
     */
    public function create(): View
    {
        return view('vehicles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validarDatos($request);

        $vehicle = Vehicle::create($data);

        return redirect()->route('vehicles.show', $vehicle)->with('status', 'Vehículo registrado exitosamente.');
    }

    public function edit(Vehicle $vehicle): View
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $this->validarDatos($request, $vehicle->id);

        $vehicle->update($data);

        return redirect()->route('vehicles.show', $vehicle)->with('status', 'Datos del vehículo actualizados.');
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        if ($vehicle->boletas()->exists() || $vehicle->stickers()->exists() || $vehicle->actasEntrega()->exists()) {
            return back()->withErrors(['vehicle' => 'No se puede retirar un vehículo que tiene historial documental.']);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('status', 'Vehículo eliminado del registro local.');
    }

    private function validarDatos(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'placa' => ['required', 'string', 'max:20', 'unique:vehicles,placa'.($ignoreId ? ",{$ignoreId}" : '')],
            'numero_equipo' => ['nullable', 'string', 'max:50', 'unique:vehicles,numero_equipo'.($ignoreId ? ",{$ignoreId}" : '')],
            'chasis' => ['required', 'string', 'max:50', 'unique:vehicles,chasis'.($ignoreId ? ",{$ignoreId}" : '')],
            'motor' => ['nullable', 'string', 'max:50'],
            'marca' => ['required', 'string', 'max:100'],
            'modelo' => ['required', 'string', 'max:100'],
            'linea' => ['nullable', 'string', 'max:100'],
            'anio' => ['nullable', 'integer', 'min:1950', 'max:'.(date('Y') + 1)],
            'color' => ['nullable', 'string', 'max:50'],
            'naturaleza_origen' => ['nullable', 'string', 'max:50'],
            'sap_codigo' => ['nullable', 'string', 'max:50'],
        ], [
            'placa.required' => 'La placa es obligatoria.',
            'numero_equipo.unique' => 'Ya existe un vehículo registrado con este número de equipo.', 
            'placa.unique' => 'Ya existe un vehículo registrado con esta placa.',
            'chasis.required' => 'El número de chasis es obligatorio.',
            'chasis.unique' => 'Ya existe un vehículo registrado con este chasis.',
            'marca.required' => 'La marca es obligatoria.',
            'modelo.required' => 'El modelo es obligatorio.',
        ]);
    }
}
