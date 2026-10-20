<?php $__env->startSection('title', 'Nuevo Rol'); ?>

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="welcome-section">
        <h2 class="welcome-title">Crear Nuevo Rol</h2>
        <p class="welcome-subtitle">Registre un perfil de acceso. El slug de validación se generará automáticamente a partir del nombre.</p>
    </section>

    <div class="form-card" style="max-width: 600px; margin-top: 0;">
        <div class="form-header">
            <span class="form-title">Datos del Rol</span>
        </div>

        <form method="POST" action="<?php echo e(route('roles.store')); ?>" style="padding: 24px;">
            <?php echo csrf_field(); ?>

            <!-- Campo: Nombre -->
            <div class="form-group">
                <label for="name" class="form-label">Nombre del Rol</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?php echo e(old('name')); ?>" 
                       class="form-control" 
                       placeholder="Ej. Operador de Impresión" 
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

            <!-- Campo: Descripción -->
            <div class="form-group">
                <label for="description" class="form-label">Descripción de Responsabilidades</label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          class="form-control" 
                          placeholder="Describa brevemente qué tareas y privilegios tendrá este rol en el sistema..." 
                          style="resize: vertical;"><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
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

            <!-- Botones de Acción -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <a href="<?php echo e(route('roles.index')); ?>" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <span>Guardar Rol</span>
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/roles/create.blade.php ENDPATH**/ ?>