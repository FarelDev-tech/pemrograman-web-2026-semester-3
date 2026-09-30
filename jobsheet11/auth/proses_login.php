<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Jobsheet 10 Latihan 3: batas maksimal percobaan gagal
$maxAttempts = 3;
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = [];
}
$userKey = strtolower($username);
$attempts = $_SESSION['login_attempts'][$userKey] ?? 0;

// Jobsheet 10 Latihan 3: Cek apakah akun sedang terkunci karena melebihi batas percobaan
if ($attempts >= $maxAttempts) {
    $_SESSION['flash'] = [
        'type'  => 'error',
        'pesan' => "Akses diblokir! Terlalu banyak percobaan gagal untuk akun '$username'. Silakan hubungi admin."
    ];
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Regenerasi session ID setelah login berhasil untuk mencegah session fixation.
    session_regenerate_id(true);

    // Jobsheet 10 Latihan 3: Reset counter percobaan gagal jika login berhasil
    unset($_SESSION['login_attempts'][$userKey]);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    // Jobsheet 10 Latihan 2: Simpan persistent cookie selama 30 hari jika opsi dicentang
    if (!empty($_POST['remember'])) {
        setcookie('remember_user', $user['username'], [
            'expires'  => time() + (30 * 24 * 60 * 60),
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    header('Location: ../index.php');
    exit;
}

// Jobsheet 10 Latihan 3: Akumulasi hitungan kegagalan login dan hitung sisa kesempatan
$_SESSION['login_attempts'][$userKey] = $attempts + 1;
$sisa = $maxAttempts - $_SESSION['login_attempts'][$userKey];

if ($sisa > 0) {
    $pesan = "Username atau password salah. Sisa kesempatan: $sisa kali.";
} else {
    $pesan = "Batas percobaan terlampaui! Akun '$username' terkunci sementara dari percobaan brute-force.";
}

$_SESSION['flash'] = ['type' => 'error', 'pesan' => $pesan];
header('Location: login.php');
exit;