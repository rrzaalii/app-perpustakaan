# Sistem Perpustakaan Digital Kampus (`app-perpustakaan`)

Aplikasi web manajemen perpustakaan kampus berbasis **Laravel 12** yang menyediakan:
- Antarmuka Blade (Dashboard, manajemen Buku, Kategori, Anggota, Peminjaman, Laporan, Profil, dan Autentikasi berbasis role `admin` / `petugas`).
- REST API (`books`, `members`, `loans`, `stats`) menggunakan API Resource.
- Konsumsi API internal dari sisi Blade (`DashboardController` dan `LoanController@report`) menggunakan Laravel HTTP Client.
- Seeder dan Factory dengan data dummy bergaya Indonesia.

---

## Prasyarat

- PHP >= 8.2
- Composer
- Database server (MySQL / MariaDB atau SQLite)

---

## Instalasi dan Setup

1. **Clone repository dan masuk ke direktori project:**
   ```bash
   git clone <url-repository-anda>
   cd app-perpustakaan
   ```

2. **Install dependency PHP:**
   ```bash
   composer install
   ```

3. **Salin file environment dan generate application key:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi `.env`:**
   Sesuaikan koneksi database (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), serta pastikan dua konfigurasi berikut terisi:
   ```env
   INTERNAL_API_URL=http://127.0.0.1:8011
   APP_FAKER_LOCALE=id_ID
   ```

5. **Jalankan migrasi dan seeder database:**
   ```bash
   php artisan migrate:fresh --seed
   ```

   Seeder akan membuat data awal:
   - **3 User:**
     - Admin: `admin@pens.ac.id` / `password` (`Bambang Sutrisno`)
     - Petugas 1: `petugas1@pens.ac.id` / `password` (`Siti Rahmawati`)
     - Petugas 2: `petugas2@pens.ac.id` / `password` (`Ahmad Fauzi`)
   - **5 Kategori**, **20 Buku**, **15 Anggota**, dan **10 Transaksi Peminjaman**.

---

## Cara Menjalankan Aplikasi

Karena server pengembangan bawaan PHP (`php artisan serve`) hanya memproses satu request pada satu waktu, jalankan **dua instance server** di dua terminal berbeda agar panggilan HTTP internal dari Dashboard (`GET /api/stats`) dan Laporan (`GET /api/loans`) tidak mengalami deadlock:

- **Terminal 1 — Server Utama (untuk diakses melalui browser):**
  ```bash
  php artisan serve --port=8000
  ```
- **Terminal 2 — Server API Internal (khusus panggilan `Http::get()` ke `INTERNAL_API_URL`):**
  ```bash
  php artisan serve --port=8011
  ```

Setelah kedua server berjalan, buka browser ke `http://127.0.0.1:8000/login`.

---

## Dokumentasi Tambahan & Pengujian

- **Dokumentasi REST API:** Lihat [API.md](./API.md).
- **Skenario Demo UAS:** Lihat [DEMO.md](./DEMO.md).
- **Menjalankan Automated Test:**
  ```bash
  php artisan test
  ```
