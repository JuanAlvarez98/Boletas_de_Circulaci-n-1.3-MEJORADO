<?php $__env->startSection('title', 'Asignar Roles'); ?>

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="welcome-section">
        <h2 class="welcome-title">Asignar Roles: <?php echo e($user->name); ?></h2>
        <p class="welcome-subtitle">Marque los perfiles de acceso correspondientes para las funciones en la plataforma.</p>
    </section>

    <!-- Errores de validación o seguridad -->
    <?php if($errors->any()): ?>
        <div class="alert alert-error" style="max-width: 650px;">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <div class="form-card" style="max-width: 650px; margin-top: 0;">
        <div class="form-header" style="background-color: #f8fafc;">
            <div style="display: flex; flex-direction: column; gap: 4px;">
                <span class="form-title" style="font-size: 15px;">Información del Funcionario</span>
                <span style="font-size: 12.5px; color: var(--text-muted);">
                    Usuario: <strong><?php echo e($user->username ?? 'N/A'); ?></strong> &nbsp;|&nbsp; Correo: <strong><?php echo e($user->email); ?></strong>
                </span>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('users.update', $user->id)); ?>" style="padding: 24px;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <h3 style="font-size: 13.5px; font-weight: 700; text-transform: uppercase; color: #475569; letter-spacing: 0.5px; margin-bottom: 16px;">
                Seleccione los Roles Permitidos
            </h3>

            <!-- Listado de Roles con Checkbox -->
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isChecked = in_array($role->id, $userRoles);
                ?>
                <label for="role_<?php echo e($role->id); ?>" class="role-card <?php if($isChecked): ?> selected <?php endif; ?>" id="label_role_<?php echo e($role->id); ?>">
                    <input type="checkbox" 
                           id="role_<?php echo e($role->id); ?>" 
                           name="roles[]" 
                           value="<?php echo e($role->id); ?>" 
                           class="role-checkbox" 
                           <?php if($isChecked): ?> checked <?php endif; ?>
                           onclick="toggleCardState(<?php echo e($role->id); ?>)">
                    
                    <div class="role-info">
                        <span class="role-title">
                            <?php echo e($role->name); ?> 
                            <?php if($role->slug === 'admin'): ?>
                                <span class="badge badge-primary" style="font-size: 10px; padding: 2px 8px; margin-left: 6px;">admin</span>
                            <?php elseif($role->slug === 'operador-emisor'): ?>
                                <span class="badge badge-success" style="font-size: 10px; padding: 2px 8px; margin-left: 6px;">SAP / Emisor</span>
                            <?php elseif($role->slug === 'supervisor'): ?>
                                <span class="badge badge-warning" style="font-size: 10px; padding: 2px 8px; margin-left: 6px;">Auditor</span>
                            <?php endif; ?>
                        </span>
                        <span class="role-desc"><?php echo e($role->description ?? 'Sin descripción para este rol.'); ?></span>
                    </div>
                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Botones de Guardar/Cancelar -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <a href="<?php echo e(route('users.index')); ?>" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">
                    <span>Guardar Cambios</span>
                </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/users/edit.blade.php ENDPATH**/ ?>