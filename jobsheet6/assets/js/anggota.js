// Jobsheet 6 Latihan 2: Memanfaatkan fungsi muatDataTabel untuk modul anggota
function muatDaftarAnggota() {
    muatDataTabel("../data/anggota.json", ["no_anggota", "nama", "alamat", "no_hp"]);
}

document.addEventListener("DOMContentLoaded", muatDaftarAnggota);
