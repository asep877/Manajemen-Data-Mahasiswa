<?php
/**
 * includes/footer.php
 * Bagian bawah halaman + JavaScript konfirmasi hapus.
 */
?>
</main>

<footer class="footer">
    <div class="container">
        <?= e(t('footer_text', date('Y'))) ?>
    </div>
</footer>

<script>
    // Konfirmasi sebelum form dengan atribut data-confirm dikirim (dipakai untuk tombol Hapus)
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm(form.getAttribute('data-confirm'))) {
                event.preventDefault();   // batalkan pengiriman jika pengguna memilih Cancel
            }
        });
    });
</script>
</body>
</html>
