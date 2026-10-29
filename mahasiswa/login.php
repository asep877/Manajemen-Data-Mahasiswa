<?php
/**
 * login.php : Halaman login (memakai $_SESSION, password_verify, regenerate id)
 */
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

// Jika sudah login, tidak perlu melihat halaman login lagi
if (is_logged_in()) {
    redirect('index.php');
}

$errors   = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        // Token CSRF tidak cocok
        $errors['general'] = t('msg_csrf_invalid');
    } else {
        $username = input_string($_POST, 'username');
        $password = (isset($_POST['password']) && is_string($_POST['password'])) ? $_POST['password'] : '';

        if ($username === '' || $password === '') {
            $errors['general'] = t('login_required');
        } else {
            try {
                // Cari user dengan prepared statement
                $stmt = get_pdo()->prepare('SELECT id, username, password FROM users WHERE username = :username LIMIT 1');
                $stmt->execute([':username' => $username]);
                $user = $stmt->fetch();

                // Verifikasi password terhadap hash di database
                if ($user && password_verify($password, $user['password'])) {

                    // Cegah session fixation: buat ID session baru setelah login berhasil
                    session_regenerate_id(true);

                    $_SESSION['user_id']  = (int) $user['id'];
                    $_SESSION['username'] = $user['username'];

                    set_flash('success', t('login_success', $user['username']));
                    redirect('index.php');
                } else {
                    $errors['general'] = t('login_failed');
                }
            } catch (PDOException $ex) {
                error_log('Login error: ' . $ex->getMessage());
                $errors['general'] = t('msg_db_error');
            }
        }
    }
}

$page_title = t('login_title');
$body_class = 'auth-page';
require __DIR__ . '/includes/header.php';
?>

<div class="card auth-card">
    <h1><?= e(t('login_title')) ?></h1>
    <p class="subtitle"><?= e(t('login_subtitle')) ?></p>

    <?php if (isset($errors['general'])): ?>
        <div class="alert alert-error" role="alert"><?= e($errors['general']) ?></div>
    <?php endif; ?>

    <form method="post" action="login.php" novalidate>
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="username"><?= e(t('username')) ?></label>
            <!-- Nilai username dipertahankan jika login gagal -->
            <input type="text" id="username" name="username" value="<?= e($username) ?>" autocomplete="username" autofocus>
        </div>

        <div class="form-group">
            <label for="password"><?= e(t('password')) ?></label>
            <input type="password" id="password" name="password" autocomplete="current-password">
        </div>

        <button type="submit" class="btn btn-primary btn-block"><?= e(t('login_button')) ?></button>
    </form>

    <p class="demo-hint"><?= e(t('login_hint')) ?></p>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
