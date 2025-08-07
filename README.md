🎓 SPK BEASISWA – Sistem Pendukung Keputusan Multi-Metode
Aplikasi web berbasis Laravel untuk membantu seleksi penerima beasiswa dengan mengimplementasikan kombinasi metode yang canggih. Sistem ini menggunakan Naive Bayes untuk klasifikasi awal, diikuti dengan perankingan menggunakan MOORA atau MAIRCA untuk alternatif yang memenuhi syarat.

🚀 Fitur Utama
Tiga Metode Perhitungan: Implementasi lengkap untuk Naive Bayes, MOORA, dan MAIRCA.

Kombinasi Metode: Proses seleksi bertahap yang inovatif:

Klasifikasi Awal: Menggunakan Naive Bayes untuk mengidentifikasi alternatif yang "LAYAK" atau "TIDAK LAYAK".

Perankingan Akhir: Alternatif yang "LAYAK" kemudian diurutkan kembali menggunakan metode MOORA atau MAIRCA.

Manajemen Data Dinamis:

CRUD Kriteria (menyesuaikan tipe benefit atau cost).

CRUD Alternatif dengan penyesuaian input skor berdasarkan jenis kriteria.

Interface Pengguna: Tampilan modern dan responsif untuk kemudahan pengelolaan data.

Tanpa Integrasi Eksternal: Sistem ini berdiri sendiri, tidak memerlukan API atau login eksternal.

🛠️ Teknologi yang Digunakan
Backend: Laravel 12, PHP >= 8.1

Database: MySQL (disarankan), PostgreSQL

Frontend: Bootstrap 5 (CDN), FontAwesome (CDN)

Lingkungan: Composer untuk manajemen dependensi.

📦 Cara Instalasi
1. Clone Project dan Dependensi
git clone https://github.com/NAMAUSER/spk-beasiswa.git
cd spk-beasiswa

# Instalasi dependensi PHP
composer install

# Salin file konfigurasi .env
cp .env.example .env

# Hapus baris di .env agar aplikasi bisa berjalan
# APP_KEY=

# Generate kunci aplikasi Laravel
php artisan key:generate

2. Konfigurasi Database
Buka file .env dan atur koneksi database Anda:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_beasiswa
DB_USERNAME=root
DB_PASSWORD=

3. Migrasi dan Seeder
Jalankan perintah berikut untuk membuat tabel database dan mengisi data awal (seeder):

php artisan migrate --seed

4. Jalankan Aplikasi
php artisan serve

Aplikasi Anda sekarang dapat diakses di http://127.0.0.1:8000.