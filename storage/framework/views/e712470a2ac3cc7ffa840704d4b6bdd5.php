<?php $__env->startSection('title', 'Emitir Boleta de Circulación'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 8px; color: #334155; }
    .form-control {
        width: 100%; padding: 10px 14px; border: 1.5px solid #cbd5e1; border-radius: 8px;
        font-size: 14px; color: var(--text-main); outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus { border-color: var(--secondary); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15); }
    .input-error { color: var(--danger); font-size: 12px; margin-top: 6px; }
    .vehicle-summary {
        background-color: var(--primary-light); border: 1px solid #dbeafe; border-radius: 10px;
        padding: 16px 20px; margin-bottom: 24px; font-size: 13.5px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="welcome-section">
        <h2 class="welcome-title">Emitir Boleta de Circulación</h2>
        <p class="welcome-subtitle">Seleccione el vehículo y complete los datos de vigencia de la boleta.</p>
    </section>

    <?php if($errors->any()): ?>
        <div class="alert alert-error"><?php echo e($errors->first()); ?></div>
    <?php endif; ?>

    <?php if(!$vehicle): ?>
        <?php ($rutaCreate = 'boletas.create'); ?>
        <?php echo $__env->make('partials._buscador_vehiculo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <div class="form-card" style="margin-top: 0;">
            <div class="form-header"><span class="form-title">Paso 2: Datos de la Boleta</span></div>

            <div style="padding: 24px;">
                <div class="vehicle-summary">
                    <strong><?php echo e($vehicle->placa); ?></strong> — <?php echo e($vehicle->marca); ?> <?php echo e($vehicle->modelo); ?> (<?php echo e($vehicle->anio ?? 's/f'); ?>)<br>
                    Chasis: <?php echo e($vehicle->chasis); ?>

                    <?php if($vehicle->numero_equipo): ?>
                        · No. Equipo: <?php echo e($vehicle->numero_equipo); ?>

                    <?php endif; ?>
                    &nbsp;·&nbsp;<a href="<?php echo e(route('boletas.create')); ?>" style="color: var(--primary);">Cambiar vehículo</a>
                </div>

                <form method="POST" action="<?php echo e(route('boletas.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="vehicle_id" value="<?php echo e($vehicle->id); ?>">

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px;">
                        <div class="form-group">
                            <label for="fecha_emision" class="form-label">Fecha de Emisión *</label>
                            <input type="date" id="fecha_emision" name="fecha_emision" value="<?php echo e(old('fecha_emision', now()->format('Y-m-d'))); ?>" class="form-control" required>
                            <?php $__errorArgs = ['fecha_emision'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label for="fecha_vigencia" class="form-label">Vigente Hasta *</label>
                            <input type="date" id="fecha_vigencia" name="fecha_vigencia" value="<?php echo e(old('fecha_vigencia', now()->addYear()->format('Y-m-d'))); ?>" class="form-control" required>
                            <?php $__errorArgs = ['fecha_vigencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" rows="3" class="form-control" style="resize: vertical;"><?php echo e(old('observaciones')); ?></textarea>
                        <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>" class="btn-secondary">Cancelar</a>
                        <button type="submit" class="btn-primary"><span>Emitir Boleta</span></button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/boletas/create.blade.php ENDPATH**/ ?>