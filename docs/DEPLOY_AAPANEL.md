# Deploy KeeHub ke aaPanel + Cloudflare Tunnel (port 111)

Target: `https://keehub.keetech.my.id` diakses via cloudflared → `http://localhost:111` (Nginx aaPanel).

## 0. Persyaratan Server (aaPanel)

- CentOS/Ubuntu dengan aaPanel terinstall
- **PHP ≥ 8.3** (persyaratan minimum composer.json, ideal 8.4/8.5). Install via *aaPanel → App Store → PHP*.
- Ekstensi PHP wajib: `bcmath`, `ctype`, `curl`, `dom`, `fileinfo`, `gd` (opsional), `intl`, `mbstring`, `openssl`, `pdo`, `pdo_mysql`, `redis` (opsional), `tokenizer`, `xml`, `zip`
- MySQL (atau MariaDB), Composer, Node.js ≥ 20 + npm
- Akun domain terdaftar di Cloudflare dengan tunnel cloudflared (dari PC/macOS kamu, arahkan ke `http://localhost:111`)

> Saat ini proyek **tidak punya job queue maupun scheduled task**, jadi worker opsional. Tetap siapkan `queue:work` jika nanti ada fitur baru.

## 1. Upload Kode ke Server

Jalankan dari komputer lokal (di dalam folder project):

```bash
# Buat arsip tanpa vendor/node_modules/asset build (semua akan dibuat di server)
git archive --format=tar.gz -o keehub.tar.gz HEAD
```

Upload `keehub.tar.gz` ke server lalu:

```bash
# Di server, misal root site
cd /www/wwwroot/keehub
tar xzf keehub.tar.gz
rm keehub.tar.gz
```

## 2. Setup Environment

```bash
cd /www/wwwroot/keehub

# 2.1 Identitas & keamanan
APP_NAME=KeeHub
APP_ENV=production
APP_KEY=base64:...            # hasil php artisan key:generate
APP_DEBUG=false
APP_URL=https://keehub.keetech.my.id
```

Buat `.env` dari contoh:

```bash
cp .env.example .env
nano .env
```

Set minimal berikut sesuai server (nilai telepon MySQL dari panel aaPanel):

```env
APP_NAME=KeeHub
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://keehub.keetech.my.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nama_db>          # buat di MySQL aaPanel
DB_USERNAME=<user_db>
DB_PASSWORD=<password_db>

# User admin/staf dibuat saat migrate --seed
KEEHUB_ADMIN_EMAIL=admin@ketech.my.id
KEEHUB_ADMIN_PASSWORD=<isi-sekarang>
KEEHUB_STAFF_EMAIL=staff@ketech.my.id
KEEHUB_STAFF_PASSWORD=<isi-sekarang>

# Email: ganti MAIL_MAILER dari log ke smtp agar notifikasi terkirim
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=xxx
MAIL_PASSWORD=xxx
MAIL_FROM_ADDRESS=no-reply@keetech.my.id
MAIL_FROM_NAME="${APP_NAME}"

LOG_LEVEL=error
```

Lalu generate APP_KEY dan buat database jika belum ada (di MySQL aaPanel), kemudian:

```bash
php artisan key:generate
```

## 3. Install Dependensi

```bash
# PHP
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Frontend
npm ci --ignore-scripts
npm run build
```

## 4. Database

```bash
php artisan migrate --seed --force
```

`--seed` membuat akun admin & staf memakai nilai `KEEHUB_*` di `.env` (sudah di-hash otomatis oleh seeder).

## 5. Link & Izin Folder

```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

## 6. Cache Produksi

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

Saat ada update, urutannya: `php artisan optimize:clear` → upload → jalankan ulang langkah 3–6.

## 7. konfigurasi Nginx di aaPanel (port 111)

Karena cloudflared menunjuk ke `localhost:111`, web server tidak perlu port 80/443.

1. **Nginx** → *Add site* → domain `keehub.keetech.my.id`
2. Di *Site → Settings → Website Directory* arahkan **satu level ke atas** `public/` (root ke `/www/wwwroot/keehub/public`) set *Runtime Environment* ke PHP ≥ 8.3.
3. Port: domain diakses hanya via tunnel, tapi set `listen 111;` (bukan 80):
   - *Site → Settings → Configuration file*, ubah `server { listen 80; ... }` menjadi `server { listen 111; ... }`
4. Di blok `server`, set `root` dan tambahkan rewrite Laravel (jika belum ada):

```nginx
server {
    listen 111;
    server_name keehub.keetech.my.id;

    root /www/wwwroot/keehub/public;
    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/tmp/php-cgi-<VERSI>.sock;  # sesuaikan versi PHP
        fastcgi_index index.php;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

5. *Save* lalu *Reload*. Cek dengan `curl http://localhost:111` di server — harus mengembalikan HTML app.

> Catatan: aaPanel biasanya menambahkan konfigurasi rewrite sendiri. Pastikan blok `location /` memakai `try_files` di atas; jika konfigurasi aaPanel menduplikasi `listen`, simpan port 111 di blok sesuai nama domain.

## 8. Cloudflare Tunnel (cloudflared)

Di PC/macOS lokal, pastikan tunnel mengarahkan:

```
keehub.keetech.my.id → http://localhost:111
```

Contoh `config.yml` cloudflared:

```yaml
tunnel: <TUNNEL_ID>
credentials-file: /path/to/<TUNNEL_ID>.json

ingress:
  - hostname: keehub.keetech.my.id
    service: http://localhost:111
  - service: http_status:404
```

Setelah service Nginx aktif di port 111, akses `https://keehub.keetech.my.id`. HTTPS sudah ditangani tunnel, jadi app berjalan di belakangnya secara transparan.

## 9. Factory Reset & Pemeliharaan

- **Update kode:** `php artisan optimize:clear` → upload versi baru → `composer install --no-dev` → `npm run build` → `php artisan migrate --force` → jalankan kembali langkah 5–6.
- **Backup:** pakai fitur *Backup* di aaPanel untuk database & site.
- **Queue (opsional, jika nanti ada job):** jalankan `php artisan queue:work` sebagai service/systemd, atau sesuaikan supervisor di aaPanel.

## 10. Verifikasi Akhir

```bash
curl -I https://keehub.keetech.my.id          # harus 200
php artisan about                               # cek environment
php artisan migrate:status                      # semua ran
```

Login admin di `/admin` (Filament) lalu cek: produk/kategori, ongkir, pengiriman, dan halaman publik.