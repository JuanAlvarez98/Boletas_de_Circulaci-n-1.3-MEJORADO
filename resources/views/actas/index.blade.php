@extends('layouts.dashboard')

@section('title', 'Actas de Entrega')

@section('styles')
<style>
    .search-panel {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
        margin-top: 20px;
    }
    .search-bar {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }
    .search-input-wrap {
        position: relative;
        flex-grow: 1;
        min-width: 260px;
    }
    .search-input-wrap svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: var(--text-muted);
        pointer-events: none;
    }
    .search-bar input {
        width: 100%;
        padding: 10px 14px 10px 42px;
        border: 1.5px solid #cbd5e1;
        border-radius: 9px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
        background-color: #f8fafc;
    }
    .search-bar input:focus {
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
            <h2 class="welcome-title">Actas de Entrega</h2>
            <p class="welcome-subtitle">Registro y entrega formal de vehículos con notificación digital automatizada por correo.</p>
        </div>
        @auth
            @if(Auth::user()->hasAnyRole(['admin', 'operador-emisor', 'operator']))
                <a href="{{ route('actas.create') }}" class="btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Registrar Acta</span>
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

    <!-- Buscador -->
    <div class="search-panel">
        <form method="GET" action="{{ route('actas.index') }}" class="search-bar">
            <div class="search-input-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="{{ $query }}" placeholder="Buscar por folio, placa, nombre o correo de quien recibe...">
            </div>
            <button type="submit" class="btn-primary">Buscar</button>
            @if(!empty($query))
                <a href="{{ route('actas.index') }}" class="btn-secondary">Limpiar</a>
            @endif
        </form>
    </div>

    <!-- Resultados -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Actas Registradas en el Sistema</span>
            <span style="font-size: 13px; color: var(--text-muted);">Total: {{ $actas->total() }} registros</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">Folio</th>
                        <th style="width: 25%;">Vehículo</th>
                        <th style="width: 28%;">Recibe (Titular / Conductor)</th>
                        <th style="width: 14%;">Fecha Entrega</th>
                        <th style="width: 18%; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($actas as $acta)
                        <tr>
                            <td>
                                <strong style="color: #7c3aed; font-size: 14px;">{{ $acta->folio }}</strong>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span class="placa-pill">{{ $acta->vehicle->placa }}</span>
                                    <span style="font-size: 13px; color: var(--text-main); font-weight: 600;">
                                        {{ $acta->vehicle->marca }} {{ $acta->vehicle->modelo }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: var(--text-main); display: block;">{{ $acta->recibe_nombre }}</span>
                                @if($acta->recibe_email)
                                    <div style="font-size: 12px; color: #0284c7; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 13px; height: 13px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $acta->recibe_email }}</span>
                                        @if($acta->enviado_email_at)
                                            <span style="color: #059669; font-size: 10.5px; font-weight: 700; background: #ecfdf5; padding: 1px 5px; border-radius: 4px; margin-left: 2px;">✓ Enviado</span>
                                        @endif
                                    </div>
                                @endif
                                @if($acta->recibe_identidad)
                                    <span style="font-size: 11.5px; color: var(--text-muted); display: block;">ID: {{ $acta->recibe_identidad }}</span>
                                @endif
                            </td>
                            <td>
                                <span style="color: var(--text-secondary); font-size: 13px;">{{ $acta->fecha_entrega->format('d/m/Y') }}</span>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('actas.show', $acta) }}" class="btn-secondary" style="padding: 6px 14px; font-size: 12.5px;">
                                    Ver / Imprimir →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 48px; color: var(--text-muted);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 36px; height: 36px; color: #94a3b8;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span style="font-weight: 600; color: var(--text-main);">No hay actas registradas</span>
                                    <span style="font-size: 13px;">No se encontraron actas con el criterio de búsqueda.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 24px;">
        {{ $actas->links() }}
    </div>
@endsection



