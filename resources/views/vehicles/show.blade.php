@extends('layouts.dashboard')

@section('title', 'Ficha de Vehículo · ' . $vehicle->placa)

@section('styles')
<style>
    .ficha-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        padding: 26px;
    }
    .ficha-item {
        background-color: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 14px 18px;
    }
    .ficha-item .label {
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 5px;
    }
    .ficha-item .value {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main);
    }
    .action-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }
    .placa-banner {
        font-family: monospace;
        font-size: 16px;
        font-weight: 800;
        background-color: #eff6ff;
        color: #1e3a8a;
        padding: 4px 12px;
        border-radius: 8px;
        border: 1.5px solid #bfdbfe;
        display: inline-block;
    }
</style>
@endsection

@section('content')
    <section class="welcome-section">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap: wrap; gap: 16px; width: 100%;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <span class="placa-banner">{{ $vehicle->placa }}</span>
                    <h2 class="welcome-title" style="margin-bottom: 0;">{{ $vehicle->marca }} {{ $vehicle->modelo }}</h2>
                </div>
                <p class="welcome-subtitle">Registro institucional {{ $vehicle->sap_codigo ? 'sincronizado con SAP (' . $vehicle->sap_codigo . ')' : 'local de la flota de seguridad' }}.</p>
            </div>
            <a href="{{ route('vehicles.index') }}" class="btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Volver al buscador</span>
            </a>
        </div>
    </section>

    @if (session('status'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <!-- Ficha de Datos -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Especificaciones Técnicas del Vehículo</span>
            @auth
                @if(Auth::user()->hasAnyRole(['admin', 'operador-emisor']))
                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn-secondary" style="padding: 6px 14px; font-size: 12.5px;">
                        Editar Registro
                    </a>
                @endif
            @endauth
        </div>

        <div class="ficha-grid">
            <div class="ficha-item"><div class="label">No. de Equipo</div><div class="value">{{ $vehicle->numero_equipo ?? '—' }}</div></div>
            <div class="ficha-item"><div class="label">Tipo</div><div class="value">{{ $vehicle->linea ?? '—' }}</div></div>
            <div class="ficha-item"><div class="label">Marca</div><div class="value">{{ $vehicle->marca }}</div></div>
            <div class="ficha-item"><div class="label">Modelo</div><div class="value">{{ $vehicle->modelo }}</div></div>
            <div class="ficha-item"><div class="label">Año</div><div class="value">{{ $vehicle->anio ?? '—' }}</div></div>
            <div class="ficha-item"><div class="label">Chasis / VIN</div><div class="value" style="font-family: monospace; font-size: 13.5px;">{{ $vehicle->chasis }}</div></div>
            <div class="ficha-item"><div class="label">No. de Motor</div><div class="value" style="font-family: monospace; font-size: 13.5px;">{{ $vehicle->motor ?? '—' }}</div></div>
            <div class="ficha-item"><div class="label">Naturaleza / Origen</div><div class="value">{{ $vehicle->naturaleza_origen ?? '—' }}</div></div>
            <div class="ficha-item"><div class="label">Placa / Registro</div><div class="value" style="color: var(--primary);">{{ $vehicle->placa }}</div></div>
            <div class="ficha-item"><div class="label">Color</div><div class="value">{{ $vehicle->color ?? '—' }}</div></div>
        </div>
    </div>

    <!-- Acciones Operativas -->
    @auth
        @if(Auth::user()->hasAnyRole(['admin', 'operador-emisor']))
            <div class="action-row">
                <a href="{{ route('boletas.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Emitir Boleta de Circulación</span>
                </a>
                <a href="{{ route('actas.create', ['vehicle_id' => $vehicle->id]) }}" class="btn-primary" style="background: linear-gradient(135deg, #7c3aed, #8b5cf6);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    <span>Registrar Acta de Entrega</span>
                </a>
            </div>
        @endif
    @endauth

    <!-- Historial de Boletas -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Historial de Boletas de Circulación Emitidas</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha Emisión</th>
                        <th>Fecha Vigencia</th>
                        <th>Estado</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicle->boletas as $boleta)
                        <tr>
                            <td><strong style="color: var(--primary);">{{ $boleta->folio }}</strong></td>
                            <td>{{ $boleta->fecha_emision->format('d/m/Y') }}</td>
                            <td>{{ $boleta->fecha_vigencia->format('d/m/Y') }}</td>
                            <td>
                                @if($boleta->estado === 'vigente')
                                    <span class="badge badge-success">Vigente</span>
                                @elseif($boleta->estado === 'vencida')
                                    <span class="badge badge-danger">Vencida</span>
                                @else
                                    <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">Anulada</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('boletas.show', $boleta) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                    Ver Boleta →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align: center; padding: 32px; color: var(--text-muted);">Aún no se han emitido boletas para este vehículo.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Historial de Actas de Entrega -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Historial de Actas de Entrega</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 18%;">Folio</th>
                        <th style="width: 40%;">Recibe (Titular / Conductor)</th>
                        <th style="width: 22%;">Fecha de Entrega</th>
                        <th style="width: 20%; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicle->actasEntrega as $acta)
                        <tr>
                            <td><strong style="color: #7c3aed;">{{ $acta->folio }}</strong></td>
                            <td>
                                <span style="font-weight: 600; color: var(--text-main);">{{ $acta->recibe_nombre }}</span>
                                @if($acta->recibe_email)
                                    <div style="font-size: 11.5px; color: #0284c7; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $acta->recibe_email }}</span>
                                        @if($acta->enviado_email_at)
                                            <span style="color: #059669; font-size: 10px; font-weight: 700; background: #ecfdf5; padding: 1px 4px; border-radius: 3px;">✓ Notificado</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>{{ $acta->fecha_entrega->format('d/m/Y') }}</td>
                            <td style="text-align: right;">
                                <a href="{{ route('actas.show', $acta) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                    Ver Acta →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align: center; padding: 32px; color: var(--text-muted);">Aún no se han registrado actas de entrega para este vehículo.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
