# 🎓 SPK BEASISWA – Sistem Pendukung Keputusan Metode MOORA

Aplikasi web berbasis Laravel 12 untuk membantu seleksi penerima beasiswa menggunakan metode MOORA (Multi-Objective Optimization on the basis of Ratio Analysis). Sistem ini mendukung input dinamis kriteria dan alternatif, serta menyajikan hasil peringkat otomatis.

---

## 🚀 Fitur Utama

- CRUD Kriteria (jenis: benefit/cost, bobot otomatis)
- CRUD Alternatif dengan penyesuaian input berdasarkan tipe kriteria
- Perhitungan otomatis menggunakan Metode MOORA
- Menampilkan skor akhir dan peringkat terbaik
- Tampilan modern & responsif (tanpa library tambahan)
- Tanpa login (akses langsung oleh admin)
- Tidak menggunakan API eksternal
- Siap dikembangkan tim (metode Naive Bayes dapat ditambahkan kemudian)

---

## 🛠️ Teknologi yang Digunakan

- Laravel 12
- PHP >= 8.1
- MySQL
- Bootstrap 5 (CDN)
- FontAwesome (CDN)
- SQLite opsional (untuk testing lokal)

---

## 📦 Cara Instalasi (Menggunakan MySQL)

### 1. Clone Project

```bash
git clone https://github.com/NAMAUSER/spk-beasiswa.git
cd spk-beasiswa

#Install dependenci
composer install

#copy file /env
cp .env.example .env

#setup database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_beasiswa
DB_USERNAME=root
DB_PASSWORD=  

#generate key lewat terminal
php artisan key:generate

#jalankan seeder untuk data awal tanpa input lagi
php artisan migrate --seed


#jalakan website
php artisan serve
