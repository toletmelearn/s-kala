# S-kala Deployment Guide

## 1) Server Requirements
- PHP: `^8.2` (recommended `8.2` or `8.3`)
- Composer: latest stable
- MySQL: `8+` (or MariaDB compatible)
- Node.js: `18+`
- NPM: latest stable (bundled with Node)
- Web server: Apache or Nginx

Required PHP extensions (common Laravel set):
- `bcmath`
- `ctype`
- `curl`
- `fileinfo`
- `json`
- `mbstring`
- `openssl`
- `pdo`
- `pdo_mysql`
- `tokenizer`
- `xml`
- `gd` (recommended for image workflows)
- `zip` (recommended)

Permissions:
- Ensure write access for:
  - `storage/`
  - `bootstrap/cache/`
  - `public/uploads/` (if uploads are written there by app)

## 2) Local Setup Commands
```bash
composer install
npm install
npm run build
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan optimize:clear
php artisan serve
```

## 3) Production Deployment Commands
```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

Optional after deploy:
```bash
php artisan optimize
```

## 4) Required `.env` Keys (Sample Only)
Do not store real secrets in source control.

```env
APP_NAME="S-kala"
APP_ENV=production
APP_KEY=base64:GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-domain.example

LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skala_db
DB_USERNAME=skala_user
DB_PASSWORD=CHANGE_ME

SESSION_DRIVER=file
SESSION_LIFETIME=120

CACHE_STORE=file
QUEUE_CONNECTION=database
```

## 5) Upload Folders
This project stores module uploads in `public/uploads/*` (example paths):
- `public/uploads/trainees/...`
- `public/uploads/gallery/...`
- `public/uploads/events/...`
- `public/uploads/products/...`
- `public/uploads/csr-reports/...`
- `public/uploads/certificates/...`

If using `storage/app/public` in future modules, keep `php artisan storage:link` active.

## 6) Backup Guidance
- Database backup:
  - Daily logical dump (`mysqldump`) or managed DB snapshots.
- Upload backup:
  - Backup full `public/uploads/` directory regularly.
- Environment backup:
  - Keep `.env` in secure private vault (never commit to git).

Recommended policy:
- Daily incremental backup
- Weekly full backup
- Monthly restore drill (test restore on staging)

