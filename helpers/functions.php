<?php
// helpers/functions.php — kumpulan function umum (dimuat dengan require_once)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ---------- Escaping & format ---------- */

function e(?string $nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function hitungDiskon(float $harga, float $persen = 10): float
{
    return $harga * ($persen / 100);
}

function validasiEmail(string $email): bool
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}

function ringkasTeks(string $teks, int $panjang = 50): string
{
    $teks = trim($teks);
    if (mb_strlen($teks) <= $panjang) {
        return $teks;
    }
    return rtrim(mb_substr($teks, 0, $panjang)) . '...';
}

/* ---------- Latihan function (bagian E) ---------- */

function konversiCelciusKeFahrenheit(float $c): float
{
    return ($c * 9 / 5) + 32;
}

function tentukanStatusNilai(float $nilai): string
{
    if ($nilai >= 85) return 'A (Sangat Baik)';
    if ($nilai >= 70) return 'B (Baik)';
    if ($nilai >= 55) return 'C (Cukup)';
    if ($nilai >= 40) return 'D (Kurang)';
    return 'E (Sangat Kurang)';
}

function hitungTotal(float $harga, int $jumlah): float
{
    return $harga * $jumlah;
}

/* ---------- URL & routing ---------- */

function url(string $page = 'dashboard', array $params = []): string
{
    $query = ['page' => $page] + $params;
    return 'index.php?' . http_build_query($query);
}

function asset(string $path): string
{
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    return $base . '/assets/' . ltrim($path, '/');
}

function redirect(string $page, array $params = []): void
{
    header('Location: ' . url($page, $params));
    exit;
}

function isActive(string $prefix, string $current): string
{
    return ($current === $prefix || str_starts_with($current, $prefix . '/')) ? 'active' : '';
}

/* ---------- Flash message ---------- */

function setFlash(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function tampilkanFlash(): void
{
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        $kelas = $f['tipe'] === 'sukses' ? 'alert-sukses' : 'alert-gagal';
        echo '<div class="alert ' . $kelas . '">' . e($f['pesan']) . '</div>';
    }
}

/* ---------- CSRF ---------- */

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

function csrfValid(): bool
{
    $token = $_POST['csrf_token'] ?? '';
    return is_string($token)
        && !empty($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

/* ---------- Autentikasi ---------- */

function isLoggedIn(): bool
{
    return !empty($_SESSION['admin_id']);
}

// Membuat tabel admins (jika belum ada) dan akun awal admin / admin123 saat tabel masih kosong.
// Hash dibuat saat runtime dengan password_hash(). GANTI password setelah pengujian.
function pastikanAdminAwal(PDO $pdo): void
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL
    )');

    if ((int) $pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn() === 0) {
        $stmt = $pdo->prepare('INSERT INTO admins (username, password_hash) VALUES (:u, :p)');
        $stmt->execute(['u' => 'admin', 'p' => password_hash('admin123', PASSWORD_DEFAULT)]);
    }
}
