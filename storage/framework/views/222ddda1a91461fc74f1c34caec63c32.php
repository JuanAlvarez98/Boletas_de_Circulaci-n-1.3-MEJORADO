<?php $__env->startSection('title', 'Iniciar Sesión'); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-header">
        <img
            src="<?php echo e(asset('images/logo-sig.png')); ?>"
            alt="Sistema Integrado de Gestión - Policía Honduras"
            class="auth-brand-logo"
        >
        <div class="auth-logo auth-logo-legacy" aria-hidden="true">
            <!-- Icono Automotriz (Vehículo / Tránsito) -->
            <svg viewBox="0 0 24 24">
                <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 10l1.5-4.5h11L19 10H5z"/>
            </svg>
        </div>
        <h1 class="auth-title">Boletas de Circulación</h1>
        <p class="auth-subtitle">Ingrese sus credenciales institucionales para acceder.</p>
    </div>

    <!-- Mensaje de estado (ej: al restablecer contraseña) -->
    <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <!-- Errores generales -->
    <?php if($errors->any()): ?>
        <div class="alert alert-error">
            <?php if($errors->has('login')): ?>
                <?php echo e($errors->first('login')); ?>

            <?php else: ?>
                Por favor, verifique los datos ingresados.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" autocomplete="off">
        <?php echo csrf_field(); ?>

        <!-- Campo Dual: Usuario o Correo -->
        <div class="form-group">
            <label for="login" class="form-label">Usuario o Correo Institucional</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <!-- Icono de Usuario/Mail -->
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </span>
                <input type="text" id="login" name="login" value="<?php echo e(old('login')); ?>"                
                       class="form-control" placeholder="ejemplo@organizacion.gob.hn o usuario" required autofocus>                                         
            </div>
        </div>

        <!-- Campo: Contraseña con Toggle de Mostrar/Ocultar -->
        <div class="form-group">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-wrapper">
                <span class="input-icon">
                    <!-- Icono de Candado -->
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>
                <input type="password" id="password" name="password"
                        class="form-control" placeholder="••••••••" style="padding-right: 42px;" required>
                              
                <!-- Botón Interactivo Mostrar/Ocultar -->
                <button type="button" id="togglePasswordBtn" class="password-toggle" title="Mostrar contraseña">
                    <!-- Icono Ojo Cerrado (Por defecto) -->
                    <svg id="eyeClosedIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                    <!-- Icono Ojo Abierto (Oculto al inicio) -->
                    <svg id="eyeOpenIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        <!-- Opciones del Formulario -->
        <div class="form-options">
            <a href="<?php echo e(route('password.request')); ?>" class="form-link">¿Olvidó su contraseña?</a>
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn-submit">
            <span>Iniciar Sesión</span>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const eyeClosedIcon = document.getElementById('eyeClosedIcon');
        const eyeOpenIcon = document.getElementById('eyeOpenIcon');

        togglePasswordBtn.addEventListener('click', function() {
            // Alternar el tipo de input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Alternar los iconos SVG correspondientes
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/auth/login.blade.php ENDPATH**/ ?>