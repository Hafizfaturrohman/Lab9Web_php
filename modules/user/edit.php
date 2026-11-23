<?php
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$user = false;
if ($id) {
    $stmt = $pdo->prepare('SELECT id, nama, email FROM users WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();
}

if (!$user) {
    http_response_code(404);
    echo '<section><h2>Data tidak ditemukan</h2><a href="' . e(url('user/list')) . '">Kembali</a></section>';
    return;
}

$errors = [];
$nama  = $user['nama'];
$email = $user['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        $errors[] = 'Token keamanan tidak valid.';
    } else {
        $nama  = trim($_POST['nama'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($nama === '' || mb_strlen($nama) > 100) $errors[] = 'Nama wajib diisi (maks. 100 karakter).';
        if (!validasiEmail($email))                 $errors[] = 'Format email tidak valid.';

        if (!$errors) {
            $stmt = $pdo->prepare('UPDATE users SET nama = :nama, email = :email WHERE id = :id');
            $stmt->execute(['nama' => $nama, 'email' => $email, 'id' => $id]);
            setFlash('sukses', 'Data pengguna berhasil diperbarui.');
            redirect('user/list');
        }
    }
}
?>
<section>
    <h2>Edit Pengguna</h2>
    <?php foreach ($errors as $err): ?>
        <div class="alert alert-gagal"><?= e($err) ?></div>
    <?php endforeach; ?>

    <form method="post" action="<?= e(url('user/edit', ['id' => $id])) ?>">
        <?= csrfField() ?>
        <label>Nama</label>
        <input type="text" name="nama" value="<?= e($nama) ?>" required>
        <label>Email</label>
        <input type="text" name="email" value="<?= e($email) ?>" required>
        <button type="submit" class="btn">Perbarui</button>
        <a href="<?= e(url('user/list')) ?>">Batal</a>
    </form>
</section>
