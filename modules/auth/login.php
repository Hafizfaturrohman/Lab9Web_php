<?php
if (isLoggedIn()) {
    redirect('user/list');
}

pastikanAdminAwal($pdo);

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfValid()) {
        $errors[] = 'Token keamanan tidak valid.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admins WHERE username = :u');
        $stmt->execute(['u' => $username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id']   = (int) $admin['id'];
            $_SESSION['admin_nama'] = $admin['username'];
            setFlash('sukses', 'Login berhasil. Selamat datang, ' . $admin['username'] . '.');

            $tujuan = $_SESSION['redirect_after_login'] ?? 'user/list';
            unset($_SESSION['redirect_after_login']);
            redirect($tujuan);
        }
        $errors[] = 'Username atau password salah.';
    }
}
?>
<section>
    <h2>Login</h2>
    <p>Halaman Data Pengguna hanya dapat diakses setelah login.</p>
    <?php foreach ($errors as $err): ?>
        <div class="alert alert-gagal"><?= e($err) ?></div>
    <?php endforeach; ?>

    <form method="post" action="<?= e(url('auth/login')) ?>">
        <?= csrfField() ?>
        <label>Username</label>
        <input type="text" name="username" value="<?= e($username) ?>" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit" class="btn">Masuk</button>
    </form>
    <p><small>Akun awal praktikum: <code>admin</code> / <code>admin123</code></small></p>
</section>
