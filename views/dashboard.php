<?php
$total = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
?>
<section class="content">
    <h2>Dashboard</h2>
    <p>Selamat datang di aplikasi PHP modular. Seluruh halaman memakai header dan footer yang sama dan diakses melalui router <code>index.php?page=...</code>.</p>
    <p><strong>Total pengguna terdaftar:</strong> <?= $total ?></p>
    <a class="btn" href="<?= e(url('user/list')) ?>">Kelola Pengguna</a>
</section>
