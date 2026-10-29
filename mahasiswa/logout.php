<?php
/**
 * logout.php : Keluar dari aplikasi (hanya lewat POST + CSRF token)
 */
require_once __DIR__ . '/includes/auth.php';

// Hanya terima POST dengan token CSRF yang valid
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_verify($_POST['csrf_token'] ?? null)) {
    redirect('index.php');
}

// Simpan pilihan bahasa agar tetap konsisten setelah logout
$lang = current_lang();

// 1. Kosongkan semua data session
$_SESSION = [];

// 2. Hapus cookie session di browser
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// 3. Hancurkan session di server
session_destroy();

// 4. Mulai session baru yang bersih hanya untuk bahasa + pesan flash
session_start();
session_regenerate_id(true);
$_SESSION['lang'] = $lang;
set_flash('success', t('logout_success'));

redirect('login.php');
