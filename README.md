# 🎓 SPK BEASISWA – Sistem Pendukung Keputusan Multi-Metode

Aplikasi web berbasis **Laravel** untuk membantu seleksi penerima beasiswa dengan implementasi kombinasi metode canggih. Sistem ini menggunakan **Naive Bayes** untuk klasifikasi awal, diikuti dengan perankingan menggunakan **MOORA** atau **MAIRCA** untuk alternatif yang memenuhi syarat.

---

## 🚀 Fitur Utama

- **Tiga Metode Perhitungan**  
  Implementasi lengkap dan terintegrasi untuk metode Naive Bayes, MOORA, dan MAIRCA.

- **Kombinasi Metode Bertahap**  
  1. **Klasifikasi Awal:** Naive Bayes mengidentifikasi alternatif "LAYAK" atau "TIDAK LAYAK".  
  2. **Perankingan Akhir:** Alternatif "LAYAK" kemudian diurutkan menggunakan MOORA atau MAIRCA sesuai kebutuhan.

- **Manajemen Data Dinamis**  
  - CRUD kriteria dengan pengaturan tipe *benefit* atau *cost*.  
  - CRUD alternatif dengan input penyesuaian skor berdasarkan jenis kriteria.

- **Interface Modern dan Responsif**  
  Tampilan pengguna yang mudah dipakai dan adaptif di berbagai perangkat.

- **Tanpa Integrasi Eksternal**  
  Berjalan mandiri tanpa memerlukan API atau login eksternal.

---

## 🛠️ Teknologi yang Digunakan

| Komponen       | Teknologi                   |
|----------------|-----------------------------|
| Backend        | Laravel 12, PHP >= 8.1      |
| Database       | MySQL (disarankan), PostgreSQL |
| Frontend       | Bootstrap 5 (CDN), FontAwesome (CDN) |
| Manajemen Paket| Composer                    |

---

## 📦 Cara Instalasi

### 1. Clone Repository dan Instal Dependensi
