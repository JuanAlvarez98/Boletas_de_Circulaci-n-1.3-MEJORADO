@extends('layouts.auth')

@section('title', 'Recuperar Contraseña')

@section('content')
    <div class="auth-header">
        <div class="auth-logo">
            <!-- Icono de Llave / Recuperación -->
            <svg viewBox="0 0 24 24">
                <path d="M12.65 10C11.83 7.67 9.61 6 7 6c-3.31 0-6 2.69-6 6s2.69 6 6 6c2.61 0 4.83-1.67 5.65-4H17v4h4v-4h2v-4H12.65zM7 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
            </svg>
        </div>
        <h1 class="auth-title">¿Olvidó su contraseña?</h1>
        <p class="auth-subtitle">Ingrese su correo electrónico institucional registrado y le enviaremos un enlace de recuperación seguro.</p>
    </div>

    <!-- Mensaje de estado (enlace enviado con éxito) -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <!-- Errores generales -->
    @if ($errors->any())
        <div class="alert alert-error">
            {{ $errors->first('email') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Campo: Correo Electrónico -->
        <div class="form-group">
            <label for="email" class="form-label">Correo Electrónico Institucional</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       class="form-control" 
                       placeholder="ejemplo@organizacion.com" 
                       required 
                       autofocus>
            </div>
            @error('email')
                <div class="input-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn-submit">
            <span>Enviar Enlace Seguro</span>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l7-7m0 0l-7-7m7 7H5" />
            </svg>
        </button>

        <!-- Retorno al login -->
        <div style="text-align: center; margin-top: 24px; font-size: 13px;">
            <a href="{{ route('login') }}" class="form-link">Volver al inicio de sesión</a>
        </div>
    </form>
@endsection
