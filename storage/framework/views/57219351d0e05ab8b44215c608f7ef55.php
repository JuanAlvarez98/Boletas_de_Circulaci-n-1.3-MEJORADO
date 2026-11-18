<?php $__env->startSection('title', 'Nuevo usuario'); ?>

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="welcome-section">
    <h2 class="welcome-title">Agregar nuevo usuario</h2>
    <p class="welcome-subtitle">Registre las credenciales y el nivel de acceso del usuario.</p>
</section>

<?php if($errors->any()): ?>
    <div class="alert alert-error" style="max-width: 760px;">
        Revise los campos marcados antes de continuar.
    </div>
<?php endif; ?>

<div class="form-card" style="max-width: 760px; margin-top: 0;">
    <div class="form-header">
        <span class="form-title">Datos de la cuenta</span>
    </div>

    <form method="POST" action="<?php echo e(route('users.store')); ?>" style="padding: 24px;">
        <?php echo csrf_field(); ?>

        <div class="user-form-grid">
            <div class="form-group full-width">
                <label for="name" class="form-label">Nombre completo</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="<?php echo e(old('name')); ?>"
                    class="form-control"
                    maxlength="255"
                    autocomplete="name"
                    required
                    autofocus>
                <?php $__errorArgs = ['name'];
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

            <div class="form-group full-width">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?php echo e(old('username')); ?>"
                    class="form-control"
                    maxlength="255"
                    autocomplete="username"
                    required>
                <?php $__errorArgs = ['username'];
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

            <div class="form-group full-width">
                <label for="email" class="form-label">Correo</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?php echo e(old('email')); ?>"
                    class="form-control"
                    maxlength="255"
                    autocomplete="email"
                    required>
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
                <?php $__errorArgs = ['password'];
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
                <select id="role" name="role" class="form-control" required onchange="actualizarNotaRol(this.value)">
                    <option value="">Seleccione un rol</option>
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($role->slug); ?>" <?php if(old('role') === $role->slug): echo 'selected'; endif; ?>>
                            <?php if($role->slug === 'admin'): ?>
                                Administrador
                            <?php elseif($role->slug === 'operador-emisor' || $role->slug === 'operator'): ?>
                                Operador
                            <?php elseif($role->slug === 'supervisor'): ?>
                                Supervisor
                            <?php else: ?>
                                <?php echo e($role->name); ?>

                            <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div id="role-permission-hint" style="display: none; margin-top: 8px; padding: 10px 14px; border-radius: 8px; background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; font-size: 12.5px; font-weight: 600;"></div>
                <?php $__errorArgs = ['role'];
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
        </div>

        <div style="display:flex;gap:12px;justify-content:flex-end;margin-top:30px;border-top:1px solid var(--border-color);padding-top:20px;">
            <a href="<?php echo e(route('users.index')); ?>" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Guardar usuario</button>
        </div>
    </form>
</div>

<script>
function actualizarNotaRol(slug) {
    const hint = document.getElementById('role-permission-hint');
    if (!hint) return;
    if (slug === 'operador-emisor' || slug === 'operator') {
        hint.textContent = 'Permisos del rol Operador: Acceso a Dashboard y en el menú lateral únicamente al módulo Ficha de Vehículo para ejecutar consultas en el Web Service SAP.';
        hint.style.display = 'block';
    } else if (slug === 'supervisor') {
        hint.textContent = 'Permisos del rol Supervisor: Visualización y auditoría de Panel de Control, Ficha de Vehículo, Boletas y Actas (solo lectura).';
        hint.style.display = 'block';
    } else if (slug === 'admin') {
        hint.textContent = 'Permisos del rol Administrador: Acceso total a todos los módulos operativos, emisión de documentos y gestión de usuarios/roles.';
        hint.style.display = 'block';
    } else {
        hint.style.display = 'none';
    }
}
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('role');
    if (select && select.value) {
        actualizarNotaRol(select.value);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/users/create.blade.php ENDPATH**/ ?>