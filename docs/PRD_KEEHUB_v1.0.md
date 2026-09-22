# PRD — KEEHUB
## PC Parts Store, PC Builder & IT Service Platform

**Version:** 1.0  
**Status:** Final Draft / Scope Locked  
**Platform:** Responsive Web / PWA Ready  
**Target:** Desktop & Mobile

---

# 1. PRODUCT OVERVIEW

## 1.1 Nama Produk

**KeeHub**

## 1.2 Positioning

KeeHub adalah platform toko komputer dan layanan IT yang menggabungkan:

- Penjualan PC Parts
- PC Builder
- Compatibility Checker
- PC Rakitan
- Jasa Rakit PC
- IT Service
- Inventory
- Quotation
- Invoice
- Payment Tracking
- Manual Shipping & Resi
- Customer Management
- Social Media Integration

KeeHub bukan hanya ecommerce, tetapi menjadi **digital platform untuk operasional toko PC dan IT Service**.

## 1.3 Brand Positioning

> **KeeHub — Build. Buy. Upgrade.**

---

# 2. PRODUCT GOALS

## Primary Goals

1. Menjual PC Parts secara online.
2. Membantu customer memilih komponen yang kompatibel.
3. Membantu customer membuat konfigurasi PC sesuai budget.
4. Menyediakan jasa rakit PC.
5. Menyediakan layanan IT Service.
6. Mempermudah pembuatan quotation dan invoice.
7. Mengelola stok toko.
8. Mengelola order dan pengiriman.
9. Mengelola data customer dan riwayat transaksi.
10. Menghubungkan website dengan Instagram, TikTok, dan WhatsApp.

## Business Goals

- Meningkatkan penjualan.
- Mengurangi pekerjaan administrasi manual.
- Meningkatkan kepercayaan customer.
- Membuat proses jual → rakit → QC → kirim lebih terstruktur.
- Menjadi pusat informasi produk dan layanan KeeHub.

---

# 3. TARGET USER

## 3.1 Customer

Customer yang ingin:

- Membeli komponen PC.
- Merakit PC.
- Upgrade PC.
- Meminta rekomendasi PC.
- Konsultasi build.
- Service PC.
- Melacak order.
- Mendapatkan invoice.
- Melihat riwayat transaksi.

## 3.2 Owner / Admin

Bertugas:

- Mengelola produk.
- Mengelola order.
- Mengelola customer.
- Mengelola invoice.
- Mengelola pembayaran.
- Mengelola pengiriman.
- Mengelola quotation.
- Melihat dashboard dan laporan.

## 3.3 Staff / Warehouse

Bertugas:

- Mengelola stok.
- Stock opname.
- Barang masuk.
- Barang keluar.
- Persiapan order.

## 3.4 Technician

Bertugas:

- Service.
- Rakit PC.
- Diagnosis.
- Testing.
- QC.

---

# 4. MVP SCOPE LOCK

MVP harus fokus pada **PC Parts Store + PC Builder + Order + Invoice + Payment Tracking + Inventory Basic + PC Assembly/Service + Quotation**.

## WAJIB ADA DI MVP

- Authentication
- Product Catalog
- Category
- Brand
- Search
- Cart
- Checkout
- Order
- Invoice
- Manual Payment
- Manual Shipping / Resi
- Basic Inventory
- Customer Management
- PC Builder
- Basic Compatibility Checker
- Power Calculator
- Service / Rakit PC
- Customer-Owned Components
- QC Checklist
- Quotation
- Admin Dashboard
- WhatsApp CTA
- Instagram Link
- TikTok Link
- Basic RBAC
- Activity Log

## TIDAK MASUK MVP

Fitur berikut masuk backlog V2/V3:

- Payment Gateway
- Courier API
- Automatic Tracking API
- Advanced Supplier/Purchase Management
- Serial Number Management
- Warranty/RMA Automation
- Loyalty Program
- Referral
- Affiliate
- Public Build Community
- Advanced Review System
- AI PC Recommendation
- AI Chatbot
- Instagram API
- TikTok API
- Advanced Analytics
- Multi Store
- Multi Warehouse
- Accounting
- Payroll
- Marketplace Integration
- Native Mobile App

**Scope Lock Rule:** jika fitur baru muncul selama development dan tidak ada di daftar MVP, masukkan ke backlog V2/V3. Jangan menambah scope MVP tanpa keputusan khusus.

---

# 5. WEBSITE STRUCTURE

## Public Website

```text
/
├── Home
├── Shop
│   ├── Categories
│   ├── Products
│   └── Product Detail
├── PC Builder
├── PC Rakitan
├── Service
├── Promo
├── About
├── Contact
├── FAQ
├── Cart
├── Checkout
├── Login
└── Register
```

## Customer Area

```text
/account
├── Dashboard
├── Profile
├── Orders
├── Invoices
├── PC Builds
├── Service
└── Addresses
```

## Admin Area

```text
/admin
├── Dashboard
├── Products
├── Categories
├── Brands
├── Inventory
├── Orders
├── Quotations
├── Invoices
├── Payments
├── Shipping
├── PC Builder
├── Service
├── QC
├── Customers
├── Reports
├── Users
└── Settings
```

---

# 6. HOMEPAGE

Homepage harus modern, clean, tech-oriented, responsive, dan mobile-first.

## Hero

Headline:

> **Build Your PC. Your Way.**

Subheadline:

> Temukan komponen PC, buat PC rakitan sesuai budget, dan dapatkan bantuan dari tim KeeHub.

CTA:

- **Mulai PC Builder**
- **Belanja Part**

## Category Section

- CPU
- Motherboard
- GPU
- RAM
- SSD
- HDD
- PSU
- Casing
- CPU Cooler
- Monitor
- Keyboard
- Mouse
- Networking

## Product Section

- Best Seller
- Produk Terbaru
- Promo
- Recommended

## PC Builder CTA

> **Bingung memilih komponen?**

Masukkan budget dan kebutuhanmu.

**[ Buat Build PC ]**

## Service CTA

> **Punya PC bermasalah?**

**[ Request Service ]**

## Social Media

Tampilkan:

- Instagram
- TikTok
- PC Build
- Unboxing
- Benchmark
- Tips Hardware
- Promo
- Service
- Customer Build

Link social media harus dapat diedit dari admin settings.

---

# 7. SHOP / ECOMMERCE

## Product Listing

Fitur:

- Search
- Filter
- Sorting
- Pagination
- Category
- Brand
- Price range
- Availability
- Specification filter

## Product Card

Menampilkan:

- Product image
- Product name
- Brand
- Price
- Stock status
- Badge
- Add to Cart
- Wishlist (opsional MVP)

Badge:

- BEST SELLER
- NEW
- PROMO
- LOW STOCK
- OUT OF STOCK

---

# 8. PRODUCT DETAIL

Informasi:

- Product image gallery
- Product name
- SKU
- Brand
- Price
- Stock
- Description
- Specification
- Warranty information jika tersedia
- Weight
- Dimensions

CTA:

- **Add to Cart**
- **Buy Now**
- **Ask via WhatsApp**

## Compatibility Information

Jika produk adalah komponen PC, tampilkan informasi compatibility yang tersedia dari database.

Contoh:

```text
CPU Socket: AM4
Recommended PSU: 550W+
```

Compatibility tidak boleh hanya berdasarkan teks deskripsi; data teknis harus memiliki field terstruktur jika digunakan oleh PC Builder.

---

# 9. PC BUILDER

PC Builder adalah fitur utama KeeHub.

## Step 1 — Purpose

Customer memilih:

- Gaming
- Office
- Programming
- Editing
- Streaming
- Design
- AI
- Server

## Step 2 — Budget

Contoh:

- Rp5 juta
- Rp7 juta
- Rp10 juta
- Rp15 juta
- Custom

## Step 3 — Components

Customer memilih:

- CPU
- Motherboard
- RAM
- GPU
- Storage
- PSU
- Case
- Cooler

## Build Summary

```text
CPU             Rp...
Motherboard     Rp...
RAM             Rp...
GPU             Rp...
Storage         Rp...
PSU             Rp...
Case            Rp...
Cooler          Rp...

TOTAL           Rp...
```

## Build Status

- Compatible
- Warning
- Incompatible

---

# 10. BASIC COMPATIBILITY ENGINE

Compatibility MVP harus sederhana, deterministik, dan berbasis data produk.

## CPU ↔ Motherboard

Validasi:

- Socket

## RAM ↔ Motherboard

Validasi:

- DDR generation
- Maximum capacity
- Supported frequency

## Motherboard ↔ Case

Validasi:

- Form factor

## GPU ↔ Case

Validasi:

- GPU length
- Case GPU clearance

## CPU Cooler ↔ Case

Validasi:

- Cooler height
- Case clearance

## GPU ↔ PSU

Validasi:

- Recommended PSU wattage

## Rule Result

```text
COMPATIBLE
WARNING
INCOMPATIBLE
```

## MVP Limitation

Tidak perlu membuat compatibility engine super-kompleks.

Tidak wajib memvalidasi seluruh detail BIOS, chipset revision, RAM QVL, PCIe lane allocation, clearance kabel, atau detail teknis ekstrem pada MVP.

---

# 11. POWER CALCULATOR

Sistem menghitung estimasi konsumsi daya.

Contoh:

```text
CPU           65W
GPU          115W
Motherboard   50W
RAM           10W
SSD            5W
Fans          15W
------------------
Estimated    260W
```

Recommendation:

```text
Recommended PSU: 550W
```

Perhitungan harus menggunakan nilai TDP/power yang tersedia pada data komponen dan diberi margin keamanan.

---

# 12. BUILD MANAGEMENT

Customer dapat:

- Menyimpan build.
- Mengedit build.
- Menghapus build.
- Menambahkan build ke cart.
- Membagikan build.

Contoh:

```text
BUILD #PCB-20260903-001
```

Build dapat memiliki share URL publik/read-only.

---

# 13. REQUEST CUSTOM BUILD

Customer dapat meminta bantuan KeeHub.

Form:

- Nama
- WhatsApp
- Budget
- Kebutuhan
- Game/software
- Resolusi monitor
- Komponen yang sudah dimiliki
- Catatan

Admin menerima request dan dapat membuat quotation berdasarkan request tersebut.

---

# 14. PC RAKITAN

Halaman khusus PC build siap beli.

Kategori:

- Gaming PC
- Office PC
- Editing PC
- Streaming PC
- Budget PC
- High-End PC

Setiap build menampilkan:

- CPU
- GPU
- RAM
- Storage
- PSU
- Case
- Total price
- Performance description

CTA:

- **Beli Build**
- **Customize Build**

---

# 15. SERVICE MANAGEMENT

Service dapat berasal dari:

1. Customer online.
2. Customer datang langsung.
3. WhatsApp.
4. Admin membuat service order manual.

## Service Types

- Rakit PC
- Upgrade PC
- Cleaning
- Thermal Paste
- Install Windows
- Driver Installation
- Troubleshooting
- Hardware Checking
- Cable Management
- Data/Storage Service
- Other

## Service Status

```text
Received
↓
Checking
↓
Waiting Approval
↓
Processing
↓
Testing
↓
Ready
↓
Completed
```

---

# 16. CUSTOMER-OWNED COMPONENTS

Customer dapat membawa komponen sendiri.

Contoh:

```text
CPU: Ryzen 5 5600
Motherboard: B550M
RAM: 16GB
GPU: RTX 4060
```

Sistem mencatat komponen sebagai:

> **CUSTOMER OWNED**

Customer-owned components:

- Tidak masuk inventory penjualan.
- Tidak mengurangi stock produk toko.
- Dapat dicatat sebagai bagian dari service order.
- Hanya jasa/biaya tambahan yang ditagihkan.

---

# 17. QC / TESTING

Setelah PC selesai dirakit atau service selesai, technician mengisi QC.

## Hardware

- CPU detected
- RAM detected
- SSD detected
- GPU detected
- USB
- LAN
- WiFi
- Audio
- Display

## Software

- BIOS
- Windows
- Driver
- Update

## Testing

- CPU stress test
- GPU stress test
- RAM test
- Storage health

## Result

```text
QC RESULT: PASS
```

Data QC:

- Technician
- Date
- Checklist result
- Notes
- Overall result

Benchmark otomatis tidak wajib pada MVP.

---

# 18. QUOTATION

Quotation digunakan sebelum customer melakukan order.

Contoh:

```text
QT-2026-001

Customer:
Budi

Ryzen 5 5600        Rp...
B550M               Rp...
RTX 4060            Rp...
RAM 16GB            Rp...
SSD 1TB             Rp...
PSU 550W            Rp...
Case                Rp...
Jasa Rakit          Rp...

TOTAL               Rp...
```

Quotation memiliki:

- Nomor
- Customer
- Tanggal
- Expired date
- Items
- Discount
- Shipping
- Notes
- Terms

Status:

- Draft
- Sent
- Accepted
- Rejected
- Expired
- Converted

Quotation dapat:

- Preview
- Print
- Download PDF
- Dikirim melalui WhatsApp

## Convert

Quotation:

```text
Quotation
↓
Order
↓
Invoice
```

---

# 19. ORDER MANAGEMENT

Order dapat berasal dari:

- Website
- Admin manual
- WhatsApp
- Offline store

## Order Type

```text
PRODUCT
PC BUILD
SERVICE
PRODUCT + SERVICE
```

## Order Status

```text
Pending
Confirmed
Processing
Ready
Shipped
Completed
Cancelled
```

Setiap perubahan status penting harus disimpan dalam history.

---

# 20. INVOICE

Invoice otomatis dibuat berdasarkan order.

Invoice berisi:

```text
KEEHUB
PC PARTS • PC BUILDER • IT SERVICE

INVOICE
INV-20260903-001

Customer:
Budi

Items:
Ryzen 5 5600
A520M
RAM 16GB
RTX 4060
SSD 1TB
PSU 550W
Case
Jasa Rakit

Subtotal       Rp...
Discount       Rp...
Shipping       Rp...
TOTAL          Rp...

Payment:
TRANSFER

STATUS:
PAID
```

Invoice dapat:

- View
- Download PDF
- Print
- Send via WhatsApp

Invoice tidak boleh dihapus permanen setelah transaksi/payment tercatat. Gunakan status cancelled/void bila diperlukan.

---

# 21. PAYMENT

## Payment Method

- Cash
- Bank Transfer
- QRIS
- E-Wallet
- Debit
- Credit
- Other

## MVP

Pembayaran dicatat **manual oleh admin**.

Tidak menggunakan:

- Midtrans
- Xendit
- Stripe
- Payment gateway lainnya

## Payment Status

- Unpaid
- Partial
- Paid
- Refunded

## DP / Partial Payment

Contoh:

```text
Total       Rp8.000.000
DP          Rp3.000.000
Remaining   Rp5.000.000
```

Sistem harus menyimpan payment history.

---

# 22. SHIPPING

Shipping dibuat manual pada MVP.

Admin mengisi:

- Courier
- Tracking number
- Shipping cost
- Shipping date
- Notes

Courier:

- JNE
- J&T
- SiCepat
- AnterAja
- Pos
- Cargo
- Local Courier
- Custom

Status:

```text
Preparing
Shipped
In Transit
Delivered
```

## Pickup

Pilihan:

> Pickup at Store

Pickup tidak membutuhkan resi.

Tidak ada courier API atau automatic tracking pada MVP.

---

# 23. INVENTORY

Inventory MVP mendukung:

- Current Stock
- Minimum Stock
- Stock In
- Stock Out
- Adjustment
- Stock Opname
- Stock Alert
- Stock History

Setiap stock movement:

```text
Product
Quantity
Type
Reference
User
Date
Notes
```

## Stock Rule

Order yang sudah dikonfirmasi/processed sesuai business rule akan mengurangi stock.

Cancelled order yang sebelumnya mengurangi stock harus memiliki mekanisme reversal.

Customer-owned component tidak pernah mengurangi stock toko.

---

# 24. CUSTOMER MANAGEMENT

Customer data:

- Name
- WhatsApp
- Email
- Password
- Address
- Orders
- Builds
- Services
- Invoices

Customer dapat melihat:

- Riwayat order
- Invoice
- Build tersimpan
- Service status

---

# 25. WHATSAPP

WhatsApp digunakan sebagai channel komunikasi utama.

MVP menggunakan link `wa.me`, bukan WhatsApp API.

CTA:

- Chat via WhatsApp
- Ask Product
- Request Build
- Consultation
- Send Invoice
- Service Notification

Contoh pesan:

> Halo KeeHub, saya ingin menanyakan produk Ryzen 5 5600.

Link WhatsApp dapat dibuat dari template message.

---

# 26. SOCIAL MEDIA

## Instagram

MVP:

- Profile link
- Instagram CTA
- Social section

## TikTok

MVP:

- Profile link
- TikTok CTA
- Social section

Username/link social media dapat diedit melalui:

```text
Admin → Settings → Social Media
```

Tidak menggunakan Instagram API atau TikTok API pada MVP.

---

# 27. DASHBOARD

## Owner/Admin Dashboard

Metrics:

```text
Sales Today
Orders Today
Service Today
Build Requests
Low Stock
```

Sections:

- Recent Orders
- Recent Service
- Low Stock
- Recent Quotations

Dashboard MVP tidak membutuhkan analytics kompleks, forecasting, atau CFO dashboard.

---

# 28. REPORTS

MVP report:

## Sales

- Daily
- Weekly
- Monthly
- Custom

## Product

- Best seller
- Low stock
- Stock value

## Service

- Service count
- Service revenue
- Service type

## Export

- Excel
- PDF

Advanced financial accounting tidak termasuk MVP.

---

# 29. USER & ROLE

MVP menggunakan role sederhana:

## OWNER / ADMIN

Full access.

## STAFF

Akses terbatas:

- Orders
- Customers
- Inventory
- Service
- QC

Tidak perlu fine-grained permission matrix pada MVP kecuali memang diperlukan saat implementasi.

---

# 30. DATABASE CORE

Database MVP yang disarankan:

```text
users
customers
customer_addresses

categories
brands
products
product_images
product_specs

inventory
stock_movements

pc_builds
pc_build_items
compatibility_rules

orders
order_items

quotations
quotation_items

invoices
invoice_items
payments

shipments

services
service_items
service_status_history

qc_records
qc_checklist

notifications
settings
activity_logs
```

Target awal sekitar **25–30 tabel**, tetapi jumlah final boleh berubah berdasarkan normalisasi database saat implementasi.

---

# 31. CORE RELATIONSHIPS

## Product Order

```text
Customer
↓
Order
↓
Order Items
↓
Invoice
↓
Payment
↓
Shipment
```

## PC Build

```text
Customer
↓
PC Build
↓
Components
↓
Order
↓
Invoice
↓
Assembly
↓
QC
↓
Shipment / Pickup
```

## Service

```text
Customer
↓
Service Order
↓
Checking
↓
Quotation / Approval
↓
Processing
↓
Testing
↓
Invoice
↓
Payment
↓
Completed
```

---

# 32. PRODUCT SPECIFICATION

Produk PC harus memiliki specification fields terstruktur.

## CPU

```text
Socket
Core
Thread
Base Clock
Boost Clock
TDP
Architecture
Integrated Graphics
```

## GPU

```text
VRAM
Memory Type
Power Consumption
Length
Recommended PSU
Interface
```

## Motherboard

```text
Socket
Chipset
RAM Type
RAM Slots
Maximum RAM
M.2 Slots
PCIe
Form Factor
```

## RAM

```text
Generation
Capacity
Frequency
CAS Latency
Module Count
```

## PSU

```text
Wattage
Efficiency
Certification
Modular
Form Factor
```

Specification yang dibutuhkan compatibility engine harus disimpan dalam format terstruktur, bukan hanya deskripsi bebas.

---

# 33. SEO

Setiap product/category/build memiliki:

- SEO title
- Meta description
- Slug
- Keywords
- Structured product data jika diperlukan

Contoh:

```text
/produk/amd-ryzen-5-5600
/shop/processor
/pc-builder/build/ryzen-5-5600-rtx-4060
```

---

# 34. RESPONSIVE DESIGN

## Desktop

- Sidebar/filter
- Product grid
- PC Builder workspace
- Admin sidebar

## Tablet

- Adaptive grid
- Collapsible filters

## Mobile

Bottom navigation:

```text
Home
Shop
Builder
Service
Account
```

Cart harus tetap mudah diakses.

---

# 35. UI / UX DIRECTION

Visual:

**Modern Tech Store**

Karakter:

- Clean
- Modern
- Dark/light compatible
- Rounded cards
- Smooth animation
- Responsive
- Mobile-first
- Professional
- Tidak terlalu RGB/norak

PC Builder harus terasa seperti aplikasi modern, bukan sekadar form panjang.

---

# 36. PWA READY

Website dipersiapkan untuk:

- Installable
- App icon
- Splash screen
- Responsive
- Basic offline support

Transaksi tidak harus offline.

Offline cache hanya untuk UI shell dan data yang aman untuk di-cache.

---

# 37. SECURITY

Minimal:

- Password hashing
- CSRF protection
- XSS protection
- SQL injection protection
- PDO prepared statements
- Session security
- Authorization/RBAC
- Input validation
- File upload validation
- Rate limiting pada endpoint penting
- Activity log
- Secure authentication

Admin area harus selalu melakukan authorization check di server-side.

---

# 38. BACKEND & TECH STACK

> **REVISI v1.0.1:** Stack backend diubah dari "PHP 8+ Native OOP MVC" menjadi Laravel. Keputusan revisi stack: scope fitur, database, business rules, dan phases tidak berubah.

## Backend

**Laravel 12+ (PHP 8.4)**

Menggunakan:

- Laravel Breeze (Blade) untuk authentication storefront & customer
- Laravel Eloquent / Query Builder (PDO + Prepared Statements)
- MVC + Service Layer (`app/Services/`) + Form Request validation
- Middleware + Gate/Policy untuk RBAC
- Filament 3 untuk area `/admin` (dashboard, CRUD, tabel, export)
- REST-style internal endpoints (fetch JSON untuk PC Builder)
- Rate limiting bawaan Laravel pada endpoint penting

## Database

**MySQL / MariaDB (InnoDB, utf8mb4)**

## Frontend

**Tailwind CSS**

JavaScript:

- Alpine.js
- Fetch/AJAX
- Blade templates (storefront & account area: Blade + Alpine, bukan SPA)
- Area admin: Filament 3 (Livewire di internal admin)

## Libraries

- filament/filament — admin panel
- barryvdh/laravel-dompdf — PDF invoice/quotation
- maatwebsite/excel — export Excel (PhpSpreadsheet)
- simplesoftwareio/simple-qrcode — QR generation (wa.me / QRIS statis)
- intervention/image — optimasi gambar produk (WebP + thumbnail)
- spatie/laravel-activitylog — activity log

---

# 39. PROJECT STRUCTURE

```text
keehub/
│
├── app/
│   ├── config/
│   ├── controllers/
│   ├── models/
│   ├── services/
│   ├── repositories/
│   ├── middleware/
│   ├── helpers/
│   └── routes/
│
├── public/
│   ├── assets/
│   ├── uploads/
│   └── index.php
│
├── views/
│   ├── customer/
│   ├── shop/
│   ├── builder/
│   ├── service/
│   └── admin/
│
├── storage/
│   ├── invoices/
│   ├── quotations/
│   └── logs/
│
└── database/
    ├── migrations/
    └── seeders/
```

---

# 40. DEVELOPMENT PHASES

## PHASE 1 — FOUNDATION

- Authentication
- User roles
- Database
- Product
- Category
- Brand
- Customer
- Admin dashboard

## PHASE 2 — ECOMMERCE

- Shop
- Product detail
- Cart
- Checkout
- Order
- Manual payment
- Invoice
- Manual shipping/resi

## PHASE 3 — INVENTORY

- Stock
- Stock movement
- Stock opname
- Stock alert

## PHASE 4 — PC BUILDER

- Build creation
- Component selection
- Compatibility
- Power calculation
- Save build
- Share build

## PHASE 5 — SERVICE

- Service order
- Technician
- Diagnosis
- Repair
- PC assembly
- QC

## PHASE 6 — QUOTATION & BUSINESS

- Quotation
- Convert quotation to order
- Reports
- Business rules

## PHASE 7 — MARKETING

- WhatsApp
- Instagram
- TikTok
- SEO

---

# 41. MVP PRIORITY

## P0 — CORE

- Authentication
- Product
- Category
- Brand
- Search
- Cart
- Checkout
- Order
- Invoice
- Manual Payment
- Manual Resi
- Basic Inventory
- Customer
- Admin Dashboard

## P0 — UNIQUE VALUE

- PC Builder
- Basic Compatibility
- Power Calculator
- Service / Rakit
- Customer-Owned Components
- Quotation
- QC

## P1 — SUPPORTING

- WhatsApp
- Instagram
- TikTok
- Basic Reports
- Activity Log

---

# 42. OUT OF MVP / V2-V3 BACKLOG

## V2

- Payment Gateway
- Courier API
- Automatic Tracking
- Supplier Management
- Purchase Order
- Serial Number
- Warranty
- RMA
- Promotion/Voucher
- Review
- Advanced RBAC

## V3

- AI PC Recommendation
- AI Sales Assistant
- AI Service Assistant
- Public Build Community
- Loyalty
- Referral
- Affiliate
- Marketplace Integration
- Multi Store
- Multi Warehouse
- Accounting Integration
- Native Mobile App
- Advanced Analytics

---

# 43. CORE BUSINESS FLOW

## Scenario A — Customer Buy Part

```text
Browse
↓
Product
↓
Cart
↓
Checkout
↓
Payment
↓
Invoice
↓
Packing
↓
Shipping
↓
Resi
↓
Delivered
↓
Completed
```

## Scenario B — Customer Buy + Rakit

```text
PC Builder
↓
Select Components
↓
Compatibility Check
↓
Add Build
↓
Checkout
↓
Payment / DP
↓
Assembly
↓
QC
↓
Packing
↓
Shipping / Pickup
↓
Completed
```

## Scenario C — Customer Bawa Part Sendiri

```text
Service Request
↓
Receive Components
↓
Checking
↓
Quotation
↓
Customer Approval
↓
Assembly
↓
QC
↓
Invoice
↓
Payment
↓
Pickup / Shipping
↓
Completed
```

## Scenario D — Custom PC

```text
Custom Build Request
↓
Admin Review
↓
PC Build
↓
Quotation
↓
Customer Approval
↓
Order
↓
DP
↓
Procurement / Stock Allocation
↓
Assembly
↓
QC
↓
Pelunasan
↓
Shipping / Pickup
```

---

# 44. IMPORTANT BUSINESS RULES

1. Customer-owned components tidak masuk inventory penjualan.
2. Barang toko yang digunakan dalam order mengurangi stock sesuai status bisnis yang ditentukan.
3. Cancelled order yang sudah mengurangi stock wajib melakukan stock reversal.
4. Partial payment menyimpan seluruh payment history.
5. Invoice tidak dihapus permanen setelah payment tercatat.
6. Quotation dapat dikonversi menjadi order.
7. Service dapat memiliki item tambahan.
8. PC rakitan memiliki QC record.
9. Satu order dapat memiliki produk + jasa rakit.
10. Invoice dapat mencakup product, service, shipping, discount, dan payment.
11. Manual resi dapat ditambahkan setelah order diproses.
12. Admin dapat membuat order manual.
13. Perubahan penting dicatat dalam activity log.
14. Compatibility rule dapat dikelola dari admin.
15. Harga jual dan HPP dipisahkan.
16. Customer dapat membeli produk tanpa membuat PC Build.
17. Customer dapat meminta jasa rakit tanpa membeli produk toko.
18. Semua status order/service memiliki history.
19. Data customer-owned component harus dibedakan jelas dari inventory toko.
20. Status pembayaran harus dihitung berdasarkan total payment yang tercatat, bukan hanya satu transaksi.

---

# 45. DEFINITION OF DONE — V1

KeeHub V1 dianggap selesai apabila:

- Customer dapat register/login.
- Admin dapat mengelola produk.
- Customer dapat mencari produk.
- Customer dapat memasukkan produk ke cart.
- Customer dapat checkout.
- Admin dapat membuat order manual.
- Sistem dapat membuat invoice.
- Sistem dapat mencatat payment.
- Sistem mendukung DP/partial payment.
- Admin dapat menambahkan resi manual.
- Customer dapat melihat status order.
- Admin dapat mengelola stock.
- Customer dapat membuat PC Build.
- Sistem dapat mengecek compatibility dasar.
- Sistem dapat menghitung estimasi power.
- Customer dapat request jasa rakit/service.
- Customer-owned components dapat dicatat.
- Admin dapat membuat quotation.
- Quotation dapat dikonversi menjadi order.
- Technician dapat melakukan QC.
- Dashboard menampilkan statistik utama.
- Invoice dapat dicetak / PDF.
- WhatsApp CTA tersedia.
- Instagram/TikTok link dapat diubah dari settings.
- Website responsive di desktop dan mobile.
- Basic RBAC berjalan.
- Activity log berjalan.
- Security dasar diterapkan.

---

# 46. ACCEPTANCE CRITERIA UTAMA

## Ecommerce

**Given** customer memiliki produk yang stoknya tersedia  
**When** customer checkout  
**Then** order berhasil dibuat dan invoice dapat dibuat.

## Inventory

**Given** order yang valid menggunakan produk toko  
**When** order diproses sesuai stock rule  
**Then** stock berkurang dan stock movement tercatat.

## PC Builder

**Given** customer memilih CPU dan motherboard  
**When** socket berbeda  
**Then** sistem menampilkan `INCOMPATIBLE`.

## PC Builder RAM

**Given** motherboard DDR4  
**When** customer memilih RAM DDR5  
**Then** sistem menampilkan `INCOMPATIBLE`.

## Case

**Given** motherboard Micro ATX  
**When** case tidak mendukung Micro ATX  
**Then** sistem menampilkan `INCOMPATIBLE`.

## PSU

**Given** estimasi kebutuhan sistem 300W  
**When** PSU yang dipilih hanya 250W  
**Then** sistem menampilkan warning/incompatible berdasarkan threshold rule.

## Quotation

**Given** quotation berstatus Draft  
**When** admin mengirim quotation  
**Then** status berubah menjadi Sent.

**Given** quotation Accepted  
**When** admin memilih Convert  
**Then** sistem membuat order yang mereferensikan quotation.

## Payment

**Given** invoice Rp8.000.000  
**When** customer membayar Rp3.000.000  
**Then** invoice berstatus Partial dan remaining balance Rp5.000.000.

## QC

**Given** PC selesai dirakit  
**When** technician mengisi seluruh checklist dan hasil PASS  
**Then** QC record tersimpan dengan status PASS.

## Customer-Owned

**Given** customer membawa GPU sendiri  
**When** service order dibuat  
**Then** GPU ditandai Customer Owned dan tidak mengurangi inventory.

---

# 47. NON-FUNCTIONAL REQUIREMENTS

## Performance

- Halaman utama harus ringan.
- Query database menggunakan indexing yang sesuai.
- Gunakan pagination untuk data besar.
- Hindari N+1 query.
- Image produk menggunakan optimized image.
- Asset production diminify/minify bila memungkinkan.

## Responsive

Wajib berjalan baik pada:

- Desktop
- Laptop
- Tablet
- Mobile

## Maintainability

- MVC jelas.
- Business logic tidak ditaruh langsung di view.
- Database query terisolasi.
- Reusable service/helper digunakan.
- Naming convention konsisten.
- Error handling terstruktur.

## Security

Semua input dari user dianggap tidak terpercaya.

---

# 48. FINAL NAVIGATION — CUSTOMER

```text
KEEHUB

HOME

SHOP
 ├── CPU
 ├── GPU
 ├── Motherboard
 ├── RAM
 ├── Storage
 ├── PSU
 ├── Case
 ├── Cooler
 ├── Monitor
 └── Accessories

PC BUILDER

PC RAKITAN

SERVICE

PROMO

ABOUT

CONTACT

────────────────

ACCOUNT
ORDERS
INVOICES
PC BUILDS

────────────────

INSTAGRAM
TIKTOK
WHATSAPP
```

---

# 49. FINAL NAVIGATION — ADMIN

```text
DASHBOARD

SALES
 ├── Orders
 ├── Quotations
 ├── Invoices
 ├── Payments
 └── Shipping

CATALOG
 ├── Products
 ├── Categories
 ├── Brands
 └── Specifications

PC BUILDER
 ├── Builds
 ├── Components
 └── Compatibility Rules

INVENTORY
 ├── Stock
 ├── Stock Movement
 └── Stock Opname

SERVICE
 ├── Service Orders
 ├── Assembly
 └── QC

CUSTOMER
 └── Customers

REPORTS
 ├── Sales
 ├── Products
 ├── Inventory
 └── Service

SYSTEM
 ├── Users
 ├── Settings
 └── Activity Logs
```

---

# 50. FINAL PRODUCT VISION

KeeHub bukan hanya:

> **"Website jual komponen PC."**

Tetapi:

> **"Platform digital untuk toko PC dan IT Service."**

Customer datang ke KeeHub untuk:

**Cari Part**  
↓  
**Pilih Part**  
↓  
**Cek Compatibility**  
↓  
**Rakit PC**  
↓  
**Minta Quotation**  
↓  
**Order**  
↓  
**Bayar**  
↓  
**Dirakit**  
↓  
**QC**  
↓  
**Dikirim / Pickup**  
↓  
**Service / Upgrade**

---

# END OF PRD

## KeeHub

**Build. Buy. Upgrade.**

PC Parts • PC Builder • PC Rakitan • IT Service
