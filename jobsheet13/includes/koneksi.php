<?php
$config = require __DIR__ . '/config.php';

try {
    // Jika terhubung ke database cloud (bukan localhost), aktifkan sslmode=require
    $isLocal = in_array($config['db_host'], ['localhost', '127.0.0.1'], true);
    $ssl = $isLocal ? '' : ';sslmode=require';

    $pdo = new PDO(
        "pgsql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_name']}{$ssl}",
        $config['db_user'],
        $config['db_pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jobsheet 11 Latihan 2: Mencegah kebocoran informasi teknis ke browser
    error_log("Database Error: " . $e->getMessage());
    die("Maaf, terjadi gangguan pada koneksi sistem. Silakan coba beberapa saat lagi.");
}
