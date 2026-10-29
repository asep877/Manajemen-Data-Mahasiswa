<?php
/**
 * lang/id.php : Terjemahan Bahasa Indonesia
 */
return [
    // Umum
    'app_title'        => 'Manajemen Data Mahasiswa',
    'footer_text'      => '© %s Tugas Kuliah Pemrograman Web',
    'hello'            => 'Halo, %s',
    'logout'           => 'Keluar',
    'language_label'   => 'Bahasa',

    // Login
    'login_title'      => 'Masuk ke Aplikasi',
    'login_subtitle'   => 'Silakan login untuk mengelola data mahasiswa.',
    'username'         => 'Username',
    'password'         => 'Password',
    'login_button'     => 'Masuk',
    'login_required'   => 'Username dan password wajib diisi.',
    'login_failed'     => 'Username atau password salah.',
    'login_success'    => 'Login berhasil. Selamat datang, %s!',
    'logout_success'   => 'Anda telah keluar dari aplikasi.',
    'login_hint'       => 'Akun demo: admin / admin123',

    // Halaman & tombol
    'student_list'     => 'Daftar Mahasiswa',
    'add_student'      => 'Tambah Mahasiswa',
    'edit_student'     => 'Edit Mahasiswa',
    'no'               => 'No',
    'nim'              => 'NIM',
    'name'             => 'Nama Lengkap',
    'email'            => 'Email',
    'major'            => 'Jurusan',
    'phone'            => 'No. HP',
    'created_at'       => 'Dibuat Pada',
    'action'           => 'Aksi',
    'edit'             => 'Edit',
    'delete'           => 'Hapus',
    'save'             => 'Simpan',
    'update'           => 'Perbarui',
    'cancel'           => 'Batal',
    'select_major'     => '-- Pilih Jurusan --',
    'no_data'          => 'Belum ada data mahasiswa.',
    'total_data'       => 'Total: %d data',
    'confirm_delete'   => 'Yakin ingin menghapus data "%s"? Tindakan ini tidak dapat dibatalkan.',

    // Petunjuk isian
    'hint_nim'         => 'Hanya angka, 5-20 digit.',
    'hint_name'        => 'Huruf, spasi, titik, apostrof, atau tanda hubung (3-100 karakter).',
    'hint_email'       => 'Contoh: nama@email.com',
    'hint_phone'       => 'Hanya angka, 10-15 digit.',

    // Pesan flash
    'msg_created'        => 'Data mahasiswa berhasil ditambahkan.',
    'msg_create_failed'  => 'Gagal menyimpan data mahasiswa.',
    'msg_updated'        => 'Data mahasiswa berhasil diperbarui.',
    'msg_update_failed'  => 'Gagal memperbarui data mahasiswa.',
    'msg_deleted'        => 'Data mahasiswa berhasil dihapus.',
    'msg_delete_failed'  => 'Gagal menghapus data mahasiswa.',
    'msg_not_found'      => 'Data mahasiswa tidak ditemukan.',
    'msg_invalid_request'=> 'Permintaan tidak valid.',
    'msg_csrf_invalid'   => 'Token keamanan tidak valid. Silakan muat ulang halaman dan coba lagi.',
    'msg_db_error'       => 'Terjadi kesalahan pada database.',
    'form_has_errors'    => 'Periksa kembali isian formulir Anda.',

    // Pesan error validasi
    'err_required'       => 'Field ini wajib diisi.',
    'err_nim_numeric'    => 'NIM hanya boleh berisi angka.',
    'err_nim_length'     => 'NIM harus terdiri dari 5 sampai 20 digit.',
    'err_nim_exists'     => 'NIM sudah terdaftar.',
    'err_name_length'    => 'Nama harus 3 sampai 100 karakter.',
    'err_name_format'    => 'Nama hanya boleh berisi huruf, spasi, titik, apostrof, dan tanda hubung.',
    'err_email_invalid'  => 'Format email tidak valid.',
    'err_email_length'   => 'Email maksimal 100 karakter.',
    'err_major_invalid'  => 'Jurusan yang dipilih tidak valid.',
    'err_phone_numeric'  => 'No. HP hanya boleh berisi angka.',
    'err_phone_length'   => 'No. HP harus terdiri dari 10 sampai 15 digit.',
];
