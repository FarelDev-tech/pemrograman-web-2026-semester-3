<?php
// Jobsheet 8 Latihan 4: Skrip migrasi data dari JSON ke database PostgreSQL
require __DIR__ . '/includes/koneksi.php';

// Membaca data dari berkas JSON
$jsonData = file_get_contents(__DIR__ . '/data/buku.json');
$daftarBuku = json_decode($jsonData, true);

// Menyiapkan kueri insert
$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)"
);

// Memasukkan setiap baris buku ke dalam database
foreach ($daftarBuku as $buku) {
    $stmt->execute([
        'judul'     => $buku['judul'],
        'pengarang' => $buku['pengarang'],
        'tahun'     => (int) $buku['tahun'],
        'isbn'      => $buku['isbn'] ?? '-',
        'stok'      => (int) $buku['stok'],
        'kategori'  => $buku['kategori'] ?? 'Umum',
    ]);
}

// Menampilkan pesan berhasil
echo "Migrasi berhasil! Sebanyak " . count($daftarBuku) . " data buku berhasil dipindahkan ke PostgreSQL.";
