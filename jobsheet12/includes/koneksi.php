<?php
$host = "localhost";
$port = "5432";
$db   = "simpus_mini_farel";
$user = "postgres";
$pass = "farel123";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Jobsheet 11 Latihan 2: Mencegah kebocoran informasi teknis ke browser
    error_log("Database Error: " . $e->getMessage());
    die("Maaf, terjadi gangguan pada koneksi sistem. Silakan coba beberapa saat lagi.");
}
