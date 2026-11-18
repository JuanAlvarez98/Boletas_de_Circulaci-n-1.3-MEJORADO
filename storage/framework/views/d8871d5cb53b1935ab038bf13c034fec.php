<?php $__env->startSection('title', 'Ficha de Vehículos · Consulta Oficial SAP PM'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .sap-search-card {
        background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
        border: 1.5px solid #bfdbfe;
        border-radius: 16px;
        padding: 26px 28px;
        box-shadow: 0 4px 18px rgba(30, 58, 138, 0.06);
        margin-top: 20px;
    }
    .sap-search-input-wrap {
        position: relative;
        flex: 1;
        min-width: 280px;
    }
    .sap-search-input-wrap svg {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        color: #64748b;
        pointer-events: none;
    }
    .sap-search-input {
        width: 100%;
        padding: 13px 16px 13px 48px;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        outline: none;
        background: #ffffff;
        color: #0f172a;
        transition: all 0.2s ease;
    }
    .sap-search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
    }
    .ficha-card-sap {
        background: #ffffff;
        border: 2px solid #3b82f6;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.15);
        margin-top: 24px;
        overflow: hidden;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
    }
    .ficha-sap-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        color: #ffffff;
        padding: 20px 26px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        transition: background 0.25s ease, color 0.25s ease;
    }
    .ficha-sap-equipo-badge {
        background: #ffffff;
        color: #1e3a8a;
        font-family: monospace;
        font-size: 12.5px;
        font-weight: 800;
        padding: 3px 10px;
        border-radius: 6px;
        letter-spacing: 0.5px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .ficha-sap-estado-badge {
        background: #ffffff;
        color: #1e3a8a;
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .ficha-sap-titulo {
        font-size: 20px;
        font-weight: 800;
        margin: 4px 0;
        color: #ffffff;
    }
    .ficha-sap-subtitulo {
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
    }
    .btn-emitir-ficha {
        background: #10b981;
        border: 1.5px solid #059669;
        color: #ffffff;
        padding: 10px 18px;
        font-size: 13.5px;
        font-weight: 700;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
    }
    .btn-emitir-ficha:hover {
        filter: brightness(0.95);
    }

    /* Variantes de color de la Card según estado SAP */
    /* Rojo: Mal Estado */
    .ficha-card-sap.estado-rojo {
        background: #fef2f2;
        border-color: #ef4444;
        box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.22);
    }
    .ficha-card-sap.estado-rojo .ficha-sap-header {
        background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%);
    }
    .ficha-card-sap.estado-rojo .ficha-sap-equipo-badge {
        background: #ffffff;
        color: #b91c1c;
    }
    .ficha-card-sap.estado-rojo .ficha-sap-estado-badge {
        color: #b91c1c;
    }
    .ficha-card-sap.estado-rojo .ficha-item {
        background-color: #ffffff;
        border-color: #fecaca;
    }
    .ficha-card-sap.estado-rojo .ficha-item:hover {
        border-color: #fca5a5;
    }

    /* Verde: Buen Estado / Disponible */
    .ficha-card-sap.estado-verde {
        background: #f0fdf4;
        border-color: #16a34a;
        box-shadow: 0 10px 25px -5px rgba(22, 163, 74, 0.22);
    }
    .ficha-card-sap.estado-verde .ficha-sap-header {
        background: linear-gradient(135deg, #166534 0%, #16a34a 100%);
    }
    .ficha-card-sap.estado-verde .ficha-sap-equipo-badge {
        background: #ffffff;
        color: #15803d;
    }
    .ficha-card-sap.estado-verde .ficha-sap-estado-badge {
        color: #15803d;
    }
    .ficha-card-sap.estado-verde .btn-emitir-ficha {
        background: #ffffff;
        color: #166534;
        border-color: #ffffff;
    }
    .ficha-card-sap.estado-verde .ficha-item {
        background-color: #ffffff;
        border-color: #bbf7d0;
    }
    .ficha-card-sap.estado-verde .ficha-item:hover {
        border-color: #86efac;
    }

    /* Amarillo: Tiempo de Test */
    .ficha-card-sap.estado-amarillo {
        background: #fefce8;
        border-color: #eab308;
        box-shadow: 0 10px 25px -5px rgba(234, 179, 8, 0.25);
    }
    .ficha-card-sap.estado-amarillo .ficha-sap-header {
        background: linear-gradient(135deg, #eab308 0%, #facc15 100%);
        color: #422006;
    }
    .ficha-card-sap.estado-amarillo .ficha-sap-equipo-badge {
        background: #ffffff;
        color: #a16207;
    }
    .ficha-card-sap.estado-amarillo .ficha-sap-estado-badge {
        background: #ffffff;
        color: #a16207;
    }
    .ficha-card-sap.estado-amarillo .ficha-sap-titulo {
        color: #422006;
    }
    .ficha-card-sap.estado-amarillo .ficha-sap-subtitulo {
        color: #713f12;
    }
    .ficha-card-sap.estado-amarillo .ficha-item {
        background-color: #ffffff;
        border-color: #fde047;
    }
    .ficha-card-sap.estado-amarillo .ficha-item:hover {
        border-color: #facc15;
    }
    .ficha-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 16px;
        padding: 24px 26px;
    }
    .ficha-item {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
        transition: transform 0.15s ease, border-color 0.15s ease;
    }
    .ficha-item:hover {
        border-color: #cbd5e1;
        background-color: #ffffff;
    }
    .ficha-item .label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .ficha-item .value {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        word-break: break-word;
    }
    .ficha-item .value.empty {
        color: #94a3b8;
        font-weight: 500;
        font-style: italic;
    }
    .equipo-badge {
        font-family: monospace;
        font-size: 14px;
        font-weight: 800;
        background-color: #eff6ff;
        color: #1e3a8a;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #bfdbfe;
        display: inline-block;
    }

    /* Pestañas de la Ficha */
    .ficha-tabs-nav {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px 0 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        overflow-x: auto;
    }
    .ficha-tab-btn {
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 11px 18px;
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        border-radius: 8px 8px 0 0;
        white-space: nowrap;
    }
    .ficha-tab-btn:hover {
        color: #1e293b;
        background: rgba(255, 255, 255, 0.7);
    }
    .ficha-tab-btn.active {
        color: #1e40af;
        border-bottom-color: #2563eb;
        background: #ffffff;
        font-weight: 700;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.02);
    }
    .ficha-card-sap.estado-rojo .ficha-tabs-nav {
        background: #fef2f2;
        border-bottom-color: #fecaca;
    }
    .ficha-card-sap.estado-rojo .ficha-tab-btn.active {
        color: #991b1b;
        border-bottom-color: #dc2626;
        background: #ffffff;
    }
    .ficha-card-sap.estado-verde .ficha-tabs-nav {
        background: #f0fdf4;
        border-bottom-color: #bbf7d0;
    }
    .ficha-card-sap.estado-verde .ficha-tab-btn.active {
        color: #15803d;
        border-bottom-color: #16a34a;
        background: #ffffff;
    }
    .ficha-card-sap.estado-amarillo .ficha-tabs-nav {
        background: #fefce8;
        border-bottom-color: #fde047;
    }
    .ficha-card-sap.estado-amarillo .ficha-tab-btn.active {
        color: #854d0e;
        border-bottom-color: #ca8a04;
        background: #ffffff;
    }

    .ficha-tab-panel {
        display: none;
    }
    .ficha-tab-panel.active {
        display: block;
    }

    /* Estilos para campos condicionales / deshabilitados */
    .ficha-item.item-disabled {
        opacity: 0.65;
        background-color: #f1f5f9 !important;
        border: 1.5px dashed #cbd5e1;
        cursor: not-allowed;
    }
    .ficha-item.item-enabled {
        border-color: #3b82f6;
        background-color: #ffffff;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.08);
    }
    .ficha-card-sap.estado-rojo .ficha-item.item-enabled {
        border-color: #ef4444;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.1);
    }
    .ficha-card-sap.estado-verde .ficha-item.item-enabled {
        border-color: #16a34a;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.1);
    }
    .ficha-card-sap.estado-amarillo .ficha-item.item-enabled {
        border-color: #ca8a04;
        box-shadow: 0 2px 8px rgba(202, 138, 4, 0.1);
    }
    .badge-condicion {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 10.5px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 4px;
        margin-top: 6px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .badge-condicion.habilitado {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .badge-condicion.deshabilitado {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #cbd5e1;
    }
    @keyframes spin { 100% { transform: rotate(360deg); } }

    /* Responsividad Avanzada (DevTools / Móviles / Tablets) */
    @media (max-width: 900px) {
        .sap-search-card {
            padding: 20px 18px;
            border-radius: 14px;
        }
        .ficha-sap-header {
            padding: 18px 20px;
        }
        .ficha-tabs-nav {
            padding: 10px 16px 0 16px;
        }
        .ficha-grid {
            padding: 20px 18px;
            gap: 14px;
        }
    }

    @media (max-width: 640px) {
        .sap-search-card {
            padding: 16px 14px;
            border-radius: 12px;
            margin-top: 14px;
        }
        .sap-search-card > div:first-child {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 6px;
        }
        .sap-search-input-wrap {
            min-width: 0 !important;
            width: 100%;
        }
        .sap-search-input {
            padding: 11px 14px 11px 42px;
            font-size: 14px;
        }
        .sap-search-input-wrap svg {
            left: 14px;
            width: 18px;
            height: 18px;
        }
        #form-sap-search {
            flex-direction: column;
            align-items: stretch !important;
            gap: 10px;
        }
        #btn-sap-buscar {
            width: 100%;
            justify-content: center;
            padding: 12px 18px;
        }
        #form-sap-search .btn-secondary {
            width: 100%;
            text-align: center;
            justify-content: center;
            padding: 10px 16px;
            display: inline-flex;
            align-items: center;
        }
        .ficha-card-sap {
            border-radius: 12px;
            margin-top: 16px;
        }
        .ficha-sap-header {
            padding: 16px 14px;
            flex-direction: column;
            align-items: stretch !important;
            gap: 14px;
        }
        .ficha-sap-header > div:first-child {
            width: 100%;
        }
        .ficha-sap-titulo {
            font-size: 18px;
            line-height: 1.3;
            word-break: break-word;
        }
        .ficha-sap-subtitulo {
            font-size: 12.5px;
            line-height: 1.4;
            word-break: break-word;
        }
        .ficha-sap-header > div:last-child,
        .ficha-sap-header form {
            width: 100%;
        }
        .btn-emitir-ficha {
            width: 100%;
            justify-content: center;
            padding: 11px 16px;
        }
        .ficha-tabs-nav {
            padding: 8px 10px 0 10px;
            gap: 4px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .ficha-tabs-nav::-webkit-scrollbar {
            display: none;
        }
        .ficha-tab-btn {
            padding: 8px 12px;
            font-size: 12px;
            gap: 6px;
            flex-shrink: 0;
        }
        .ficha-grid {
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px;
            padding: 14px 12px;
        }
        .ficha-item {
            padding: 11px 12px;
            min-width: 0;
            overflow: hidden;
        }
        .ficha-item .label {
            font-size: 10px;
            margin-bottom: 4px;
        }
        .ficha-item .value {
            font-size: 13.5px;
            word-break: break-word;
            overflow-wrap: break-word;
        }
        .badge-condicion {
            font-size: 9.5px;
            padding: 2px 6px;
            white-space: normal;
            line-height: 1.2;
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
    <!-- Cabecera Institucional -->
    <section class="welcome-section">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; width: 100%;">
            <div>
                <h2 class="welcome-title">Ficha de Vehículos</h2>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <span class="badge" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 12.5px; font-weight: 700; padding: 7px 14px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                    <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: #10b981;"></span>
                    Web Service SAP Activo (Mandante 300)
                </span>
            </div>
        </div>
    </section>

    <?php if(session('status')): ?>
        <div class="alert alert-success">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span><?php echo e(session('status')); ?></span>
        </div>
    <?php endif; ?>

    
    <div class="sap-search-card">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 12px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="background: #1e3a8a; color: #ffffff; font-size: 11.5px; font-weight: 800; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.5px;">SAP</span>
                <strong style="color: #1e3a8a; font-size: 16px;">Buscar Número de Equipo del Vehículo</strong>
            </div>
            <span style="font-size: 12.5px; color: #475569; font-weight: 600;">
                Búsqueda directa en Web Service SAP · Solo lectura
            </span>
        </div>

   

        <form id="form-sap-search" method="GET" action="<?php echo e(route('vehicles.index')); ?>" onsubmit="consultarSapFicha(event)" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div class="sap-search-input-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="input-sap-equipo" name="numero_equipo" value="<?php echo e($numeroEquipo); ?>" placeholder="Ingrese el Número de Equipo SAP (ej. 10001683)..." required autofocus class="sap-search-input">
            </div>
            <button type="submit" id="btn-sap-buscar" class="btn-primary" style="padding: 13px 26px; font-size: 14.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                <svg id="sap-buscar-spinner" style="display: none; animation: spin 1s linear infinite;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                <svg id="sap-buscar-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Buscar</span>
            </button>
            <a href="<?php echo e(route('vehicles.index')); ?>" onclick="limpiarConsultaSap(event)" id="btn-sap-limpiar" class="btn-secondary" style="padding: 13px 22px; font-size: 14.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>Limpiar</span>
            </a>
        </form>

        
        <div id="sap-error-box" style="display: <?php echo e($sapError ? 'flex' : 'none'); ?>; margin-top: 18px; background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 10px; padding: 14px 18px; color: #991b1b; font-size: 13.5px; align-items: center; gap: 10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink: 0;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span id="sap-error-texto"><?php echo e($sapError); ?></span>
        </div>
    </div>

    
    <div id="ficha-sap-contenedor" style="display: <?php echo e($sapData ? 'block' : 'none'); ?>;">
        <?php
            $d = $sapData;
            $numEquipo = $d['numero_equipo'] ?? '';
            $denominacion = $d['denominacion'] ?? '';
            $dependencia = $d['dependencia'] ?? '';
            $estado = $d['estado_sap'] ?? 'Consultado en SAP PM';

            $estadoNorm = strtr(mb_strtolower(trim((string) $estado), 'UTF-8'), [
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            ]);
            $cardEstadoClass = '';
            if (str_contains($estadoNorm, 'mal estado')) {
                $cardEstadoClass = 'estado-rojo';
            } elseif (str_contains($estadoNorm, 'buen estado') || str_contains($estadoNorm, 'disponible')) {
                $cardEstadoClass = 'estado-verde';
            } elseif (str_contains($estadoNorm, 'tiempo de test') || str_contains($estadoNorm, 'tiempo test') || str_contains($estadoNorm, 'reparacion')) {
                $cardEstadoClass = 'estado-amarillo';
            }

            // Validación de origen: Orgánico o Rentado
            $natNorm = strtr(mb_strtolower(trim((string) ($d['naturaleza_origen'] ?? '')), 'UTF-8'), [
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            ]);
            $esOrganico = str_contains($natNorm, 'organic') || str_contains($natNorm, 'propio');
            $esRentado = str_contains($natNorm, 'rentad') || str_contains($natNorm, 'alquilad') || str_contains($natNorm, 'leasing');
        ?>
        <div id="ficha-card-sap" class="ficha-card-sap <?php echo e($cardEstadoClass); ?>">
            
            <div class="ficha-sap-header">
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <span id="ficha-sap-equipo-badge" class="ficha-sap-equipo-badge">
                            <?php echo e($numEquipo ?: '—'); ?>

                        </span>
                        <span id="ficha-sap-estado" class="ficha-sap-estado-badge">
                            <?php echo e($estado); ?>

                        </span>
                    </div>
                    <h3 id="ficha-sap-titulo" class="ficha-sap-titulo">
                        <?php echo e($d['marca'] ?? ''); ?> <?php echo e($d['modelo'] ?? ''); ?> <?php echo e(!empty($d['anio']) ? '(' . $d['anio'] . ')' : ''); ?>

                    </h3>
                    <p id="ficha-sap-subtitulo" class="ficha-sap-subtitulo">
                        <?php echo e($denominacion ?: ($numEquipo ? 'Equipo SAP: ' . $numEquipo : '')); ?>

                        <?php if($dependencia): ?>
                            · <span id="ficha-sap-dependencia-header"><?php echo e($dependencia); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            
            <div class="ficha-tabs-nav">
                <button type="button" class="ficha-tab-btn active" data-tab="tab-panel-principales" onclick="seleccionarFichaTab('tab-panel-principales', this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <span>Datos Principales</span>
                </button>
                <button type="button" class="ficha-tab-btn" data-tab="tab-panel-tecnicos" onclick="seleccionarFichaTab('tab-panel-tecnicos', this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                    <span>Especificaciones Técnicas</span>
                </button>
                <button type="button" class="ficha-tab-btn" data-tab="tab-panel-origen" onclick="seleccionarFichaTab('tab-panel-origen', this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <span>Origen y Administración</span>
                </button>
            </div>

            
            <div id="tab-panel-principales" class="ficha-tab-panel active">
                <div class="ficha-grid">
                    <div class="ficha-item">
                        <div class="label">Placa / Registro</div>
                        <div class="value <?php echo e(empty($d['placa'] ?? null) ? 'empty' : ''); ?>" id="val-placa" style="color: <?php echo e(!empty($d['placa'] ?? null) ? '#1e40af' : '#94a3b8'); ?>;">
                            <?php echo e($d['placa'] ?? '—'); ?>

                        </div>
                    </div>
                    <div class="ficha-item">
                        <div class="label">Año</div>
                        <div class="value <?php echo e(empty($d['anio'] ?? null) ? 'empty' : ''); ?>" id="val-anio">
                            <?php echo e($d['anio'] ?? '—'); ?>

                        </div>
                    </div>
                    <div class="ficha-item">
                        <div class="label">Color</div>
                        <div class="value <?php echo e(empty($d['color'] ?? null) ? 'empty' : ''); ?>" id="val-color">
                            <?php echo e($d['color'] ?? '—'); ?>

                        </div>
                    </div>
                    <div class="ficha-item">
                        <div class="label">Dependencia Policial</div>
                        <div class="value <?php echo e(empty($d['dependencia'] ?? null) ? 'empty' : ''); ?>" id="val-dependencia">
                            <?php echo e($d['dependencia'] ?? '—'); ?>

                        </div>
                    </div>
                    <div class="ficha-item">
                        <div class="label">Naturaleza / Origen</div>
                        <div class="value <?php echo e(empty($d['naturaleza_origen'] ?? null) ? 'empty' : ''); ?>" id="val-naturaleza">
                            <?php echo e($d['naturaleza_origen'] ?? '—'); ?>

                        </div>
                    </div>
                </div>
            </div>

            
            <div id="tab-panel-tecnicos" class="ficha-tab-panel">
                <div class="ficha-grid">
                    <div class="ficha-item">
                        <div class="label">Chasis / VIN</div>
                        <div class="value <?php echo e(empty($d['chasis'] ?? null) ? 'empty' : ''); ?>" id="val-chasis" style="font-family: monospace;">
                            <?php echo e($d['chasis'] ?? '—'); ?>

                        </div>
                    </div>
                    <div class="ficha-item">
                        <div class="label">No. de Motor</div>
                        <div class="value <?php echo e(empty($d['motor'] ?? null) ? 'empty' : ''); ?>" id="val-motor" style="font-family: monospace;">
                            <?php echo e($d['motor'] ?? '—'); ?>

                        </div>
                    </div>
                    <div class="ficha-item">
                        <div class="label">Cilindraje</div>
                        <div class="value <?php echo e(empty($d['cilindraje'] ?? null) ? 'empty' : ''); ?>" id="val-cilindraje">
                            <?php echo e($d['cilindraje'] ?? '—'); ?>

                        </div>
                    </div>
                    <div class="ficha-item">
                        <div class="label">Tipo de Combustible</div>
                        <div class="value <?php echo e(empty($d['tipo_combustible'] ?? null) ? 'empty' : ''); ?>" id="val-tipo-combustible">
                            <?php echo e($d['tipo_combustible'] ?? '—'); ?>

                        </div>
                    </div>
                    <div class="ficha-item">
                        <div class="label">Tipo de Abastecimiento</div>
                        <div class="value <?php echo e(empty($d['tipo_abastecimiento'] ?? null) ? 'empty' : ''); ?>" id="val-tipo-abastecimiento">
                            <?php echo e($d['tipo_abastecimiento'] ?? '—'); ?>

                        </div>
                    </div>
                    <div class="ficha-item">
                        <div class="label">Blindaje</div>
                        <div class="value <?php echo e(empty($d['blindaje'] ?? null) ? 'empty' : ''); ?>" id="val-blindaje">
                            <?php echo e($d['blindaje'] ?? '—'); ?>

                        </div>
                    </div>
                </div>
            </div>

            
            <div id="tab-panel-origen" class="ficha-tab-panel">
                <div class="ficha-grid">
                    <div class="ficha-item">
                        <div class="label">Naturaleza / Origen</div>
                        <div class="value <?php echo e(empty($d['naturaleza_origen'] ?? null) ? 'empty' : ''); ?>" id="val-naturaleza-tab3">
                            <?php echo e($d['naturaleza_origen'] ?? '—'); ?>

                        </div>
                        <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
                            Define si aplica Activo Fijo (Orgánico) o Rentadora (Rentado).
                        </div>
                    </div>

                    
                    <div class="ficha-item <?php echo e($esOrganico ? 'item-enabled' : ($esRentado ? 'item-disabled' : '')); ?>" id="item-activo-fijo">
                        <div class="label">Activo Fijo</div>
                        <div class="value <?php echo e(empty($d['activo_fijo'] ?? null) ? 'empty' : ''); ?>" id="val-activo-fijo">
                            <?php echo e($d['activo_fijo'] ?? '—'); ?>

                        </div>
                        <div id="status-activo-fijo">
                            <?php if($esOrganico): ?>
                                <span class="badge-condicion habilitado">✓ Habilitado (Equipo Orgánico)</span>
                            <?php elseif($esRentado): ?>
                                <span class="badge-condicion deshabilitado">✕ No aplica (Vehículo Rentado)</span>
                            <?php else: ?>
                                <span class="badge-condicion deshabilitado">Habilitado si es Orgánico</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="ficha-item <?php echo e($esRentado ? 'item-enabled' : ($esOrganico ? 'item-disabled' : '')); ?>" id="item-rentadora">
                        <div class="label">Nombre Rentadora</div>
                        <div class="value <?php echo e(empty($d['nombre_rentadora'] ?? null) ? 'empty' : ''); ?>" id="val-rentadora">
                            <?php echo e($d['nombre_rentadora'] ?? '—'); ?>

                        </div>
                        <div id="status-rentadora">
                            <?php if($esRentado): ?>
                                <span class="badge-condicion habilitado">✓ Habilitado (Equipo Rentado)</span>
                            <?php elseif($esOrganico): ?>
                                <span class="badge-condicion deshabilitado">✕ No aplica (Vehículo Orgánico)</span>
                            <?php else: ?>
                                <span class="badge-condicion deshabilitado">Habilitado si es Rentado</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function seleccionarFichaTab(tabId, btn) {
        document.querySelectorAll('.ficha-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.ficha-tab-panel').forEach(p => p.classList.remove('active'));

        if (btn) {
            btn.classList.add('active');
        } else {
            const defaultBtn = document.querySelector(`.ficha-tab-btn[data-tab="${tabId}"]`);
            if (defaultBtn) defaultBtn.classList.add('active');
        }

        const panel = document.getElementById(tabId);
        if (panel) {
            panel.classList.add('active');
        }
    }

    function actualizarValidacionNaturaleza(naturalezaStr) {
        const norm = String(naturalezaStr || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();

        const esOrganico = norm.includes('organic') || norm.includes('propio');
        const esRentado = norm.includes('rentad') || norm.includes('alquilad') || norm.includes('leasing');

        const itemActivo = document.getElementById('item-activo-fijo');
        const itemRentadora = document.getElementById('item-rentadora');
        const statusActivo = document.getElementById('status-activo-fijo');
        const statusRentadora = document.getElementById('status-rentadora');

        if (!itemActivo || !itemRentadora) return;

        itemActivo.classList.remove('item-enabled', 'item-disabled');
        itemRentadora.classList.remove('item-enabled', 'item-disabled');

        if (esOrganico) {
            itemActivo.classList.add('item-enabled');
            itemRentadora.classList.add('item-disabled');
            if (statusActivo) statusActivo.innerHTML = '<span class="badge-condicion habilitado">✓ Habilitado (Equipo Orgánico)</span>';
            if (statusRentadora) statusRentadora.innerHTML = '<span class="badge-condicion deshabilitado">✕ No aplica (Vehículo Orgánico)</span>';
        } else if (esRentado) {
            itemRentadora.classList.add('item-enabled');
            itemActivo.classList.add('item-disabled');
            if (statusActivo) statusActivo.innerHTML = '<span class="badge-condicion deshabilitado">✕ No aplica (Vehículo Rentado)</span>';
            if (statusRentadora) statusRentadora.innerHTML = '<span class="badge-condicion habilitado">✓ Habilitado (Equipo Rentado)</span>';
        } else {
            if (statusActivo) statusActivo.innerHTML = '<span class="badge-condicion deshabilitado">Habilitado si es Orgánico</span>';
            if (statusRentadora) statusRentadora.innerHTML = '<span class="badge-condicion deshabilitado">Habilitado si es Rentado</span>';
        }
    }

    function obtenerClaseEstadoCard(estadoStr) {
        const norm = String(estadoStr || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();

        if (norm.includes('mal estado')) {
            return 'estado-rojo';
        }
        if (norm.includes('buen estado') || norm.includes('disponible')) {
            return 'estado-verde';
        }
        if (norm.includes('tiempo de test') || norm.includes('tiempo test') || norm.includes('reparacion')) {
            return 'estado-amarillo';
        }
        return '';
    }

    function limpiarConsultaSap(e) {
        if (e) e.preventDefault();
        const input = document.getElementById('input-sap-equipo');
        if (input) {
            input.value = '';
            input.focus();
        }
        const fichaContainer = document.getElementById('ficha-sap-contenedor');
        if (fichaContainer) {
            fichaContainer.style.display = 'none';
        }
        const errorBox = document.getElementById('sap-error-box');
        if (errorBox) {
            errorBox.style.display = 'none';
        }
        if (window.location.search) {
            window.location.href = '<?php echo e(route("vehicles.index")); ?>';
        }
    }

    async function consultarSapFicha(e) {
        e.preventDefault();
        const input = document.getElementById('input-sap-equipo');
        const equipo = input.value.trim();
        if (!equipo) return;

        const btn = document.getElementById('btn-sap-buscar');
        const spinner = document.getElementById('sap-buscar-spinner');
        const icon = document.getElementById('sap-buscar-icon');
        const errorBox = document.getElementById('sap-error-box');
        const errorTexto = document.getElementById('sap-error-texto');
        const fichaContainer = document.getElementById('ficha-sap-contenedor');

        btn.disabled = true;
        spinner.style.display = 'inline-block';
        icon.style.display = 'none';
        errorBox.style.display = 'none';

        try {
            const response = await fetch('<?php echo e(route("sap.consultar")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ numero_equipo: equipo })
            });

            const res = await response.json();

            if (!response.ok || !res.success) {
                throw new Error(res.message || 'No se encontró ningún vehículo con ese número de equipo en SAP.');
            }

            const data = res.data;

            // Número de equipo en el encabezado, títulos y estado
            document.getElementById('ficha-sap-equipo-badge').textContent = data.numero_equipo || '—';
            const descTitulo = `${data.marca || ''} ${data.modelo || ''} ${data.anio ? '(' + data.anio + ')' : ''}`.trim() || 'Vehículo SAP';
            document.getElementById('ficha-sap-titulo').textContent = descTitulo;
            document.getElementById('ficha-sap-estado').textContent = data.estado_sap || 'Consultado en SAP PM';
            document.getElementById('ficha-sap-subtitulo').textContent = data.denominacion || (`Equipo SAP: ${data.numero_equipo}` + (data.dependencia ? ` · ${data.dependencia}` : ''));

            // Aplicar color de la card según estado del vehículo
            const cardEl = document.getElementById('ficha-card-sap');
            if (cardEl) {
                cardEl.classList.remove('estado-rojo', 'estado-verde', 'estado-amarillo');
                const claseEstado = obtenerClaseEstadoCard(data.estado_sap);
                if (claseEstado) {
                    cardEl.classList.add(claseEstado);
                }
            }

            // Valores de campos (si no están, se dejan en blanco)
            const setField = (id, val) => {
                const el = document.getElementById(id);
                if (!el) return;
                if (val && String(val).trim() !== '') {
                    el.textContent = val;
                    el.classList.remove('empty');
                } else {
                    el.textContent = '—';
                    el.classList.add('empty');
                }
            };

            // Pestaña 1: Datos Principales
            setField('val-placa', data.placa);
            setField('val-anio', data.anio);
            setField('val-color', data.color);
            setField('val-dependencia', data.dependencia);
            setField('val-naturaleza', data.naturaleza_origen);

            // Pestaña 2: Especificaciones Técnicas
            setField('val-chasis', data.chasis);
            setField('val-motor', data.motor);
            setField('val-cilindraje', data.cilindraje);
            setField('val-tipo-combustible', data.tipo_combustible);
            setField('val-tipo-abastecimiento', data.tipo_abastecimiento);
            setField('val-blindaje', data.blindaje);

            // Pestaña 3: Origen y Administración
            setField('val-naturaleza-tab3', data.naturaleza_origen);
            setField('val-activo-fijo', data.activo_fijo);
            setField('val-rentadora', data.nombre_rentadora);

            // Aplicar validación condicional de Activo Fijo / Rentadora
            actualizarValidacionNaturaleza(data.naturaleza_origen);

            // Reiniciar a la pestaña principal para ver los datos más importantes primero
            seleccionarFichaTab('tab-panel-principales');

            // Actualizar número de equipo en el formulario de Emitir Boleta
            const syncInput = document.getElementById('sync-numero-equipo');
            if (syncInput) {
                syncInput.value = data.numero_equipo;
            }

            fichaContainer.style.display = 'block';
            fichaContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        } catch (err) {
            errorTexto.textContent = err.message;
            errorBox.style.display = 'flex';
        } finally {
            btn.disabled = false;
            spinner.style.display = 'none';
            icon.style.display = 'inline-block';
        }
    }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/vehicles/index.blade.php ENDPATH**/ ?>