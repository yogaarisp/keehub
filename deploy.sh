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

# Deteksi folder web di aaPanel
if [ -d "/www/wwwroot/keehub.keetech.my.id" ]; then
    ROOT="/www/wwwroot/keehub.keetech.my.id"
elif [ -d "/www/wwwroot/keehub" ]; then
    ROOT="/www/wwwroot/keehub"
else
    ROOT="$(pwd)"
fi

PHP="php"
export COMPOSER_ALLOW_SUPERUSER=1

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

say "1/8 Git pull update terbaru"
git pull origin main

say "2/8 Bersihkan cache lama"
$PHP artisan optimize:clear
$PHP artisan filament:optimize-clear || true

say "3/8 Install dependensi PHP (no-dev)"
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
$PHP artisan filament:assets || true
$PHP artisan livewire:publish --assets || true
mkdir -p public/livewire
cp -f public/vendor/livewire/* public/livewire/ 2>/dev/null || true

say "4/8 Build frontend aset produksi"
npm run build

say "5/8 Migrasi database"
$PHP artisan migrate --force

say "6/8 Storage link & permission folder"
$PHP artisan storage:link || true
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache
chmod -R 755 public/livewire public/vendor/livewire 2>/dev/null || true
chown -R "$WEB_USER:$WEB_GROUP" storage bootstrap/cache public/livewire public/vendor/livewire 2>/dev/null || true

say "7/8 Cache produksi"
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache
$PHP artisan event:cache || true

say "8/8 Cek environment"
$PHP artisan about

say "Selesai! Aplikasi KeeHub sudah bersih, ter-update, dan ter-cache untuk produksi."
say "PENTING: Jangan lupa Reload/Restart PHP-FPM di aaPanel agar OPcache me-refresh kode terbaru."