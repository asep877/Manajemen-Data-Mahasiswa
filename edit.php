<?php
/**
 * edit.php : UPDATE - form edit data mahasiswa berdasarkan id
 */
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

require_login();   // halaman terproteksi

$pdo = get_pdo();

// Ambil dan validasi id dari URL (harus bilangan bulat positif)
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    set_flash('error', t('msg_invalid_request'));
    redirect('index.php');
}

// Ambil data lama dari database
try {
    $stmt = $pdo->prepare('SELECT id, nim, nama, email, jurusan, no_hp FROM mahasiswa WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $student = $stmt->fetch();
} catch (PDOException $ex) {
    error_log('Gagal membaca data: ' . $ex->getMessage());
    set_flash('error', t('msg_db_error'));
    redirect('index.php');
}

if (!$student) {
    set_flash('error', t('msg_not_found'));
    redirect('index.php');
}

// Nilai awal form = data lama dari database
$data = [
    'nim'     => $student['nim'],
    'nama'    => $student['nama'],
    'email'   => $student['email'],
    'jurusan' => $student['jurusan'],
    'no_hp'   => $student['no_hp'],
];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $errors['general'] = t('msg_csrf_invalid');
    } else {
        // 1. Sanitasi input (menimpa data lama agar input terbaru tetap tampil jika error)
        $data = sanitize_mahasiswa_input($_POST);

        // 2. Validasi (NIM milik mahasiswa ini sendiri tidak dianggap duplikat)
        $errors = validate_mahasiswa($data, $pdo, $id);

        // 3. Jika valid, update dengan prepared statement
        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare(
                    'UPDATE mahasiswa
                     SET nim = :nim, nama = :nama, email = :email, jurusan = :jurusan, no_hp = :no_hp
                     WHERE id = :id'
                );
                $stmt->execute([
                    ':nim'     => $data['nim'],
                    ':nama'    => $data['nama'],
                    ':email'   => $data['email'],
                    ':jurusan' => $data['jurusan'],
                    ':no_hp'   => $data['no_hp'],
                    ':id'      => $id,
                ]);

                set_flash('success', t('msg_updated'));
                redirect('index.php');
            } catch (PDOException $ex) {
                error_log('Gagal memperbarui data: ' . $ex->getMessage());
                $errors['general'] = t('msg_update_failed');
            }
        }
    }
}

$page_title = t('edit_student');
require __DIR__ . '/includes/header.php';
?>

<div class="card form-card">
    <div class="card-header">
        <h1><?= e(t('edit_student')) ?></h1>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error" role="alert">
            <?= e($errors['general'] ?? t('form_has_errors')) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="edit.php?id=<?= (int) $id ?>" novalidate>
        <?= csrf_field() ?>

        <?php require __DIR__ . '/includes/form_fields.php'; ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= e(t('update')) ?></button>
            <a href="index.php" class="btn btn-outline"><?= e(t('cancel')) ?></a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
