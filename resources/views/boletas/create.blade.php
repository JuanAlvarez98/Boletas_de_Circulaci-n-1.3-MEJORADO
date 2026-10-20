@extends('layouts.dashboard')

@section('title', 'Emitir Boleta de Circulación')

@section('styles')
<style>
    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 8px; color: #334155; }
    .form-control {
        width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px;
        font-size: 14px; color: var(--text-main); outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus { border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15); }
    .input-error { color: var(--danger); font-size: 12px; margin-top: 6px; }
    .vehicle-summary {
        background-color: var(--primary-light); border: 1px solid #dbeafe; border-radius: 10px;
        padding: 16px 20px; margin-bottom: 24px; font-size: 13.5px;
    }
</style>
@endsection

@section('content')
    <section class="welcome-section">
        <h2 class="welcome-title">Emitir Boleta de Circulación</h2>
        <p class="welcome-subtitle">Seleccione el vehículo y complete los datos de vigencia de la boleta.</p>
    </section>

    @if ($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    @if(!$vehicle)
        @php($rutaCreate = 'boletas.create')
        @include('partials._buscador_vehiculo')
    @else
        <div class="form-card" style="margin-top: 0;">
            <div class="form-header"><span class="form-title">Paso 2: Datos de la Boleta</span></div>

            <div style="padding: 24px;">
                <div class="vehicle-summary">
                    <strong>{{ $vehicle->placa }}</strong> — {{ $vehicle->marca }} {{ $vehicle->modelo }} ({{ $vehicle->anio ?? 's/f' }})<br>
                    Chasis: {{ $vehicle->chasis }}
                    @if($vehicle->numero_equipo)
                        · No. Equipo: {{ $vehicle->numero_equipo }}
                    @endif
                    &nbsp;·&nbsp;<a href="{{ route('boletas.create') }}" style="color: var(--primary);">Cambiar vehículo</a>
                </div>

                <form method="POST" action="{{ route('boletas.store') }}">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px;">
                        <div class="form-group">
                            <label for="fecha_emision" class="form-label">Fecha de Emisión *</label>
                            <input type="date" id="fecha_emision" name="fecha_emision" value="{{ old('fecha_emision', now()->format('Y-m-d')) }}" class="form-control" required>
                            @error('fecha_emision')<div class="input-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="fecha_vigencia" class="form-label">Vigente Hasta *</label>
                            <input type="date" id="fecha_vigencia" name="fecha_vigencia" value="{{ old('fecha_vigencia', now()->addYear()->format('Y-m-d')) }}" class="form-control" required>
                            @error('fecha_vigencia')<div class="input-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="3" class="form-control" style="resize: vertical;">{{ old('observaciones') }}</textarea>
                        @error('observaciones')<div class="input-error">{{ $message }}</div>@enderror
                    </div>

                    <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary"><span>Emitir Boleta</span></button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
