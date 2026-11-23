<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab9Web - Aplikasi PHP Modular</title>
    <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body>
<div class="container">
    <header>
        <h1>Aplikasi PHP Modular</h1>
        <p>Praktikum 9 — Template, Function, dan Routing</p>
    </header>
    <nav>
        <a class="<?= isActive('dashboard', $currentPage) ?>" href="<?= e(url('dashboard')) ?>">Home</a>
        <a class="<?= isActive('profil', $currentPage) ?>" href="<?= e(url('profil')) ?>">Profil</a>
        <a class="<?= isActive('kontak', $currentPage) ?>" href="<?= e(url('kontak')) ?>">Kontak</a>
        <a class="<?= isActive('user', $currentPage) ?>" href="<?= e(url('user/list')) ?>">Data Pengguna</a>
        <a class="<?= isActive('demo-helper', $currentPage) ?>" href="<?= e(url('demo-helper')) ?>">Demo Helper</a>
        <span class="nav-kanan">
        <?php if (isLoggedIn()): ?>
            <form method="post" action="<?= e(url('auth/logout')) ?>" class="inline">
                <?= csrfField() ?>
                <span>Halo, <?= e($_SESSION['admin_nama'] ?? '') ?></span>
                <button type="submit" class="btn-link">Logout</button>
            </form>
        <?php else: ?>
            <a class="<?= isActive('auth', $currentPage) ?>" href="<?= e(url('auth/login')) ?>">Login</a>
        <?php endif; ?>
        </span>
    </nav>
    <main>
        <?php tampilkanFlash(); ?>
