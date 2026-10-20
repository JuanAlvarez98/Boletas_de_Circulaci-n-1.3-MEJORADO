@extends('layouts.dashboard')

@section('title', 'Sticker ' . $sticker->codigo)

@section('styles')
<style>
    .sticker-card {
        background: #fff;
        border: 2px solid var(--primary);
        border-radius: 14px;
        max-width: 380px;
        margin: 24px auto 0;
        padding: 28px;
        text-align: center;
    }
    .sticker-card .institucion { font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-muted); font-weight: 700; }
    .sticker-card .titulo { font-size: 16px; font-weight: 700; color: var(--primary); margin: 4px 0 16px; }
    .sticker-card .placa { font-size: 26px; font-weight: 800; letter-spacing: 0.04em; margin-bottom: 16px; }
    .qr-wrapper { display: flex; justify-content: center; margin: 16px 0; }
    .sticker-datos { text-align: left; font-size: 13px; margin-top: 16px; border-top: 1px dashed var(--border-color); padding-top: 16px; }
    .sticker-datos div { margin-bottom: 4px; }
    .sticker-datos strong { color: var(--text-main); }
    .sticker-codigo { margin-top: 16px; font-family: monospace; font-size: 12px; color: var(--text-muted); }

    @media print {
        .topbar, .sidebar, .welcome-section, .alert, .no-print { display: none !important; }
        .main-content { padding: 0 !important; max-width: 100% !important; }
        .sticker-card { margin: 0 auto; border: 2px solid #000; }
        body { background: #fff !important; }
    }
</style>
@endsection

@section('content')
    <section class="welcome-section no-print">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <h2 class="welcome-title">Sticker: {{ $sticker->codigo }}</h2>
                <p class="welcome-subtitle">Vehículo {{ $sticker->vehicle->placa }} — {{ $sticker->vehicle->marca }} {{ $sticker->vehicle->modelo }}</p>
            </div>
            <div style="display:flex; gap: 10px;">
                <a href="{{ route('vehicles.show', $sticker->vehicle) }}" class="btn-secondary">← Volver a la Ficha</a>
                <button onclick="window.print()" class="btn-primary">Imprimir Sticker</button>
            </div>
        </div>
    </section>

    @if (session('status'))
        <div class="alert alert-success no-print">{{ session('status') }}</div>
    @endif
    @if(Auth::user()->hasAnyRole(['admin','operator']) && $sticker->estado === 'activo')
        <form class="no-print" method="POST" action="{{ route('stickers.destroy',$sticker) }}" style="display:flex;gap:10px;margin-bottom:18px">@csrf @method('DELETE')
            <input name="motivo_anulacion" required minlength="10" maxlength="500" placeholder="Motivo de anulación" style="flex:1;padding:9px;border:1px solid #cbd5e1;border-radius:7px">
            <button class="btn-logout" type="submit" onclick="return confirm('¿Anular este sticker?')">Anular sticker</button>
        </form>
    @endif

    <div class="sticker-card">
        <div class="institucion">Sistema de Control de Boletas de Circulación</div>
        <div class="titulo">Sticker de Identificación Vehicular</div>

        <div class="placa">{{ $sticker->vehicle->placa }}</div>

        <div class="qr-wrapper" id="qr-code"></div>

        <div class="sticker-datos">
            <div><strong>Marca:</strong> {{ $sticker->vehicle->marca }}</div>
            <div><strong>Modelo:</strong> {{ $sticker->vehicle->modelo }}</div>
            <div><strong>Chasis:</strong> {{ $sticker->vehicle->chasis }}</div>
        </div>

        <div class="sticker-codigo">{{ $sticker->codigo }}</div>
    </div>
@endsection

@section('scripts')
    {{-- Librería ligera para generar el QR directamente en el navegador (sin dependencias de Composer) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        new QRCode(document.getElementById("qr-code"), {
            text: @json($sticker->contenido_qr),
            width: 160,
            height: 160,
            correctLevel: QRCode.CorrectLevel.M
        });
    </script>
@endsection
