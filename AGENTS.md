# Aturan Project

## Stack dan Arsitektur

- Gunakan **CodeIgniter 4 saja**; jangan memakai framework lain.
- **Controller tipis**: logika bisnis dan query tidak ditulis di controller.
- Semua query database lewat **Model** (UserModel, CategoryModel, ArchiveModel), bukan query mentah di controller.
- Autentikasi ditangani lewat **Filter** (AuthFilter, GuestFilter), bukan pengecekan manual di setiap controller.
- Semua form **POST wajib memakai CSRF** protection CodeIgniter 4.
- Semua output di view wajib di-escape dengan **esc()**.
- File upload disimpan di **writable/uploads** (di luar folder public), bukan di public.

## Aturan untuk Agent

- Kerjakan **hanya fase yang diminta**; jangan mengerjakan fase berikutnya.
- **Jangan menjalankan git commit atau git push**; pengguna yang melakukannya.
- **Jangan menambah fitur di luar scope** (PRD bagian 2).
- Jadikan PRD bagian 2 sampai 8 sebagai sumber kebenaran. Jika ada yang bertentangan atau tidak jelas, tanyakan ke pengguna.
- Jangan menaruh kredensial nyata di repository; satu-satunya kredensial yang boleh ditulis adalah akun uji seeder (PRD bagian 3).
- Setelah selesai, tulis ringkasan: file yang dibuat atau diubah, dan perintah untuk mengujinya.
