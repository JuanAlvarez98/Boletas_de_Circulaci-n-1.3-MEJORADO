<?php $__env->startSection('title', 'Ficha de Vehículo · ' . $vehicle->placa); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .ficha-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        padding: 26px;
    }
    .ficha-item {
        background-color: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 14px 18px;
    }
    .ficha-item .label {
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 5px;
    }
    .ficha-item .value {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main);
    }
    .action-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }
    .placa-banner {
        font-family: monospace;
        font-size: 16px;
        font-weight: 800;
        background-color: #eff6ff;
        color: #1e3a8a;
        padding: 4px 12px;
        border-radius: 8px;
        border: 1.5px solid #bfdbfe;
        display: inline-block;
    }
    @media (max-width: 640px) {
        .ficha-grid {
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
            padding: 16px 14px;
        }
        .ficha-item {
            padding: 12px 14px;
        }
    }
    @media (max-width: 380px) {
        .ficha-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="welcome-section">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap: wrap; gap: 16px; width: 100%;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <span class="placa-banner"><?php echo e($vehicle->placa ?: 'Equipo ' . $vehicle->numero_equipo); ?></span>
                    <h2 class="welcome-title" style="margin-bottom: 0;"><?php echo e($vehicle->marca ?? ''); ?> <?php echo e($vehicle->modelo ?? 'Vehículo'); ?></h2>
                </div>
                <p class="welcome-subtitle">
                    Información técnica oficial obtenida mediante el Web Service de SAP<?php echo e($vehicle->numero_equipo ? ' (Equipo: ' . $vehicle->numero_equipo . ')' : ''); ?>.
                    <?php if($vehicle->dependencia): ?>
                        · <?php echo e($vehicle->dependencia); ?>

                    <?php endif; ?>
                </p>
            </div>
            <a href="<?php echo e(route('vehicles.index')); ?>" class="btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Volver a la consulta de vehículos</span>
            </a>
        </div>
    </section>

    <?php if(session('status')): ?>
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span><?php echo e(session('status')); ?></span>
        </div>
    <?php endif; ?>

    <?php if(isset($errors) && $errors->any()): ?>
        <div class="alert alert-danger" style="background: #fef2f2; border: 1.5px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span><?php echo e($errors->first()); ?></span>
        </div>
    <?php endif; ?>

    <!-- Ficha de Datos -->
    <div class="table-card">
        <div class="table-header">
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <span class="table-title">Especificaciones Técnicas del Vehículo</span>
                <span class="badge" style="background-color: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11.5px; font-weight: 700; padding: 3px 8px; border-radius: 4px;">
                    Datos Oficiales SAP PM
                </span>
                <?php if($vehicle->estado_sap): ?>
                    <span class="badge" style="background-color: #f1f5f9; color: #334155; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 4px;">
                        <?php echo e($vehicle->estado_sap); ?>

                    </span>
                <?php endif; ?>
            </div>
            <?php if($vehicle->numero_equipo || $vehicle->sap_codigo): ?>
                <form method="POST" action="<?php echo e(route('vehicles.actualizar-sap', $vehicle)); ?>" style="margin: 0;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-secondary" style="padding: 6px 14px; font-size: 12.5px; display: inline-flex; align-items: center; gap: 6px;" title="Actualizar datos oficiales desde el servicio de SAP PM">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                        <span>Actualizar desde SAP</span>
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="ficha-grid">
            <div class="ficha-item"><div class="label">No. de Equipo</div><div class="value"><?php echo e($vehicle->numero_equipo ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Marca</div><div class="value"><?php echo e($vehicle->marca ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Modelo</div><div class="value"><?php echo e($vehicle->modelo ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Tipo / Línea</div><div class="value"><?php echo e($vehicle->linea ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Tipo de Equipo</div><div class="value"><?php echo e($vehicle->tipo_equipo ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Año</div><div class="value"><?php echo e($vehicle->anio ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Naturaleza / Origen</div><div class="value"><?php echo e($vehicle->naturaleza_origen ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Dependencia Policial</div><div class="value"><?php echo e($vehicle->dependencia ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Placa / Registro</div><div class="value" style="color: var(--primary);"><?php echo e($vehicle->placa ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Chasis / VIN</div><div class="value" style="font-family: monospace; font-size: 13.5px;"><?php echo e($vehicle->chasis ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">No. de Motor</div><div class="value" style="font-family: monospace; font-size: 13.5px;"><?php echo e($vehicle->motor ?? '—'); ?></div></div>
            <div class="ficha-item"><div class="label">Denominación SAP</div><div class="value"><?php echo e($vehicle->denominacion ?? '—'); ?></div></div>
        </div>
    </div>

    <!-- Acciones Operativas -->
    <?php if(auth()->guard()->check()): ?>
        <?php if(Auth::user()->hasAnyRole(['admin', 'operador-emisor'])): ?>
            <div class="action-row">
                <a href="<?php echo e(route('boletas.create', ['vehicle_id' => $vehicle->id])); ?>" class="btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Emitir Boleta de Circulación</span>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Historial de Boletas -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Historial de Boletas de Circulación Emitidas</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha Emisión</th>
                        <th>Fecha Vigencia</th>
                        <th>Estado</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vehicle->boletas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $boleta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong style="color: var(--primary);"><?php echo e($boleta->folio); ?></strong></td>
                            <td><?php echo e($boleta->fecha_emision->format('d/m/Y')); ?></td>
                            <td><?php echo e($boleta->fecha_vigencia->format('d/m/Y')); ?></td>
                            <td>
                                <?php if($boleta->estado === 'vigente'): ?>
                                    <span class="badge badge-success">Vigente</span>
                                <?php elseif($boleta->estado === 'vencida'): ?>
                                    <span class="badge badge-danger">Vencida</span>
                                <?php else: ?>
                                    <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">Anulada</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo e(route('boletas.show', $boleta)); ?>" class="btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                    Ver Boleta →
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" style="text-align: center; padding: 32px; color: var(--text-muted);">Aún no se han emitido boletas para este vehículo.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Historial de Actas de Entrega -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Historial de Actas de Entrega</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 18%;">Folio</th>
                        <th style="width: 40%;">Recibe (Titular / Conductor)</th>
                        <th style="width: 22%;">Fecha de Entrega</th>
                        <th style="width: 20%; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vehicle->actasEntrega; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong style="color: #7c3aed;"><?php echo e($acta->folio); ?></strong></td>
                            <td>
                                <span style="font-weight: 600; color: var(--text-main);"><?php echo e($acta->recibe_nombre); ?></span>
                                <?php if($acta->recibe_email): ?>
                                    <div style="font-size: 11.5px; color: #0284c7; display: flex; align-items: center; gap: 4px; margin-top: 2px;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span><?php echo e($acta->recibe_email); ?></span>
                                        <?php if($acta->enviado_email_at): ?>
                                            <span style="color: #059669; font-size: 10px; font-weight: 700; background: #ecfdf5; padding: 1px 4px; border-radius: 3px;">✓ Notificado</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($acta->fecha_entrega->format('d/m/Y')); ?></td>
                            <td style="text-align: right;">
                                <a href="<?php echo e(route('actas.show', $acta)); ?>" class="btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                    Ver Acta →
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="4" style="text-align: center; padding: 32px; color: var(--text-muted);">Aún no se han registrado actas de entrega para este vehículo.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/vehicles/show.blade.php ENDPATH**/ ?>