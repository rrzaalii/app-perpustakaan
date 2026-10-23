# Dokumentasi REST API - Sistem Perpustakaan Digital Kampus

Base URL: `http://127.0.0.1:8000/api`  
Header Wajib: `Accept: application/json` dan `Content-Type: application/json` (untuk request `POST`/`PUT`)

---

## Ringkasan 11 Endpoint API

| No | Method | URL | Body (jika ada) | Status Code (Sukses / Gagal) | Contoh Response |
|---|---|---|---|---|---|
| 1 | `GET` | `/api/books` | Query opsional: `?judul=...&category_id=...` | `200 OK` | `{"data":[{"id":1,"judul":"Laskar Pelangi","penulis":"Andrea Hirata","penerbit":"Bentang Pustaka","tahun_terbit":2005,"isbn":"9789793062792","stok":5,"sampul":null,"category":{"id":1,"nama_kategori":"Novel"},"created_at":"2026-04-01T08:00:00.000000Z","updated_at":"2026-04-01T08:00:00.000000Z"}],"links":{"first":"http://127.0.0.1:8000/api/books?page=1","last":"http://127.0.0.1:8000/api/books?page=1","prev":null,"next":null},"meta":{"current_page":1,"from":1,"last_page":1,"path":"http://127.0.0.1:8000/api/books","per_page":10,"to":1,"total":1}}` |
| 2 | `GET` | `/api/books/{id}` | - | `200 OK` / `404 Not Found` | `{"data":{"id":1,"judul":"Laskar Pelangi","penulis":"Andrea Hirata","penerbit":"Bentang Pustaka","tahun_terbit":2005,"isbn":"9789793062792","stok":5,"sampul":null,"category":{"id":1,"nama_kategori":"Novel"},"created_at":"2026-04-01T08:00:00.000000Z","updated_at":"2026-04-01T08:00:00.000000Z"}}` |
| 3 | `POST` | `/api/books` | `{"judul":"Clean Code","penulis":"Robert C. Martin","penerbit":"Prentice Hall","tahun_terbit":2008,"isbn":"9780132350884","stok":3,"category_id":2}` | `201 Created` / `422 Unprocessable Content` | `{"data":{"id":2,"judul":"Clean Code","penulis":"Robert C. Martin","penerbit":"Prentice Hall","tahun_terbit":2008,"isbn":"9780132350884","stok":3,"sampul":null,"category":{"id":2,"nama_kategori":"Pemrograman"},"created_at":"2026-04-16T09:10:00.000000Z","updated_at":"2026-04-16T09:10:00.000000Z"}}` |
| 4 | `PUT` | `/api/books/{id}` | `{"judul":"Clean Code (Edisi Revisi)","penulis":"Robert C. Martin","penerbit":"Prentice Hall","tahun_terbit":2008,"isbn":"9780132350884","stok":7,"category_id":2}` | `200 OK` / `404 Not Found` / `422 Unprocessable Content` | `{"data":{"id":2,"judul":"Clean Code (Edisi Revisi)","penulis":"Robert C. Martin","penerbit":"Prentice Hall","tahun_terbit":2008,"isbn":"9780132350884","stok":7,"sampul":null,"category":{"id":2,"nama_kategori":"Pemrograman"},"created_at":"2026-04-16T09:10:00.000000Z","updated_at":"2026-04-16T09:15:00.000000Z"}}` |
| 5 | `DELETE` | `/api/books/{id}` | - | `200 OK` / `404 Not Found` | `{"message":"Buku berhasil dihapus."}` |
| 6 | `GET` | `/api/members` | - | `200 OK` | `{"data":[{"id":1,"nama":"Budi Santoso","nim":"3124500001","email":"budi@student.pens.ac.id","nomor_telepon":"081234567890","alamat":"Jl. Raya ITS Sukolilo, Surabaya","status":"aktif","created_at":"2026-04-01T08:05:00.000000Z","updated_at":"2026-04-01T08:05:00.000000Z"}],"links":{"first":"http://127.0.0.1:8000/api/members?page=1","last":"http://127.0.0.1:8000/api/members?page=1","prev":null,"next":null},"meta":{"current_page":1,"from":1,"last_page":1,"path":"http://127.0.0.1:8000/api/members","per_page":10,"to":1,"total":1}}` |
| 7 | `GET` | `/api/members/{id}` | - | `200 OK` / `404 Not Found` | `{"data":{"id":1,"nama":"Budi Santoso","nim":"3124500001","email":"budi@student.pens.ac.id","nomor_telepon":"081234567890","alamat":"Jl. Raya ITS Sukolilo, Surabaya","status":"aktif","created_at":"2026-04-01T08:05:00.000000Z","updated_at":"2026-04-01T08:05:00.000000Z"}}` |
| 8 | `GET` | `/api/loans` | - | `200 OK` | `{"data":[{"id":1,"member":{"id":1,"nama":"Budi Santoso"},"petugas":{"id":1,"name":"Admin Perpustakaan"},"tanggal_pinjam":"2026-04-10","tanggal_kembali":"2026-04-17","tanggal_dikembalikan":null,"status":"dipinjam","books":[{"id":1,"judul":"Laskar Pelangi"}]}],"links":{"first":"http://127.0.0.1:8000/api/loans?page=1","last":"http://127.0.0.1:8000/api/loans?page=1","prev":null,"next":null},"meta":{"current_page":1,"from":1,"last_page":1,"path":"http://127.0.0.1:8000/api/loans","per_page":10,"to":1,"total":1}}` |
| 9 | `POST` | `/api/loans` | `{"member_id":1,"user_id":2,"tanggal_pinjam":"2026-04-16","tanggal_kembali":"2026-04-23","book_ids":[1]}` | `201 Created` / `422 Unprocessable Content` | `{"data":{"id":3,"member":{"id":1,"nama":"Budi Santoso"},"petugas":{"id":2,"name":"Petugas Satu"},"tanggal_pinjam":"2026-04-16","tanggal_kembali":"2026-04-23","tanggal_dikembalikan":null,"status":"dipinjam","books":[{"id":1,"judul":"Laskar Pelangi"}]}}` |
| 10 | `PUT` | `/api/loans/{id}/kembalikan` | - | `200 OK` / `404 Not Found` | `{"data":{"id":3,"member":{"id":1,"nama":"Budi Santoso"},"petugas":{"id":2,"name":"Petugas Satu"},"tanggal_pinjam":"2026-04-16","tanggal_kembali":"2026-04-23","tanggal_dikembalikan":"2026-04-16","status":"dikembalikan","books":[{"id":1,"judul":"Laskar Pelangi"}]}}` |
| 11 | `GET` | `/api/stats` | - | `200 OK` | `{"total_buku":5,"total_anggota":3,"peminjaman_aktif":2}` |

---

## Contoh Response Skenario Gagal (Error)

### 1. Validasi Gagal (`422 Unprocessable Content`) - Contoh `POST /api/books` dengan Body Kosong

```json
{
    "message": "Judul buku wajib diisi. (and 4 more errors)",
    "errors": {
        "judul": [
            "Judul buku wajib diisi."
        ],
        "penulis": [
            "Nama penulis wajib diisi."
        ],
        "penerbit": [
            "Nama penerbit wajib diisi."
        ],
        "tahun_terbit": [
            "Tahun terbit wajib diisi."
        ],
        "stok": [
            "Stok wajib diisi."
        ],
        "category_id": [
            "Kategori wajib dipilih."
        ]
    }
}
```

### 2. Validasi Gagal (`422 Unprocessable Content`) - Contoh `POST /api/loans` dengan Body Kosong

```json
{
    "message": "Anggota wajib dipilih. (and 4 more errors)",
    "errors": {
        "member_id": [
            "Anggota wajib dipilih."
        ],
        "user_id": [
            "Petugas (user_id) wajib diisi."
        ],
        "tanggal_pinjam": [
            "Tanggal pinjam wajib diisi."
        ],
        "tanggal_kembali": [
            "Tanggal kembali wajib diisi."
        ],
        "book_ids": [
            "Pilih minimal satu buku."
        ]
    }
}
```

### 3. Resource Tidak Ditemukan (`404 Not Found`) - Contoh `GET /api/books/999`

```json
{
    "message": "No query results for model [App\\Models\\Book] 999"
}
```
