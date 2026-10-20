# Sistema de Boletas de Circulación

Aplicación Laravel 12 para administrar vehículos en MySQL local y emitir boletas, stickers QR y actas de entrega con roles, 2FA, auditoría y conservación de historial.

## Requisitos

- PHP 8.2 o superior y Composer
- MySQL 8 o MariaDB 10.6+
- Node.js 20 o superior
- Una cuenta SMTP para los códigos 2FA

## Instalación

```bash
composer install
copy .env.example .env
php artisan key:generate
```

Configure en `.env` la conexión MySQL y el correo. Luego ejecute:

```bash
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

No copie el `.env` de otra instalación. Cada ambiente debe tener su propia `APP_KEY` y credenciales.

## Actualización desde la versión 1.1

1. Haga un respaldo completo de MySQL y pruebe que pueda restaurarlo.
2. Reemplace el código, conservando únicamente su `.env` local.
3. Ejecute `composer install`, `php artisan migrate --force`, `npm install` y `npm run build`.
4. Pruebe inicio de sesión, correo 2FA, emisión, anulación e impresión.

## Operación segura

- En producción use `APP_ENV=production`, `APP_DEBUG=false`, HTTPS y `SESSION_SECURE_COOKIE=true`.
- Ejecute permanentemente `php artisan queue:work` si cambia el correo a colas.
- Configure `php artisan schedule:run` cada minuto; el sistema marca boletas vencidas diariamente.
- Nunca distribuya `.env`, `database.sqlite`, `vendor`, `node_modules`, registros ni cachés.
- Desactive cuentas en vez de borrar funcionarios que tengan documentos emitidos.
- Toda anulación exige un motivo y se registra en `audit_logs`.

## Respaldo recomendado

Realice un respaldo cifrado diario de MySQL, conserve varias generaciones y ensaye una restauración al menos una vez al mes. Restrinja el acceso porque existen datos personales.

## Pruebas

```bash
php artisan test
```

Las pruebas cubren integridad entre vehículos y boletas, conservación de documentos anulados, auditoría y consecutivos únicos.
