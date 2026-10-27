# 🚀 Panduan Menjalankan Project KeeHub

Dokumen ini berisi panduan langkah demi langkah untuk menjalankan aplikasi **KeeHub** di environment lokal (development).

---

## 📋 Prasyarat Sistem

Sebelum memulai, pastikan perangkat Anda sudah terinstall:

1. **PHP**: Versi `>= 8.3` (dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `bcmath`, `curl`, `xml`, `zip`, `gd`)
2. **Composer**: Versi terbaru
3. **Node.js**: Versi `>= 18` atau `>= 20` & **NPM**
4. **Database Server**: MySQL / MariaDB (misal via MAMP, XAMPP, Docker, atau Homebrew)

---

## 🛠️ Langkah-langkah Instalasi Awal

Jika project baru di-clone atau belum pernah di-setup:

### 1. Salin File Environment
Duplikat file konfigurasi `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

### 2. Atur Konfigurasi Database di `.env`
Buka file `.env` dan sesuaikan koneksi database MySQL Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306        # Ubah ke 8889 jika menggunakan port default MySQL MAMP
DB_DATABASE=keehub  # Pastikan database 'keehub' sudah dibuat di MySQL / phpMyAdmin
DB_USERNAME=root
DB_PASSWORD=        # Masukkan password database (default MAMP biasanya 'root')
```

> **Catatan:** Buat database bernama `keehub` terlebih dahulu melalui phpMyAdmin, DBeaver, TablePlus, atau terminal MySQL:
> ```sql
> CREATE DATABASE keehub;
> ```

### 3. Install Dependensi PHP (Composer)
```bash
composer install
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Buat Symlink Storage
Agar file gambar/media produk bisa diakses oleh publik:
```bash
php artisan storage:link
```

### 6. Jalankan Migrasi & Seeder Database
Perintah ini akan membuat struktur tabel serta mengisi data awal (akun Admin, Staff, kategori, dan produk dummy):
```bash
php artisan migrate --seed
```

### 7. Install Dependensi Frontend (NPM)
```bash
npm install
```

---

## ▶️ Cara Menjalankan Aplikasi

Anda dapat menjalankan aplikasi menggunakan salah satu dari dua cara berikut:

### Opsi A: Menggunakan 2 Terminal Terpisah (Direkomendasikan)

Buka dua tab atau jendela terminal di direktori project:

* **Terminal 1: Menjalankan Laravel Backend Server**
  ```bash
  php artisan serve
  ```
  *Server backend aktif di: [http://localhost:8000](http://localhost:8000)*

* **Terminal 2: Menjalankan Vite Dev Server (Frontend & Tailwind)**
  ```bash
  npm run dev
  ```
  *Vite server aktif untuk hot-reload CSS dan JS.*

---

### Opsi B: Menggunakan Perintah Otomatis Laravel Dev

Laravel menyediakan perintah dev runner terpadu:
```bash
composer run dev
# atau
php artisan dev
```

---

## 🌐 Akses Aplikasi & Akun Default

Setelah server berjalan, buka browser dan akses URL berikut:

| Halaman | URL | Keterangan |
| :--- | :--- | :--- |
| **Storefront (Toko Publik)** | [http://localhost:8000](http://localhost:8000) | Katalog, Keranjang, PC Builder, Service Tracker |
| **Panel Admin (Filament)** | [http://localhost:8000/admin](http://localhost:8000/admin) | Dashboard Manajemen Produk, Pesanan, Staff, & Pengaturan |

### Kredensial Login Default (Hasil Seeder):

* **Akun Owner / Admin**:
  * **Email**: `admin@keetech.my.id`
  * **Password**: `admin123`
  * **Role**: Owner (Akses penuh ke semua modul panel admin)

* **Akun Staff Gudang**:
  * **Email**: `staff@keetech.my.id`
  * **Password**: `staff123`
  * **Role**: Staff

---

## 🔧 Troubleshooting / Masalah Umum

1. **Error: `Vite manifest not found`**:
   Jalankan build frontend sekali:
   ```bash
   npm run build
   ```
   Lalu jalankan kembali `npm run dev`.

2. **Error Cache / Perubahan Konfigurasi Tidak Terbaca**:
   Bersihkan semua cache aplikasi:
   ```bash
   php artisan optimize:clear
   ```

3. **Gambar Produk Tidak Tampil**:
   Pastikan symlink storage sudah terhubung:
   ```bash
   php artisan storage:link
   ```

4. **Koneksi Database Gagal (`SQLSTATE[HY000] [2002]`)**:
   * Pastikan service MySQL sedang berjalan (Start di MAMP / XAMPP).
   * Periksa `DB_PORT` di file `.env` (port default standard adalah `3306`, sedangkan default MAMP seringkali `8889`).
