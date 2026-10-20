<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Panel de Control'); ?> - SIG | Secretaría de Seguridad</title>
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Paleta Institucional Secretaría de Seguridad / Unidad SIG */
            --primary: #1e3a8a;          /* Azul Institucional Principal */
            --primary-dark: #0f2942;     /* Azul Marino Profundo */
            --primary-hover: #1d4ed8;    /* Azul Real */
            --primary-light: #eff6ff;    /* Azul Glacial */
            --primary-border: #bfdbfe;   /* Borde Azul Suave */

            --accent-cyan: #0284c7;      /* Cian Seguridad */
            --accent-emerald: #059669;   /* Verde Operativo */
            --accent-amber: #d97706;     /* Ámbar Alerta */
            --accent-purple: #7c3aed;    /* Púrpura Gestión */
            --accent-rose: #e11d48;      /* Rubí / Peligro */
            
            /* Fondos con profundidad (no blanco plano) */
            --bg-body: #edf2f7;          /* Fondo pizarra suave */
            --bg-body-gradient: radial-gradient(circle at 10% 20%, #e2eafc 0%, #edf2f7 50%, #e8eef6 100%);
            --card-bg: #ffffff;
            --card-bg-subtle: #f8fafc;
            
            /* Textos y Bordes */
            --text-main: #0f172a;        /* Pizarra oscuro */
            --text-secondary: #334155;   /* Gris texto legible */
            --text-muted: #64748b;       /* Gris atenuado */
            --border-color: #e2e8f0;     /* Gris borde */
            --border-color-hover: #cbd5e1;

            /* Sombras avanzadas */
            --shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-sm: 0 2px 4px rgba(15, 23, 42, 0.05);
            --shadow-md: 0 4px 12px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
            --shadow-lg: 0 10px 25px -3px rgba(15, 23, 42, 0.08), 0 4px 8px -2px rgba(15, 23, 42, 0.03);
            --shadow-glow-blue: 0 0 15px rgba(37, 99, 235, 0.2);

            /* Estados */
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            background-image: var(--bg-body-gradient);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* ==========================================================
           BARRA SUPERIOR (TOPBAR)
           ========================================================== */
        .topbar {
            background-color: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            color: inherit;
        }

        .brand-logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary), #2563eb);
            border-radius: 10px;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.25);
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .topbar-brand:hover .brand-logo-container {
            transform: scale(1.04);
        }

        .brand-logo-container svg {
            width: 26px;
            height: 26px;
            fill: currentColor;
        }

        .brand-text-wrap {
            display: flex;
            flex-direction: column;
        }

        .brand-institution {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--primary);
        }

        .brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-badge {
            font-family: 'Inter', sans-serif;
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 7px;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: #ffffff;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Información de Usuario y Perfil */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-right: 18px;
            border-right: 1px solid var(--border-color);
            background: none;
        }

        .user-avatar-wrap {
            position: relative;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
            box-shadow: 0 2px 6px rgba(30, 58, 138, 0.2);
        }

        .user-status-dot {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 11px;
            height: 11px;
            background-color: #10b981;
            border: 2px solid #ffffff;
            border-radius: 50%;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .user-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-main);
            line-height: 1.2;
        }

        .user-role-badge {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Botón de Logout */
        .logout-form {
            display: inline-block;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background-color: #ffffff;
            color: #dc2626;
            border: 1.5px solid #fee2e2;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-xs);
        }

        .btn-logout:hover {
            background-color: #fef2f2;
            border-color: #fca5a5;
            color: #b91c1c;
            box-shadow: 0 3px 8px rgba(220, 38, 38, 0.12);
            transform: translateY(-1px);
        }

        .btn-logout svg {
            width: 16px;
            height: 16px;
        }

        /* ==========================================================
           CONTENEDOR PRINCIPAL (LAYOUT)
           ========================================================== */
        .app-layout {
            display: flex;
            flex-grow: 1;
        }

        /* ==========================================================
           BARRA LATERAL (SIDEBAR) CON ICONOS MULTICOLORES
           ========================================================== */
        .sidebar {
            width: 270px;
            background-color: #ffffff;
            border-right: 1px solid var(--border-color);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            box-shadow: 2px 0 10px rgba(15, 23, 42, 0.02);
            justify-content: space-between;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-heading {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #94a3b8;
            padding: 16px 14px 6px;
        }

        .sidebar-heading:first-of-type {
            padding-top: 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s ease;
            position: relative;
        }

        .nav-link:hover {
            background-color: #f1f5f9;
            color: var(--primary);
            transform: translateX(2px);
        }

        .nav-link.active {
            background: linear-gradient(90deg, #eff6ff 0%, #f8fafc 100%);
            color: var(--primary);
            font-weight: 700;
            border: 1px solid var(--primary-border);
            box-shadow: 0 2px 6px rgba(30, 58, 138, 0.06);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -16px;
            top: 6px;
            bottom: 6px;
            width: 4px;
            background: linear-gradient(180deg, var(--primary), var(--primary-hover));
            border-radius: 0 4px 4px 0;
        }

        /* 
           ICONOS DE COLORES ESPECÍFICOS PARA CADA SECCIÓN
        */
        .nav-icon-badge {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .nav-icon-badge svg {
            width: 19px;
            height: 19px;
            stroke-width: 2.2;
        }

        .nav-link:hover .nav-icon-badge {
            transform: scale(1.08);
        }

        /* 1. Panel de Control (Índigo / Azul Eléctrico) */
        .icon-dashboard {
            background-color: #eef2ff;
            color: #4f46e5;
            border: 1px solid #e0e7ff;
        }
        .nav-link.active .icon-dashboard {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(79, 70, 229, 0.3);
            border-color: transparent;
        }

        /* 2. Ficha de Vehículo (Esmeralda / Verde) */
        .icon-vehicle {
            background-color: #ecfdf5;
            color: #059669;
            border: 1px solid #d1fae5;
        }
        .nav-link.active .icon-vehicle {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(5, 150, 105, 0.3);
            border-color: transparent;
        }

        /* 3. Boletas de Circulación (Ámbar / Naranja Dorado) */
        .icon-boleta {
            background-color: #fffbeb;
            color: #d97706;
            border: 1px solid #fef3c7;
        }
        .nav-link.active .icon-boleta {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(217, 119, 6, 0.3);
            border-color: transparent;
        }

        /* 4. Actas de Entrega (Violeta / Púrpura) */
        .icon-acta {
            background-color: #f5f3ff;
            color: #7c3aed;
            border: 1px solid #ede9fe;
        }
        .nav-link.active .icon-acta {
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(124, 58, 237, 0.3);
            border-color: transparent;
        }

        /* 5. Usuarios (Cian / Azul Cielo) */
        .icon-users {
            background-color: #e0f2fe;
            color: #0284c7;
            border: 1px solid #bae6fd;
        }
        .nav-link.active .icon-users {
            background: linear-gradient(135deg, #0284c7, #0ea5e9);
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(2, 132, 199, 0.3);
            border-color: transparent;
        }

        /* 6. Roles y Permisos (Carmesí / Rubí) */
        .icon-roles {
            background-color: #ffe4e6;
            color: #e11d48;
            border: 1px solid #fecdd3;
        }
        .nav-link.active .icon-roles {
            background: linear-gradient(135deg, #e11d48, #f43f5e);
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(225, 29, 72, 0.3);
            border-color: transparent;
        }

        /* Footer del Sidebar */
        .sidebar-footer {
            margin-top: 24px;
            padding: 14px;
            background: linear-gradient(135deg, #f8fafc, #edf2f7);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            text-align: center;
        }

        .sidebar-footer-title {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-footer-desc {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .sidebar-footer-badge {
            display: inline-block;
            margin-top: 8px;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 8px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            color: var(--accent-cyan);
        }

        /* ==========================================================
           CONTENIDO PRINCIPAL (MAIN CONTENT)
           ========================================================== */
        .main-content {
            flex-grow: 1;
            padding: 32px 40px;
            max-width: 1360px;
            width: 100%;
            margin: 0 auto;
        }

        /* Banner de Bienvenida Institucional */
        .welcome-section {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-left: 5px solid var(--primary);
            border-radius: 14px;
            padding: 22px 28px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .welcome-title {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.3px;
        }

        .welcome-subtitle {
            font-size: 13.5px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Tarjetas de Contenedores y Tablas */
        .table-card, .form-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-top: 24px;
            transition: box-shadow 0.2s ease;
        }

        .table-card:hover, .form-card:hover {
            box-shadow: var(--shadow-lg);
        }

        .table-header, .form-header {
            padding: 18px 24px;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-title, .form-title {
            font-family: 'Outfit', sans-serif;
            font-size: 16.5px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.2px;
        }

        /* ==========================================================
           TABLAS MODERNAS SAAS DE ALTO CONTRASTE
           ========================================================== */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 700;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            padding: 16px 22px;
            border-bottom: 1.5px solid var(--border-color);
        }

        tr {
            transition: background-color 0.15s ease;
        }

        tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        td {
            padding: 18px 22px;
            color: #334155;
            vertical-align: middle;
            line-height: 1.5;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        /* ==========================================================
           BOTONES MODERNOS E INSTITUCIONALES
           ========================================================== */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 9px;
            font-weight: 600;
            font-size: 13.5px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 6px rgba(30, 58, 138, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover), #2563eb);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.35);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background-color: #ffffff;
            color: #334155;
            border: 1.5px solid #cbd5e1;
            padding: 8px 16px;
            border-radius: 9px;
            font-weight: 600;
            font-size: 13.5px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: var(--shadow-xs);
        }

        .btn-secondary:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
            color: var(--primary);
            transform: translateY(-1px);
        }

        /* ==========================================================
           ALERTAS DEL SISTEMA
           ========================================================== */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 13.5px;
            margin-bottom: 22px;
            line-height: 1.5;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: var(--shadow-xs);
        }

        .alert-success {
            background-color: #ecfdf5;
            border: 1.5px solid #a7f3d0;
            color: #065f46;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1.5px solid #fecaca;
            color: #991b1b;
        }

        /* ==========================================================
           INSIGNIAS (BADGES) CON INDICADORES
           ========================================================== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1;
        }

        .badge-primary { background-color: #eff6ff; color: #1e40af; border: 1px solid #dbeafe; }
        .badge-success { background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .badge-warning { background-color: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .badge-danger  { background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .badge-purple  { background-color: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }

        /* Formularios */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 9px;
            background-color: #ffffff;
            color: #0f172a;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-hover);
            box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15);
        }

        .input-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
            font-weight: 500;
        }

        /* Responsive Layout */
        @media (max-width: 900px) {
            .app-layout {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                padding: 16px;
            }
            .main-content {
                padding: 24px 16px;
            }
            .topbar {
                padding: 0 16px;
            }
            .brand-title {
                font-size: 15px;
            }
        }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>

    <!-- Barra Superior Institucional -->
    <header class="topbar">
        <a href="<?php echo e(route('dashboard')); ?>" class="topbar-brand">
            <div class="brand-logo-container">
                <svg viewBox="0 0 24 24">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.18l7 3.12v4.7c0 4.67-3.13 9.07-7 10.18-3.87-1.11-7-5.51-7-10.18V6.3l7-3.12zm-1 5v6h2v-6h-2zm0 8v2h2v-2h-2z"/>
                </svg>
            </div>
            <div class="brand-text-wrap">
                <span class="brand-institution">Secretaría de Seguridad</span>
                <span class="brand-title">
                    Control de Boletas
                    <span class="brand-badge">SIG</span>
                </span>
            </div>
        </a>

        <div class="topbar-actions">
            <?php if(auth()->guard()->check()): ?>
                <div class="user-profile">
                    <div class="user-avatar-wrap">
                        <div class="user-avatar">
                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                        </div>
                        <span class="user-status-dot" title="Usuario en línea"></span>
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?php echo e(Auth::user()->name); ?></span>
                        <span class="user-role-badge">
                            <?php if(Auth::user()->hasRole('admin')): ?>
                                Administrador SIG
                            <?php elseif(Auth::user()->hasRole('operador-emisor')): ?>
                                Operador Emisor
                            <?php elseif(Auth::user()->hasRole('supervisor')): ?>
                                Supervisor
                            <?php else: ?>
                                Funcionario
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('logout')); ?>" method="POST" class="logout-form">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-logout" title="Cerrar sesión de forma segura">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </header>

    <!-- Contenedor Lateral + Contenido -->
    <div class="app-layout">
        
        <!-- Sidebar Navigation con Iconos Multicolores -->
        <aside class="sidebar">
            <div class="sidebar-nav">
                
                <div class="sidebar-heading">Menú Principal</div>

                <!-- 1. Dashboard (Índigo / Azul Eléctrico) -->
                <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(Route::is('dashboard') ? 'active' : ''); ?>">
                    <div class="nav-icon-badge icon-dashboard">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                    </div>
                    <span>Panel de Control</span>
                </a>

                <!-- Módulos Operativos -->
                <?php if(Auth::user()->hasAnyRole(['admin', 'operador-emisor', 'supervisor'])): ?>
                    <div class="sidebar-heading">Operaciones</div>

                    <!-- 2. Ficha de Vehículo (Esmeralda / Verde) -->
                    <a href="<?php echo e(route('vehicles.index')); ?>" class="nav-link <?php echo e(Route::is('vehicles.*') ? 'active' : ''); ?>">
                        <div class="nav-icon-badge icon-vehicle">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 17l-2 2m0 0l-2-2m2 2V9a5 5 0 015-5h6a2 2 0 012 2v11m0 0l2 2m-2-2l-2 2M5 13h14" />
                            </svg>
                        </div>
                        <span>Ficha de Vehículo</span>
                    </a>

                    <!-- 3. Boletas de Circulación (Ámbar / Naranja) -->
                    <a href="<?php echo e(route('boletas.index')); ?>" class="nav-link <?php echo e(Route::is('boletas.*') ? 'active' : ''); ?>">
                        <div class="nav-icon-badge icon-boleta">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span>Boletas de Circulación</span>
                    </a>

                    <!-- 4. Actas de Entrega (Violeta / Púrpura) -->
                    <a href="<?php echo e(route('actas.index')); ?>" class="nav-link <?php echo e(Route::is('actas.*') ? 'active' : ''); ?>">
                        <div class="nav-icon-badge icon-acta">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <span>Actas de Entrega</span>
                    </a>
                <?php endif; ?>

                <!-- Administración -->
                <?php if(Auth::user()->hasRole('admin')): ?>
                    <div class="sidebar-heading">Administración</div>

                    <!-- 5. Usuarios (Cian / Azul Cielo) -->
                    <a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e(Route::is('users.*') ? 'active' : ''); ?>">
                        <div class="nav-icon-badge icon-users">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <span>Usuarios</span>
                    </a>

                    <!-- 6. Roles y Permisos (Carmesí / Rubí) -->
                    <a href="<?php echo e(route('roles.index')); ?>" class="nav-link <?php echo e(Route::is('roles.*') ? 'active' : ''); ?>">
                        <div class="nav-icon-badge icon-roles">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <span>Gestionar Roles</span>
                    </a>
                <?php endif; ?>

            </div>

            <!-- Identificación Institucional Footer -->
            <div class="sidebar-footer">
                <div class="sidebar-footer-title">SIG</div>
                <div class="sidebar-footer-desc">Sistema Integrado de Gestión ©2026</div>
            </div>
        </aside>

        <!-- Contenido Central -->
        <main class="main-content">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

    </div>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\JUANALEJANDROALVAREZ\PROYECTOS\Laravel\Boletas_de_Circulación 1.3 MEJORADO\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>