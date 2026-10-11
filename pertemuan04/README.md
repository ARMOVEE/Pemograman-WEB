# Pertemuan 04 - Aplikasi Inventaris (MVC)

Aplikasi web inventaris barang berbasis arsitektur Model-View-Controller (MVC) murni tanpa framework, dibangun menggunakan PHP 8 dan MySQL/MariaDB. Proyek ini merupakan tugas praktikum Modul 04 mata kuliah Pemrograman Web yang berfokus pada pemisahan logika bisnis, pengelolaan database transaksi, dan autentikasi pengguna.

## Struktur Direktori

```text
pertemuan04/
├── README.md               # Dokumentasi direktori pertemuan 04
└── inventaris-mvc/         # Proyek utama aplikasi inventaris MVC
    ├── .env.example        # Contoh konfigurasi environment
    ├── .gitignore          # Pengabaian file sensitif (.env, logs/)
    ├── README.md           # Dokumentasi teknis aplikasi
    ├── app/
    │   ├── config/         # Konfigurasi aplikasi
    │   ├── controllers/    # Pengendali route dan alur logika
    │   ├── core/           # Inti framework sederhana (Router, Model, Controller, Database, Logger)
    │   ├── models/         # Model data dan query database
    │   └── views/          # Tampilan antarmuka (Blade-like PHP, layout sidebar, partials)
    ├── database/
    │   └── inventory.sql   # Skema tabel dan data awal (seeder)
    └── public/
        ├── .htaccess       # Rewrite URL Apache
        └── index.php       # Front controller / titik masuk aplikasi
```

## Fitur Utama

- **Autentikasi & Otorisasi:** Sistem login dan logout berbasis PHP session dengan pembagian hak akses (admin, manager, staff).
- **Dashboard Ringkasan:** Ringkasan statistik inventaris (total barang, total stok, nilai aset, transaksi hari ini, dan daftar stok menipis).
- **Manajemen Barang (CRUD):** Pencatatan data barang lengkap dengan kode, nama, kategori, stok, satuan, harga beli, dan harga jual.
- **Pencarian, Filter, & Paginasi:** Kemudahan navigasi data barang dengan filter kategori, pencarian kata kunci, serta pembagian halaman.
- **Manajemen Kategori (CRUD):** Pengelolaan kategori inventaris barang.
- **Transaksi Stok Masuk & Keluar:** Mutasi stok dengan dukungan database transaction untuk mencegah stok bernilai negatif (race condition safe).
- **Logging Sistem:** Pencatatan kesalahan ke berkas log harian ketika terjadi kegagalan query database atau transaksi.

## Cara Menjalankan

### 1. Kebutuhan Sistem
- PHP 8.0 atau versi yang lebih baru (dengan ekstensi `pdo_mysql` aktif).
- MySQL atau MariaDB (misalnya via paket XAMPP).
- Peramban web modern (Google Chrome, Firefox, dsb.).

### 2. Import Database
Pastikan layanan MySQL di XAMPP telah berjalan, lalu impor berkas skema:
- Menggunakan phpMyAdmin: Buat database atau pilih menu **Import**, lalu pilih berkas `inventaris-mvc/database/inventory.sql`.
- Menggunakan Command Prompt / PowerShell:
  ```bash
  mysql -u root -p < inventaris-mvc/database/inventory.sql
  ```

### 3. Konfigurasi Lingkungan (.env)
Masuk ke dalam folder `inventaris-mvc/`, lalu salin berkas `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Sesuaikan parameter koneksi database pada berkas `.env`:
```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=inventory_mvc
DB_USER=root
DB_PASS=
BASE_URL=http://localhost:8000
```
*(Catatan: Jangan mengubah atau meng-commit berkas `.env` asli ke repositori publik).*

### 4. Menjalankan Server Lokal
Jalankan PHP built-in web server dari dalam folder `inventaris-mvc/`:
```bash
cd inventaris-mvc
php -S localhost:8000 -t public public/index.php
```

### 5. Mengakses Aplikasi
Buka peramban web dan akses:
```
http://localhost:8000
```
Login menggunakan akun default yang tersedia pada data seeder database.
