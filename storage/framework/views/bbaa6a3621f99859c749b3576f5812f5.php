
<div class="form-card" style="margin-top: 0;">
    <div class="form-header"><span class="form-title">Paso 1: Seleccione el Vehículo</span></div>

    <div style="padding: 24px;">
        <form method="GET" action="<?php echo e(route($rutaCreate)); ?>" style="display: flex; gap: 12px;">
            <input type="text" name="q" value="<?php echo e($query ?? ''); ?>" class="form-control" placeholder="Buscar por placa o chasis..." autofocus>
            <button type="submit" class="btn-primary">Buscar</button>
        </form>

        <?php if(($query ?? '') !== ''): ?>
            <div style="margin-top: 20px;">
                <?php $__empty_1 = true; $__currentLoopData = $resultados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div style="display:flex; align-items:center; justify-content:space-between; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 10px;">
                        <div>
                            <strong><?php echo e($v->placa); ?></strong> — <?php echo e($v->marca); ?> <?php echo e($v->modelo); ?>

                            <div style="font-size: 12px; color: var(--text-muted);">
                                Chasis: <?php echo e($v->chasis); ?>

                                <?php if($v->numero_equipo): ?>
                                    · No. Equipo: <?php echo e($v->numero_equipo); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                        <a href="<?php echo e(route($rutaCreate, ['vehicle_id' => $v->id])); ?>" class="btn-secondary" style="padding: 6px 12px; font-size: 12px;">Seleccionar</a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="color: var(--text-muted); font-size: 13.5px; margin-top: 12px;">No se encontraron vehículos con ese criterio.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/partials/_buscador_vehiculo.blade.php ENDPATH**/ ?>