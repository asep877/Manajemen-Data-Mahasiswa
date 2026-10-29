<?php
/**
 * includes/form_fields.php
 * Field form mahasiswa yang dipakai bersama oleh create.php dan edit.php.
 * Membutuhkan variabel:
 *   $data   : array nilai field (nim, nama, email, jurusan, no_hp)
 *   $errors : array pesan error per field
 */
?>
<!-- NIM -->
<div class="form-group <?= isset($errors['nim']) ? 'has-error' : '' ?>">
    <label for="nim"><?= e(t('nim')) ?></label>
    <input type="text" id="nim" name="nim" value="<?= e($data['nim']) ?>"
           inputmode="numeric" maxlength="20" autocomplete="off">
    <small class="hint"><?= e(t('hint_nim')) ?></small>
    <?php if (isset($errors['nim'])): ?>
        <span class="error-text"><?= e($errors['nim']) ?></span>
    <?php endif; ?>
</div>

<!-- Nama -->
<div class="form-group <?= isset($errors['nama']) ? 'has-error' : '' ?>">
    <label for="nama"><?= e(t('name')) ?></label>
    <input type="text" id="nama" name="nama" value="<?= e($data['nama']) ?>"
           maxlength="100" autocomplete="off">
    <small class="hint"><?= e(t('hint_name')) ?></small>
    <?php if (isset($errors['nama'])): ?>
        <span class="error-text"><?= e($errors['nama']) ?></span>
    <?php endif; ?>
</div>

<!-- Email -->
<div class="form-group <?= isset($errors['email']) ? 'has-error' : '' ?>">
    <label for="email"><?= e(t('email')) ?></label>
    <input type="text" id="email" name="email" value="<?= e($data['email']) ?>"
           maxlength="100" autocomplete="off">
    <small class="hint"><?= e(t('hint_email')) ?></small>
    <?php if (isset($errors['email'])): ?>
        <span class="error-text"><?= e($errors['email']) ?></span>
    <?php endif; ?>
</div>

<!-- Jurusan -->
<div class="form-group <?= isset($errors['jurusan']) ? 'has-error' : '' ?>">
    <label for="jurusan"><?= e(t('major')) ?></label>
    <select id="jurusan" name="jurusan">
        <option value=""><?= e(t('select_major')) ?></option>
        <?php foreach (get_jurusan_list() as $jurusan): ?>
            <option value="<?= e($jurusan) ?>" <?= $data['jurusan'] === $jurusan ? 'selected' : '' ?>>
                <?= e($jurusan) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errors['jurusan'])): ?>
        <span class="error-text"><?= e($errors['jurusan']) ?></span>
    <?php endif; ?>
</div>

<!-- No. HP -->
<div class="form-group <?= isset($errors['no_hp']) ? 'has-error' : '' ?>">
    <label for="no_hp"><?= e(t('phone')) ?></label>
    <input type="text" id="no_hp" name="no_hp" value="<?= e($data['no_hp']) ?>"
           inputmode="numeric" maxlength="15" autocomplete="off">
    <small class="hint"><?= e(t('hint_phone')) ?></small>
    <?php if (isset($errors['no_hp'])): ?>
        <span class="error-text"><?= e($errors['no_hp']) ?></span>
    <?php endif; ?>
</div>
