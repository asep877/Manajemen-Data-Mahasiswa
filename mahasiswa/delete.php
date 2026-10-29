<?php
/**
 * delete.php : DELETE - hapus data mahasiswa (hanya lewat POST + CSRF token)
 */
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

require_login();   // halaman terproteksi

// Tolak akses langsung lewat URL (GET): penghapusan wajib lewat POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

// Verifikasi token CSRF
if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    set_flash('error', t('msg_csrf_invalid'));
    redirect('index.php');
}

// Validasi id
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    set_flash('error', t('msg_invalid_request'));
    redirect('index.php');
}

try {
    $stmt = get_pdo()->prepare('DELETE FROM mahasiswa WHERE id = :id');
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        set_flash('success', t('msg_deleted'));
    } else {
        set_flash('error', t('msg_not_found'));
    }
} catch (PDOException $ex) {
    error_log('Gagal menghapus data: ' . $ex->getMessage());
    set_flash('error', t('msg_delete_failed'));
}

redirect('index.php');
