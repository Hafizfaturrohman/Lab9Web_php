# Lab9Web — Praktikum 9: PHP Modular

**Mata Kuliah:** Pemrograman Web
**Nama : Hafiz Faturrohman / NIM : 312210375** 

## 1. Tujuan Project
Menerapkan modularisasi aplikasi PHP: template bersama (header/footer), library function (helpers), struktur direktori terpisah berdasarkan tanggung jawab, routing berbasis parameter URL dengan whitelist + halaman 404, serta refactoring aplikasi CRUD pengguna.

## 2. Kebutuhan Perangkat
- PHP 8.0+ (memakai `str_starts_with`)
- MySQL/MariaDB
- Apache (XAMPP/Laragon) — `mod_rewrite` hanya untuk fitur opsional
- Browser dan VS Code

## 3. Cara Menjalankan
1. Salin folder `Lab9Web` ke docroot (`htdocs` XAMPP atau `www` Laragon).
2. Jalankan Apache dan MySQL.
3. Import `database.sql` melalui phpMyAdmin (membuat database `db_latihan` dan tabel `users`).
4. Sesuaikan kredensial di `config/database.php` bila perlu.
5. Buka `http://localhost/Lab9Web/index.php`.

## 4. Struktur Direktori
```
Lab9Web/
├── index.php              # titik masuk + router
├── database.sql           # skema & data awal
├── .htaccess              # (opsional) URL rewrite
├── config/database.php    # satu-satunya koneksi database (PDO)
├── views/                 # header, footer, dashboard, 404
├── helpers/functions.php  # function umum
├── modules/
│   ├── pages/             # profil, kontak, demo-helper
│   ├── user/              # list, add, edit, delete
│   └── auth/              # login, logout
├── assets/css, assets/js
└── latihan/               # uji include vs require (bagian C)
```

## 5. Daftar Rute
| Parameter `page` | File | Keterangan |
|---|---|---|
| `dashboard` (default) | views/dashboard.php | Beranda + total pengguna |
| `profil` | modules/pages/profil.php | Profil mahasiswa |
| `kontak` | modules/pages/kontak.php | Form kontak + validasi |
| `demo-helper` | modules/pages/demo-helper.php | Demo seluruh function |
| `user/list` | modules/user/list.php | Daftar pengguna |
| `user/add` | modules/user/add.php | Tambah pengguna |
| `user/edit&id=N` | modules/user/edit.php | Ubah pengguna |
| `user/delete` | modules/user/delete.php | Hapus (hanya POST + CSRF) |
| `auth/login` | modules/auth/login.php | Form login (admin / admin123) |
| `auth/logout` | modules/auth/logout.php | Logout (hanya POST + CSRF) |
| _lainnya_ | views/404.php | Status HTTP 404 |

Rute `user/*` hanya dapat diakses setelah login; jika belum login pengguna dialihkan ke `auth/login`.

## 6. Langkah Praktikum
1. **Include vs require** — `latihan/uji-include.php` memanggil `pesan.php`. Setelah `pesan.php` di-rename: `include` menampilkan *warning* dan baris setelahnya tetap jalan; `require` menghasilkan *fatal error* dan eksekusi berhenti.
2. **Template** — header/footer dipisah ke `views/`; halaman hanya berisi konten, dipanggil router.
3. **Function** — `helpers/functions.php` berisi `formatRupiah`, `hitungDiskon`, `validasiEmail`, `ringkasTeks`, `konversiCelciusKeFahrenheit`, `tentukanStatusNilai`, `hitungTotal`, `e`, plus helper URL, flash message, dan CSRF. Dipakai di dashboard, kontak, demo-helper, dan modul user.
4. **Struktur direktori** — sesuai bagian F modul.
5. **Router** — `index.php` memakai array `$routes` (whitelist). Input `page` tidak pernah digabung langsung menjadi path file; rute tak dikenal → 404.
6. **Refactoring CRUD** — koneksi hanya di `config/database.php`; semua tautan memakai `url()` → `index.php?page=...`; query memakai prepared statement.
7. **Tantangan mandiri** — menu aktif (`isActive()`), flash message sukses/gagal, `.htaccess` rewrite, dan pembatasan akses modul user dengan login (`modules/auth/`). Tabel `admins` dibuat otomatis saat halaman login pertama kali dibuka (akun awal `admin` / `admin123`, password disimpan dengan `password_hash`).

## 7. Pengujian Router
| Pengujian | Hasil yang diharapkan |
|---|---|
| `index.php` | Dashboard tampil |
| `index.php?page=user/list` | Daftar pengguna tampil |
| `index.php?page=user/add` | Form tambah tampil |
| `index.php?page=admin/rahasia` | 404 |
| `index.php?page=` | 404 |
| `index.php?page[]=x` | 404 (bukan string) |
| `index.php?page=../config/database` | 404 |
| Buka `index.php?page=user/delete` lewat URL | Dialihkan ke daftar, tidak ada data terhapus |
| Buka `index.php?page=user/list` tanpa login | Dialihkan ke halaman login |
| Login dengan password salah | Pesan "Username atau password salah" |
| Login `admin` / `admin123` | Masuk, menu menampilkan "Halo, admin" dan Logout |

## 8. Keamanan yang Diterapkan
- Whitelist rute (anti path traversal / LFI)
- Output di-escape dengan `e()` (anti XSS)
- Prepared statement PDO (anti SQL injection)
- Hapus/ubah/tambah via POST + token CSRF
- Detail error koneksi tidak ditampilkan ke pengguna

## 9. Kendala dan Solusi
| Kendala | Solusi |
|---|---|
| _(contoh)_ CSS tidak tampil setelah URL diubah | Path aset dibentuk lewat helper `asset()` |
| _(contoh)_ Redirect gagal: "headers already sent" | `ob_start()` di `index.php` |
| _(isi kendala Anda sendiri)_ | |

## 10. Screenshot
Tambahkan folder `screenshots/` berisi: struktur direktori, template (beberapa halaman), demo function, routing (termasuk 404), dan CRUD (list, tambah, edit, hapus).
