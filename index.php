<?php
// index.php — titik masuk aplikasi sekaligus router
ob_start(); // memungkinkan redirect setelah proses form meski header sudah dimuat

require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/config/database.php';

// Whitelist rute: hanya halaman ini yang boleh diakses
$routes = [
    'dashboard'    => __DIR__ . '/views/dashboard.php',
    'profil'       => __DIR__ . '/modules/pages/profil.php',
    'kontak'       => __DIR__ . '/modules/pages/kontak.php',
    'demo-helper'  => __DIR__ . '/modules/pages/demo-helper.php',
    'user/list'    => __DIR__ . '/modules/user/list.php',
    'user/add'     => __DIR__ . '/modules/user/add.php',
    'user/edit'    => __DIR__ . '/modules/user/edit.php',
    'user/delete'  => __DIR__ . '/modules/user/delete.php',
    'auth/login'   => __DIR__ . '/modules/auth/login.php',
    'auth/logout'  => __DIR__ . '/modules/auth/logout.php',
];

// Rute yang hanya boleh diakses setelah login
$protectedRoutes = ['user/list', 'user/add', 'user/edit', 'user/delete'];

$page = $_GET['page'] ?? 'dashboard';

if (!is_string($page) || $page === '' || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $page        = '404';
    $contentFile = __DIR__ . '/views/404.php';
} else {
    $contentFile = $routes[$page];
}

// Pembatasan akses: wajib login untuk rute terlindungi
if (in_array($page, $protectedRoutes, true) && !isLoggedIn()) {
    $_SESSION['redirect_after_login'] = 'user/list';
    setFlash('gagal', 'Silakan login terlebih dahulu.');
    redirect('auth/login');
}

$currentPage = $page; // dipakai header.php untuk menu aktif

require_once __DIR__ . '/views/header.php';
require $contentFile;
require_once __DIR__ . '/views/footer.php';
ob_end_flush();
