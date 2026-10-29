# Manajemen Data Mahasiswa (PHP Native + MySQL)

Aplikasi web CRUD untuk tugas kuliah **Pemrograman Web**, dibuat dengan
**PHP Native (tanpa framework)**, **MySQL (PDO)**, dan **HTML/CSS** sederhana.

## Fitur

- **Form & Validasi**
  - Form POST dengan validasi sisi server (if-else dan switch).
  - NIM hanya angka (5-20 digit) dan unik, email valid, No. HP hanya angka (10-15 digit).
  - Sanitasi dengan `trim()`, `filter_var()`, dan `htmlspecialchars()` (di setiap output).
  - Pesan error per field dan nilai input dipertahankan saat validasi gagal.
- **CRUD Database**
  - Koneksi PDO dengan prepared statements di semua query.
  - Create, Read (tabel dengan nomor urut), Update, dan Delete.
  - Delete lewat POST dengan konfirmasi JavaScript `confirm()`.
  - Flash message berhasil/gagal setelah setiap aksi.
- **Session**
  - Login dengan `password_hash()` / `password_verify()` dan `session_regenerate_id(true)`.
  - Semua halaman CRUD diproteksi (redirect ke `login.php` jika belum login).
  - Logout menghapus data session, cookie session, dan menghancurkan session.
  - Dual bahasa Indonesia | English (`$_SESSION['lang']`) dengan helper `t('key')`.
- **Keamanan tambahan**: token CSRF pada semua form (termasuk hapus dan logout),
  whitelist untuk dropdown jurusan dan redirect bahasa, cookie session `HttpOnly` + `SameSite`.

## Cara Instalasi (XAMPP)

1. Instal dan jalankan **XAMPP**, lalu aktifkan modul **Apache** dan **MySQL**
   di XAMPP Control Panel.
2. Salin folder proyek ini ke `C:\xampp\htdocs\` dan beri nama, misalnya, `mahasiswa`
   sehingga menjadi `C:\xampp\htdocs\mahasiswa\`.
   (Laragon: letakkan di `C:\laragon\www\mahasiswa\`.)
3. Import database (lihat bagian berikutnya).
4. Periksa `config/database.php`. Default-nya sudah sesuai XAMPP/Laragon
   (host `localhost`, user `root`, password kosong, database `db_mahasiswa`).
5. Buka browser: **http://localhost/mahasiswa/login.php**

> Kebutuhan: PHP 7.4+ (disarankan PHP 8.x) dengan ekstensi `pdo_mysql` dan `mbstring`
> (keduanya aktif secara default di XAMPP/Laragon).

## Cara Import SQL

**Lewat phpMyAdmin**
1. Buka http://localhost/phpmyadmin
2. Klik tab **Import** -> **Choose File** -> pilih `database.sql`.
3. Klik **Import** / **Go**. Database `db_mahasiswa` beserta tabel dan data contoh
   akan terbentuk otomatis.

**Lewat command line**
```bash
mysql -u root -p < database.sql
```

> Catatan: `database.sql` memuat `DROP TABLE IF EXISTS`, sehingga import ulang akan
> mengembalikan data ke kondisi awal.

## Akun Login

| Username | Password   |
|----------|------------|
| `admin`  | `admin123` |

Password disimpan dalam bentuk hash bcrypt (`password_hash()`), bukan teks biasa.

## Struktur Folder

```
project/
├── config/
│   └── database.php        # Konfigurasi & koneksi PDO
├── lang/
│   ├── id.php              # Terjemahan Bahasa Indonesia
│   └── en.php              # Terjemahan Bahasa Inggris
├── includes/
│   ├── auth.php            # Session, cek login, require_login()
│   ├── lang.php            # Helper bahasa: current_lang(), t('key')
│   ├── functions.php       # e(), flash, CSRF, sanitasi & validasi
│   ├── form_fields.php     # Field form bersama untuk create & edit
│   ├── header.php          # Header, navigasi, pilihan bahasa, flash
│   └── footer.php          # Footer + JS konfirmasi hapus
├── assets/
│   └── style.css           # Styling responsif
├── index.php               # Read: daftar data
├── create.php              # Create: tambah data
├── edit.php                # Update: ubah data
├── delete.php              # Delete: hapus data (POST)
├── login.php               # Halaman login
├── logout.php              # Logout (POST)
├── set_lang.php            # Ganti bahasa ID | EN
├── database.sql            # Struktur tabel + data contoh + user admin
└── README.md
```

## Catatan Teknis

- **Escape output**: semua data yang ditampilkan dibungkus `e()` (`htmlspecialchars` dengan
  `ENT_QUOTES` dan UTF-8). Data tidak di-escape saat disimpan agar tidak ter-encode ganda di database.
- **Menambah bahasa**: buat `lang/xx.php`, lalu tambahkan kode bahasa ke `SUPPORTED_LANGS`
  di `includes/lang.php`.
- **Menambah jurusan**: ubah daftar di fungsi `get_jurusan_list()` pada `includes/functions.php`.
- **Troubleshooting**: jika muncul "Koneksi database gagal", pastikan MySQL menyala,
  database sudah di-import, dan kredensial di `config/database.php` benar.
