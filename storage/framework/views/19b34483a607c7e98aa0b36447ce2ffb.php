<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Acceso al Sistema'); ?> - Control de Boletas de Circulación</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1e3a8a;       /* Azul marino institucional */
            --primary-hover: #1e40af;
            --secondary: #0d9488;     /* Turquesa / Esmeralda */
            --bg-gradient-start: #0f172a; /* Pizarra oscuro */
            --bg-gradient-end: #1e293b;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --card-bg: rgba(255, 255, 255, 0.9);
            --border-color: rgba(226, 232, 240, 0.8);
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            --focus-ring: 0 0 0 3px rgba(13, 148, 136, 0.3);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
             background-image:
                linear-gradient(rgba(15, 23, 42, 0.42), rgba(15, 23, 42, 0.56)),
                url('<?php echo e(asset('images/fondo-patrullas.png')); ?>');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            color: var(--text-main);
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
        }

        /* Elementos decorativos de fondo (automoción / velocidad abstracto) */
        body::before, body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            z-index: 1;
            filter: blur(80px);
            opacity: 0.15;
        }
        body::before {
            background-color: var(--primary);
            top: 10%;
            left: 10%;
        }
        body::after {
            background-color: var(--secondary);
            bottom: 10%;
            right: 10%;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            margin: auto;
            z-index: 2;
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .auth-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 24px 26px;
            box-shadow: var(--shadow);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .auth-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.3);
        }

        .auth-logo svg {
            width: 32px;
            height: 32px;
            fill: #ffffff;
        }

        .auth-logo-legacy {
            display: none;
        }

        .auth-brand-logo {
            display: block;
            width: min(100%, 250px);
            height: auto;
            margin: -12px auto 4px;
            object-fit: contain;
            mix-blend-mode: multiply;
        }

        .auth-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .auth-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Formularios */
        .form-group {
            margin-bottom: 14px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #334155;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-control {
            width: 100%;
            padding: 10px 16px 10px 42px;
            font-size: 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            background: #ffffff;
            transition: all 0.25s ease;
            outline: none;
            color: #0f172a;
        }

        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: var(--focus-ring);
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-icon svg {
            width: 18px;
            height: 18px;
        }

        /* Toggle Mostrar/Ocultar Contraseña */
        .password-toggle {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--secondary);
        }

        .password-toggle svg {
            width: 18px;
            height: 18px;
        }

        /* Acciones secundarias */
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: #475569;
        }

        .checkbox-input {
            width: 16px;
            height: 16px;
            accent-color: var(--secondary);
            border-radius: 4px;
            cursor: pointer;
        }

        .form-link {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .form-link:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        /* Botón de acción principal */
        .btn-submit {
            width: 100%;
            padding: 11px 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(30, 58, 138, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 12px -2px rgba(30, 58, 138, 0.3);
            background: linear-gradient(135deg, var(--primary-hover), #1d4ed8);
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        /* Mensajes de Alerta y Error */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #b91c1c;
        }

        .alert-success {
            background-color: #ecfdf5;
            border: 1px solid #d1fae5;
            color: #065f46;
        }

        .input-error {
            font-size: 12px;
            color: #b91c1c;
            margin-top: 6px;
        }

        /* Animación Fade In */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-height: 700px) {
            body {
                align-items: flex-start;
                padding: 10px;
            }

            .auth-card {
                padding: 16px 24px;
            }

            .auth-header {
                margin-bottom: 14px;
            }

            .auth-brand-logo {
                width: min(100%, 200px);
                margin: -16px auto 0;
            }

            .auth-title {
                font-size: 20px;
                margin-bottom: 4px;
            }

            .auth-subtitle {
                font-size: 12px;
                line-height: 1.35;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .form-options {
                margin-bottom: 12px;
            }
        }

        @media (max-width: 480px) {
            body {
                align-items: flex-start;
                padding: 10px;
            }

            .auth-container {
                max-width: 100%;
            }

            .auth-card {
                padding: 20px 18px;
            }

            .auth-brand-logo {
                width: min(100%, 210px);
                margin-top: -8px;
            }
        }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/layouts/auth.blade.php ENDPATH**/ ?>