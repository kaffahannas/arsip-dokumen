# Sistem Arsip Dokumen

Aplikasi web sederhana untuk mengarsipkan dokumen digital. Admin dapat login, mengelola kategori, lalu mengunggah, melihat, mengunduh, mengubah, dan menghapus arsip dokumen berformat **PDF, JPG, atau PNG**.

Aplikasi dibangun dengan **CodeIgniter 4**, menyimpan file upload di luar folder `public`, dan menyediakan migration, seeder, serta dump SQL agar mudah dijalankan dari database kosong.

## Fitur

- Login dan logout dengan proteksi session.
- Semua halaman selain login hanya bisa diakses setelah login.
- CRUD kategori (tambah, lihat daftar, ubah, hapus).
- CRUD arsip dokumen dengan upload file.
- Lihat file arsip langsung di browser dan unduh file.
- Validasi ekstensi, MIME type, dan ukuran file maksimal **5 MB**.
- Kategori yang masih memiliki arsip tidak dapat dihapus.
- Tampilan responsif dengan Bootstrap 5.
- Flash message, validasi form, konfirmasi hapus, dan empty state.
- CSRF protection pada semua form POST dan escaping output dengan `esc()`.

## Tech Stack

- **PHP** 8.2 atau lebih baru
- **CodeIgniter** 4.7
- **MySQL / MariaDB**
- **Bootstrap** 5.3.3 dan **Bootstrap Icons** 1.11.3 (CDN)
- **Composer** untuk manajemen dependency

## Prasyarat

Pastikan sudah terpasang:

- PHP 8.2+ dengan ekstensi `intl`, `mbstring`, dan `mysqli`
- Composer
- MySQL atau MariaDB
- Git

Cek versi PHP dan Composer:

```bash
php -v
composer --version
```

## Instalasi

1. **Clone repository**

   ```bash
   git clone https://github.com/username/arsip-dokumen.git
   cd arsip-dokumen
   ```

   Sesuaikan URL di atas dengan URL repository Anda.

2. **Install dependency**

   ```bash
   composer install
   ```

3. **Salin file environment**

   Windows (PowerShell):

   ```powershell
   Copy-Item env.example .env
   ```

   Linux/macOS:

   ```bash
   cp env.example .env
   ```

   Buka `.env`, lalu sesuaikan `app.baseURL` dan koneksi database:

   ```ini
   CI_ENVIRONMENT = development

   app.baseURL = 'http://localhost:8080/'

   database.default.hostname = localhost
   database.default.database = arsip_dokumen
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

4. **Buat database**

   ```sql
   CREATE DATABASE arsip_dokumen
       CHARACTER SET utf8mb4
       COLLATE utf8mb4_general_ci;
   ```

5. **Jalankan migration**

   ```bash
   php spark migrate
   ```

6. **Isi data awal dengan seeder**

   ```bash
   php spark db:seed DatabaseSeeder
   ```

   Seeder akan membuat akun admin dan tiga kategori contoh.

7. **Jalankan aplikasi**

   ```bash
   php spark serve
   ```

   Buka `http://localhost:8080` di browser.

### Alternatif: Import dump SQL

Jika tidak ingin menjalankan migration dan seeder, Anda dapat mengimpor dump SQL yang sudah disediakan:

```bash
mysql -u root -p arsip_dokumen < database/arsip_dokumen.sql
```

Atau impor file `database/arsip_dokumen.sql` melalui phpMyAdmin.

## Akun Uji

| Email | Password |
| --- | --- |
| `admin@example.com` | `Admin12345` |

Akun ini dibuat oleh `UserSeeder`. Tidak ada fitur registrasi; pengguna baru hanya dapat ditambahkan melalui seeder.

## Struktur Folder

```text
arsip-dokumen/
├── app/
│   ├── Config/              # Konfigurasi aplikasi, routes, filters, database
│   ├── Controllers/         # Auth, Archives, Categories
│   ├── Database/
│   │   ├── Migrations/      # Migration tabel users, categories, archives
│   │   └── Seeds/           # UserSeeder, CategorySeeder, DatabaseSeeder
│   ├── Filters/             # AuthFilter dan GuestFilter
│   ├── Models/              # UserModel, CategoryModel, ArchiveModel
│   └── Views/               # Layout, autentikasi, arsip, kategori, error
├── database/
│   └── arsip_dokumen.sql    # Dump SQL database
├── public/                  # Document root web server (index.php)
├── tests/                   # Pengujian bawaan CodeIgniter
├── writable/
│   └── uploads/             # Penyimpanan file arsip (di luar public)
├── .env                     # Konfigurasi lokal (tidak di-commit)
├── env.example              # Contoh konfigurasi environment
├── composer.json
├── spark
└── README.md
```

## Catatan Konfigurasi Upload

Aplikasi membatasi ukuran file maksimal **5 MB**. Agar upload berjalan lancar, pastikan konfigurasi PHP di `php.ini` lebih besar dari batas tersebut:

```ini
upload_max_filesize = 8M
post_max_size = 10M
```

`post_max_size` harus lebih besar atau sama dengan `upload_max_filesize`. Setelah mengubah `php.ini`, restart web server (Apache/Nginx) atau PHP-FPM.

Cek nilai yang sedang aktif:

```bash
php -i | grep -E "upload_max_filesize|post_max_size"
```

Di Windows (PowerShell):

```powershell
php -i | Select-String "upload_max_filesize|post_max_size"
```

File upload disimpan di `writable/uploads/` dengan nama acak. File tidak dapat diakses langsung lewat URL public; akses hanya melalui route `archives/file` dan `archives/download` yang dilindungi login.

## Catatan untuk Hosting

- **Document root web server harus mengarah ke folder `public/`**, bukan ke root project. Jangan menaruh seluruh project di dalam `public_html` tanpa mengarahkan document root ke `public/`, karena file konfigurasi dan source code bisa terekspos.
- Pastikan folder `writable/` dapat ditulis oleh user web server.
- Set `CI_ENVIRONMENT = production` dan `app.baseURL` sesuai domain (gunakan HTTPS) saat production.
- Jangan commit file `.env`; gunakan environment variable atau konfigurasi server untuk kredensial.
- Untuk Apache, file `public/.htaccess` sudah disediakan. Untuk Nginx, arahkan `root` ke folder `public` dan teruskan request ke `index.php`.
- Proteksi folder `writable/` di Apache memakai `writable/.htaccess`. Pada Nginx, tambahkan aturan `location` untuk menolak akses langsung ke folder tersebut.
- Dump SQL tersedia di `database/arsip_dokumen.sql` untuk keperluan backup atau import.
