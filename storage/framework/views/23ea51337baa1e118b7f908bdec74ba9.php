<?php $__env->startSection('title', 'Recuperar Contraseña'); ?>

<?php $__env->startSection('content'); ?>
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
    <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <!-- Errores generales -->
    <?php if($errors->any()): ?>
        <div class="alert alert-error">
            <?php echo e($errors->first('email')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo csrf_field(); ?>

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
                       value="<?php echo e(old('email')); ?>" 
                       class="form-control" 
                       placeholder="ejemplo@organizacion.com" 
                       required 
                       autofocus>
            </div>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="input-error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
            <a href="<?php echo e(route('login')); ?>" class="form-link">Volver al inicio de sesión</a>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    (function() {
        function redirigirAReset(url) {
            if (!url) return;
            window.location.replace(url);
        }

        // Comunicación entre pestañas: si se abre el enlace de restablecimiento desde el correo,
        // esta pestaña de "¿Olvidó su contraseña?" se reemplaza automáticamente por la pantalla de Nueva Contraseña.
        if ('BroadcastChannel' in window) {
            const channel = new BroadcastChannel('flota_password_reset');
            channel.onmessage = function(event) {
                if (event.data && event.data.type === 'OPEN_RESET_IN_FORGOT_TAB' && event.data.url) {
                    channel.postMessage({ type: 'ACK_RESET_IN_FORGOT_TAB' });
                    redirigirAReset(event.data.url);
                }
            };
        }

        window.addEventListener('storage', function(event) {
            if (event.key === 'flota_reset_target_url' && event.newValue) {
                try {
                    localStorage.setItem('flota_reset_ack', String(Date.now()));
                } catch (e) {}
                redirigirAReset(event.newValue);
            }
        });
    })();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>