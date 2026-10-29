<?php
/**
 * includes/lang.php
 * Helper bahasa (dual language ID | EN).
 * Bahasa yang dipilih disimpan di $_SESSION['lang'].
 */

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

const SUPPORTED_LANGS = ['id', 'en'];
const DEFAULT_LANG    = 'id';

// Jika belum ada pilihan bahasa, pakai bahasa default
if (!isset($_SESSION['lang']) || !in_array($_SESSION['lang'], SUPPORTED_LANGS, true)) {
    $_SESSION['lang'] = DEFAULT_LANG;
}

/**
 * Mengembalikan kode bahasa aktif ('id' atau 'en').
 */
function current_lang(): string
{
    $lang = $_SESSION['lang'] ?? DEFAULT_LANG;
    return in_array($lang, SUPPORTED_LANGS, true) ? $lang : DEFAULT_LANG;
}

/**
 * Memuat array terjemahan dari lang/id.php atau lang/en.php (di-cache per request).
 */
function load_translations(): array
{
    static $translations = null;

    if ($translations === null) {
        $file = __DIR__ . '/../lang/' . current_lang() . '.php';
        $translations = require $file;
    }

    return $translations;
}

/**
 * Helper terjemahan: t('key') atau t('key', $arg1, $arg2) untuk placeholder %s / %d.
 * Jika key tidak ditemukan, key itu sendiri yang dikembalikan.
 */
function t(string $key, ...$args): string
{
    $translations = load_translations();
    $text = $translations[$key] ?? $key;

    return $args ? vsprintf($text, $args) : $text;
}
