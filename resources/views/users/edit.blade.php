@extends('layouts.dashboard')

@section('title', 'Asignar Roles')

@section('styles')
<style>
    .role-card {
        border: 1.5px solid var(--border-color);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 16px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .role-card:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }
    .role-card.selected {
        border-color: var(--secondary);
        background-color: #f0fdfa;
    }
    .role-checkbox {
        width: 18px;
        height: 18px;
        accent-color: var(--secondary);
        margin-top: 2px;
        cursor: pointer;
    }
    .role-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .role-title {
        font-size: 14.5px;
        font-weight: 600;
        color: #1e293b;
    }
    .role-desc {
        font-size: 12.5px;
        color: var(--text-muted);
        line-height: 1.4;
    }
</style>
@endsection

@section('content')
    <section class="welcome-section">
        <h2 class="welcome-title">Asignar Roles: {{ $user->name }}</h2>
        <p class="welcome-subtitle">Marque los perfiles de acceso correspondientes para las funciones en la plataforma.</p>
    </section>

    <!-- Errores de validación o seguridad -->
    @if ($errors->any())
        <div class="alert alert-error" style="max-width: 650px;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="form-card" style="max-width: 650px; margin-top: 0;">
        <div class="form-header" style="background-color: #f8fafc;">
            <div style="display: flex; flex-direction: column; gap: 4px;">
                <span class="form-title" style="font-size: 15px;">Información del Funcionario</span>
                <span style="font-size: 12.5px; color: var(--text-muted);">
                    Usuario: <strong>{{ $user->username ?? 'N/A' }}</strong> &nbsp;|&nbsp; Correo: <strong>{{ $user->email }}</strong>
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('users.update', $user->id) }}" style="padding: 24px;">
            @csrf
            @method('PUT')

            <h3 style="font-size: 13.5px; font-weight: 700; text-transform: uppercase; color: #475569; letter-spacing: 0.5px; margin-bottom: 16px;">
                Seleccione los Roles Permitidos
            </h3>

            <!-- Listado de Roles con Checkbox -->
            @foreach($roles as $role)
                @php
                    $isChecked = in_array($role->id, $userRoles);
                @endphp
                <label for="role_{{ $role->id }}" class="role-card @if($isChecked) selected @endif" id="label_role_{{ $role->id }}">
                    <input type="checkbox" 
                           id="role_{{ $role->id }}" 
                           name="roles[]" 
                           value="{{ $role->id }}" 
                           class="role-checkbox" 
                           @if($isChecked) checked @endif
                           onclick="toggleCardState({{ $role->id }})">
                    
                    <div class="role-info">
                        <span class="role-title">
                            {{ $role->name }} 
                            @if($role->slug === 'admin')
                                <span class="badge badge-primary" style="font-size: 10px; padding: 2px 8px; margin-left: 6px;">admin</span>
                            @elseif($role->slug === 'operador-emisor')
                                <span class="badge badge-success" style="font-size: 10px; padding: 2px 8px; margin-left: 6px;">SAP / Emisor</span>
                            @elseif($role->slug === 'supervisor')
                                <span class="badge badge-warning" style="font-size: 10px; padding: 2px 8px; margin-left: 6px;">Auditor</span>
                            @endif
                        </span>
                        <span class="role-desc">{{ $role->description ?? 'Sin descripción para este rol.' }}</span>
                    </div>
                </label>
            @endforeach

            <!-- Botones de Guardar/Cancelar -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <a href="{{ route('users.index') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <span>Guardar Cambios</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    // Cambiar dinámicamente el estilo visual de la tarjeta de rol al marcar el checkbox
    function toggleCardState(roleId) {
        const checkbox = document.getElementById('role_' + roleId);
        const cardLabel = document.getElementById('label_role_' + roleId);
        
        if (checkbox.checked) {
            cardLabel.classList.add('selected');
        } else {
            cardLabel.classList.remove('selected');
        }
    }
</script>
@endsection
