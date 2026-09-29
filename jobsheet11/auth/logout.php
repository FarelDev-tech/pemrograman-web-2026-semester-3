<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Jobsheet 10 Latihan 2: Hapus cookie Remember Me saat logout
if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

session_destroy();
header('Location: login.php');
exit;