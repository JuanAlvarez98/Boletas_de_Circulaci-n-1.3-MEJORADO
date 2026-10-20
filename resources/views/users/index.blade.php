@extends('layouts.dashboard')

@section('title', 'Gestión de Usuarios')

@section('content')
    <!-- Cabecera -->
    <section class="welcome-section">
        <div>
            <h2 class="welcome-title">Usuarios y Roles Institucionales</h2>
            <p class="welcome-subtitle">Administre el acceso, perfiles de autorización y roles asignados a los operadores del sistema.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Nuevo Usuario</span>
        </a>
    </section>

    <!-- Alertas de estado -->
    @if (session('status'))
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Directorio de Funcionarios</span>
            <span style="font-size: 13px; color: var(--text-muted);">Total: {{ count($users) }} usuarios</span>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 25%;">Funcionario</th>
                        <th style="width: 20%;">Nombre de Usuario</th>
                        <th style="width: 25%;">Correo Institucional</th>
                        <th style="width: 20%;">Roles Activos</th>
                        <th style="width: 10%; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px; flex-shrink: 0;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong style="color: var(--text-main); font-size: 14px;">{{ $user->name }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-family: monospace; font-size: 13px; background: #f1f5f9; padding: 3px 8px; border-radius: 5px; border: 1px solid #cbd5e1; color: var(--text-main);">
                                    {{ $user->username ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span style="color: var(--text-secondary);">{{ $user->email }}</span>
                            </td>
                            <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                    @forelse($user->roles as $role)
                                        @if($role->slug === 'admin')
                                            <span class="badge badge-primary">Admin</span>
                                        @elseif($role->slug === 'operador-emisor')
                                            <span class="badge badge-success">Operador Emisor</span>
                                        @elseif($role->slug === 'supervisor')
                                            <span class="badge badge-warning">Supervisor</span>
                                        @else
                                            <span class="badge" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">{{ $role->name }}</span>
                                        @endif
                                    @empty
                                        <span class="badge badge-danger" style="font-style: italic;">Sin Rol Asignado</span>
                                    @endforelse
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn-secondary" style="padding: 6px 14px; font-size: 12.5px;">
                                    Gestionar →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 48px; color: var(--text-muted);">
                                No hay usuarios registrados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
