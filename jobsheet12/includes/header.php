<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';
$sudahLogin = isset($_SESSION['user_id']);

// Jobsheet 11 Latihan 4: Lapisan pertahanan Content-Security-Policy (CSP) terhadap XSS
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self';");

// Prefix relatif ke root proyek ini (bukan root domain) — supaya
// /assets, /index.php, dst tetap benar walau proyek diakses lewat
// subfolder (mis. dp2026.test/kode-praktikum/jobsheet-11/), bukan cuma lewat vhost yang document root-nya langsung folder ini.
$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
$__currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
$__currentPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Jobsheet 11 Latihan 3: Escaping variabel $page_title pada tag title -->
    <title>SIMPUS-Mini<?php echo isset($page_title) ? ' | ' . e($page_title) : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header>
        <div class="header-top">
            <h1><a href="<?php echo $base; ?>index.php">SIMPUS-Mini</a></h1>
            <div class="header-actions">
                <div class="auth-status">
                    <?php if ($sudahLogin): ?>
                        <span><?php echo e($_SESSION['nama'] ?? $_SESSION['username'] ?? 'Petugas'); ?></span>
                        <a href="<?php echo $base; ?>auth/logout.php">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo $base; ?>auth/login.php">Login</a>
                    <?php endif; ?>
                </div>
                <button type="button" id="nav-toggle-btn" class="nav-toggle-label">&#9776;</button>
            </div>
        </div>
        <nav id="main-nav">
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
                <?php if ($sudahLogin): ?>
                <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
                <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
                <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
                <li><a href="<?php echo $base; ?>peminjaman/tambah.php">Peminjaman Baru</a></li>
                <li><a href="<?php echo $base; ?>peminjaman/kembali.php">Pengembalian</a></li>
                <li><a href="<?php echo $base; ?>peminjaman/riwayat.php">Riwayat</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>