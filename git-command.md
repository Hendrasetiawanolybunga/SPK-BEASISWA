**Git: Kumpulan Perintah Penting untuk Kolaborasi Tim (Beserta Penjelasan)**

---

### 🟢 1. Inisialisasi Project Git Lokal

```bash
git init
```

> Membuat repository Git lokal di dalam folder project.

---

### 🌐 2. Menghubungkan ke Repository GitHub

```bash
git remote add origin https://github.com/username/nama-repo.git
```

> Menghubungkan repo lokal dengan repo GitHub (ganti URL dengan milik kamu).

---

### 📂 3. Menambahkan File ke Antrian Commit

```bash
git add .
```

> Menambahkan semua file yang berubah ke staging area.

Alternatif:

```bash
git add nama_file.txt
```

> Menambahkan file tertentu saja.

---

### 📝 4. Membuat Commit

```bash
git commit -m "Deskripsi perubahan"
```

> Menyimpan snapshot perubahan ke repository lokal.

---

### ☁️ 5. Push ke GitHub (Upload Perubahan)

```bash
git push origin main
```

> Mengirim commit lokal ke branch `main` di GitHub.

Jika pertama kali push:

```bash
git push -u origin main
```

> Agar branch `main` otomatis dilacak.

---

### 🔄 6. Menarik Perubahan dari GitHub

```bash
git pull origin main
```

> Menggabungkan semua perubahan terbaru dari GitHub ke lokal.

Alternatif manual:

```bash
git fetch
```

```bash
git merge origin/main
```

> `fetch` = ambil data saja, `merge` = gabungkan.

---

### 🛑 7. Menyimpan Perubahan Lokal Sementara (Sebelum Pull)

```bash
git stash
```

> Menyimpan semua perubahan tanpa commit. Cocok digunakan sebelum `git pull` agar tidak konflik.

Untuk mengembalikan:

```bash
git stash pop
```

---

### 🔁 8. Melihat Riwayat Commit

```bash
git log
```

> Menampilkan semua commit beserta hash ID.

Ringkas:

```bash
git log --oneline
```

---

### 🧪 9. Membuat Branch Baru (Uji Coba)

```bash
git checkout -b nama-branch
```

> Membuat branch baru dan langsung berpindah ke sana.

---

### 🔁 10. Berpindah Antar Branch

```bash
git checkout main
```

> Pindah ke branch utama `main`.

---

### 📌 11. Melihat Semua Branch

```bash
git branch
```

> Menampilkan daftar semua branch lokal.

---

### 🧹 12. Menghapus Branch Lokal (Opsional)

```bash
git branch -d nama-branch
```

> Menghapus branch lokal setelah selesai uji coba.

---

### ⏪ 13. Membatalkan Commit Terakhir (Hard Reset)

```bash
git reset --hard HEAD~1
```

> Menghapus commit terakhir dan semua perubahannya. ⚠️ Hati-hati, tidak bisa dibatalkan!

---

### 🆚 14. Melihat Perbedaan Kode

```bash
git diff
```

> Menampilkan perbedaan antar file yang belum di-commit.

---

### 🧭 15. Mengecek Status Git Saat Ini

```bash
git status
```

> Menampilkan status perubahan, file yang belum di-add, dan branch aktif.

---

### 📤 16. Clone Project dari GitHub

```bash
git clone https://github.com/username/nama-repo.git
```

> Mengunduh project dari GitHub ke komputer lokal.


