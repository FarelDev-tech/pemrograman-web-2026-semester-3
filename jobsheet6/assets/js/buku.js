// Jobsheet 6 Latihan 2 & 3: Memanfaatkan fungsi muatDataTabel dengan kolom kategori
function muatDaftarBuku() {
    // Jobsheet 6 Latihan 3: Menambahkan "kategori" ke daftar kunci yang dirender
    muatDataTabel("../data/buku.json", ["judul", "pengarang", "tahun", "kategori", "stok"]);
}

document.addEventListener("DOMContentLoaded", function () {
    muatDaftarBuku();

    // Jobsheet 6 Latihan 1: Menghubungkan tombol Muat Ulang ke fungsi muatDaftarBuku
    const btnMuatUlang = document.getElementById("btn-muat-ulang");
    if (btnMuatUlang) {
        btnMuatUlang.addEventListener("click", muatDaftarBuku);
    }
});
