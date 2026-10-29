<?php
/**
 * index.php : READ - menampilkan seluruh data mahasiswa dalam tabel
 */
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

require_login();   // halaman terproteksi

$students = [];

try {
    $stmt = get_pdo()->prepare(
        'SELECT id, nim, nama, email, jurusan, no_hp, created_at
         FROM mahasiswa
         ORDER BY id ASC'
    );
    $stmt->execute();
    $students = $stmt->fetchAll();
} catch (PDOException $ex) {
    error_log('Gagal membaca data: ' . $ex->getMessage());
    set_flash('error', t('msg_db_error'));
}

$page_title = t('student_list');
require __DIR__ . '/includes/header.php';
?>

<div class="card">
    <div class="card-header">
        <h1><?= e(t('student_list')) ?></h1>
        <a href="create.php" class="btn btn-primary">+ <?= e(t('add_student')) ?></a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th class="text-center"><?= e(t('no')) ?></th>
                    <th><?= e(t('nim')) ?></th>
                    <th><?= e(t('name')) ?></th>
                    <th><?= e(t('email')) ?></th>
                    <th><?= e(t('major')) ?></th>
                    <th><?= e(t('phone')) ?></th>
                    <th><?= e(t('created_at')) ?></th>
                    <th><?= e(t('action')) ?></th>
                </tr>
            </thead>
            <tbody>
            <?php if (count($students) === 0): ?>
                <tr>
                    <td colspan="8" class="empty-row"><?= e(t('no_data')) ?></td>
                </tr>
            <?php else: ?>
                <?php $nomor = 1; ?>
                <?php foreach ($students as $row): ?>
                    <tr>
                        <td class="text-center"><?= $nomor++ ?></td>
                        <td><?= e($row['nim']) ?></td>
                        <td><?= e($row['nama']) ?></td>
                        <td><?= e($row['email']) ?></td>
                        <td><?= e($row['jurusan']) ?></td>
                        <td><?= e($row['no_hp']) ?></td>
                        <td><?= e(date('d-m-Y H:i', strtotime($row['created_at']))) ?></td>
                        <td>
                            <div class="actions">
                                <a href="edit.php?id=<?= (int) $row['id'] ?>" class="btn btn-outline btn-small">
                                    <?= e(t('edit')) ?>
                                </a>

                                <!-- Hapus lewat POST + CSRF + konfirmasi JavaScript -->
                                <form action="delete.php" method="post" class="inline-form"
                                      data-confirm="<?= e(t('confirm_delete', $row['nama'])) ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-small">
                                        <?= e(t('delete')) ?>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <p class="total-info"><?= e(t('total_data', count($students))) ?></p>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
