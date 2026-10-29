<?php
/**
 * set_lang.php : Mengganti bahasa (ID | EN) lalu kembali ke halaman sebelumnya.
 * Contoh pemakaian: set_lang.php?lang=en
 */
require_once __DIR__ . '/includes/auth.php';

// Simpan pilihan bahasa hanya jika termasuk daftar yang didukung (whitelist)
$lang = $_GET['lang'] ?? '';
if (is_string($lang) && in_array($lang, SUPPORTED_LANGS, true)) {
    $_SESSION['lang'] = $lang;
}

// Kembali ke halaman asal. Hanya halaman di whitelist yang diizinkan
// (mencegah open redirect).
$allowedPages = ['index.php', 'create.php', 'edit.php', 'login.php'];
$target       = 'index.php';
$referer      = $_SERVER['HTTP_REFERER'] ?? '';

if ($referer !== '') {
    $parts = parse_url($referer);
    $page  = basename($parts['path'] ?? '');

    if (in_array($page, $allowedPages, true)) {
        $target = $page;

        // Pertahankan parameter id (dipakai oleh edit.php)
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $query);
            if (isset($query['id']) && is_string($query['id']) && ctype_digit($query['id'])) {
                $target .= '?id=' . $query['id'];
            }
        }
    }
}

redirect($target);
