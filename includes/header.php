<?php
/**
 * includes/header.php
 * Bagian atas halaman: <head>, navigasi, pilihan bahasa, dan flash message.
 * Variabel opsional yang bisa diisi sebelum include:
 *   $page_title : judul halaman
 *   $body_class : class tambahan untuk <body>
 */
require_once __DIR__ . '/auth.php';

$page_title = $page_title ?? t('app_title');
$body_class = $body_class ?? '';
$flash      = get_flash();   // ambil pesan flash (sekali tampil)
?>
<!DOCTYPE html>
<html lang="<?= e(current_lang()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($page_title) ?> - <?= e(t('app_title')) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="<?= e($body_class) ?>">

<header class="topbar">
    <div class="container topbar-inner">
        <a class="brand" href="index.php"><?= e(t('app_title')) ?></a>

        <nav class="topbar-nav">
            <!-- Pilihan bahasa: ID | EN -->
            <div class="lang-switch" aria-label="<?= e(t('language_label')) ?>">
                <a href="set_lang.php?lang=id" class="<?= current_lang() === 'id' ? 'active' : '' ?>">ID</a>
                <span>|</span>
                <a href="set_lang.php?lang=en" class="<?= current_lang() === 'en' ? 'active' : '' ?>">EN</a>
            </div>

            <?php if (is_logged_in()): ?>
                <span class="user-info"><?= e(t('hello', $_SESSION['username'] ?? '')) ?></span>
                <!-- Logout lewat POST + CSRF token -->
                <form action="logout.php" method="post" class="inline-form">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-small btn-light"><?= e(t('logout')) ?></button>
                </form>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container main-content">
    <?php if ($flash): ?>
        <div class="alert <?= $flash['type'] === 'success' ? 'alert-success' : 'alert-error' ?>" role="alert">
            <?= e($flash['message']) ?>
        </div>
    <?php endif; ?>
