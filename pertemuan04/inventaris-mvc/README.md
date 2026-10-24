# Sistem Inventaris Barang (PHP MVC v2.0)

Aplikasi inventaris barang berbasis **PHP 8 murni dan MySQL/MariaDB tanpa framework**, menggunakan arsitektur **Model-View-Controller (MVC)** yang telah ditingkatkan sesuai **Modul 05: Keamanan, RBAC, Laporan, REST API & Deployment**.

---

## Fitur Utama (Pembaruan Versi 2.0)

1. **Keamanan & Session Hardening**:
   - Proteksi token CSRF per sesi dengan perbandingan konstan-waktu (`hash_equals()`).
   - Pengerasan cookie sesi (`HttpOnly`, `SameSite=Lax`, `Secure` saat HTTPS, regenerasi ID, dan batas idle `SESSION_IDLE_TIMEOUT`).
   - HTTP Security Headers (`X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`).
   - Halaman error generik terpusat untuk status 403, 419, 404, dan 500.

2. **Role-Based Access Control (RBAC)**:
   - Matriks izin terpusat untuk 3 peran: `admin`, `manager`, dan `staff`.
   - Penerapan prinsip *default deny*: otorisasi diverifikasi ketat di controller (`$this->authorize(...)`).
   - Menu navigasi sidebar dan tombol aksi antarmuka otomatis menyesuaikan hak akses pengguna.

3. **Soft Delete & Pemulihan Data**:
   - Penghapusan logis (*soft delete*) dengan kolom `deleted_at` sehingga data transaksi masa lalu tetap utuh.
   - Halaman tong sampah khusus (`/items/trash`) dan pemulihan data (*restore*) untuk peran admin.
   - Proteksi transaksi stok pada barang yang sedang di tong sampah.

4. **Detail Barang & Riwayat Stok**:
   - Halaman detail barang lengkap (`/items/show/{id}`) menampilkan spesifikasi, foto, kalkulasi nilai persediaan, status stok menipis, serta 20 riwayat transaksi terakhir.

5. **Upload Foto Barang Aman**:
   - Validasi MIME type berbasis isi berkas sesungguhnya menggunakan ekstensi `finfo`.
   - Validasi struktur gambar via `getimagesize()` dan pembatasan ukuran berkas (`UPLOAD_MAX_MB`).
   - Penamaan berkas acak kriptografis (`bin2hex(random_bytes(16))`) untuk mencegah path traversal.
   - Proteksi direktori `public/uploads/.htaccess` melarang eksekusi skrip PHP/CGI.

6. **Audit Log Aktivitas**:
   - Jejak audit *append-only* di tabel `activity_logs` mencatat aktor, aksi, entitas, ID entitas, deskripsi, dan alamat IP.
   - Halaman penampil log khusus admin (`/logs`) dengan filter aksi dan paginasi.

7. **Laporan & Ekspor CSV Aman**:
   - Rekapitulasi stok dan transaksi dengan filter rentang tanggal, kategori, dan stok menipis.
   - Ekspor data CSV dengan proteksi *Formula Injection* (menetralkan `=`, `+`, `-`, `@`) dan UTF-8 BOM.

8. **Dashboard Analitik**:
   - Visualisasi pergerakan stok masuk dan keluar 7 hari terakhir menggunakan grafik batang **Chart.js**.
   - Daftar 5 barang dengan stok terbanyak.

9. **REST API JSON + Bearer Token**:
   - Autentikasi Bearer token ter-hash SHA-256 (`api_tokens`).
   - Endpoint:
     * `GET /api` — Informasi dan daftar endpoint
     * `GET /api/me` — Profil pengguna pemegang token
     * `GET /api/items` & `GET /api/items/{id}` — Katalog barang & riwayat
     * `POST /api/items` — Tambah barang baru
     * `POST /api/transactions` — Catat mutasi stok masuk/keluar
     * `GET /api/dashboard` — Data ringkasan analitik
     * `GET /api/lowStock` — Daftar barang stok menipis
   - Dukungan CORS, format JSON standar, dan kode status HTTP yang benar (200, 201, 401, 403, 404, 405, 409, 422).

---

## Kebutuhan Sistem

- PHP 8.1 atau lebih baru (ekstensi `pdo_mysql`, `fileinfo`, `mbstring` aktif)
- MySQL 8.0+ atau MariaDB 10.4+
- Web server Apache / Nginx / PHP built-in server

---

## Panduan Instalasi & Migrasi

### 1. Konfigurasi Lingkungan
Salin `.env.example` ke `.env` lalu sesuaikan konfigurasi:
```bash
cp .env.example .env
```
Variabel konfigurasi yang tersedia:
```env
APP_NAME="Inventory System"
APP_ENV=local
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
BASE_URL=http://localhost:8000

DB_HOST=localhost
DB_PORT=3306
DB_NAME=db_inventory
DB_USER=root
DB_PASS=

SESSION_IDLE_TIMEOUT=30
UPLOAD_MAX_MB=2
API_ALLOWED_ORIGIN=*
API_DEFAULT_LIMIT=10
```

### 2. Migrasi Basis Data
Jika baru memulai, impor skema Modul 04 terlebih dahulu:
```bash
Get-Content database\inventory.sql | C:\xampp\mysql\bin\mysql.exe -u root
```
Lalu jalankan skrip migrasi skema v2 (Modul 05):
```bash
Get-Content database\migration_v2.sql | C:\xampp\mysql\bin\mysql.exe -u root
```

### 3. Menjalankan Aplikasi
Gunakan server bawaan PHP:
```bash
php -S localhost:8000 -t public public/index.php
```
Buka peramban di: `http://localhost:8000`

---

## Kredensial Akun Demo

| Username | Password | Peran | Hak Akses |
|---|---|---|---|
| `admin` | `123456` | admin | Akses penuh (CRUD, Restore sampah, Pengguna, Audit Log) |
| `manager` | `123456` | manager | Dashboard, CRUD Barang, Kategori, Transaksi, Laporan & Ekspor |
| `staff` | `123456` | staff | Dashboard, Lihat Barang/Kategori/Laporan, Catat Transaksi Stok |

---

## Penggunaan REST API

### Menerbitkan Token API (CLI)
Jalankan skrip penerbit token dari terminal:
```bash
php bin/make-api-token.php admin "integrasi-mobile"
```
Simpan token yang dihasilkan (format: `inv_...`).

### Contoh Pemanggilan API via cURL
1. Cek profil pengguna token:
```bash
curl -H "Authorization: Bearer <TOKEN>" http://localhost:8000/api/me
```

2. Ambil data barang (dengan paginasi dan pencarian):
```bash
curl -H "Authorization: Bearer <TOKEN>" "http://localhost:8000/api/items?search=laptop&limit=10&page=1"
```

3. Catat transaksi mutasi stok:
```bash
curl -X POST http://localhost:8000/api/transactions \
  -H "Authorization: Bearer <TOKEN>" \
  -H "Content-Type: application/json" \
  -d '{"item_id":1,"type":"OUT","quantity":2,"notes":"Pemakaian operasional"}'
```

---

## Pengujian Otomatis

Aplikasi dilengkapi suite pengujian otomatis untuk memverifikasi logika RBAC, proteksi formula CSV, token CSRF, sanitasi query/input, dan konfigurasi.

Jalankan pengujian:
```bash
php tests/run.php
```
Target hasil: **Lulus: 22 | Gagal: 0**

---

## Deployment & Backup Produksi

- Pastikan `APP_DEBUG=false` dan `APP_ENV=production` pada file `.env`.
- Arahkan `DocumentRoot` web server ke folder `public/`, bukan root proyek.
- Konfigurasi server web tersedia di:
  * Apache: [`deploy/inventory.conf`](file:///c:/xampp/htdocs/pertemuan01/pertemuan04/inventaris-mvc/deploy/inventory.conf)
  * Nginx: [`deploy/inventory.nginx.conf`](file:///c:/xampp/htdocs/pertemuan01/pertemuan04/inventaris-mvc/deploy/inventory.nginx.conf)
- Skrip pencadangan berkala database & berkas upload tersedia di [`deploy/backup.sh`](file:///c:/xampp/htdocs/pertemuan01/pertemuan04/inventaris-mvc/deploy/backup.sh).
