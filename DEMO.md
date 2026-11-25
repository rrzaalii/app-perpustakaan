# Skenario Demo Aplikasi - Sistem Perpustakaan Digital Kampus

Dokumen ini berisi urutan langkah demo aplikasi **app-perpustakaan** untuk persiapan UAS.

---

## Persiapan Sebelum Demo

1. Reset dan isi ulang database dengan data dummy realistis:
   ```bash
   php artisan migrate:fresh --seed
   ```
2. Jalankan **dua** instance server pengembangan di dua terminal terpisah (agar konsumsi API internal dari Dashboard dan Laporan tidak mengalami deadlock):
   - **Terminal 1 (Server Utama / Browser):**
     ```bash
     php artisan serve --port=8000
     ```
   - **Terminal 2 (Server API Internal):**
     ```bash
     php artisan serve --port=8011
     ```
3. Buka browser ke `http://127.0.0.1:8000` dan siapkan Postman dengan base URL `http://127.0.0.1:8000/api`.

---

## Urutan Skenario Demo

### 1. Login
- Buka `http://127.0.0.1:8000/login`.
- Masukkan kredensial akun admin hasil seeding:
  - **Email:** `admin@pens.ac.id`
  - **Password:** `password`
- Klik tombol **Login**.
- **Hasil yang ditunjukkan:** Pengguna diarahkan ke halaman Dashboard (`/`) dan nama **Bambang Sutrisno (Admin)** tampil di navbar.

### 2. Tampilkan Dashboard
- Pada halaman Dashboard (`/`), tunjukkan tiga kartu statistik:
  - **Total Buku** (awal: `20`)
  - **Total Anggota** (awal: `15`)
  - **Peminjaman Aktif** (sesuai jumlah transaksi berstatus `dipinjam` dari `LoanSeeder`)
- Jelaskan bahwa angka statistik diambil melalui `Http::get()` ke endpoint internal `GET /api/stats` (port `8011`), bukan query database langsung dari `DashboardController`.

### 3. Tambah Kategori
- Klik menu **Kategori** pada navbar (`/categories`).
- Klik **+ Tambah Kategori**, lalu isi contoh data baru:
  - **Nama Kategori:** `Arsitektur Perangkat Lunak`
  - **Deskripsi:** `Buku mengenai desain sistem dan arsitektur aplikasi.`
- Simpan dan pastikan kategori baru muncul di daftar kategori.

### 4. Tambah Buku
- Klik menu **Buku** pada navbar (`/books`), tunjukkan juga pagination di bagian bawah tabel berjalan rapi.
- Klik **+ Tambah Buku**, lalu tambahkan buku baru dengan memilih kategori yang baru dibuat:
  - **Judul:** `Clean Architecture`
  - **Penulis:** `Robert C. Martin`
  - **Penerbit:** `Prentice Hall`
  - **Tahun Terbit:** `2017`
  - **ISBN:** `9780134494166`
  - **Stok:** `5`
  - **Kategori:** `Arsitektur Perangkat Lunak`
- Simpan dan pastikan buku baru muncul di daftar buku.

### 5. Tambah Anggota
- Klik menu **Anggota** pada navbar (`/members`), tunjukkan daftar anggota bergaya Indonesia beserta pagination-nya.
- Klik **+ Tambah Anggota**, lalu isi data anggota baru:
  - **Nama:** `Dewi Kartika`
  - **NIM:** `3124500099`
  - **Email:** `dewi.kartika@pens.ac.id`
  - **Nomor Telepon:** `081234567890`
  - **Alamat:** `Jl. Teknik Kimia Keputih, Surabaya`
  - **Status:** `aktif`
- Simpan dan pastikan anggota baru tercatat di daftar anggota.

### 6. Buat Peminjaman
- Klik menu **Peminjaman** pada navbar (`/loans`).
- Klik **+ Tambah Peminjaman**, lalu pilih:
  - **Anggota:** `Dewi Kartika`
  - **Tanggal Pinjam:** tanggal hari ini
  - **Tanggal Kembali:** 7 hari dari hari ini
  - **Buku:** centang `Clean Architecture` (boleh lebih dari satu buku)
- Simpan transaksi peminjaman baru.

### 7. Lihat Daftar Peminjaman Aktif
- Kembali ke halaman **Peminjaman** (`/loans`).
- Tunjukkan transaksi peminjaman baru milik **Dewi Kartika** tampil dengan status badge **Dipinjam** dan tombol aksi **Kembalikan**.
- Buka **Dashboard** (`/`) sebentar jika ingin menunjukkan bahwa angka **Total Buku**, **Total Anggota**, dan **Peminjaman Aktif** bertambah otomatis.

### 8. Proses Pengembalian
- Pada halaman **Peminjaman** (`/loans`), klik tombol **Kembalikan** pada transaksi peminjaman milik **Dewi Kartika**.
- **Hasil yang ditunjukkan:** Status transaksi berubah menjadi **Dikembalikan** dan `tanggal_dikembalikan` tercatat sesuai tanggal hari ini.

### 9. Tampilkan Laporan
- Klik menu **Laporan** pada navbar (`/loans/report`) atau tombol **Lihat Laporan Peminjaman** di Dashboard.
- Tunjukkan tabel laporan peminjaman beserta navigasi halaman (`Sebelumnya` / `Selanjutnya`) yang datanya dikonsumsi langsung dari `GET /api/loans`.
- *(Opsional untuk demonstrasi ketahanan error)*: Matikan sementara server port `8011`, refresh Dashboard/Laporan untuk menunjukkan fallback aman (angka `0` / tabel kosong tanpa error 500), lalu nyalakan kembali server port `8011`.

### 10. Demo REST API di Postman
Siapkan header `Accept: application/json` (dan `Content-Type: application/json` untuk `POST`/`PUT`). Contoh endpoint yang didemokan (detail lengkap ada di `API.md`):
1. `GET http://127.0.0.1:8000/api/stats` — menampilkan ringkasan statistik JSON (`total_buku`, `total_anggota`, `peminjaman_aktif`).
2. `GET http://127.0.0.1:8000/api/books?judul=Clean` — menampilkan daftar buku dalam format JSON Resource + metadata pagination.
3. `POST http://127.0.0.1:8000/api/books` — menambahkan buku baru lewat API (`201 Created`), serta contoh body kosong untuk menunjukkan validasi `422 Unprocessable Content`.
4. `GET http://127.0.0.1:8000/api/members` — menampilkan daftar anggota.
5. `GET http://127.0.0.1:8000/api/loans` — menampilkan daftar peminjaman beserta relasi anggota, petugas, dan daftar buku.
6. `POST http://127.0.0.1:8000/api/loans` dan `PUT http://127.0.0.1:8000/api/loans/{id}/kembalikan` — membuat peminjaman dan memproses pengembalian lewat API.
