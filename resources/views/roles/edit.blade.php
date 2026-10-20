@extends('layouts.dashboard')

@section('title', 'Editar Rol')

@section('styles')
<style>
    .form-group {
        margin-bottom: 24px;
    }
    .form-label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #334155;
    }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        color: var(--text-main);
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
    }
    .input-error {
        color: var(--danger);
        font-size: 12px;
        margin-top: 6px;
    }
</style>
@endsection

@section('content')
    <section class="welcome-section">
        <h2 class="welcome-title">Editar Rol: {{ $role->name }}</h2>
        <p class="welcome-subtitle">Modifique el nombre o la descripción del rol. El slug de validación interna se mantendrá protegido para el rol administrador.</p>
    </section>

    <div class="form-card" style="max-width: 600px; margin-top: 0;">
        <div class="form-header">
            <span class="form-title">Modificar Datos del Rol</span>
        </div>

        <form method="POST" action="{{ route('roles.update', $role->id) }}" style="padding: 24px;">
            @csrf
            @method('PUT')

            <!-- Campo: Nombre -->
            <div class="form-group">
                <label for="name" class="form-label">Nombre del Rol</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $role->name) }}" 
                       class="form-control" 
                       placeholder="Ej. Operador de Impresión" 
                       required 
                       {{ $role->slug === 'admin' ? 'readonly' : '' }} 
                       autofocus>
                @if($role->slug === 'admin')
                    <div style="font-size: 11.5px; color: var(--text-muted); margin-top: 6px; font-style: italic;">
                        El nombre del Administrador principal no se puede cambiar por seguridad del sistema.
                    </div>
                @endif
                @error('name')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo: Descripción -->
            <div class="form-group">
                <label for="description" class="form-label">Descripción de Responsabilidades</label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          class="form-control" 
                          placeholder="Describa brevemente qué tareas y privilegios tendrá este rol en el sistema..." 
                          style="resize: vertical;">{{ old('description', $role->description) }}</textarea>
                @error('description')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botones de Acción -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <a href="{{ route('roles.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <span>Actualizar Rol</span>
                </button>
            </div>
        </form>
    </div>
@endsection
