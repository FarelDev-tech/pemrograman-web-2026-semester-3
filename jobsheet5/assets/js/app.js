// Hamburger Menu menggantikan checkbox css hack
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// Konfirmasi hapus (front-end only, belum ke server) 
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const nama = row ? row.querySelector("td")?.textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
            if (yakin && row) {
                row.remove();
                updateTableCounter(); // Latihan 4: Update counter setelah baris dihapus
            }
        });
    });
}

// ===== Latihan 4: Indikator Penghitung Baris Tersisa (Real-Time Counter) =====
function updateTableCounter() {
    const table = document.querySelector(".table-responsive table");
    if (!table) return;

    let counter = document.getElementById("table-counter");
    if (!counter) {
        counter = document.createElement("p");
        counter.id = "table-counter";
        counter.className = "table-counter";
        const container = document.querySelector(".table-responsive");
        if (container) {
            container.parentNode.insertBefore(counter, container);
        }
    }

    const allRows = table.querySelectorAll("tbody tr");
    const totalRows = allRows.length;
    let visibleRows = 0;
    allRows.forEach(function (row) {
        if (row.style.display !== "none") {
            visibleRows++;
        }
    });

    const isAnggota = table.querySelector("th:nth-child(2)")?.textContent.toLowerCase().includes("nama");
    const entitas = isAnggota ? "anggota" : "buku";
    counter.textContent = "Menampilkan " + visibleRows + " dari " + totalRows + " " + entitas;
}

// Filter/pencarian tabel 
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    // Jobsheet 5 Latihan 3: Menentukan kolom target pencarian: dibagian kolom kedua jika tabel Anggota (Nama), kolom pertama jika tabel Buku (Judul)
    const isTabelAnggota = table.querySelector("th:nth-child(2)")?.textContent.toLowerCase().includes("nama");
    const targetIndex = isTabelAnggota ? 1 : 0; 

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            // Jobsheet 5 Latihan 3: Ambil sel kolom target spesifik (bukan seluruh teks baris)
            const cell = row.cells[targetIndex] || row.querySelector("td");
            const teks = cell ? cell.textContent.toLowerCase() : "";
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
        updateTableCounter(); // Latihan 4: Update counter saat filter pencarian berjalan
    });
}

// Validasi form (client-side)
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

// ===== Latihan 5: Refactor Validasi Form dengan Skema Array & Perulangan forEach =====
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // Daftar konfigurasi aturan validasi per field (Buku & Anggota)
        const aturanValidasi = [
            {
                selector: "[name='judul'], [name='nama']",
                uji: function (input) { return input.value.trim() === ""; },
                pesan: "Field ini wajib diisi."
            },
            {
                selector: "[name='pengarang']",
                uji: function (input) { return input.value.trim() === ""; },
                pesan: "Pengarang wajib diisi."
            },
            {
                selector: "[name='no_anggota']",
                uji: function (input) { return input.value.trim() === ""; },
                pesan: "No. Anggota wajib diisi."
            },
            {
                selector: "[name='tahun']",
                uji: function (input) {
                    const nilai = parseInt(input.value, 10);
                    return isNaN(nilai) || nilai < 1900 || nilai > 2026;
                },
                pesan: "Tahun harus di antara 1900-2026."
            },
            {
                selector: "[name='stok']",
                uji: function (input) {
                    const nilai = parseInt(input.value, 10);
                    return isNaN(nilai) || nilai < 0;
                },
                pesan: "Stok tidak boleh negatif."
            },
            {
                selector: "[name='isbn']",
                uji: function (input) {
                    return input.value.trim() !== "" && !/^[\d-]+$/.test(input.value.trim());
                },
                pesan: "ISBN hanya boleh berupa angka dan tanda hubung (-)."
            }
        ];

        // Perulangan evaluasi aturan secara otomatis
        aturanValidasi.forEach(function (aturan) {
            const input = form.querySelector(aturan.selector);
            if (input) {
                if (aturan.uji(input)) {
                    tampilkanError(input, aturan.pesan);
                    valid = false;
                } else {
                    hapusError(input);
                }
            }
        });

        if (!valid) {
            e.preventDefault();
        }
    });
}

// Menjalankan fungsi saat seluruh dokumen HTML selesai dimuat
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
    updateTableCounter();
});
