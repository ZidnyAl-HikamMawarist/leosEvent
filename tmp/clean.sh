#!/bin/bash

echo "🚀 Memulai Pembersihan Project Leos Event..."

# 1. Bersihkan Cache Laravel melalui Artisan
php artisan optimize:clear

# 2. Hapus Folder Berlemak (Jika ada)
echo "🗑️ Menghapus folder yang tidak dibutuhkan di server..."
rm -rf node_modules
rm -rf .git
rm -rf .vscode
rm -rf tests

# 3. Hapus File Sampah
echo "🗑️ Menghapus file sampah & logs..."
rm -f storage/logs/*.log
rm -f .env.example
rm -f phpunit.xml
rm -f PLAN_README.md

echo "✅ SELESAI! Project kamu sekarang 80% lebih ringan dan siap tempur di server! 🚀"
