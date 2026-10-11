# Sistem Inventaris Barang (PHP MVC)

Aplikasi inventaris barang berbasis PHP 8 dan MySQL/MariaDB tanpa framework, dengan arsitektur Model-View-Controller. Dibuat untuk Modul 04 mata kuliah Pemrograman Web (PHP dan MySQL).

## Fitur

- Login dan logout berbasis session, dengan proteksi route
- CRUD kategori dan barang
- Transaksi stok masuk dan keluar dengan database transaction (stok tidak boleh negatif)
- Pencarian, filter kategori, dan paginasi
- Dashboard ringkasan inventaris

## Kebutuhan

- PHP 8.0 atau lebih baru dengan ekstensi pdo_mysql
- MySQL atau MariaDB
- Opsional: XAMPP (Apache)

## Instalasi

1. Salin `.env.example` menjadi `.env`, lalu sesuaikan `BASE_URL` dan kredensial database (`DB_USER`, `DB_PASS`).
2. Impor database `database/inventory.sql`:

        mysql -u root -p < database/inventory.sql

   Di Windows PowerShell:

        Get-Content database\inventory.sql | C:\xampp\mysql\bin\mysql.exe -u root

   Atau lewat phpMyAdmin: menu Import, pilih `database/inventory.sql`.
3. Jalankan aplikasi dengan PHP built-in server:

        php -S localhost:8000 -t public public/index.php

   Lalu buka http://localhost:8000
4. Dengan XAMPP: letakkan proyek di `htdocs`, atur `BASE_URL` menjadi `http://localhost/<nama-folder>/public`, lalu buka URL tersebut.

## Kredensial demo

| Username | Password | Peran |
|----------|----------|-------|
| admin | 123456 | admin |
| staff | 123456 | staff |
| manager | 123456 | manager |

Kredensial ini hanya untuk pengembangan dan pembelajaran. Ganti sebelum dipakai di luar komputer lokal.

## Struktur singkat

- `public/index.php` : front controller
- `app/core` : router, base controller, base model, database, middleware, logger, helper
- `app/models`, `app/controllers`, `app/views` : lapisan MVC
- `database/inventory.sql` : skema dan data contoh
