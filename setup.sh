#!/bin/bash

echo "======================================================="
echo "   Menyiapkan Database MySQL & User untuk KosManage   "
echo "======================================================="

# Buat database dan user kosuser di MySQL
sudo mysql << 'EOF'
CREATE DATABASE IF NOT EXISTS kosmanage;
CREATE USER IF NOT EXISTS 'kosuser'@'localhost' IDENTIFIED BY 'KosManage@2026!';
CREATE USER IF NOT EXISTS 'kosuser'@'127.0.0.1' IDENTIFIED BY 'KosManage@2026!';
ALTER USER 'kosuser'@'localhost' IDENTIFIED BY 'KosManage@2026!';
ALTER USER 'kosuser'@'127.0.0.1' IDENTIFIED BY 'KosManage@2026!';
GRANT ALL PRIVILEGES ON kosmanage.* TO 'kosuser'@'localhost';
GRANT ALL PRIVILEGES ON kosmanage.* TO 'kosuser'@'127.0.0.1';
FLUSH PRIVILEGES;
EOF

if [ $? -ne 0 ]; then
    echo ""
    echo "❌ Terjadi kendala saat mengakses MySQL dengan sudo."
    echo "Pastikan password sudo yang Anda masukkan sudah benar."
    exit 1
fi

echo "✓ User 'kosuser' dan Database 'kosmanage' berhasil disiapkan."

echo "=== Membersihkan cache config & menjalankan migrasi tabel ==="
php artisan config:clear
php artisan migrate:fresh --seed --force

echo ""
echo "======================================================="
echo "✓ SELESAI! Database KosManage sudah siap digunakan."
echo "Silakan refresh browser Anda di http://127.0.0.1:8000"
echo "======================================================="
