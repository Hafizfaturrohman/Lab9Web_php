<?php
$errors = [];
$nama = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        $errors[] = 'Token keamanan tidak valid.';
    } else {
        $nama  = trim($_POST['nama'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($nama === '' || mb_strlen($nama) > 100) $errors[] = 'Nama wajib diisi (maks. 100 karakter).';
        if (!validasiEmail($email))                 $errors[] = 'Format email tidak valid.';

        if (!$errors) {
            $stmt = $pdo->prepare('INSERT INTO users (nama, email) VALUES (:nama, :email)');
            $stmt->execute(['nama' => $nama, 'email' => $email]);
            setFlash('sukses', 'Pengguna berhasil ditambahkan.');
            redirect('user/list');
        }
    }
}
?>
<section>
    <h2>Tambah Pengguna</h2>
    <?php foreach ($errors as $err): ?>
        <div class="alert alert-gagal"><?= e($err) ?></div>
    <?php endforeach; ?>

    <form method="post" action="<?= e(url('user/add')) ?>">
        <?= csrfField() ?>
        <label>Nama</label>
        <input type="text" name="nama" value="<?= e($nama) ?>" required>
        <label>Email</label>
        <input type="text" name="email" value="<?= e($email) ?>" required>
        <button type="submit" class="btn">Simpan</button>
        <a href="<?= e(url('user/list')) ?>">Batal</a>
    </form>
</section>
