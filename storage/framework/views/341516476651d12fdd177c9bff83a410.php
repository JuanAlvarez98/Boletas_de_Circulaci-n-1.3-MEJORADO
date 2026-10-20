<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acta de Entrega Oficial</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; margin: 0; padding: 30px 12px; color: #1e293b;">
    
    <!-- Contenedor Principal de la Tarjeta de Correo -->
    <div style="max-width: 620px; margin: 0 auto; background-color: #ffffff; border-radius: 14px; box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.06); overflow: hidden; border: 1px solid #e2e8f0;">
        
        <!-- Cabecera Institucional -->
        <div style="background-color: #f8fafc; border-top: 5px solid #1e40af; border-bottom: 1px solid #e2e8f0; padding: 26px 20px 18px; text-align: center;">
            <div style="margin-bottom: 12px;">
                <img src="<?php echo e($message->embed(public_path('images/logo-sig.png'))); ?>" alt="SIG - Control de Boletas" style="height: 105px; max-height: 115px; width: auto; object-fit: contain; display: inline-block;">
            </div>
            
            <h1 style="margin: 6px 0 8px; font-size: 21px; font-weight: 700; color: #0f172a; line-height: 1.3;">
                Acta de Entrega - Boletas de Circulación
            </h1>
            
            <div style="margin-top: 6px;">
                <span style="display: inline-block; background-color: #eff6ff; color: #1e40af; font-size: 14px; font-weight: 700; font-family: 'Consolas', 'Courier New', monospace; padding: 5px 14px; border-radius: 6px; border: 1.5px solid #bfdbfe;">
                    Folio: <?php echo e($acta->folio); ?>

                </span>
            </div>
        </div>
        
        <!-- Cuerpo del Mensaje -->
        <div style="padding: 24px 24px;">
            <p style="font-size: 15px; line-height: 1.5; color: #1e293b; margin-top: 0; margin-bottom: 12px;">
                Estimado(a) <strong><?php echo e($acta->recibe_nombre); ?></strong>,
            </p>
            <p style="font-size: 13.5px; line-height: 1.5; color: #475569; margin-bottom: 20px;">
                Le notificamos que se ha registrado y formalizado la entrega oficial del vehículo detallado a continuación en el SIG Control de Boletas de Circulación:
            </p>
            
            <!-- Resumen Destacado de Datos del Vehículo y Documento -->
            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb; border-radius: 10px; padding: 20px; margin-bottom: 24px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
                    <tr>
                        <td style="padding: 7px 0; color: #64748b; width: 42%;">Placa:</td>
                        <td style="padding: 7px 0;">
                            <span style="font-family: monospace; font-size: 14px; font-weight: 700; color: #1e3a8a; background: #eff6ff; padding: 2px 8px; border-radius: 4px; border: 1px solid #bfdbfe;">
                                <?php echo e($acta->vehicle->placa); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 7px 0; color: #64748b;">Vehículo:</td>
                        <td style="padding: 7px 0; font-weight: 600; color: #1e293b;">
                            <?php echo e($acta->vehicle->marca); ?> <?php echo e($acta->vehicle->modelo); ?> (<?php echo e($acta->vehicle->anio ?? 's/f'); ?>)
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 7px 0; color: #64748b;">Chasis:</td>
                        <td style="padding: 7px 0; font-family: monospace; color: #334155; font-size: 13px;">
                            <?php echo e($acta->vehicle->chasis); ?>

                        </td>
                    </tr>
                    <?php if($acta->boleta): ?>
                    <tr>
                        <td style="padding: 7px 0; color: #64748b;">Boleta Vinculada:</td>
                        <td style="padding: 7px 0; font-weight: 600; color: #0284c7;">
                            <?php echo e($acta->boleta->folio); ?> (Vigente hasta <?php echo e($acta->boleta->fecha_vigencia->format('d/m/Y')); ?>)
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td style="padding: 7px 0; color: #64748b;">Fecha de Entrega:</td>
                        <td style="padding: 7px 0; font-weight: 600; color: #1e293b;">
                            <?php echo e($acta->fecha_entrega->format('d/m/Y')); ?>

                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 7px 0; color: #64748b;">Funcionario que Entrega:</td>
                        <td style="padding: 7px 0; color: #334155; font-weight: 500;">
                            <?php echo e($acta->entrega_nombre); ?>

                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 7px 0; color: #64748b;">Receptor Titular / ID:</td>
                        <td style="padding: 7px 0; color: #334155; font-weight: 500;">
                            <?php echo e($acta->recibe_nombre); ?> <?php echo e($acta->recibe_identidad ? '('.$acta->recibe_identidad.')' : ''); ?>

                        </td>
                    </tr>
                </table>
            </div>

            <?php if($acta->observaciones): ?>
                <div style="background-color: #f1f5f9; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; font-size: 13px; color: #475569; border: 1px dashed #cbd5e1;">
                    <strong style="color: #334155; display: block; margin-bottom: 4px;">Observaciones registradas:</strong>
                    <?php echo e($acta->observaciones); ?>

                </div>
            <?php endif; ?>

            <!-- Banner Informativo Digital -->
            <div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px; font-size: 12.5px; color: #065f46; display: flex; align-items: center;">
                <span>✓ Este correo constituye el comprobante y respaldo digital de la entrega formal emitida en el sistema.</span>
            </div>

            <p style="font-size: 12px; color: #94a3b8; line-height: 1.5; margin-bottom: 0; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                Documento generado automáticamente el <?php echo e(now()->format('d/m/Y H:i')); ?>.
            </p>
        </div>
        
        <!-- Pie de Página -->
        <div style="background-color: #f8fafc; padding: 18px 24px; text-align: center; font-size: 11.5px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            <p style="margin: 3px 0;">Secretaría de Seguridad</p>
            <p style="margin: 3px 0;">&copy; <?php echo e(date('Y')); ?> SIG - Sistema Integrado de Gestión</p>
        </div>
        
    </div>
    
</body>
</html>
<?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/emails/acta-entrega.blade.php ENDPATH**/ ?>