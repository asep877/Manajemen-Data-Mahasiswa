<?php
/**
 * includes/functions.php
 * Kumpulan fungsi bantu: escape output, redirect, flash message,
 * CSRF token, sanitasi dan validasi data mahasiswa.
 */

/**
 * Escape output HTML (wajib dipakai untuk setiap data yang ditampilkan).
 */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect ke URL tertentu lalu hentikan script.
 */
function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

/* ---------------------------------------------------------
 * FLASH MESSAGE (pesan sekali tampil, disimpan di session)
 * --------------------------------------------------------- */

function set_flash(string $type, string $message): void
{
    // $type: 'success' atau 'error'
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);   // hapus agar hanya tampil sekali
    return $flash;
}

/* ---------------------------------------------------------
 * CSRF TOKEN SEDERHANA
 * --------------------------------------------------------- */

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function csrf_verify($token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);   // perbandingan aman terhadap timing attack
}

/* ---------------------------------------------------------
 * SANITASI INPUT
 * --------------------------------------------------------- */

/**
 * Ambil nilai string dari array sumber (mis. $_POST) lalu trim().
 * Jika nilainya bukan string (mis. array hasil manipulasi), dianggap kosong.
 */
function input_string(array $source, string $key): string
{
    $value = $source[$key] ?? '';
    return is_string($value) ? trim($value) : '';
}

/**
 * Daftar jurusan yang diizinkan (whitelist untuk dropdown & validasi).
 */
function get_jurusan_list(): array
{
    return [
        'Teknik Informatika',
        'Sistem Informasi',
        'Teknik Elektro',
        'Teknik Sipil',
        'Manajemen',
        'Akuntansi',
        'Ilmu Komunikasi',
        'Desain Komunikasi Visual',
    ];
}

/**
 * Membersihkan input form mahasiswa.
 * - trim()               : buang spasi di awal/akhir
 * - filter_var()         : bersihkan karakter ilegal pada email
 * - htmlspecialchars()   : dilakukan saat OUTPUT lewat e(), bukan saat disimpan,
 *                          supaya data di database tidak ter-encode ganda.
 */
function sanitize_mahasiswa_input(array $source): array
{
    $data = [
        'nim'     => input_string($source, 'nim'),
        'nama'    => input_string($source, 'nama'),
        'email'   => input_string($source, 'email'),
        'jurusan' => input_string($source, 'jurusan'),
        'no_hp'   => input_string($source, 'no_hp'),
    ];

    // Rapikan spasi ganda pada nama
    $data['nama'] = preg_replace('/\s+/u', ' ', $data['nama']);

    // Hapus karakter yang tidak boleh ada di email
    $data['email'] = (string) filter_var($data['email'], FILTER_SANITIZE_EMAIL);

    return $data;
}

/* ---------------------------------------------------------
 * VALIDASI DATA MAHASISWA
 * --------------------------------------------------------- */

/**
 * Cek apakah NIM sudah dipakai mahasiswa lain (prepared statement).
 * $ignoreId dipakai saat edit agar data milik sendiri tidak dianggap duplikat.
 */
function nim_exists(PDO $pdo, string $nim, ?int $ignoreId = null): bool
{
    if ($ignoreId !== null) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM mahasiswa WHERE nim = :nim AND id <> :id');
        $stmt->execute([':nim' => $nim, ':id' => $ignoreId]);
    } else {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM mahasiswa WHERE nim = :nim');
        $stmt->execute([':nim' => $nim]);
    }

    return (int) $stmt->fetchColumn() > 0;
}

/**
 * Validasi sisi server. Mengembalikan array error per field
 * (array kosong = semua valid).
 */
function validate_mahasiswa(array $data, PDO $pdo, ?int $ignoreId = null): array
{
    $errors = [];

    foreach (['nim', 'nama', 'email', 'jurusan', 'no_hp'] as $field) {
        $value = $data[$field] ?? '';

        // Semua field wajib diisi
        if ($value === '') {
            $errors[$field] = t('err_required');
            continue;
        }

        // Validasi spesifik per field memakai switch + if-else
        switch ($field) {
            case 'nim':
                if (!preg_match('/^[0-9]+$/D', $value)) {
                    $errors['nim'] = t('err_nim_numeric');
                } elseif (strlen($value) < 5 || strlen($value) > 20) {
                    $errors['nim'] = t('err_nim_length');
                } elseif (nim_exists($pdo, $value, $ignoreId)) {
                    $errors['nim'] = t('err_nim_exists');
                }
                break;

            case 'nama':
                $panjang = mb_strlen($value, 'UTF-8');
                if ($panjang < 3 || $panjang > 100) {
                    $errors['nama'] = t('err_name_length');
                } elseif (!preg_match("/^[\p{L}][\p{L}\s.'\-]*$/u", $value)) {
                    $errors['nama'] = t('err_name_format');
                }
                break;

            case 'email':
                if (mb_strlen($value, 'UTF-8') > 100) {
                    $errors['email'] = t('err_email_length');
                } elseif (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors['email'] = t('err_email_invalid');
                }
                break;

            case 'jurusan':
                if (!in_array($value, get_jurusan_list(), true)) {
                    $errors['jurusan'] = t('err_major_invalid');
                }
                break;

            case 'no_hp':
                if (!preg_match('/^[0-9]+$/D', $value)) {
                    $errors['no_hp'] = t('err_phone_numeric');
                } elseif (strlen($value) < 10 || strlen($value) > 15) {
                    $errors['no_hp'] = t('err_phone_length');
                }
                break;
        }
    }

    return $errors;
}
