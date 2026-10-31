# Panduan Menjalankan & Mengakses KeeHub

Dokumen ini berisi panduan untuk menjalankan dan mengakses aplikasi **KeeHub** di komputer lokal (Windows / Laragon).

---

## 1. Status Setup Otomatis yang Telah Selesai Dilakukan

Semua proses instalasi dan konfigurasi awal telah berhasil diproses secara otomatis:

- [x] **PHP 8.4** telah diunduh dan dipasang di `G:\laragon\bin\php\php-8.4.27-Win32-vs17-x64` dengan ekstensi yang diperlukan (`pdo_mysql`, `pdo_sqlite`, `curl`, `mbstring`, `fileinfo`, `gd`, `zip`).
- [x] File konfigurasi `.env` telah disiapkan.
- [x] Dependency PHP (`composer install`) telah terpasang.
- [x] Application Encryption Key (`php artisan key:generate`) telah digenerate.
- [x] Asset Filament Admin (`php artisan filament:upgrade`) telah dipublish.
- [x] Symlink Storage (`php artisan storage:link`) telah terhubung.
- [x] Database telah dimigrasi & di-seed (`php artisan migrate --seed`) dengan akun default dan data katalog.
- [x] Asset Frontend (`npm install` & `npm run build`) telah selesai dikompilasi ke `public/build`.

---

## 2. Cara Menjalankan Aplikasi

Anda dapat menjalankan project dengan salah satu dari dua cara berikut:

### Opsi 1: Menjalankan via Terminal (Artisan Serve) — Paling Cepat

Buka PowerShell / Terminal di folder `G:\laragon\www\keehub`, lalu jalankan:

```powershell
& G:\laragon\bin\php\php-8.4.27-Win32-vs17-x64\php.exe artisan serve
```

*(Atau cukup ketik `php artisan serve` jika Anda membuka tombol **Terminal** dari aplikasi Laragon setelah memilih PHP 8.4).*

Aplikasi siap diakses di browser:
- **Halaman Utama / Katalog**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Panel Admin / Dashboard**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

---

### Opsi 2: Menjalankan via Laragon Virtual Host (`http://keehub.test`)

Jika ingin menggunakan domain lokal Laragon:
1. Buka aplikasi **Laragon**.
2. **Pilih PHP 8.4**:
   - Klik kanan di mana saja pada jendela Laragon -> pilih menu **PHP** -> **Version** -> pilih **`php-8.4.27-Win32-vs17-x64`**.
3. Klik tombol **Start All** di Laragon.
4. Buka browser dan akses:
   - **Halaman Utama**: [http://keehub.test](http://keehub.test)
   - **Panel Admin**: [http://keehub.test/admin](http://keehub.test/admin)

---

## 3. Informasi Akun Login (Filament Admin Panel)

Setelah membuka halaman `/admin`, gunakan salah satu kredensial berikut untuk masuk:

### 👑 Owner / Administrator
- **Email**: `admin@keetech.my.id`
- **Password**: `admin123`
- **Hak Akses**: Akses penuh ke seluruh menu (Katalog, Transaksi, Laporan, Manajemen User, dan Pengaturan Toko).

### 📦 Staff Gudang
- **Email**: `staff@keetech.my.id`
- **Password**: `staff123`
- **Hak Akses**: Pengelolaan stok barang dan operasional layanan.

---

## 4. Opsi Database (SQLite vs MySQL)

Saat ini project aktif menggunakan database **SQLite** (`database/database.sqlite`) sehingga aplikasi langsung bisa berjalan seketika tanpa perlu menyalakan service MySQL.

Jika Anda ingin beralih ke **MySQL bawaan Laragon**:
1. Pastikan service MySQL di Laragon sudah aktif (**Start All**).
2. Buat database baru bernama `keehub` via HeidiSQL atau phpMyAdmin.
3. Buka file `.env`, ubah bagian database menjadi:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=keehub
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. Jalankan migrasi dan seeder ke MySQL:
   ```powershell
   & G:\laragon\bin\php\php-8.4.27-Win32-vs17-x64\php.exe artisan migrate --seed
   ```

---

## 5. Mode Pengembangan Frontend (Live Reload)

Jika Anda ingin mengubah tampilan styling (Tailwind CSS) dengan fitur live reload saat coding:
```bash
npm run dev
```
Biarkan perintah ini tetap berjalan di tab terminal terpisah selama proses development.
