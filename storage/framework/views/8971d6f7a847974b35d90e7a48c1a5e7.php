<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Código de Verificación 2FA</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; margin: 0; padding: 40px 10px; color: #1f2937;">
    
    <!-- Contenedor Principal (Tarjeta) -->
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); overflow: hidden; border: 1px solid #e5e7eb;">
        
        <!-- Cabecera (Header) con Gradiente Institucional -->
        <div style="background: #1e3a8a; background: linear-gradient(135deg, #1e3a8a, #0d9488); padding: 30px 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 22px; font-weight: 600; letter-spacing: 0.5px; color: #ffffff; font-family: 'Segoe UI', Arial, sans-serif;">
                SIG / Boletas de Circulación
            </h1>
        </div>
        
        <!-- Contenido (Body) -->
        <div style="padding: 40px 30px; text-align: center;">
            <p style="font-size: 16px; line-height: 1.6; color: #4b5563; margin-bottom: 25px; font-family: 'Segoe UI', Arial, sans-serif;">
                Se ha solicitado un inicio de sesión para su cuenta institucional. Use el siguiente código de verificación de un solo uso (OTP) para continuar:
            </p>
            
            <!-- Caja del Código OTP -->
            <div style="display: inline-block; background-color: #f8fafc; border: 2px dashed #0d9488; color: #1e3a8a; font-size: 32px; font-weight: 700; letter-spacing: 6px; padding: 12px 28px; border-radius: 8px; margin: 15px 0; font-family: monospace, Courier, sans-serif;">
                <?php echo e($code); ?>

            </div>
            
            <p style="margin-top: 25px; font-size: 13px; color: #9ca3af; line-height: 1.5; font-family: 'Segoe UI', Arial, sans-serif;">
                Este código es válido por 10 minutos. Si no ha solicitado este acceso, ignore este correo o cambie su contraseña de inmediato.
            </p>
        </div>
        
        <!-- Pie de página (Footer) -->
        <div style="background-color: #f9fafb; padding: 20px; text-align: center; font-size: 11px; color: #9ca3af; border-top: 1px solid #f3f4f6; font-family: 'Segoe UI', Arial, sans-serif;">
            <p style="margin: 4px 0;">Este es un correo automático de seguridad, por favor no responda a este mensaje.</p>
            <p style="margin: 4px 0;">&copy; <?php echo e(date('Y')); ?> SIG - Control de Boletas de Circulación</p>
        </div>
        
    </div>
    
</body>
</html>
<?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/emails/two-factor-code.blade.php ENDPATH**/ ?>