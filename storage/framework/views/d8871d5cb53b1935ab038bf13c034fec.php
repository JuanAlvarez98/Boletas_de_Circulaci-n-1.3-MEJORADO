<?php $__env->startSection('title', 'Ficha de Vehículos'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .search-panel {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 20px;
        box-shadow: var(--shadow-sm);
        margin-top: 20px;
    }
    .search-bar {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }
    .search-input-wrap {
        position: relative;
        flex-grow: 1;
        min-width: 260px;
    }
    .search-input-wrap svg {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: var(--text-muted);
        pointer-events: none;
    }
    .search-bar input {
        width: 100%;
        padding: 10px 14px 10px 42px;
        border: 1.5px solid #cbd5e1;
        border-radius: 9px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s ease;
        background-color: #f8fafc;
    }
    .search-bar input:focus {
        border-color: var(--primary-hover);
        background-color: #ffffff;
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15);
    }
    .placa-pill {
        font-family: monospace;
        font-size: 13.5px;
        font-weight: 700;
        background-color: #eff6ff;
        color: #1e3a8a;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #bfdbfe;
        display: inline-block;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Cabecera -->
    <section class="welcome-section">
        <div>
            <h2 class="welcome-title">Ficha de Vehículo</h2>
            <p class="welcome-subtitle">Búsqueda, consulta técnica y emisión de documentos para el parque vehicular.</p>
        </div>
        <?php if(auth()->guard()->check()): ?>
            <?php if(Auth::user()->hasAnyRole(['admin', 'operador-emisor', 'operator'])): ?>
                <a href="<?php echo e(route('vehicles.create')); ?>" class="btn-primary">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Registrar Vehículo</span>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    </section>

    <?php if(session('status')): ?>
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span><?php echo e(session('status')); ?></span>
        </div>
    <?php endif; ?>

    <!-- Barra de Búsqueda -->
    <div class="search-panel">
        <form method="GET" action="<?php echo e(route('vehicles.index')); ?>" class="search-bar">
            <div class="search-input-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="<?php echo e($query); ?>" placeholder="Buscar por no. de equipo, placa (ej. HAB-1234), marca, modelo o chasis...">
            </div>
            <button type="submit" class="btn-primary">Buscar</button>
            <?php if(!empty($query)): ?>
                <a href="<?php echo e(route('vehicles.index')); ?>" class="btn-secondary">Limpiar</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Resultados -->
    <div class="table-card">
        <div class="table-header">
            <span class="table-title">Vehiculos Registrados</span>
            <span style="font-size: 13px; color: var(--text-muted);">
                Total: <?php echo e($vehicles->total()); ?> registros
            </span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">Placa</th>
                        <th style="width: 15%;">No. de Equipo</th>
                        <th style="width: 25%;">Marca / Modelo</th>
                        <th style="width: 10%;">Año</th>
                        <th style="width: 20%;">Chasis / VIN</th>
                        <th style="width: 15%; text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <span class="placa-pill"><?php echo e($vehicle->placa); ?></span>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #475569;"><?php echo e($vehicle->numero_equipo ?? '—'); ?></span>
                            </td>
                            <td>
                                <strong style="color: var(--text-main);"><?php echo e($vehicle->marca); ?></strong> 
                                <span style="color: var(--text-secondary);"><?php echo e($vehicle->modelo); ?></span>
                                <?php if($vehicle->color): ?>
                                    <span style="font-size: 12px; color: var(--text-muted); display: block;">Color: <?php echo e($vehicle->color); ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($vehicle->anio ?? '—'); ?></td>
                            <td style="font-family: monospace; font-size: 13px; color: var(--text-secondary);">
                                <?php echo e($vehicle->chasis); ?>

                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>" class="btn-secondary" style="padding: 6px 14px; font-size: 12.5px;">
                                    Ver Ficha →
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px; color: var(--text-muted);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 36px; height: 36px; color: #94a3b8;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span style="font-weight: 600; color: var(--text-main);">No se encontraron vehículos</span>
                                    <span style="font-size: 13px;">Intente con otro término o número de placa.</span>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top: 24px;">
        <?php echo e($vehicles->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/vehicles/index.blade.php ENDPATH**/ ?>