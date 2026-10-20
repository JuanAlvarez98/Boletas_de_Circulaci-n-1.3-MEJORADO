@extends('layouts.dashboard')

@section('title', 'Registrar Acta de Entrega')

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
        <div>
            <h2 class="welcome-title">Registrar Acta de Entrega</h2>
            <p class="welcome-subtitle">Seleccione el vehículo y complete los datos de quién entrega y quién recibe.</p>
        </div>
    </section>

    @if ($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    @if(!$vehicle)
        @php($rutaCreate = 'actas.create')
        @include('partials._buscador_vehiculo')
    @else
        <div class="form-card" style="margin-top: 0;">
            <div class="form-header"><span class="form-title">Datos del Acta</span></div>

            <div style="padding: 24px;">
                <div class="vehicle-summary">
                    <strong>{{ $vehicle->placa }}</strong> — {{ $vehicle->marca }} {{ $vehicle->modelo }} ({{ $vehicle->anio ?? 's/f' }})<br>
                    Chasis: {{ $vehicle->chasis }}
                    &nbsp;·&nbsp;<a href="{{ route('actas.create') }}" style="color: var(--primary); font-weight: 600;">Cambiar vehículo</a>
                </div>

                <form method="POST" action="{{ route('actas.store') }}">
                    @csrf
                    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                    @if($vehicle->boletas->isNotEmpty())
                        <div class="form-group">
                            <label for="boleta_id" class="form-label">Boleta de Circulación Relacionada (opcional)</label>
                            <select id="boleta_id" name="boleta_id" class="form-control">
                                <option value="">Sin relacionar</option>
                                @foreach($vehicle->boletas as $b)
                                    <option value="{{ $b->id }}" @selected(old('boleta_id') == $b->id)>{{ $b->folio }} (Vigente hasta {{ $b->fecha_vigencia->format('d/m/Y') }})</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px;">
                        <div class="form-group">
                            <label for="entrega_nombre" class="form-label">Quién Entrega (Funcionario) *</label>
                            <input type="text" id="entrega_nombre" name="entrega_nombre" value="{{ old('entrega_nombre', Auth::user()->name) }}" class="form-control" required>
                            @error('entrega_nombre')<div class="input-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="fecha_entrega" class="form-label">Fecha de Entrega *</label>
                            <input type="date" id="fecha_entrega" name="fecha_entrega" value="{{ old('fecha_entrega', now()->format('Y-m-d')) }}" class="form-control" required>
                            @error('fecha_entrega')<div class="input-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="recibe_nombre" class="form-label">Quién Recibe (Titular / Conductor) *</label>
                            <input type="text" id="recibe_nombre" name="recibe_nombre" value="{{ old('recibe_nombre') }}" class="form-control" placeholder="Nombre completo de quien recibe" required>
                            @error('recibe_nombre')<div class="input-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label for="recibe_identidad" class="form-label">Identidad de Quien Recibe</label>
                            <input type="text" id="recibe_identidad" name="recibe_identidad" value="{{ old('recibe_identidad') }}" class="form-control" placeholder="Ej. 0801-1990-12345">
                            @error('recibe_identidad')<div class="input-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Entrega Automatizada por Correo Electrónico -->
                    <div style="background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%); border: 1.5px solid #dbeafe; border-radius: 12px; padding: 18px 20px; margin-bottom: 24px;">
                        <div class="form-group" style="margin-bottom: 8px;">
                            <label for="recibe_email" class="form-label" style="display: flex; align-items: center; justify-content: space-between;">
                                <span>
                                    <strong>Correo Electrónico de Quien Recibe</strong>
                                    <span style="font-weight: normal; color: var(--text-muted); font-size: 12.5px;">(Para entrega digital automatizada)</span>
                                </span>
                                <span style="font-size: 11px; font-weight: 700; color: #0284c7; background: #e0f2fe; padding: 2px 8px; border-radius: 6px;">Opcional</span>
                            </label>
                            <div style="position: relative;">
                                <input type="email" id="recibe_email" name="recibe_email" value="{{ old('recibe_email') }}" class="form-control" placeholder="ejemplo@correo.com" style="padding-left: 40px;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: #0284c7;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @error('recibe_email')<div class="input-error">{{ $message }}</div>@enderror
                        </div>
                        <div style="font-size: 12.5px; color: #475569; display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px; color: #059669; flex-shrink: 0;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Al ingresar el correo, el acta se enviará automáticamente con todos los detalles al guardar.</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="3" class="form-control" style="resize: vertical;" placeholder="Notas adicionales sobre la entrega del vehículo...">{{ old('observaciones') }}</textarea>
                        @error('observaciones')<div class="input-error">{{ $message }}</div>@enderror
                    </div>

                    <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <a href="{{ route('vehicles.show', $vehicle) }}" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            <span>Registrar y Entregar Acta</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection


