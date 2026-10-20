<?php $__env->startSection('title', 'Verificación 2FA'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .digit-group {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        margin: 24px 0;
    }

    .digit-input {
        width: 48px;
        height: 56px;
        background-color: #ffffff;
        border: 2px solid #cbd5e1;
        border-radius: 8px;
        font-size: 24px;
        font-weight: 700;
        text-align: center;
        color: var(--primary);
        outline: none;
        transition: all 0.2s ease;
    }

    .digit-input:focus {
        border-color: var(--secondary);
        box-shadow: var(--focus-ring);
        transform: scale(1.05);
    }

    .digit-input:disabled {
        background-color: #f1f5f9;
        cursor: not-allowed;
    }

    .resend-box {
        text-align: center;
        margin-top: 24px;
        font-size: 13px;
        color: var(--text-muted);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-header">
        <div class="auth-logo">
            <!-- Icono de Seguridad (Escudo con llave / doble factor) -->
            <svg viewBox="0 0 24 24">
                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 6c1.4 0 2.5 1.1 2.5 2.5S13.4 12 12 12s-2.5-1.1-2.5-2.5S10.6 7 12 7zm0 12c-2.7 0-5.8-1.37-5.8-4 0-1.38 1.12-2.5 2.5-2.5h6.6c1.38 0 2.5 1.12 2.5 2.5 0 2.63-3.1 4-5.8 4z"/>
            </svg>
        </div>
        <h1 class="auth-title">Verificación de Identidad</h1>
        <p class="auth-subtitle">
            <?php if($isAppBased): ?>
                Ingrese el código de 6 dígitos provisto por su aplicación autenticadora (Google Authenticator / Authy).
            <?php else: ?>
                Hemos enviado un código OTP a su correo electrónico institucional para validar su acceso.
            <?php endif; ?>
        </p>
    </div>

    <!-- Alerta de Estado (ej: reenvío de código exitoso) -->
    <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <!-- Errores generales -->
    <?php if($errors->any()): ?>
        <div class="alert alert-error">
            <?php echo e($errors->first('code')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('auth.two-factor.verify')); ?>" id="twoFactorForm">
        <?php echo csrf_field(); ?>

        <!-- Input Oculto Real para Laravel -->
        <input type="hidden" name="code" id="realCodeInput">

        <!-- Cuadrícula Visual de 6 Dígitos -->
        <div class="digit-group">
            <input type="text" id="digit1" class="digit-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required autofocus>
            <input type="text" id="digit2" class="digit-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
            <input type="text" id="digit3" class="digit-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
            <input type="text" id="digit4" class="digit-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
            <input type="text" id="digit5" class="digit-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
            <input type="text" id="digit6" class="digit-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
        </div>

        <button type="submit" class="btn-submit" id="btnSubmit">
            <span>Verificar Acceso</span>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </button>
    </form>

    <!-- Sección de Reenvío (Solo para 2FA por Correo) -->
    <?php if(!$isAppBased): ?>
        <div class="resend-box">
            ¿No recibió el código o expiró?
            <form method="POST" action="<?php echo e(route('auth.two-factor.resend')); ?>" style="display: inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="form-link" style="background: none; border: none; font-size: inherit; cursor: pointer; padding: 0;">
                    Reenviar código
                </button>
            </form>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = Array.from(document.querySelectorAll('.digit-input'));
        const realInput = document.getElementById('realCodeInput');
        const form = document.getElementById('twoFactorForm');

        // Manejar eventos en las cajas de texto individuales
        inputs.forEach((input, index) => {
            // Ir al siguiente input al escribir un número
            input.addEventListener('input', function(e) {
                const value = e.target.value;
                if (value.length > 0) {
                    // Reemplazar por solo números
                    e.target.value = value.replace(/[^0-9]/g, '');
                    
                    if (index < inputs.length - 1 && e.target.value !== '') {
                        inputs[index + 1].focus();
                        inputs[index + 1].select();
                    }
                }
                updateRealInput();
            });

            // Retroceder al borrar con Backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace') {
                    if (input.value === '') {
                        if (index > 0) {
                            inputs[index - 1].focus();
                            inputs[index - 1].value = '';
                        }
                    } else {
                        input.value = '';
                    }
                    updateRealInput();
                    e.preventDefault();
                }
            });

            // Soporte para pegar el código completo (Copy-Paste)
            input.addEventListener('paste', function(e) {
                const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                const cleanData = pasteData.replace(/[^0-9]/g, '').substring(0, 6);

                if (cleanData.length > 0) {
                    for (let i = 0; i < cleanData.length; i++) {
                        if (inputs[i]) {
                            inputs[i].value = cleanData[i];
                        }
                    }
                    // Dar foco al último input llenado
                    const focusIndex = Math.min(cleanData.length, inputs.length - 1);
                    inputs[focusIndex].focus();
                    updateRealInput();
                }
                e.preventDefault();
            });
        });

        // Concatenar el valor de todos los inputs en el input oculto real
        function updateRealInput() {
            const code = inputs.map(input => input.value).join('');
            realInput.value = code;
        }

        // Antes de enviar, asegurar que el input oculto está al día
        form.addEventListener('submit', function(e) {
            updateRealInput();
            if (realInput.value.length < 6) {
                e.preventDefault();
                alert('Por favor complete el código de 6 dígitos.');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/auth/two-factor.blade.php ENDPATH**/ ?>