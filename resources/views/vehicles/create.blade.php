@extends('layouts.dashboard')

@section('title', 'Registrar Vehículo')

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
</style>
@endsection

@section('content')
    <section class="welcome-section">
        <h2 class="welcome-title">Registrar Vehículo</h2>
        <p class="welcome-subtitle">Este registro alimenta la base local mientras no se cuente con la conexión directa a la API de SAP.</p>
    </section>

    <div class="form-card" style="margin-top: 0;">
        <div class="form-header"><span class="form-title">Datos del Vehículo</span></div>

        <form method="POST" action="{{ route('vehicles.store') }}" style="padding: 24px;">
            @csrf

            @include('vehicles._form')

            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <a href="{{ route('vehicles.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary"><span>Guardar Vehículo</span></button>
            </div>
        </form>
    </div>
@endsection
