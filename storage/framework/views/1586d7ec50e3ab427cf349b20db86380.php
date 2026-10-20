

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 0 20px;">

    <div class="form-group">
        <label for="placa" class="form-label">Placa *</label>
        <input type="text" id="placa" name="placa" value="<?php echo e(old('placa', $vehicle->placa ?? '')); ?>" class="form-control" placeholder="Ej. HAB-1234" required autofocus>
        <?php $__errorArgs = ['placa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
       <label for="numero_equipo" class="form-label">  No. de equipo </label>
       <input type="text" id="numero_equipo" name="numero_equipo" value="<?php echo e(old('numero_equipo', $vehicle->numero_equipo ?? '')); ?>" class="form-control"  placeholder="Ej. 10006905">
       <?php $__errorArgs = ['numero_equipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>    
    </div>


    <div class="form-group">
        <label for="chasis" class="form-label">Chasis *</label>
        <input type="text" id="chasis" name="chasis" value="<?php echo e(old('chasis', $vehicle->chasis ?? '')); ?>" class="form-control" required>
        <?php $__errorArgs = ['chasis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="motor" class="form-label">No. Motor</label>
        <input type="text" id="motor" name="motor" value="<?php echo e(old('motor', $vehicle->motor ?? '')); ?>" class="form-control">
        <?php $__errorArgs = ['motor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="marca" class="form-label">Marca *</label>
        <input type="text" id="marca" name="marca" value="<?php echo e(old('marca', $vehicle->marca ?? '')); ?>" class="form-control" required>
        <?php $__errorArgs = ['marca'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="modelo" class="form-label">Modelo *</label>
        <input type="text" id="modelo" name="modelo" value="<?php echo e(old('modelo', $vehicle->modelo ?? '')); ?>" class="form-control" required>
        <?php $__errorArgs = ['modelo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="linea" class="form-label">Línea / Tipo</label>
        <input type="text" id="linea" name="linea" value="<?php echo e(old('linea', $vehicle->linea ?? '')); ?>" class="form-control" placeholder="Sedán, pick-up, motocicleta...">
        <?php $__errorArgs = ['linea'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="anio" class="form-label">Año</label>
        <input type="number" id="anio" name="anio" value="<?php echo e(old('anio', $vehicle->anio ?? '')); ?>" class="form-control" min="1950" max="<?php echo e(date('Y') + 1); ?>">
        <?php $__errorArgs = ['anio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="color" class="form-label">Color</label>
        <input type="text" id="color" name="color" value="<?php echo e(old('color', $vehicle->color ?? '')); ?>" class="form-control">
        <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="naturaleza_origen" class="form-label">Naturaleza / Origen</label>
        <select id="naturaleza_origen" name="naturaleza_origen" class="form-control">
            <option value="">Seleccionar origen...</option>
            <option value="Rentado" <?php if(old('naturaleza_origen', $vehicle->naturaleza_origen ?? '') === 'Rentado'): echo 'selected'; endif; ?>>Rentado</option>
            <option value="Orgánico" <?php if(old('naturaleza_origen', $vehicle->naturaleza_origen ?? '') === 'Orgánico'): echo 'selected'; endif; ?>>Orgánico</option>
        </select>
        <?php $__errorArgs = ['naturaleza_origen'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-group">
        <label for="sap_codigo" class="form-label">Código SAP (si aplica)</label>
        <input type="text" id="sap_codigo" name="sap_codigo" value="<?php echo e(old('sap_codigo', $vehicle->sap_codigo ?? '')); ?>" class="form-control" placeholder="Se completará al integrar con SAP">
        <?php $__errorArgs = ['sap_codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="input-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

</div>
<?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/vehicles/_form.blade.php ENDPATH**/ ?>