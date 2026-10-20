@extends('layouts.auth')

@section('title', 'Restablecer Contraseña')

@section('styles')
<style>
    .policy-list {
        margin-top: 12px;
        padding: 12px;
        background-color: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        list-style: none;
        font-size: 12px;
        color: #64748b;
    }

    .policy-title {
        font-weight: 600;
        margin-bottom: 8px;
        color: #334155;
    }

    .policy-item {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
        transition: all 0.25s ease;
    }

    .policy-item:last-child {
        margin-bottom: 0;
    }

    .policy-item.valid {
        color: #0d9488; /* Esmeralda */
        font-weight: 500;
    }

    .policy-item svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }

    .policy-icon-valid {
        display: none;
        color: #0d9488;
    }

    .policy-icon-invalid {
        display: inline-block;
        color: #94a3b8;
    }

    .policy-item.valid .policy-icon-valid {
        display: inline-block;
    }

    .policy-item.valid .policy-icon-invalid {
        display: none;
    }
</style>
@endsection

@section('content')
    <div class="auth-header">
        <div class="auth-logo">
            <!-- Icono de Seguridad Avanzada -->
            <svg viewBox="0 0 24 24">
                <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
            </svg>
        </div>
        <h1 class="auth-title">Nueva Contraseña</h1>
        <p class="auth-subtitle">Establezca una contraseña segura que cumpla con los requisitos organizacionales.</p>
    </div>

    <!-- Errores generales -->
    @if ($errors->any())
        <div class="alert alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Token oculto necesario para restablecer contraseña -->
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Campo: Correo Electrónico (Solo Lectura o editable pero obligatorio) -->
        <div class="form-group">
            <label for="email" class="form-label">Correo Electrónico</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ $email ?? old('email') }}" 
                       class="form-control" 
                       required 
                       readonly>
            </div>
            @error('email')
                <div class="input-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo: Nueva Contraseña -->
        <div class="form-group">
            <label for="password" class="form-label">Nueva Contraseña</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control" 
                       placeholder="••••••••" 
                       style="padding-right: 42px;" 
                       required 
                       autofocus>
                
                <button type="button" id="togglePasswordBtn" class="password-toggle" title="Mostrar contraseña">
                    <svg id="eyeClosedIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                    <svg id="eyeOpenIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <!-- Listado Dinámico de Políticas de Contraseñas (Verificación Visual en Tiempo Real) -->
            <ul class="policy-list">
                <li class="policy-title">La contraseña debe contener:</li>
                <li id="rule-length" class="policy-item">
                    <!-- Icono Cruz -->
                    <svg class="policy-icon-invalid" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    <!-- Icono Check -->
                    <svg class="policy-icon-valid" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    <span>Mínimo 8 caracteres</span>
                </li>
                <li id="rule-case" class="policy-item">
                    <svg class="policy-icon-invalid" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    <svg class="policy-icon-valid" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    <span>Mayúsculas y minúsculas</span>
                </li>
                <li id="rule-number" class="policy-item">
                    <svg class="policy-icon-invalid" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    <svg class="policy-icon-valid" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    <span>Al menos un número</span>
                </li>
                <li id="rule-special" class="policy-item">
                    <svg class="policy-icon-invalid" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    <svg class="policy-icon-valid" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    <span>Un carácter especial (ej. @, $, !, %, *, ?, &)</span>
                </li>
            </ul>
        </div>

        <!-- Campo: Confirmar Contraseña -->
        <div class="form-group" style="margin-top: 20px;">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </span>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       class="form-control" 
                       placeholder="••••••••" 
                       required>
            </div>
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn-submit" id="btnSubmit">
            <span>Restablecer Contraseña</span>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        
        // Elementos de validación visual
        const ruleLength = document.getElementById('rule-length');
        const ruleCase = document.getElementById('rule-case');
        const ruleNumber = document.getElementById('rule-number');
        const ruleSpecial = document.getElementById('rule-special');

        // Escuchar el tipeo del usuario para verificar las políticas en tiempo real
        password.addEventListener('input', function() {
            const val = password.value;

            // 1. Longitud
            const hasLength = val.length >= 8;
            toggleRuleState(ruleLength, hasLength);

            // 2. Mayúsculas y minúsculas
            const hasCase = /[A-Z]/.test(val) && /[a-z]/.test(val);
            toggleRuleState(ruleCase, hasCase);

            // 3. Números
            const hasNumber = /[0-9]/.test(val);
            toggleRuleState(ruleNumber, hasNumber);

            // 4. Carácter Especial
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(val);
            toggleRuleState(ruleSpecial, hasSpecial);
        });

        function toggleRuleState(element, isValid) {
            if (isValid) {
                element.classList.add('valid');
            } else {
                element.classList.remove('valid');
            }
        }

        // Toggle Mostrar/Ocultar Contraseña
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const eyeClosedIcon = document.getElementById('eyeClosedIcon');
        const eyeOpenIcon = document.getElementById('eyeOpenIcon');

        togglePasswordBtn.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            if (type === 'text') {
                eyeClosedIcon.style.display = 'none';
                eyeOpenIcon.style.display = 'block';
                togglePasswordBtn.setAttribute('title', 'Ocultar contraseña');
            } else {
                eyeClosedIcon.style.display = 'block';
                eyeOpenIcon.style.display = 'none';
                togglePasswordBtn.setAttribute('title', 'Mostrar contraseña');
            }
        });
    });
</script>
@endsection
