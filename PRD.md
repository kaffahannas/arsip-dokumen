# PRD: Sistem Arsip Dokumen

CodeIgniter 4 + MySQL | Dikerjakan dengan OpenCode | Target: siap di GitHub (belum hosting)

---

## 1. Ringkasan

Aplikasi web sederhana untuk mengarsipkan dokumen digital. Admin login, mengelola kategori, lalu mengunggah, melihat, mengunduh, mengubah, dan menghapus arsip dokumen (PDF/JPG/PNG).

**Tujuan:** memenuhi semua fitur wajib di technical test, dengan kode yang rapi, database terkelola (migration + seeder), UI responsif, dan repository GitHub lengkap dengan README.

**Kriteria penilaian yang harus dijaga:** kelengkapan fitur, struktur & kualitas kode, pengelolaan database, tampilan & kemudahan penggunaan, kelengkapan repository.

## 2. Scope

**In scope**

- Login (email + password) dan logout
- CRUD kategori
- CRUD arsip + upload file + lihat + download
- Tampilan responsif
- Migration + seeder + file SQL dump
- README dengan panduan instalasi

**Out of scope (jangan dikerjakan dulu)**

- Registrasi user, lupa password, multi-role
- Hosting/deployment
- Fitur di luar soal (versioning dokumen, sharing, OCR)

Saran: pencarian dan filter kategori di daftar arsip boleh ditambahkan sebagai nilai plus kalau waktu cukup (lihat bagian 10).

## 3. Pengguna

Satu peran: **Admin**. Akun dibuat lewat seeder (tidak ada registrasi).

Akun uji (dipakai juga di README):

- Email: admin@example.com
- Password: Admin12345

## 4. Kebutuhan Fungsional

### A. Autentikasi

| ID | Kebutuhan | Acceptance criteria |
| --- | --- | --- |
| A1 | Login dengan email & password | Input valid masuk ke dashboard/daftar arsip; input salah menampilkan pesan error; validasi form (email wajib & format valid, password wajib) |
| A2 | Logout | Session dihapus, redirect ke halaman login |
| A3 | Proteksi halaman | Semua halaman selain login butuh login; akses tanpa login diarahkan ke /login; user yang sudah login tidak bisa membuka /login lagi |

### B. Manajemen Kategori

| ID | Kebutuhan | Acceptance criteria |
| --- | --- | --- |
| B1 | Daftar kategori | Tabel berisi nama, deskripsi, jumlah arsip, tombol aksi |
| B2 | Tambah kategori | Nama wajib, maksimal 100 karakter, unik |
| B3 | Edit kategori | Form terisi data lama; validasi unik mengabaikan record sendiri |
| B4 | Hapus kategori | Ada konfirmasi. Jika kategori masih dipakai arsip, hapus ditolak dengan pesan jelas (bukan error database) |

### C. Manajemen Arsip

| ID | Kebutuhan | Acceptance criteria |
| --- | --- | --- |
| C1 | Daftar arsip | Tabel dengan judul, kategori, nama file, ukuran, tanggal, aksi; ada pagination |
| C2 | Tambah arsip | Judul wajib (maks 150), kategori wajib (harus ada di DB), deskripsi opsional, file wajib |
| C3 | Upload dokumen | Hanya PDF, JPG/JPEG, PNG; maksimal 5 MB; validasi ekstensi dan MIME type |
| C4 | Edit arsip | Judul, kategori, deskripsi bisa diubah; file boleh diganti (opsional); file lama dihapus dari disk jika diganti |
| C5 | Hapus arsip | Ada konfirmasi; record dan file fisik ikut terhapus |
| C6 | Lihat dokumen | PDF/gambar tampil di browser (inline) lewat halaman detail |
| C7 | Download dokumen | File terunduh dengan nama asli |

## 5. Kebutuhan Non-Fungsional

- **Responsif:** Bootstrap 5 (lewat CDN), tabel dibungkus table-responsive, navbar collapse di mobile.
- **Keamanan:**
  - Password disimpan dengan password\_hash() dan dicek dengan password\_verify().
  - CSRF protection CI4 aktif untuk semua form POST.
  - Output di view memakai esc().
  - File **disimpan di luar folder public** (writable/uploads) dengan nama acak (getRandomName()), diakses lewat controller yang dilindungi login.
  - Validasi ekstensi dan MIME type, batas ukuran.
  - Session ID di-regenerate saat login.
- **UX:** flash message sukses/gagal, validasi inline, konfirmasi sebelum hapus, empty state ketika data kosong.
- **Kode:** konvensi CI4 (Controller tipis, Model untuk query, Filter untuk auth, View dengan layout bersama), nama bahasa Inggris konsisten, komentar seperlunya.

## 6. Model Data

**users**

- id (PK), name, email (UNIQUE), password (hash), created\_at, updated\_at

**categories**

- id (PK), name (UNIQUE), description (NULL), created\_at, updated\_at

**archives**

- id (PK), category\_id (FK ke categories.id, ON DELETE RESTRICT), title, description (NULL), original\_name, stored\_name, mime\_type, file\_size, uploaded\_by (FK ke users.id), created\_at, updated\_at

Index: archives.category\_id, archives.title.

## 7. Routes

| Method | URL | Fungsi |
| --- | --- | --- |
| GET | /login | Form login |
| POST | /login | Proses login |
| GET | /logout | Logout (disarankan POST dengan CSRF) |
| GET | / | Redirect ke /archives |
| GET | /categories | Daftar kategori |
| GET/POST | /categories/create, /categories | Form & simpan |
| GET/POST | /categories/edit/(:num), /categories/update/(:num) | Form & update |
| POST | /categories/delete/(:num) | Hapus |
| GET | /archives | Daftar arsip |
| GET/POST | /archives/create, /archives | Form & simpan |
| GET | /archives/(:num) | Detail + preview |
| GET/POST | /archives/edit/(:num), /archives/update/(:num) | Form & update |
| POST | /archives/delete/(:num) | Hapus |
| GET | /archives/file/(:num) | Tampilkan inline |
| GET | /archives/download/(:num) | Download |

Semua route kecuali /login dibungkus filter `auth`.

## 8. Struktur Folder Target

```
app/
  Config/Routes.php, Filters.php
  Controllers/ Auth.php, Categories.php, Archives.php
  Models/ UserModel.php, CategoryModel.php, ArchiveModel.php
  Filters/ AuthFilter.php, GuestFilter.php
  Database/Migrations/ (3 file)
  Database/Seeds/ UserSeeder.php, CategorySeeder.php, DatabaseSeeder.php
  Views/ layouts/main.php, auth/login.php, categories/*, archives/*
writable/uploads/ (isi di-ignore git, simpan .gitkeep)
database/arsip_dokumen.sql (dump)
PRD.md
README.md
AGENTS.md
```

## 9. Rencana Implementasi untuk OpenCode

Pekerjaan dibagi menjadi 10 fase berurutan. Satu fase = satu prompt. Setelah tiap fase, agent berhenti dan menunggu pengguna menguji dan melakukan commit.

### Aturan untuk agent

- Kerjakan hanya fase yang diminta; jangan mengerjakan fase berikutnya.
- Jadikan bagian 2 sampai 8 dokumen ini sumber kebenaran. Jika ada yang bertentangan atau tidak jelas, tanyakan ke pengguna.
- Jangan menambah fitur di luar scope (bagian 2).
- Jangan menjalankan git commit atau git push; pengguna yang melakukannya.
- Jangan menaruh kredensial nyata di repository; satu-satunya kredensial yang boleh ditulis adalah akun uji seeder (bagian 3).
- Setelah selesai, tulis ringkasan: file yang dibuat atau diubah, dan perintah untuk mengujinya.

### Fase 1: Aturan project (AGENTS.md)

```
Baca PRD.md. Tambahkan ke AGENTS.md aturan berikut: gunakan CodeIgniter 4 saja (tanpa framework lain), Controller tipis, query lewat Model, auth lewat Filter, semua form POST wajib CSRF, output view wajib esc(), file upload disimpan di writable/uploads. Tambahkan juga aturan agent dari bagian 9 PRD (kerjakan hanya fase yang diminta, jangan git commit atau push, jangan tambah fitur di luar scope). Jangan ubah kode lain.
```

Selesai jika: AGENTS.md memuat semua aturan di atas dan tidak ada file kode lain yang berubah.

### Fase 2: Konfigurasi environment

```
Baca PRD.md. Buat file .env dari env: atur CI_ENVIRONMENT=development, app.baseURL=http://localhost:8080/, dan koneksi database MySQL (database arsip_dokumen, user root, password kosong, DBDriver MySQLi). Pastikan .gitignore mengabaikan .env dan isi writable/uploads kecuali .gitkeep, lalu buat folder writable/uploads dengan .gitkeep. Buat juga env.example yang aman untuk di-commit. Jangan buat kode aplikasi.
```

Selesai jika: .env dan env.example ada, .env diabaikan git, writable/uploads/.gitkeep ada.

### Fase 3: Migration, seeder, dan model

```
Baca PRD.md bagian 3 dan 6. Buat 3 migration (users, categories, archives) lengkap dengan foreign key, index, dan timestamps sesuai model data. Buat seeder: UserSeeder (admin@example.com / Admin12345 dengan password di-hash), CategorySeeder (3 kategori contoh), dan DatabaseSeeder yang memanggil keduanya. Buat UserModel, CategoryModel, ArchiveModel dengan allowedFields, useTimestamps, dan validation rules. Jangan buat controller atau view.
```

Selesai jika: `php spark migrate` dan `php spark db:seed DatabaseSeeder` berjalan tanpa error dari database kosong.

### Fase 4: Layout dan autentikasi

```
Baca PRD.md bagian 4A, 5, dan 7. Implementasikan A1-A3: Auth controller (login, logout), AuthFilter (belum login diarahkan ke /login), GuestFilter (sudah login tidak boleh ke /login), daftarkan di Config/Filters.php dan Routes.php. Buat layout views/layouts/main.php dengan Bootstrap 5 CDN, navbar responsif (menu Arsip, Kategori, Logout), dan area flash message. Buat halaman login yang rapi dan responsif. Regenerate session ID saat login berhasil. Untuk sementara buat halaman /archives sebagai placeholder.
```

Selesai jika: seluruh acceptance criteria A1-A3 terpenuhi.

### Fase 5: CRUD kategori

```
Baca PRD.md bagian 4B, 5, dan 7. Implementasikan B1-B4: Categories controller, views (index, form create/edit), dan route di dalam group dengan filter auth. Tampilkan jumlah arsip per kategori. Saat hapus, jika kategori dipakai arsip tampilkan pesan error yang ramah. Gunakan validasi CI4 (unik dengan pengecualian id saat edit), flash message, konfirmasi hapus, dan empty state.
```

Selesai jika: seluruh acceptance criteria B1-B4 terpenuhi.

### Fase 6: CRUD arsip dan upload

```
Baca PRD.md bagian 4C, 5, dan 7. Implementasikan C1-C5: Archives controller dan views (index dengan pagination, create, edit). Aturan upload: validasi uploaded + max_size 5120 KB + ext_in pdf,jpg,jpeg,png + mime_in application/pdf,image/jpeg,image/png. Simpan file ke WRITEPATH . 'uploads' dengan getRandomName(); simpan original_name, stored_name, mime_type, file_size ke database. Saat edit dengan file baru, hapus file lama; saat hapus arsip, hapus file fisiknya. Jika insert database gagal, hapus file yang sudah terupload. Dropdown kategori diambil dari CategoryModel.
```

Selesai jika: seluruh acceptance criteria C1-C5 terpenuhi, termasuk penolakan file yang tidak valid.

### Fase 7: Lihat dan download dokumen

```
Baca PRD.md bagian 4C dan 7. Implementasikan C6-C7: halaman detail arsip (GET /archives/(:num)) berisi metadata dan preview (iframe untuk PDF, tag img untuk gambar, responsif), route /archives/file/(:num) untuk tampil inline, dan /archives/download/(:num) untuk unduh dengan nama asli. Keduanya lewat controller dan filter auth, lempar PageNotFoundException bila record atau file tidak ada. Gunakan Content-Type dari mime_type dan Content-Disposition yang sesuai.
```

Selesai jika: C6 dan C7 terpenuhi, dan file tidak bisa diakses tanpa login.

### Fase 8: Poles UI dan UX

```
Baca PRD.md bagian 5. Rapikan tampilan: pastikan semua halaman responsif di lebar 360px, 768px, dan desktop; tabel pakai table-responsive; tambah badge kategori, format ukuran file (KB/MB) dan tanggal yang mudah dibaca, ikon tombol aksi, dan halaman error 404 sederhana. Jangan mengubah logika bisnis.
```

Selesai jika: tidak ada tabel atau elemen yang melebar keluar layar di 360px.

### Fase 9: Review keamanan dan kualitas kode

Jalankan di mode Plan (tanpa mengubah file).

```
Review seluruh kode terhadap PRD.md dan checklist ini: CSRF aktif di semua form, esc() di semua output, tidak ada query mentah yang rentan injeksi, file upload tidak bisa diakses langsung dari URL public, tidak ada kode mati atau debug. Berikan daftar temuan dulu, jangan ubah apa pun.
```

Selesai jika: daftar temuan diberikan; perbaikan dikerjakan dengan prompt terpisah atas persetujuan pengguna.

### Fase 10: README

```
Buat README.md berbahasa Indonesia berisi: deskripsi singkat, fitur, tech stack, prasyarat, langkah instalasi (git clone, composer install, salin env.example ke .env, buat database, php spark migrate, php spark db:seed DatabaseSeeder, php spark serve), akun uji, struktur folder singkat, catatan konfigurasi upload (upload_max_filesize dan post_max_size di php.ini), dan catatan untuk hosting kelak (document root harus mengarah ke folder public). Tambahkan juga lokasi file dump SQL di database/arsip_dokumen.sql.
```

Selesai jika: seseorang yang belum pernah melihat project bisa menjalankannya hanya dengan README.

## 10. Nilai Plus (opsional, hanya jika waktu cukup)

- Pencarian judul dan filter kategori di daftar arsip
- Statistik ringkas di dashboard (jumlah arsip dan kategori)
- Ganti password admin

## 11. Kriteria Selesai

- [ ] Semua requirement A1-A3, B1-B4, C1-C7 memenuhi acceptance criteria
- [ ] Migration dan seeder berjalan dari database kosong
- [ ] Tidak ada kredensial atau file .env di repository
- [ ] File upload tidak dapat diakses tanpa login
- [ ] Tampilan responsif di 360px, 768px, dan desktop
- [ ] README berisi panduan instalasi dan akun uji
- [ ] Dump SQL tersedia di database/arsip\_dokumen.sql
