@extends('layouts.dashboard')

@section('title', 'Boleta ' . $boleta->folio)

@section('content')
<style>
    *, *::before, *::after {
        box-sizing: border-box;
    }

    .boleta-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 24px auto;
        padding: 10px;
        font-family: Arial, Helvetica, sans-serif;
    }

    /* Vista vertical únicamente en pantalla */
    .boleta-vertical-container {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 600px;
        color: #000;
        background: #fff;
        border: 2px solid #000;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .10);
    }

    .circulation-card-half {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 100%;
        min-width: 0;
        min-height: 400px;
        padding: 24px;
        overflow: hidden;
    }

    .pliegue-divider {
        width: 100%;
        height: 0;
        border: 0;
        border-top: 2px dashed #cbd5e1;
    }

    .header-layout {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 12px;
        gap: 12px;
    }

    .gobierno-logo-completo {
        display: block;
        width: auto;
        height: auto;
        max-height: 48px;
        object-fit: contain;
        flex: 1;
    }

    .sig-logo-unidad {
        display: block;
        width: auto;
        height: auto;
        max-height: 48px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .document-title-box {
        width: fit-content;
        max-width: 100%;
        margin: 10px auto;
        padding: 8px 16px;
        border: 2px solid #000;
        text-align: center;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 1px;
        line-height: 1.25;
        text-transform: uppercase;
    }

    .placa-destacada {
        margin: 8px 0 15px;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    .specs-table {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        border: 2px solid #000;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .specs-table td {
        width: 50%;
        min-width: 0;
        padding: 10px 12px;
        border: 1.5px solid #000;
        color: #000;
        font-size: 11px;
        font-weight: bold;
        line-height: 1.4;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: normal;
        overflow-wrap: anywhere;
        word-break: normal;
    }

    .reverso-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 100%;
        height: 100%;
        min-width: 0;
    }

    .emision-fecha {
        margin: 10px 0 15px;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .legal-text-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
        padding: 10px;
        text-align: justify;
        font-family: Arial, sans-serif;
    }

    .legal-paragraph {
        margin: 0;
        font-size: 12px;
        font-weight: bold;
        line-height: 1.45;
    }

    .reverso-divider {
        width: 75%;
        margin: 60px auto 6px;
        border: 0;
        border-top: 1.2px solid #000;
    }

    .firma-side {
        display: flex;
        flex: 1;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        padding: 0 0 2px 10px;
        text-align: center;
    }

    .firma-nombre,
    .firma-cargo,
    .firma-entidad {
        font-size: 12px;
        font-weight: bold;
        letter-spacing: .2px;
        text-transform: uppercase;
    }

    .firma-nombre { margin-bottom: 3px; }
    .firma-cargo { margin-bottom: 2px; }

    .footer-reverso {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        width: 100%;
        margin-top: auto;
    }

    .qr-side {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        margin: 35px 0 0 15px;
    }

    #boleta-qr img,
    #boleta-qr canvas {
        width: 70px !important;
        height: 70px !important;
    }

    /* Boleta abierta: 224 × 150 mm */
    @page {
        size: 224mm 150mm;
        margin: 0;
    }

    @media print {
        html,
        body {
            width: 215mm !important;
            height: 140mm !important;
            min-width: 215mm !important;
            min-height: 140mm !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            background: #fff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .topbar,
        .sidebar,
        .welcome-section,
        .alert,
        .no-print,
        .estado-badge-pantalla {
            display: none !important;
        }

        .app-layout,
        .main-content {
            display: block !important;
            width: 215mm !important;
            height: 140mm !important;
            min-width: 0 !important;
            min-height: 0 !important;
            max-width: none !important;
            max-height: none !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }

        .main-content > *:not(.boleta-wrapper) {
            display: none !important;
        }

        .boleta-wrapper {
            display: block !important;
            width: 215mm !important;
            height: 140mm !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
        }

        .boleta-vertical-container {
            position: relative !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: stretch !important;
            width: 215mm !important;
            height: 140mm !important;
            min-width: 215mm !important;
            min-height: 140mm !important;
            max-width: 215mm !important;
            max-height: 140mm !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            /* Contorno interior: marca exactamente los extremos de 224 × 150 mm
               sin sumar grosor ni modificar el tamaño físico de la boleta. */
            border: 0 !important;
            box-shadow: inset 0 0 0 .35mm #000 !important;
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }

        /* Cada panel mide exactamente 107.5 × 140 mm */
        .circulation-card-half {
            display: flex !important;
            flex: 0 0 107.5mm !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            width: 107.5mm !important;
            height: 140mm !important;
            min-width: 107.5mm !important;
            min-height: 140mm !important;
            max-width: 107.5mm !important;
            max-height: 140mm !important;
            margin: 0 !important;
            padding: 7mm !important;
            overflow: hidden !important;
        }

        /* Pliegue exactamente a 112 mm desde el borde izquierdo */
        .pliegue-divider {
            position: absolute !important;
            top: 0 !important;
            left: 107.5mm !important;
            z-index: 10 !important;
            width: 0 !important;
            height: 140mm !important;
            margin: 0 !important;
            padding: 0 !important;
            border: 0 !important;
            border-left: .3mm dashed #666 !important;
        }

        .header-layout {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            margin: 0 0 3mm !important;
            /* Logo: 2 mm a la derecha y 3 mm hacia abajo */
            transform: translate(0mm, 5mm) !important;
            gap: 3mm !important;
        }

        .gobierno-logo-completo {
            width: auto !important;
            max-width: 68mm !important;
            max-height: 22mm !important;
            object-fit: contain !important;
            margin: 0 !important;
        }

        .sig-logo-unidad {
            width: auto !important;
            max-width: 25mm !important;
            max-height: 20mm !important;
            object-fit: contain !important;
            margin: 0 !important;
        }

        .document-title-box {
            max-width: 96mm !important;
            margin: 2mm auto !important;
            padding: 2mm 3mm !important;
            font-size: 11px !important;
            line-height: 1.5 !important;
            /* Título: 1 mm a la izquierda y 5 mm hacia abajo */
            transform: translate(-1mm, -3mm) !important;
        }

        .placa-destacada {
            margin: 2mm 0 3mm !important;
            font-size: 13px !important;
            /* Placa: 2 mm hacia arriba */
            transform: translate(0mm, -5mm) !important;
        }

        .specs-table {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
           border: 1px solid #000000 !important;
           /* Tabla: 4 mm hacia abajo */
            transform: translate(0mm, -10mm) !important;
        }

        .specs-table td {
            width: 50% !important;
            max-width: 50% !important;
            min-width: 0 !important;
            padding: 2.5mm !important;
            font-size: 11px !important;
            line-height: 1.50 !important;
            white-space: normal !important;
            overflow-wrap: anywhere !important;
            word-break: normal !important;
            border: 1px solid #000000 !important;
        }

        .emision-fecha {
            margin: 2mm 0 3mm !important;
            font-size: 13px !important;
            /* Fecha: 10 mm hacia abajo */
            transform: translate(0mm, 10mm) !important;
        }

        .legal-text-container {
            gap: 3mm !important;
            margin: 0 !important;
            padding: 2mm !important;
            /* Texto contenedor: 5 mm hacia abajo */
            transform: translate(0mm, 5mm) !important;
        }

        .legal-paragraph {
            font-size: 11px !important;
            line-height: 1.50 !important;
             /* Parráfo: 5 mm hacia abajo */
            transform: translate(0mm, 5mm) !important;
        }

        .reverso-divider {
            margin: auto auto 4mm !important;
             /* linea: 30 mm hacia abajo */
            transform: translate(0mm, 36mm) !important;
        }

        .firma-nombre,
        .firma-cargo,
        .firma-entidad {
            font-size: 10px !important;
            /* firma: 17 mm hacia abajo */
            transform: translate(0mm, -17mm) !important;
        }

        .footer-reverso {
            margin: 0 !important;
        }

        .qr-side {
            width: 25mm !important;
            margin: 2mm 0 0 !important;
            /* linea: 30 mm hacia abajo */
            transform: translate(0mm, -10mm) !important;
        }

        #boleta-qr,
        #boleta-qr img,
        #boleta-qr canvas {
            width: 20mm !important;
            height: 20mm !important;
        }
    }
</style>

<section class="welcome-section no-print">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
        <div>
            <h2 class="welcome-title">Boleta de circulación: {{ $boleta->folio }}</h2>
            <p class="welcome-subtitle">La impresión genera una boleta abierta de 21.4 × 14 cm.</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <a href="{{ route('vehicles.show', $boleta->vehicle) }}" class="btn-secondary">← Volver a la ficha</a>
            <button onclick="window.print()" class="btn-primary">Imprimir boleta</button>
            @if(Auth::user()->hasAnyRole(['admin','operator']) && $boleta->estado === 'vigente')
                <form class="cancel-form" action="{{ route('boletas.destroy', $boleta) }}" method="POST" onsubmit="return confirm('¿Anular esta boleta?')">
                    @csrf
                    @method('DELETE')
                    <input name="motivo_anulacion" required minlength="10" maxlength="500" placeholder="Motivo de anulación">
                    <button type="submit" class="btn-logout">Anular</button>
                </form>
            @endif
        </div>
    </div>
</section>

@if(session('status'))
    <div class="alert alert-success no-print">{{ session('status') }}</div>
@endif

<div class="boleta-wrapper">
    <div class="boleta-vertical-container">
        <article class="circulation-card-half">
            <header class="header-layout">
                <img src="{{ asset('images/logo-gobierno.png') }}"
                     alt="Gobierno de Honduras - Secretaría de Seguridad"
                     class="gobierno-logo-completo">
                <img src="{{ asset('images/logo-sig.png') }}"
                     alt="Unidad Emisora SIG"
                     class="sig-logo-unidad">
            </header>

            <div class="document-title-box">Boleta de Registro de Vehículo Policial</div>

            <div class="placa-destacada">No. Equipo: {{ $boleta->vehicle->numero_equipo ?? '—' }}</div>

            <table class="specs-table">
                <colgroup>
                    <col style="width:50%">
                    <col style="width:50%">
                </colgroup>
                <tbody>
                    <tr>
                        <td>Tipo: {{ $boleta->vehicle->linea ?? $boleta->vehicle->tipo ?? '—' }}</td>
                        <td>Marca: {{ $boleta->vehicle->marca }}</td>
                    </tr>
                    <tr>
                        <td>Modelo: {{ $boleta->vehicle->modelo }}</td>
                        <td>Año: {{ $boleta->vehicle->anio ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td>Chasis: {{ $boleta->vehicle->chasis }}</td>
                        <td>Motor: {{ $boleta->vehicle->motor ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td>Naturaleza/Origen: {{ $boleta->vehicle->naturaleza_origen ?? '—' }}</td>
                        <td>Placa/Registro: {{ $boleta->vehicle->placa ?? '—' }}</td>
                    </tr>
                </tbody>
            </table>
        </article>

        <div class="pliegue-divider" aria-hidden="true"></div>

        <article class="circulation-card-half">
            <div class="reverso-content">
                <div class="emision-fecha">
                    Fecha de emisión: {{ $boleta->fecha_emision->format('d/m/Y') }}
                </div>

                <div class="legal-text-container">
                    <p class="legal-paragraph">
                        Se le solicita a las autoridades locales y nacionales prestar toda la colaboración en caso de necesidad, caso fortuito o fuerza mayor.
                    </p>
                    <p class="legal-paragraph">
                        En caso de emergencia, llamar a la Dirección de Logística a los teléfonos 9988-1642 y al 911.
                    </p>
                </div>

                <hr class="reverso-divider">

                <div class="firma-side">
                    <span class="firma-nombre">Cesar Yovany Gonzales Ramirez</span>
                    <span class="firma-cargo">Director de Logística</span>
                    <span class="firma-entidad">Dirección General Policía Nacional</span>
                </div>

                <div class="footer-reverso">
                    <div class="qr-side">
                        <div id="boleta-qr" aria-label="Código QR de verificación"></div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>
@endsection

@section('scripts')
@php
    $qrContenido = implode("\n", [
        'Boleta: ' . $boleta->folio,
        'Estado: ' . $boleta->estado,
        'No. equipo: ' . ($boleta->vehicle->numero_equipo ?? 'N/D'),
        'Placa: ' . $boleta->vehicle->placa,
        'Naturaleza: ' . ($boleta->vehicle->naturaleza_origen ?? 'N/D'),
        'Vence: ' . $boleta->fecha_vigencia->format('d/m/Y'),
    ]);
@endphp
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new QRCode(document.getElementById('boleta-qr'), {
            text: @json($qrContenido),
            width: 76,
            height: 76,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M
        });
    });
</script>
@endsection