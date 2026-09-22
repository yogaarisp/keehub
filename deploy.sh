#!/usr/bin/env bash
#
# Deploy KeeHub ke aaPanel /www/wwwroot/keehub
# Cocok untuk setup cloudflared -> http://localhost:111
#
# Cara pakai (di server):
#   bash deploy.sh
#
# Asumsi:
#   - .env sudah ada & terisi (lihat docs/DEPLOY_AAPANEL.md)
#   - MySQL & database sudah dibuat, port 111 sudah diarahkan di Nginx aaPanel
#   - PHP & composer tersedia di PATH (sesuaikan $PHP jika perlu)
set -euo pipefail

ROOT="/www/wwwroot/keehub"
PHP="php"

say()  { printf "\n\033[1;32m==> %s\033[0m\n" "$*"; }
die()  { printf "\033[1;31m[ERROR] %s\033[0m\n" "$*" >&2; exit 1; }

cd "$ROOT" || die "Folder $ROOT tidak ditemukan"

command -v composer >/dev/null || die "composer tidak ditemukan"
command -v node     >/dev/null || die "node tidak ditemukan"
command -v npm      >/dev/null || die "npm tidak ditemukan"

[ -f .env ] || die ".env belum ada. Salin dari .env.example dan konfigurasi dulu (lihat docs/DEPLOY_AAPANEL.md)."

# Set host sebagai web user agar storage dapat menulis
WEB_USER="www"
WEB_GROUP="www"

say "1/7 Optimize clear (mode lama)"
$PHP artisan optimize:clear

say "2/7 Install dependensi PHP (no-dev)"
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

say "3/7 Build frontend"
[ -d node_modules ] || npm ci --ignore-scripts
npm run build

say "4/7 Migrasi database"
$PHP artisan migrate --force

say "5/7 Storage link & permission"
$PHP artisan storage:link || true
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache
chown -R "$WEB_USER:$WEB_GROUP" storage bootstrap/cache 2>/dev/null || true

say "6/7 Cache produksi"
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache
$PHP artisan event:cache || true

say "7/7 Cek environment"
$PHP artisan about

say "Selesai. Cek layanan Nginx di port 111 sudah reload & akses https://keehub.keetech.my.id"