@extends('layouts.dashboard')

@section('title', 'Generar Sticker de Identificación')

@section('styles')
<style>
    .vehicle-summary {
        background-color: var(--primary-light); border: 1px solid #dbeafe; border-radius: 10px;
        padding: 16px 20px; margin-bottom: 24px; font-size: 13.5px;
    }
</style>
@endsection

@section('content')
    <section class="welcome-section">
        <h2 class="welcome-title">Generar Sticker de Identificación</h2>
        <p class="welcome-subtitle">Seleccione el vehículo para generar su sticker con código QR (marca, modelo y chasis).</p>
    </section>

    @if ($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    @if(!$vehicle)
        @php($rutaCreate = 'stickers.create')
        @include('partials._buscador_vehiculo')
    @else
        <div class="form-card" style="margin-top: 0;">
            <div class="form-header"><span class="form-title">Confirmar Generación del Sticker</span></div>

            <div style="padding: 24px;">
                <div class="vehicle-summary">
                    <strong>{{ $vehicle->placa }}</strong> — {{ $vehicle->marca }} {{ $vehicle->modelo }} ({{ $vehicle->anio ?? 's/f' }})<br>
                    Chasis: {{ $vehicle->chasis }}
                    &nbsp;·&nbsp;<a href="{{ route('stickers.create') }}" style="color: var(--primary);">Cambiar vehículo</a>
                </div>

                <p style="font-size: 13.5px; color: var(--text-muted); margin-bottom: 24px;">
                    El código QR generado codificará la marca, el modelo y el número de chasis de este vehículo.
                </p>

                <form method="POST" action="{{ route('stickers.store') }}">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                    @if($boletas->isNotEmpty())
                        <div style="margin-bottom:20px"><label for="boleta_id" style="display:block;font-weight:600;margin-bottom:8px">Boleta vigente relacionada (opcional)</label>
                        <select id="boleta_id" name="boleta_id" style="width:100%;padding:10px;border:1px solid #cbd5e1;border-radius:8px"><option value="">Sin relacionar</option>
                        @foreach($boletas as $boleta)<option value="{{ $boleta->id }}">{{ $boleta->folio }} — vence {{ $boleta->fecha_vigencia->format('d/m/Y') }}</option>@endforeach
                        </select></div>
                    @endif

                    <div style="display: flex; gap: 12px; justify-content: flex-end; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary"><span>Generar Sticker</span></button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
