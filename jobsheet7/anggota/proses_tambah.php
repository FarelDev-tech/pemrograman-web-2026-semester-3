<?php
session_start();

$nama = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($noAnggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}

// Jobsheet 7 Latihan 2: Validasi format No. Anggota (diawali agt) dan Nomor HP (angka minimal 10 digit)
if ($noAnggota !== '' && !preg_match('/^AGT-[0-9]+$/i', $noAnggota)) {
    $errors[] = "No. Anggota harus diawali 'AGT-' diikuti angka (contoh: AGT-001).";
}
if ($noHp !== '' && (!is_numeric($noHp) || strlen($noHp) < 10)) {
    $errors[] = "Nomor HP harus berupa angka dan minimal 10 digit.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

$_SESSION['anggota'][] = [
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'alamat' => $alamat,
    'no_hp' => $noHp,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;
