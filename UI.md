# 🎨 KeeHub UI/UX Comprehensive Audit & Blueprint Rombak Total

> **Dokumen Audit & Panduan Perombakan Tampilan (UI/UX)**  
> Dibuat untuk evaluasi dan referensi redesign total antarmuka web aplikasi **KeeHub** (Storefront, PC Builder, Portal Pelanggan, dan Admin Panel).

---

## 📌 Daftar Isi
1. [Ringkasan Eksekutif & Karakter Desain Saat Ini](#1-ringkasan-eksekutif--karakter-desain-saat-ini)
2. [Audit Design System & Pondasi Visual](#2-audit-design-system--pondasi-visual)
3. [Audit Halaman Storefront (Katalog & Toko)](#3-audit-halaman-storefront-katalog--toko)
4. [Audit Halaman PC Builder Simulator](#4-audit-halaman-pc-builder-simulator)
5. [Audit Halaman Service Tracker & Pengajuan Servis](#5-audit-halaman-service-tracker--pengajuan-servis)
6. [Audit Portal Akun Pelanggan (Customer Account)](#6-audit-portal-akun-pelanggan-customer-account)
7. [Audit Panel Admin (Filament v3)](#7-audit-panel-admin-filament-v3)
8. [Daftar Masalah Utama (Pain Points) Saat Ini](#8-daftar-masalah-utama-pain-points-saat-ini)
9. [Rekomendasi Konsep & Roadmap "Rombak Total"](#9-rekomendasi-konsep--roadmap-rombak-total)

---

## 1. Ringkasan Eksekutif & Karakter Desain Saat Ini

KeeHub memiliki ekosistem antarmuka yang terbagi menjadi 3 pilar:
1. **Public Storefront & Shop** (E-Commerce suku cadang komputer & PC Rakitan)
2. **PC Builder Simulator** (Tools interaktif pemilihan komponen dengan kalkulator daya & cek kompatibilitas)
3. **Admin Dashboard (Filament v3)** (Manajemen inventory, reparasi/servis B2B, kasir, POS struk thermal, dan invoice)

### Status UI Saat Ini:
* **Kelebihan**:
  * Fitur fungsional sudah sangat lengkap dan terintegrasi (kalkulator watt, filter dinamis, auto-save build, live thermal receipt, infolist servis).
  * Sudah mendukung responsif mobile dengan modal bottom sheet.
  * Mendukung Dark Mode bawaan Tailwind.
* **Kekurangan yang Perlu Dirombak**:
  * **Inkonsistensi Visual**: Storefront publik menggunakan gaya kartu putih standar dengan border tipis, sedangkan admin menggunakan dark slate kustom, dan PC builder memiliki campuran gaya.
  * **Hierarki Tipografi & Kontras Warna**: Banyak elemen kecil yang sebelumnya menggunakan warna terlalu pekat (`text-gray-950 font-bold`) atau terlalu redup (`text-gray-400`), membuat mata cepat lelah.
  * **Density / Kepadatan Layout**: Di beberapa halaman desktop, jarak antar komponen (*whitespace*) terlalu boros, sementara di mobile beberapa bagian sempat terlalu padat.
  * **Visual Polish / Micro-interactions**: Minimnya transisi animasi halus pada status tag, hover state tombol yang belum seragam, dan tampilan badge status yang berbeda-beda antar modul.

---

## 2. Audit Design System & Pondasi Visual

### 2.1 Palet Warna (Color Palette)
* **Warna Aksen Utama (Brand Gold/Amber)**:
  * Variabel: `kee-500` (`#f59e0b` / Amber-500).
  * *Catatan Audit*: Warna amber/emas ini sangat bagus untuk branding toko teknologi premium. Namun, jika teks di atasnya berwarna hitam legam 700 (`#030712`), tampilannya terkesan seperti stiker rambu proyek jalanan. Teks di atas warna emas harus menggunakan warna `text-gray-800` atau `text-slate-900` dengan bobot `font-semibold` agar terkesan mewah.
* **Neutral & Background**:
  * Light Mode: `bg-white` & `bg-gray-50/70`, border `border-gray-100` / `border-gray-200`.
  * Dark Mode: `dark:bg-gray-950` & `dark:bg-gray-900`, border `dark:border-gray-800`.
  * *Catatan Audit*: Diperlukan warna border pembatas yang lebih halus (`border-slate-200/80` di light mode dan `border-white/10` di dark mode) agar transisi kontras lebih modern.
* **Status Colors**:
  * Hijau: `emerald-500` (Ready / Selesai / Stok Ada).
  * Merah: `rose-500` (Batal / Stok Habis).
  * Biru: `blue-500` (Dikerjakan / In Progress).
  * Kuning/Orange: `amber-500` (Pengecekan / Menunggu).

### 2.2 Tipografi
* **Font Family**: Menggunakan system font sans-serif bawaan browser.
* **Rekomendasi Rombak**:
  * Menggunakan font teknologi modern seperti **Plus Jakarta Sans**, **Inter**, atau **Geist Sans**.
  * Standarisasi ukuran:
    * Judul Halaman (H1): `text-2xl sm:text-3xl font-extrabold tracking-tight`
    * Subjudul (H2/H3): `text-lg sm:text-xl font-bold`
    * Body Text: `text-sm sm:text-base leading-relaxed text-gray-600 dark:text-gray-300`
    * Meta/Badges: `text-xs font-semibold`

---

## 3. Audit Halaman Storefront (Katalog & Toko)

### 3.1 Beranda (`/` - `resources/views/shop/index.blade.php`)
* **Kondisi**:
  * Memiliki hero section dengan tombol cepat ke PC Builder dan katalog produk.
  * Menampilkan grid kategori dan produk unggulan.
* **Poin Rombak**:
  * **Hero Section**: Belum memiliki visual visualisasi unit PC gaming/workstation 3D atau foto studio berkualitas tinggi dengan floating badge (misal: *"Garansi Resmi 1 Tahun"*, *"Bisa Rakit Sesuai Budget"*).
  * **Kategori Grid**: Ikon kategori masih teks atau gambar flat standar; bisa diubah menjadi kartu interaktif dengan background glow gradient halus.
  * **Testimonial & Kepercayaan B2B**: Tambahkan section klien B2B / portfolio unit yang pernah dirakit untuk memperkuat reputasi.

### 3.2 Katalog Produk (`/shop` - `shop/listing.blade.php`)
* **Kondisi**:
  * Memiliki sidebar filter (Kategori, Brand, Range Harga).
  * Grid produk responsive (2 kolom di mobile, 3-4 kolom di desktop).
* **Poin Rombak**:
  * **Filter Sidebar di Mobile**: Saat ini menggunakan form collapsible standar. Perlu diubah menjadi slide-over drawer modern dengan indikator jumlah filter aktif (*"Filter (3)"*).
  * **Kartu Produk (`product-card.blade.php`)**:
    * Perbaiki rasio gambar produk agar tidak terdistorsi jika foto vendor berbeda aspek rasio.
    * Tambahkan tombol *"Quick Add to Cart"* atau *"Pilih ke Builder"* langsung dari kartu tanpa harus masuk halaman detail.
    * Tampilkan status stok dalam bentuk dot indicator (*Green Pulse: Ready Stock*).

### 3.3 Detail Produk (`/produk/{slug}` - `shop/detail.blade.php`)
* **Kondisi**:
  * Galeri foto produk, harga, tombol kuantiti, tombol beli, dan tabel spesifikasi teknis.
* **Poin Rombak**:
  * Galeri thumbnail di mobile perlu swipeable carousel (*touch friendly*).
  * Tombol aksi (*Beli Sekarang* & *+ Keranjang*) pada layar smartphone harus dibuat sticky di bagian bawah layar saat pengguna men-scroll membaca spesifikasi panjang.
  * Tabel spesifikasi (*Product Specs*) perlu dibuat model accordion atau tab kategori rapi (misal: *Spesifikasi Utama*, *Daya/Listrik*, *Dimensi & Garansi*).

---

## 4. Audit Halaman PC Builder Simulator

File: `resources/views/builder/index.blade.php` & `share.blade.php`

### 4.1 Bagian Filter & Rekomendasi Cepat (Pill Kebutuhan & Budget)
* **Kondisi**:
  * Pengguna bisa memilih tujuan (*Gaming*, *Office*, *Editing*) dan batas budget (*5jt, 7jt, 10jt, dll.*).
* **Poin Rombak**:
  * Pill tombol pilihan sudah dirapikan agar tidak tebal hitam pekat.
  * **Saran Redesign**: Ubah pill budget menjadi horizontal slider interaktif dengan visual range (misal slider Rp 5.000.000 s/d Rp 50.000.000+) sehingga pengguna bebas menentukan budget kustom tanpa mengetik manual.

### 4.2 Slot Komponen (Processor, Motherboard, GPU, RAM, dll.)
* **Kondisi**:
  * Menampilkan baris slot komponen vertikal dari atas ke bawah.
* **Poin Rombak**:
  * Berikan thumbnail foto mini komponen di sisi kiri nama slot.
  * Saat komponen terpilih: Tampilkan ringkasan singkat spesifikasi kunci (misal RAM: *DDR5 6000MHz 32GB (2x16GB)*) dengan font yang rapi.
  * Indikator Kompatibilitas: Berikan chip hijau *"Kompatibel"* atau kuning *"Perlu Cek BIOS"* di samping komponen yang dipilih.

### 4.3 Modal Picker Komponen (Bottom Sheet)
* **Kondisi**:
  * Di mobile muncul sebagai bottom sheet slide-up dengan search bar dan daftar produk.
* **Poin Rombak**:
  * Tambahkan filter instan per brand (misal saat pilih Processor: tombol filter *AMD* vs *Intel* di bawah kotak search).
  * Tambahkan fitur sort (*Harga Termurah*, *Harga Tertinggi*, *Paling Populer*).
  * Sticky search bar dengan keyboard auto-focus yang nyaman.

### 4.4 Halaman Share Hasil Rakitan (`/pc-builder/build/{token}`)
* **Kondisi**:
  * Tampilan publik untuk dibagikan ke teman/klien melalui WhatsApp atau link.
* **Poin Rombak**:
  * Tambahkan fitur **"Download Gambar / Spec Card (PNG)"** agar pengguna bisa membagikan kartu spesifikasi estetik ke story Instagram / WhatsApp status.
  * Tombol cetak PDF ringkasan spesifikasi untuk penawaran harga cepat (*Instant Quotation*).

---

## 5. Audit Halaman Service Tracker & Pengajuan Servis

File: `resources/views/shop/service-tracker.blade.php`

### 5.1 Pencarian & Pelacakan Status Servis
* **Kondisi**:
  * Pengguna memasukkan No. Servis atau No. WhatsApp untuk mengecek progres perbaikan.
* **Poin Rombak**:
  * Timeline Progres: Ubah tampilan status menjadi stepper visual yang modern (step: *Diterima → Pengecekan → Menunggu Approval → Pengerjaan → QC Test → Siap Diambil*).
  * Tampilkan foto kondisi unit (kondisi saat masuk vs setelah diperbaiki) jika teknisi mengunggah foto.
  * Rincian Estimasi Biaya: Kotak biaya dengan breakdown transparan antara suku cadang dan ongkos jasa.

### 5.2 Formulir Pengajuan Servis Mandiri (`/service/request`)
* **Kondisi**:
  * Form input data diri, nama perangkat, keluhan, dan jenis servis.
* **Poin Rombak**:
  * Buat wizard multi-langkah (*Step 1: Data Perangkat*, *Step 2: Keluhan Masalah*, *Step 3: Kontak & Alamat Pickup/Walk-in*).
  * Tambahkan opsi checklist kendala umum (misal: *PC Mati Total*, *Layar No Display*, *Blue Screen (BSOD)*, *Overheat/Ganti Pasta*).

---

## 6. Audit Portal Akun Pelanggan (Customer Account)

File: `resources/views/account/*`

* **Dashboard Akun**:
  * Saat ini: Ringkasan sederhana pesanan dan rakitan tersimpan.
  * **Rencana Rombak**: Buat antarmuka ala SaaS/Dashboard modern dengan kartu stat (*Pesanan Aktif*, *Servis Berjalan*, *Build Tersimpan*).
* **Riwayat Pesanan & Detail Order**:
  * Tampilkan status kurir pengiriman (resi JNE/J&T/Sicepat) dengan tombol *Lacak Paket Langsung*.
  * Tombol cetak Invoice belanja resmi KeeHub format PDF.

---

## 7. Audit Panel Admin (Filament v3)

File: `app/Filament/*` & `resources/views/filament/*`

### 7.1 Header & Sidebar
* **Kondisi**:
  * Sudah diperbaiki dengan logo KeeHub kontras tinggi, badge admin warna emas, dan tombol mobile collapse.
* **Poin Rombak Lanjutan**:
  * Buat opsi minimize sidebar icon-only yang lebih smooth di desktop.
  * Berikan breadcrumbs navigasi yang lebih jelas pada halaman form edit/view yang bertingkat.

### 7.2 Halaman Servis (`/admin/services` & `/admin/services/{id}`)
* **Kondisi**:
  * Table sudah responsif tanpa scrollbar horizontal di smartphone.
  * Halaman View dan Edit sudah 2 kolom compact.
* **Poin Rombak Lanjutan**:
  * Kanban View: Buat alternatif tampilan Kanban board (drag-and-drop kolom berdasarkan status servis) di desktop agar teknisi mudah menggeser status servis dari *"Dikerjakan"* ke *"QC Test"*.
  * Integrasi Cetak Struk Thermal: Tombol cetak struk Bluetooth sudah siap, tambahkan opsi cetak barcode label stiker kecil untuk ditempel langsung di casing PC/laptop klien.

---

## 8. Daftar Masalah Utama (Pain Points) Saat Ini

| Area | Masalah Saat Ini | Efek Pengguna | Solusi Rombak |
|---|---|---|---|
| **Branding & Look** | Kurang nuansa "High-End Computer Store" | Kesan web seperti toko template biasa | Gunakan tema *Cyber-Clean Minimalist* (Dark Slate, Aksen Emas KeeHub, Glassmorphism halus, tipografi tajam). |
| **PC Builder Mobile** | Banyak scroll vertikal saat memilih 8-10 komponen | Cepat lelah scroll naik-turun | Buat stepper kategori atau horizontal component bar. |
| **Pencarian Produk** | Belum ada filter instan per chipset/socket | Sulit mencari motherboard/RAM yang pas | Tambahkan filter socket (AM4, AM5, LGA1700) di drawer filter. |
| **Aksi Tombol Mobile** | Tombol CTA sering berada di luar jangkauan jempol | Sulit checkout saat satu tangan | Sticky bottom action bar dengan safe area padding iPhone/Android. |
| **Foto Produk** | Background foto produk bervariasi | Toko terlihat kurang seragam | Gunakan auto background badge atau template kartu produk berbingkai estetik. |

---

## 9. Rekomendasi Konsep & Roadmap "Rombak Total"

### Tahap 1: Pondasi & Design System Global (Token CSS)
1. Pasang font **Plus Jakarta Sans** atau **Inter** via Google Fonts / Fontsource.
2. Definisikan standar class kartu, tombol, badge, dan modal di `resources/css/app.css`:
   * `.keehub-card` (Rounded-2xl, subtle border, shadow halus).
   * `.keehub-btn-primary` (Amber glow, smooth hover transform).
   * `.keehub-badge` (Status badge dengan dot indicator).

### Tahap 2: Rombak Total Toko Publik (Storefront)
1. **Header / Navbar**: Navbar semi-transparan (*backdrop blur*) dengan icon keranjang interaktif dan search overlay cepat.
2. **Katalog & Kartu Produk**: Kartu produk dengan rasio gambar 1:1, badge garansi resmi, dan tombol aksi cepat.
3. **Checkout Flow**: Checkout satu halaman (*One-Page Checkout*) yang bersih, ringkas, dan jelas.

### Tahap 3: Rombak Total PC Builder
1. **Interactive Visual Rig**: Preview visual susunan casing PC sederhana yang terisi saat part dipilih.
2. **Smart Compatibility Matrix**: Alert cerdas saat part dipilih (misal: "PSU 550W kurang disarankan untuk RTX 4070, disarankan 650W+").
3. **Mobile Bottom Sheet Super Cepat**: Modal pemilihan komponen dengan search instan Alpine.js tanpa refresh halaman.

### Tahap 4: Rombak Tracking & Portal Servis
1. Stepper tracking visual dengan estimasi tanggal selesai.
2. Tombol langsung chat WhatsApp teknisi penanggung jawab servis.

---
*Dokumen ini dapat digunakan sebagai acuan kerja per sesi saat mulai merombak halaman demi halaman.*
