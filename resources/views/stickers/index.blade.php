@extends('layouts.dashboard')

@section('title', 'Stickers de Identificación')

@section('styles')
<style>
    .search-bar { display: flex; gap: 12px; margin-top: 24px; }
    .search-bar input {
        flex-grow: 1; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px;
        font-size: 14px; outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-bar input:focus { border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15); }
</style>
@endsection

@section('content')
    <section class="welcome-section">
        <h2 class="welcome-title">Stickers de Identificación</h2>
        <p class="welcome-subtitle">Stickers con código QR generados para los vehículos del sistema.</p>
    </section>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="GET" action="{{ route('stickers.index') }}" class="search-bar">
        <input type="text" name="q" value="{{ $query }}" placeholder="Buscar por código o placa...">
        <button type="submit" class="btn-primary">Buscar</button>
        @auth
            @if(Auth::user()->hasAnyRole(['admin', 'operator']))
                <a href="{{ route('stickers.create') }}" class="btn-secondary" style="white-space: nowrap;">+ Generar Sticker</a>
            @endif
        @endauth
    </form>

    <div class="table-card">
        <div class="table-header"><span class="table-title">Stickers Generados</span></div>
        <div class="table-responsive">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Vehículo</th>
                        <th>Fecha Emisión</th>
                        <th>Emitido por</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stickers as $sticker)
                        <tr>
                            <td><strong>{{ $sticker->codigo }}</strong></td>
                            <td>{{ $sticker->vehicle->placa }} — {{ $sticker->vehicle->marca }} {{ $sticker->vehicle->modelo }}</td>
                            <td>{{ $sticker->fecha_emision->format('d/m/Y') }}</td>
                            <td style="color: var(--text-muted); font-size: 13px;">{{ $sticker->emisor->name }}</td>
                            <td style="text-align: right;">
                                <a href="{{ route('stickers.show', $sticker) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 12px;">Ver / Imprimir</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">No hay stickers generados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 20px;">
        {{ $stickers->links() }}
    </div>
@endsection
