<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Services\SapVehicleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controlador de Ficha de Vehículos.
 *
 * El sistema no realiza modificaciones manuales (ingresar, editar o eliminar números de equipos/fichas).
 * La búsqueda del número de equipo se realiza en tiempo real exclusivamente en el Web Service de SAP PM.
 * Solo se extraen los campos provistos por SAP; cualquier campo no presente se mantiene en blanco.
 */
class VehicleController extends Controller
{
    /**
     * Pantalla de Ficha de Vehículos.
     * Busca el número de equipo directamente en SAP PM (no en la base de datos local).
     */
    public function index(Request $request, SapVehicleService $sapService): View
    {
        $numeroEquipo = trim((string) ($request->get('numero_equipo') ?: $request->get('q', '')));
        $sapError = null;
        $sapData = null;

        // La búsqueda se realiza en tiempo real directamente en SAP (solo lectura y en memoria, sin persistir en BD local)
        if ($numeroEquipo !== '') {
            try {
                $sapData = $sapService->consultar($numeroEquipo);
                if (!$sapData) {
                    $sapError = "No se encontró ningún vehículo con el número de equipo '{$numeroEquipo}' en SAP PM.";
                }
            } catch (\Exception $e) {
                $sapError = 'Error al consultar SAP PM: ' . $e->getMessage();
            }
        }

        return view('vehicles.index', compact('sapData', 'sapError', 'numeroEquipo'));
    }

    /**
     * Ficha técnica y documental completa del vehículo.
     */
    public function show(Vehicle $vehicle): View
    {
        $vehicle->load(['boletas' => function ($q) {
            $q->latest('fecha_emision');
        }, 'stickers', 'actasEntrega']);

        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Consulta un vehículo directamente en el Web Service de SAP por su número de equipo (llamada asíncrona/AJAX).
     */
    public function consultarSap(Request $request, SapVehicleService $sapService): JsonResponse
    {
        $request->validate([
            'numero_equipo' => 'required|string|max:50',
        ]);

        $codigo = trim($request->input('numero_equipo'));

        try {
            $sapData = $sapService->consultar($codigo);

            if (!$sapData) {
                return response()->json([
                    'success' => false,
                    'message' => "No se encontró ningún vehículo con el número de equipo '{$codigo}' en SAP PM.",
                ], 404);
            }

            // Los datos se devuelven en memoria para mostrarlos temporalmente en la ficha
            return response()->json([
                'success' => true,
                'data' => $sapData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al conectar con SAP: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualiza la ficha técnica del vehículo consultando los datos más recientes en SAP PM.
     */
    public function actualizarDesdeSap(Vehicle $vehicle, SapVehicleService $sapService): JsonResponse|RedirectResponse
    {
        $codigo = $vehicle->numero_equipo ?? $vehicle->sap_codigo;

        if (!$codigo) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este vehículo no cuenta con un número de equipo asignado para consultar SAP.',
                ], 422);
            }
            return back()->withErrors(['sap' => 'Este vehículo no cuenta con un número de equipo asignado para consultar SAP.']);
        }

        try {
            $sapData = $sapService->consultar($codigo);

            if (!$sapData) {
                if (request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "No se encontró información para el equipo '{$codigo}' en SAP PM.",
                    ], 404);
                }
                return back()->withErrors(['sap' => "No se encontró información para el equipo '{$codigo}' en SAP PM."]);
            }

            $sapService->sincronizarLocalmente($sapData);

            if (request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Ficha técnica actualizada exitosamente desde SAP PM.',
                    'data' => $sapData,
                ]);
            }

            return back()->with('status', 'Ficha técnica actualizada exitosamente con los datos oficiales de SAP.');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al conectar con SAP: ' . $e->getMessage(),
                ], 500);
            }
            return back()->withErrors(['sap' => 'Error al conectar con SAP: ' . $e->getMessage()]);
        }
    }

    /**
     * Sincroniza el vehículo consultado desde SAP en la base de datos local
     * permitiendo continuar hacia la emisión de boleta, sticker o acta.
     */
    public function sincronizarSap(Request $request, SapVehicleService $sapService): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'numero_equipo' => 'required|string|max:50',
            'sap_codigo' => 'nullable|string|max:50',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'linea' => 'nullable|string|max:100',
            'anio' => 'nullable|integer',
            'naturaleza_origen' => 'nullable|string|max:50',
            'dependencia' => 'nullable|string|max:255',
            'denominacion' => 'nullable|string|max:255',
            'estado_sap' => 'nullable|string|max:100',
            'tipo_equipo' => 'nullable|string|max:100',
            'centro_costo' => 'nullable|string|max:50',
            'centro' => 'nullable|string|max:50',
            'kilometraje' => 'nullable|string|max:50',
            'placa' => 'nullable|string|max:50',
            'chasis' => 'nullable|string|max:50',
            'motor' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'redirect_to' => 'nullable|string',
        ]);

        if (empty($validated['marca'])) {
            $fresh = $sapService->consultar($validated['numero_equipo']);
            $sapData = $fresh ?: [
                'numero_equipo' => $validated['numero_equipo'],
                'sap_codigo' => $validated['sap_codigo'] ?? $validated['numero_equipo'],
            ];
        } else {
            $sapData = [
                'numero_equipo' => $validated['numero_equipo'],
                'sap_codigo' => $validated['sap_codigo'] ?? $validated['numero_equipo'],
                'marca' => $validated['marca'] ?? null,
                'modelo' => $validated['modelo'] ?? null,
                'linea' => $validated['linea'] ?? null,
                'anio' => $validated['anio'] ?? null,
                'naturaleza_origen' => $validated['naturaleza_origen'] ?? null,
                'dependencia' => $validated['dependencia'] ?? null,
                'denominacion' => $validated['denominacion'] ?? null,
                'estado_sap' => $validated['estado_sap'] ?? null,
                'tipo_equipo' => $validated['tipo_equipo'] ?? null,
                'centro_costo' => $validated['centro_costo'] ?? null,
                'centro' => $validated['centro'] ?? null,
                'kilometraje' => $validated['kilometraje'] ?? null,
            ];
        }

        $complementos = [
            'placa' => $validated['placa'] ?? null,
            'chasis' => $validated['chasis'] ?? null,
            'motor' => $validated['motor'] ?? null,
            'color' => $validated['color'] ?? null,
        ];

        $vehicle = $sapService->sincronizarLocalmente($sapData, $complementos);

        $redirectTo = $request->input('redirect_to', 'vehicles.show');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'vehicle' => $vehicle,
                'redirect_url' => route($redirectTo, ['vehicle_id' => $vehicle->id, 'vehicle' => $vehicle->id]),
            ]);
        }

        return redirect()->route($redirectTo, ['vehicle_id' => $vehicle->id, 'vehicle' => $vehicle->id])
            ->with('status', 'Vehículo consultado correctamente desde SAP.');
    }
}
