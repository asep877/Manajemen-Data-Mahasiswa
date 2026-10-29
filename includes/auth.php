<?php
/**
 * includes/auth.php
 * Dipakai di SEMUA halaman. Menyiapkan session, bahasa, helper,
 * serta fungsi pengecekan login.
 */

// Atur cookie session yang lebih aman sebelum session dimulai
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,     // tidak bisa dibaca JavaScript
        'samesite' => 'Lax',    // membantu mencegah CSRF lintas situs
    ]);
    session_start();
}

require_once __DIR__ . '/lang.php';
require_once __DIR__ . '/functions.php';

/**
 * Apakah pengguna sudah login?
 */
function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Proteksi halaman: jika belum login, arahkan ke login.php.
 * Panggil fungsi ini di bagian atas setiap halaman CRUD.
 */
function require_login(): void
{
    if (!is_logged_in()) {
        redirect('login.php');
    }
}
