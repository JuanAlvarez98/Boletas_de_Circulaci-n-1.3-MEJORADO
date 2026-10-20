@extends('layouts.dashboard')

@section('title', 'Boletas de Circulación')

@section('styles')
<style>
    .filter-panel {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
        margin-top: 20px;
    }
    .filter-form {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }
    .filter-input-wrap {
        position: relative;
        flex-grow: 1;
        min-width: 220px;
    }
    .filter-input-wrap svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: var(--text-muted);
        pointer-events: none;
    }
    .filter-control {
        padding: 9px 14px;
        border: 1.5px solid #cbd5e1;
        border-radius: 9px;
        font-size: 13.5px;
        outline: none;
        transition: all 0.2s ease;
        background-color: #f8fafc;
        color: #0f172a;
    }
    .filter-input-wrap .filter-control {
        width: 100%;
        padding-left: 40px;
    }
    .filter-control:focus {
        border-color: var(--primary-hover);
        background-color: #ffffff;
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15);
    }
    .placa-pill {
        font-family: monospace;
        font-size: 13px;
        font-weight: 700;
        background-color: #eff6ff;
        color: #1e3a8a;
        padding: 3px 8px;
        border-radius: 5px;
        border: 1px solid #bfdbfe;
        display: inline-block;
    }
</style>
@endsection

@section('content')
    <!-- Cabecera -->
    <section class="welcome-section">
        <div>
            <h2 class="welcome-title">Boletas de Circulación</h2>
            <p class="welcome-subtitle">Historial de boletas emitidas, estado de vigencia y autorizaciones de circulación.</p>
        </div>
        @auth
            @if(Auth::user()->hasAnyRole(['admin', 'operador-emisor', 'operator']))
                <a href="{{ route('boletas.create') }}" class="btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Emitir Boleta</span>
                </a>
            @endif
        @endauth
    </section>

    @if (session('status'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <!-- Filtros de Búsqueda -->
    <div class="filter-panel">
        <form method="GET" action="{{ route('boletas.index') }}" class="filter-form">
            <div class="filter-input-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="{{ $query }}" class="filter-control" placeholder="Buscar por folio o placa...">
            </div>
            
            <select name="estado" class="filter-control">
                <option value="">Todos los estados</option>
                @foreach(['vigente'=>'Vigente','vencida'=>'Vencida','anulada'=>'Anulada'] as $v=>$l)
                    <option value="{{ $v }}" @selected(request('estado')===$v)>{{ $l }}</option>
                @endforeach
            </select>

            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="font-size: 12.5px; color: var(--text-muted);">Desde:</span>
                <input type="date" name="desde" value="{{ request('desde') }}" class="filter-control" aria-label="Desde">
            </div>

            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="font-size: 12.5px; color: var(--text-muted);">Hasta:</span>
                <input type="date" name="hasta" value="{{ request('hasta') }}" class="filter-control" aria-label="Hasta">
            </div>

            <button type="submit" class="btn-primary">Filtrar</button>
            
            @if(request()->hasAny(['q', 'estado', 'desde', 'hasta']))
                <a href="{{ route('boletas.index') }}" class="btn-secondary">Limpiar</a>
            @endif
        </form>
    </div>

    <!-- Resultados -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Boletas Emitidas en el Sistema</span>
            <span style="font-size: 13px; color: var(--text-muted);">Total: {{ $boletas->total() }} registros</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">Folio</th>
                        <th style="width: 25%;">Vehículo</th>
                        <th style="width: 15%;">Emisión</th>
                        <th style="width: 15%;">Vigencia</th>
                        <th style="width: 12%; text-align: center;">Estado</th>
                        <th style="width: 18%; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($boletas as $boleta)
                        <tr>
                            <td>
                                <strong style="color: var(--primary); font-size: 14.5px;">{{ $boleta->folio }}</strong>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 3px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="placa-pill">{{ $boleta->vehicle->placa }}</span>
                                        <strong style="color: var(--text-main); font-size: 13.5px;">{{ $boleta->vehicle->marca }} {{ $boleta->vehicle->modelo }}</strong>
                                    </div>
                                    @if($boleta->vehicle->numero_equipo)
                                        <span style="font-size: 11.5px; color: var(--text-muted);">Equipo: {{ $boleta->vehicle->numero_equipo }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--text-secondary);">{{ $boleta->fecha_emision->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: {{ $boleta->estado === 'vencida' ? '#dc2626' : ($boleta->estado === 'vigente' ? '#059669' : 'inherit') }};">
                                    {{ $boleta->fecha_vigencia->format('d/m/Y') }}
                                </span>
                            </td>
                            <td style="text-align: center;">
                                @if($boleta->estado === 'vigente')
                                    <span class="badge badge-success">Vigente</span>
                                @elseif($boleta->estado === 'vencida')
                                    <span class="badge badge-danger">Vencida</span>
                                @else
                                    <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">Anulada</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('boletas.show', $boleta) }}" class="btn-secondary" style="padding: 6px 14px; font-size: 12.5px;">
                                    Ver Boleta →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px; color: var(--text-muted);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 36px; height: 36px; color: #94a3b8;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span style="font-weight: 600; color: var(--text-main);">No hay boletas registradas</span>
                                    <span style="font-size: 13px;">No se encontraron boletas con los filtros especificados.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 24px;">
        {{ $boletas->links() }}
    </div>
@endsection
