<?php
/**
 * create.php : CREATE - form tambah data mahasiswa + validasi + simpan
 */
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

require_login();   // halaman terproteksi

$pdo = get_pdo();

// Nilai awal form (kosong)
$data = [
    'nim'     => '',
    'nama'    => '',
    'email'   => '',
    'jurusan' => '',
    'no_hp'   => '',
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $errors['general'] = t('msg_csrf_invalid');
    } else {
        // 1. Sanitasi input (nilai ini juga dipakai untuk mengisi ulang form)
        $data = sanitize_mahasiswa_input($_POST);

        // 2. Validasi sisi server
        $errors = validate_mahasiswa($data, $pdo);

        // 3. Jika valid, simpan ke database dengan prepared statement
        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare(
                    'INSERT INTO mahasiswa (nim, nama, email, jurusan, no_hp)
                     VALUES (:nim, :nama, :email, :jurusan, :no_hp)'
                );
                $stmt->execute([
                    ':nim'     => $data['nim'],
                    ':nama'    => $data['nama'],
                    ':email'   => $data['email'],
                    ':jurusan' => $data['jurusan'],
                    ':no_hp'   => $data['no_hp'],
                ]);

                set_flash('success', t('msg_created'));
                redirect('index.php');
            } catch (PDOException $ex) {
                error_log('Gagal menyimpan data: ' . $ex->getMessage());
                $errors['general'] = t('msg_create_failed');
            }
        }
    }
}

$page_title = t('add_student');
require __DIR__ . '/includes/header.php';
?>

<div class="card form-card">
    <div class="card-header">
        <h1><?= e(t('add_student')) ?></h1>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error" role="alert">
            <?= e($errors['general'] ?? t('form_has_errors')) ?>
        </div>
    <?php endif; ?>

    <!-- novalidate: agar validasi server yang tampil (bukan validasi bawaan browser) -->
    <form method="post" action="create.php" novalidate>
        <?= csrf_field() ?>

        <?php require __DIR__ . '/includes/form_fields.php'; ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= e(t('save')) ?></button>
            <a href="index.php" class="btn btn-outline"><?= e(t('cancel')) ?></a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
