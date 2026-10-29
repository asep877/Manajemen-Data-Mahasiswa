<?php
/**
 * config/database.php
 * Konfigurasi dan koneksi database memakai PDO.
 * Sesuaikan nilai di bawah jika setting MySQL Anda berbeda.
 * (Default XAMPP/Laragon: user "root" dengan password kosong)
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'db_mahasiswa');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/**
 * Mengembalikan objek PDO (koneksi dibuat sekali saja per request).
 */
function get_pdo(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // error jadi exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // hasil berupa array asosiatif
        PDO::ATTR_EMULATE_PREPARES   => false,                    // prepared statement asli (lebih aman)
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $ex) {
        // Detail error hanya ditulis ke log, tidak ditampilkan ke pengguna
        error_log('Koneksi database gagal: ' . $ex->getMessage());
        http_response_code(500);
        die('Koneksi database gagal / Database connection failed. '
            . 'Periksa config/database.php dan pastikan MySQL sudah berjalan.');
    }

    return $pdo;
}
