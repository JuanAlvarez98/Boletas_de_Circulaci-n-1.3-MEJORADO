@extends('layouts.dashboard')

@section('title', 'Panel de Control')

@section('styles')
<style>
    /* Estilos del Grid de Estadísticas */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        margin-top: 10px;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.25s ease;
    }

    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-border);
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--kpi-accent, #1e3a8a);
        border-radius: 14px 14px 0 0;
    }

    .kpi-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    .kpi-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .kpi-icon-wrap {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--kpi-bg, #eff6ff);
        color: var(--kpi-color, #1e3a8a);
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }

    .kpi-card:hover .kpi-icon-wrap {
        transform: scale(1.1);
    }

    .kpi-icon-wrap svg {
        width: 22px;
        height: 22px;
        stroke-width: 2.2;
    }

    .kpi-value-wrap {
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .kpi-value {
        font-family: 'Outfit', sans-serif;
        font-size: 32px;
        font-weight: 700;
        color: var(--text-main);
        line-height: 1;
    }

    .kpi-subtext {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 6px;
    }

    /* Colores Temáticos para KPIs */
    .kpi-vehiculos {
        --kpi-accent: #10b981;
        --kpi-bg: #ecfdf5;
        --kpi-color: #059669;
    }

    .kpi-vigentes {
        --kpi-accent: #2563eb;
        --kpi-bg: #eff6ff;
        --kpi-color: #1d4ed8;
    }

    .kpi-por-vencer {
        --kpi-accent: #f59e0b;
        --kpi-bg: #fffbeb;
        --kpi-color: #d97706;
    }

    .kpi-vencidas {
        --kpi-accent: #f43f5e;
        --kpi-bg: #ffe4e6;
        --kpi-color: #e11d48;
    }

    .kpi-anuladas {
        --kpi-accent: #64748b;
        --kpi-bg: #f1f5f9;
        --kpi-color: #475569;
    }

    .kpi-actas {
        --kpi-accent: #8b5cf6;
        --kpi-bg: #f5f3ff;
        --kpi-color: #7c3aed;
    }

    .placa-badge {
        font-family: monospace;
        font-size: 13.5px;
        font-weight: 700;
        background-color: #f1f5f9;
        color: #0f172a;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        display: inline-block;
    }
</style>
@endsection

@section('content')

    <!-- Banner de Bienvenida -->
    <section class="welcome-section">
        <div>
            <h2 class="welcome-title">Bienvenido, {{ Auth::user()->name }}</h2>
            <p class="welcome-subtitle">Panel general de control vehicular y emisión de boletas de circulación.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <span class="badge badge-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM, YYYY') }}
            </span>
        </div>
    </section>

    <!-- Grid de Métricas / KPIs -->
    <div class="kpi-grid">
        
        <!-- 1. Vehículos -->
        <div class="kpi-card kpi-vehiculos">
            <div class="kpi-header">
                <span class="kpi-title">Vehículos</span>
                <div class="kpi-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 17l-2 2m0 0l-2-2m2 2V9a5 5 0 015-5h6a2 2 0 012 2v11m0 0l2 2m-2-2l-2 2M5 13h14" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="kpi-value">{{ number_format($stats['vehiculos']) }}</div>
                <div class="kpi-subtext">Registrados en la flota</div>
            </div>
        </div>

        <!-- 2. Boletas Vigentes -->
        <div class="kpi-card kpi-vigentes">
            <div class="kpi-header">
                <span class="kpi-title">Boletas</span>
                <div class="kpi-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="kpi-value">{{ number_format($stats['vigentes']) }}</div>
                <div class="kpi-subtext">En circulación activa</div>
            </div>
        </div>

        {{--
        <!-- 3. Por Vencer -->
        <div class="kpi-card kpi-por-vencer">
            <div class="kpi-header">
                <span class="kpi-title">Por Vencer</span>
                <div class="kpi-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="kpi-value">{{ number_format($stats['por_vencer']) }}</div>
                <div class="kpi-subtext">Próximos 30 días</div>
            </div>
        </div>

        <!-- 4. Vencidas -->
        <div class="kpi-card kpi-vencidas">
            <div class="kpi-header">
                <span class="kpi-title">Vencidas</span>
                <div class="kpi-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="kpi-value">{{ number_format($stats['vencidas']) }}</div>
                <div class="kpi-subtext">Requieren renovación</div>
            </div>
        </div>
        --}}

        <!-- 5. Anuladas -->
        <div class="kpi-card kpi-anuladas">
            <div class="kpi-header">
                <span class="kpi-title">Anuladas</span>
                <div class="kpi-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="kpi-value">{{ number_format($stats['anuladas']) }}</div>
                <div class="kpi-subtext">Folios invalidados</div>
            </div>
        </div>

        <!-- 6. Actas Registradas -->
        <div class="kpi-card kpi-actas">
            <div class="kpi-header">
                <span class="kpi-title">Actas de Entrega</span>
                <div class="kpi-icon-wrap">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
            <div>
                <div class="kpi-value">{{ number_format($stats['actas']) }}</div>
                <div class="kpi-subtext">Entregas formalizadas</div>
            </div>
        </div>

    </div>

    <!-- Tabla: Boletas Próximas a Vencer -->
    <div class="table-card">
        <div class="table-header">
            <div>
                <span class="table-title">Boletas Próximas a Vencer</span>
                <div style="font-size: 12.5px; color: var(--text-muted); margin-top: 2px;">
                    Vehículos cuyas boletas expirarán en un periodo igual o menor a 30 días
                </div>
            </div>
            <a href="{{ route('boletas.index', ['estado' => 'vigente']) }}" class="btn-secondary" style="font-size: 12.5px; padding: 6px 14px;">
                Ver todas las vigentes →
            </a>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 20%;">Folio de Boleta</th>
                        <th style="width: 30%;">Vehículo / Placa</th>
                        <th style="width: 25%;">Fecha de Vencimiento</th>
                        <th style="width: 15%; text-align: center;">Estado</th>
                        <th style="width: 10%; text-align: right;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proximas as $boleta)
                        <tr>
                            <td>
                                <strong style="color: var(--primary);">{{ $boleta->folio }}</strong>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span class="placa-badge">{{ $boleta->vehicle->placa }}</span>
                                    <span style="font-size: 13.5px; color: var(--text-secondary);">
                                        {{ $boleta->vehicle->marca }} {{ $boleta->vehicle->modelo }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #b45309;">
                                    {{ $boleta->fecha_vigencia->format('d/m/Y') }}
                                </span>
                                <span style="font-size: 12px; color: var(--text-muted); display: block;">
                                    ({{ $boleta->fecha_vigencia->diffForHumans() }})
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge badge-warning">Por Vencer</span>
                            </td>
                            <td style="text-align: right;">
                                <a class="btn-secondary" style="padding: 6px 12px; font-size: 12px;" href="{{ route('boletas.show', $boleta) }}">
                                    Ver Boleta
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 48px 24px; color: var(--text-muted);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 42px; height: 42px; color: #10b981;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span style="font-size: 15px; font-weight: 600; color: var(--text-main);">Todo al día</span>
                                    <span style="font-size: 13px;">No hay boletas de circulación próximas a vencer en los siguientes 30 días.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
