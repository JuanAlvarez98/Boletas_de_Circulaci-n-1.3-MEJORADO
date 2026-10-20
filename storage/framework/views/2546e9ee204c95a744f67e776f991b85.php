<?php $__env->startSection('title', 'Acta ' . $acta->folio); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .documento {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: var(--shadow-md);
        max-width: 740px;
        margin: 24px auto 0;
        padding: 40px;
    }
    .doc-header {
        display: flex; align-items: center; justify-content: space-between;
        border-bottom: 3px solid var(--primary); padding-bottom: 20px; margin-bottom: 24px;
    }
    .doc-header .titulo { font-size: 20px; font-weight: 700; color: var(--primary); }
    .doc-header .folio { font-size: 13px; color: var(--text-muted); text-align: right; }
    .doc-header .folio strong { display: block; font-size: 16px; color: var(--text-main); font-family: monospace; }
    .doc-parrafo { font-size: 14px; line-height: 1.8; color: var(--text-main); margin-bottom: 24px; text-align: justify; }
    .doc-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 30px; margin-bottom: 24px; }
    .doc-field { display: flex; align-items: baseline; justify-content: center; gap: 6px; flex-wrap: wrap; text-align: center; }
    .doc-field .label { font-size: 14px; color: var(--text-main); font-weight: 700; }
    .doc-field .label::after { content: ":"; }
    .doc-field .value { font-size: 14px; font-weight: 500; margin-top: 0; color: var(--text-main); }
    .firmas { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 50px; }
    .firma-linea { border-top: 1.5px solid var(--text-main); padding-top: 8px; text-align: center; font-size: 12.5px; }
    .firma-linea strong { display: block; font-size: 13.5px; margin-bottom: 2px; }
    .doc-footer { margin-top: 36px; padding-top: 20px; border-top: 1px dashed var(--border-color); font-size: 12px; color: var(--text-muted); text-align: center; }

    /* Modal / Formulario Desplegable de Envío por Correo */
    .email-action-bar {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: var(--shadow-xs);
    }

    @media print {
        .topbar, .sidebar, .welcome-section, .alert, .no-print, .email-action-bar { display: none !important; }
        .main-content { padding: 0 !important; max-width: 100% !important; }
        .documento { box-shadow: none; border: none; margin: 0 auto; width: 100% !important; }
        body { background: #fff !important; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="welcome-section no-print">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <h2 class="welcome-title">Acta de Entrega: <?php echo e($acta->folio); ?></h2>
                <p class="welcome-subtitle">Vehículo <?php echo e($acta->vehicle->placa); ?> — <?php echo e($acta->vehicle->marca); ?> <?php echo e($acta->vehicle->modelo); ?></p>
            </div>
            <div style="display:flex; gap: 10px; flex-wrap: wrap;">
                <a href="<?php echo e(route('vehicles.show', $acta->vehicle)); ?>" class="btn-secondary">← Volver a la Ficha</a>
                <button onclick="document.getElementById('emailSendBox').style.display = document.getElementById('emailSendBox').style.display === 'none' ? 'block' : 'none'" class="btn-primary" style="background: linear-gradient(135deg, #0284c7, #0ea5e9);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span><?php echo e($acta->enviado_email_at ? 'Reenviar por Correo' : 'Enviar por Correo'); ?></span>
                </button>
                <button onclick="window.print()" class="btn-primary">Imprimir Acta</button>
            </div>
        </div>
    </section>

    <?php if(session('status')): ?>
        <div class="alert alert-success no-print">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span><?php echo e(session('status')); ?></span>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-error no-print">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; flex-shrink: 0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span><?php echo e($errors->first()); ?></span>
        </div>
    <?php endif; ?>

    <!-- Panel de Envío Inmediato por Correo (Desplegable) -->
    <div id="emailSendBox" class="email-action-bar no-print" style="display: <?php echo e($acta->enviado_email_at ? 'none' : 'flex'); ?>;">
        <div style="display: flex; align-items: center; gap: 12px; flex-grow: 1;">
            <div style="width: 40px; height: 40px; background: #e0f2fe; color: #0284c7; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                </svg>
            </div>
            <div>
                <div style="font-size: 13.5px; font-weight: 700; color: #0f172a;">
                    <?php echo e($acta->enviado_email_at ? 'Reenvío de copia digital del acta' : 'Entrega digital del acta por correo'); ?>

                </div>
                <div style="font-size: 12px; color: var(--text-muted);">
                    <?php if($acta->enviado_email_at): ?>
                        Último envío realizado a <strong><?php echo e($acta->recibe_email); ?></strong> el <?php echo e($acta->enviado_email_at->format('d/m/Y H:i')); ?>.
                    <?php else: ?>
                        Envía al instante una copia oficial de esta acta al correo del receptor o a cualquier interesado.
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <form method="POST" action="<?php echo e(route('actas.send-email', $acta)); ?>" style="display: flex; gap: 8px; flex-wrap: wrap; min-width: 300px;">
            <?php echo csrf_field(); ?>
            <input type="email" name="email" value="<?php echo e(old('email', $acta->recibe_email)); ?>" placeholder="correo@ejemplo.com" required style="flex: 1; padding: 8px 12px; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 13.5px; min-width: 200px;">
            <button type="submit" class="btn-primary" style="padding: 8px 16px; font-size: 13px;">
                <span>Enviar Ahora</span>
            </button>
        </form>
    </div>

    <?php if(Auth::user()->hasAnyRole(['admin','operator']) && $acta->estado === 'registrada'): ?>
        <form class="no-print" method="POST" action="<?php echo e(route('actas.destroy',$acta)); ?>" style="display:flex;gap:10px;margin-bottom:18px"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <input name="motivo_anulacion" required minlength="10" maxlength="500" placeholder="Motivo de anulación en caso de requerirse..." style="flex:1;padding:9px 14px;border:1.5px solid #cbd5e1;border-radius:8px;font-size:13.5px;">
            <button class="btn-logout" type="submit" onclick="return confirm('¿Anular esta acta?')">Anular acta</button>
        </form>
    <?php endif; ?>

    <div class="documento">
        <div class="doc-header">
            <div style="display: flex; align-items: center; gap: 16px;">
                <img src="<?php echo e(asset('images/logo-sig.png')); ?>" alt="Identificador Unidad Emisora SIG" style="height: 58px; width: auto; object-fit: contain;">
                <div>
                    <div class="titulo">Acta de Entrega Vehicular</div>
                    <div style="font-size: 12.5px; color: var(--text-muted); margin-top: 3px; font-weight: 600;">
                        Secretaría de Seguridad &bull; Unidad Emisora SIG
                    </div>
                </div>
            </div>
            <div class="folio">
                Folio
                <strong><?php echo e($acta->folio); ?></strong>
            </div>
        </div>

        <p class="doc-parrafo">
            En la fecha indicada, <strong><?php echo e($acta->entrega_nombre); ?></strong> hace entrega formal del vehículo descrito a continuación
            a <strong><?php echo e($acta->recibe_nombre); ?></strong><?php echo e($acta->recibe_identidad ? ', identificado(a) con No. ' . $acta->recibe_identidad : ''); ?>,
            <?php if($acta->recibe_email): ?>
                notificado(a) al correo electrónico <strong><?php echo e($acta->recibe_email); ?></strong>,
            <?php endif; ?>
            <?php if($acta->boleta): ?>
                en relación con la boleta de circulación <strong><?php echo e($acta->boleta->folio); ?></strong>,
            <?php endif; ?>
            dejando constancia de dicha entrega y recepción mediante la presente acta.
        </p>

        <div class="doc-grid">
            <div class="doc-field"><div class="label">Placa</div><div class="value"><?php echo e($acta->vehicle->placa); ?></div></div>
            <div class="doc-field"><div class="label">Marca / Modelo</div><div class="value"><?php echo e($acta->vehicle->marca); ?> <?php echo e($acta->vehicle->modelo); ?></div></div>
            <div class="doc-field"><div class="label">Chasis</div><div class="value"><?php echo e($acta->vehicle->chasis); ?></div></div>
            <div class="doc-field"><div class="label">Color</div><div class="value"><?php echo e($acta->vehicle->color ?? '—'); ?></div></div>
            <div class="doc-field"><div class="label">Fecha de Entrega</div><div class="value"><?php echo e($acta->fecha_entrega->format('d/m/Y')); ?></div></div>
            <div class="doc-field"><div class="label">Registrada por</div><div class="value"><?php echo e($acta->registradoPor->name); ?></div></div>
        </div>

        <?php if($acta->observaciones): ?>
            <div class="doc-field" style="margin-bottom: 20px;">
                <div class="label">Observaciones</div>
                <div class="value" style="font-weight: 500;"><?php echo e($acta->observaciones); ?></div>
            </div>
        <?php endif; ?>

        <div class="firmas">
            <div class="firma-linea">
                <strong><?php echo e($acta->entrega_nombre); ?></strong>
                Quien Entrega (Funcionario)
            </div>
            <div class="firma-linea">
                <strong><?php echo e($acta->recibe_nombre); ?></strong>
                Quien Recibe
                <?php if($acta->enviado_email_at): ?>
                    <span style="display: block; font-size: 11px; color: #0284c7; font-weight: 600; margin-top: 2px;">Copia enviada a <?php echo e($acta->recibe_email); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="doc-footer">
            Documento generado por el Sistema de Control de Boletas de Circulación Vehicular el <?php echo e($acta->created_at->format('d/m/Y H:i')); ?>

            <?php if($acta->enviado_email_at): ?>
                &bull; Notificado por correo el <?php echo e($acta->enviado_email_at->format('d/m/Y H:i')); ?>

            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/actas/show.blade.php ENDPATH**/ ?>