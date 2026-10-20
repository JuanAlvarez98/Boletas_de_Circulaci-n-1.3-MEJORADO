@extends('layouts.dashboard')

@section('title', 'Gestionar Roles')

@section('content')
    <!-- Cabecera -->
    <section class="welcome-section">
        <div>
            <h2 class="welcome-title">Administración de Roles y Permisos</h2>
            <p class="welcome-subtitle">Configuración de perfiles de autorización institucional para operadores, supervisores y administradores.</p>
        </div>
        <a href="{{ route('roles.create') }}" class="btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Nuevo Rol</span>
        </a>
    </section>

    <!-- Alertas de éxito o error -->
    @if (session('status'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Perfiles Definidos en la Plataforma</span>
            <span style="font-size: 13px; color: var(--text-muted);">Total: {{ count($roles) }} roles</span>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 20%;">Nombre del Rol</th>
                        <th style="width: 15%;">Identificador (Slug)</th>
                        <th style="width: 38%;">Descripción de Responsabilidades</th>
                        <th style="width: 12%; text-align: center;">Usuarios</th>
                        <th style="width: 15%; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>
                                <strong style="color: var(--text-main); font-size: 14px;">{{ $role->name }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-primary" style="font-family: monospace;">{{ $role->slug }}</span>
                            </td>
                            <td>
                                <span style="color: var(--text-secondary); font-size: 13.5px;">{{ $role->description ?? 'Sin descripción disponible.' }}</span>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge" style="background-color: #f1f5f9; color: var(--text-main); font-size: 13px; font-weight: 700; border: 1px solid #cbd5e1; padding: 4px 10px;">
                                    {{ $role->users_count }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 8px; align-items: center;">
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                        Editar
                                    </a>
                                    
                                    @if($role->slug !== 'admin')
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este rol? Se desvinculará de todos los usuarios.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-logout" style="padding: 6px 12px; font-size: 12px; border-radius: 8px;">
                                                Eliminar
                                            </button>
                                        </form>
                                    @else
                                        <span style="font-size: 11px; color: var(--text-muted); font-style: italic; padding: 6px 8px;">
                                            Sistema
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 48px; color: var(--text-muted);">
                                No hay roles registrados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
