<?php
// Logout hanya lewat POST + CSRF
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfValid()) {
    redirect('dashboard');
}

unset($_SESSION['admin_id'], $_SESSION['admin_nama'], $_SESSION['csrf_token']);
session_regenerate_id(true);
setFlash('sukses', 'Anda telah logout.');
redirect('auth/login');
