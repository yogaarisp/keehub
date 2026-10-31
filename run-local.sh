#!/usr/bin/env bash
set -e

echo "🚀 Mempersiapkan KeeHub untuk Local Development..."

# 1. Bersihkan file public/hot lama jika tertinggal
if [ -f public/hot ]; then
    rm -f public/hot
    echo "🧹 Membersihkan cache hot reload lama..."
fi

# 2. Cek koneksi port MySQL (MAMP port 8889 atau default 3306)
DB_PORT=$(grep -E "^DB_PORT=" .env 2>/dev/null | cut -d '=' -f2 | tr -d '\r ' || echo "8889")
if [ -z "$DB_PORT" ]; then
    DB_PORT="8889"
fi

if ! nc -z 127.0.0.1 "$DB_PORT" 2>/dev/null; then
    echo "⚠️  PERINGATAN: MySQL belum terdeteksi di port $DB_PORT."
    echo "   Pastikan aplikasi MAMP sudah dibuka dan klik 'Start Servers'!"
    echo ""
fi

# 3. Pastikan storage link ada
if [ ! -L public/storage ]; then
    php artisan storage:link --quiet 2>/dev/null || true
fi

echo "=================================================="
echo "🌐 Toko / Web Publik : http://127.0.0.1:8000"
echo "⚙️  Filament Admin     : http://127.0.0.1:8000/admin"
echo "=================================================="
echo "💡 Tekan [Ctrl + C] untuk menghentikan server."
echo ""

# Jalankan server Laravel dan Vite secara bersamaan
npm run dev
