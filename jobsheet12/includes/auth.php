<?php
// Guard clause: di-include di baris paling atas setiap halaman yang
// membutuhkan login (sebelum header.php mengeluarkan output apa pun),
// agar header('Location: ...') masih bisa dipanggil.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jobsheet 10 Latihan 2: Otomatis pulihkan sesi dari cookie jika sesi browser telah tertutup
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_user'])) {
    try {
        require_once __DIR__ . '/koneksi.php';
        $stmt = $pdo->prepare("SELECT id, nama, role FROM users WHERE username = :username");
        $stmt->execute(['username' => $_COOKIE['remember_user']]);
        $u = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($u) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['nama']    = $u['nama'];
            $_SESSION['role']    = $u['role'];
        }
    } catch (\Throwable $e) {
        // Abaikan error koneksi agar guard tetap bekerja mengalihkan ke login
    }
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}