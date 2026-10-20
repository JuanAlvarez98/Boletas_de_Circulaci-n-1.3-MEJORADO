@extends('layouts.dashboard')

@section('title', 'Nuevo usuario')

@section('styles')
<style>
    .user-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .form-group {
        min-width: 0;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #334155;
        font-size: 13.5px;
        font-weight: 600;
    }

    .form-control {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        outline: none;
        color: var(--text-main);
        background: #fff;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
    }

    .form-control:focus {
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, .15);
    }

    .input-error {
        margin-top: 6px;
        color: var(--danger);
        font-size: 12px;
    }

    .form-help {
        display: block;
        margin-top: 6px;
        color: var(--text-muted);
        font-size: 12px;
    }

    @media (max-width: 640px) {
        .user-form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full-width {
            grid-column: auto;
        }
    }
</style>
@endsection

@section('content')
<section class="welcome-section">
    <h2 class="welcome-title">Agregar nuevo usuario</h2>
    <p class="welcome-subtitle">Registre las credenciales y el nivel de acceso del usuario.</p>
</section>

@if ($errors->any())
    <div class="alert alert-error" style="max-width: 760px;">
        Revise los campos marcados antes de continuar.
    </div>
@endif

<div class="form-card" style="max-width: 760px; margin-top: 0;">
    <div class="form-header">
        <span class="form-title">Datos de la cuenta</span>
    </div>

    <form method="POST" action="{{ route('users.store') }}" style="padding: 24px;">
        @csrf

        <div class="user-form-grid">
            <div class="form-group full-width">
                <label for="name" class="form-label">Nombre completo</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control"
                    maxlength="255"
                    autocomplete="name"
                    required
                    autofocus>
                @error('name')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="email" class="form-label">Correo</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control"
                    maxlength="255"
                    autocomplete="email"
                    required>
                @error('email')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    minlength="8"
                    autocomplete="new-password"
                    required>
                <span class="form-help">Debe contener al menos 8 caracteres.</span>
                @error('password')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmación de contraseña</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    minlength="8"
                    autocomplete="new-password"
                    required>
            </div>

            <div class="form-group full-width">
                <label for="role" class="form-label">Rol</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="">Seleccione un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->slug }}" @selected(old('role') === $role->slug)>
                            @if ($role->slug === 'admin')
                                Administrador
                            @elseif ($role->slug === 'operador-emisor')
                                Operador
                            @elseif ($role->slug === 'supervisor')
                                Supervisor
                            @else
                                {{ $role->name }}
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:30px;border-top:1px solid var(--border-color);padding-top:20px;">
            <a href="{{ route('users.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Guardar usuario</button>
        </div>
    </form>
</div>
@endsection
