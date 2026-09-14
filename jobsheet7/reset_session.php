<?php
// Jobsheet 7 Latihan 4: Fitur reset seluruh data sesi via session_destroy()
session_start();

// Mengosongkan seluruh variabel di memori $_SESSION
$_SESSION = [];

// Menghapus cookie sesi dari browser apabila menggunakan cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Menghancurkan data dari sesi di server
session_destroy();

// Membuka sesi yang baru yang bersih untuk memuat notifikasi flash sukses reset
session_start();
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Seluruh data sesi berhasil direset dan dikosongkan.'
];

// Mengalihkan kembali ke halaman daftar buku
header('Location: buku/list.php');
exit;