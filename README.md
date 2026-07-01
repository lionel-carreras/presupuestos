# Presupuestos

Aplicacion Laravel para generar presupuestos online de Expreso Brio.

## Requisitos

- PHP 8.2+
- Composer
- Node.js / npm
- SQL Server con acceso a las tablas operativas
- SMTP para envio de correos

## Variables de entorno para Azure App Service

Configurar estas variables en **App Service > Configuration > Application settings**:

```env
APP_NAME="Expreso Brio Presupuestos"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_TIMEZONE=America/Argentina/Buenos_Aires
APP_URL=https://TU_APP.azurewebsites.net
ASSET_URL=

APP_LOCALE=es
APP_FALLBACK_LOCALE=es

LOG_CHANNEL=stack
LOG_LEVEL=info

DB_CONNECTION=sqlsrv
DB_HOST=
DB_PORT=1433
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_ENCRYPT=yes
DB_TRUST_SERVER_CERTIFICATE=false

SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_CONNECTION=sync
CACHE_STORE=file
FILESYSTEM_DISK=local

MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_ENCRYPTION=tls
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"
```

Generar `APP_KEY` con:

```bash
php artisan key:generate --show
```

## Deploy

El repo incluye un `Dockerfile` preparado para Azure App Service for Containers:

- instala dependencias PHP y Node;
- instala drivers `sqlsrv` y `pdo_sqlsrv`;
- ejecuta `composer install`;
- ejecuta `npm ci` y `npm run build`;
- publica Apache apuntando a `public/`.

Si se usa App Service PHP nativo en vez de contenedor, verificar que el entorno tenga instaladas las extensiones `sqlsrv` y `pdo_sqlsrv`.

## Comandos locales

```bash
composer install
npm install
npm run build
php artisan serve
```
