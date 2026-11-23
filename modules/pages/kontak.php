<?php
$errors = [];
$nama = $email = $pesan = '';
$terkirim = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        $errors[] = 'Token keamanan tidak valid.';
    } else {
        $nama  = trim($_POST['nama'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pesan = trim($_POST['pesan'] ?? '');

        if ($nama === '')              $errors[] = 'Nama wajib diisi.';
        if (!validasiEmail($email))    $errors[] = 'Format email tidak valid.';
        if ($pesan === '')             $errors[] = 'Pesan wajib diisi.';

        if (!$errors) $terkirim = true;
    }
}
?>
<section class="content">
    <h2>Kontak</h2>

    <?php if ($terkirim): ?>
        <div class="alert alert-sukses">
            Terima kasih, <?= e($nama) ?>. Pesan Anda ("<?= e(ringkasTeks($pesan, 40)) ?>") telah diterima.
        </div>
    <?php else: ?>
        <?php foreach ($errors as $err): ?>
            <div class="alert alert-gagal"><?= e($err) ?></div>
        <?php endforeach; ?>

        <form method="post" action="<?= e(url('kontak')) ?>">
            <?= csrfField() ?>
            <label>Nama</label>
            <input type="text" name="nama" value="<?= e($nama) ?>" required>
            <label>Email</label>
            <input type="text" name="email" value="<?= e($email) ?>" required>
            <label>Pesan</label>
            <textarea name="pesan" rows="4" required><?= e($pesan) ?></textarea>
            <button type="submit" class="btn">Kirim</button>
        </form>
    <?php endif; ?>
</section>
