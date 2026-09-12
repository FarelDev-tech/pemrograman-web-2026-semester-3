# 📚 Jobsheet 06 — Komunikasi Asinkron (Fetch API & JSON)

Repositori implementasi praktikum **Jobsheet 06: Komunikasi Asinkron (Fetch API & JSON)** pada aplikasi **SIMPUS-Mini**, mata kuliah Pemrograman Web, Jurusan Teknologi Informasi, Politeknik Negeri Malang.

---

## 👤 Identitas Mahasiswa

| Informasi | Detail |
| --- | --- |
| **Nama Lengkap** | Farel Maulana Firdaus |
| **NIM** | `254107060069` |
| **Kelas** | SIB - 2D |
| **Program Studi** | D-IV Sistem Informasi Bisnis |
| **Sub-CPMK** | Menerapkan komunikasi asinkron (AJAX / Fetch API, format data JSON) |

---

## 🚀 Fitur & Perubahan Arsitektur

Pada praktikum ini, data tabel statis HTML diubah sepenuhnya menjadi dinamis berbasis data JSON lokal yang diambil asinkron:
1. **Pemisahan Data & Antarmuka (`data/*.json`)**:
   - `data/buku.json`: Menyimpan 10 data buku dengan atribut `judul`, `pengarang`, `tahun`, `kategori`, dan `stok`.
   - `data/anggota.json`: Menyimpan 4 data anggota perpustakaan.
2. **Dynamic Rendering (`<tbody>` Kosong)**:
   - Elemen `<tbody>` pada `buku/list.html` dan `anggota/list.html` dikosongkan pada HTML statis, lalu diisi secara dinamis via JavaScript setelah data berhasil di-*fetch*.
3. **Fungsi Generik Reusable (`muatDataTabel`)**:
   - Didefinisikan pada `assets/js/app.js` untuk melayani pengambilan dan perenderan data tabel secara modular berdasarkan daftar kunci (*keys*) yang diinginkan.
4. **Indikator Pemuatan (*Loading Indicator*) & Error Handling**:
   - Elemen `#loading-indicator` tampil selama proses tunggu *fetch*.
   - Blok `try ... catch ... finally` menangani kegagalan HTTP/jaringan dan menampilkan pesan kesalahan ramah pengguna di dalam tabel.
5. **Event Delegation pada Tombol Aksi**:
   - `initHapusConfirm()` pada `app.js` menggunakan *event delegation* pada objek `document` dengan metode `closest(".btn-hapus")`, memastikan baris tabel dinamis tetap dapat dieksekusi interaksinya.
6. **Konsistensi UI (Spotify Green Theme)**:
   - Menggunakan palet warna hijau Spotify (`#1DB954`) yang konsisten dari Jobsheet 05.

---

## 🛠️ Rangkuman Hasil Latihan Mandiri (1 — 5)

| No | Latihan | Deskripsi Singkat & Implementasi |
|:---:|---|---|
| **1** | **Tombol "Muat Ulang Data"** | Menambahkan tombol `#btn-muat-ulang` pada `buku/list.html` untuk memicu pemanggilan ulang fungsi `muatDaftarBuku()` tanpa *refresh* halaman. |
| **2** | **Fungsi Generik Fetch & Render** | Menyatukan logika *fetch* dan perenderan tabel menjadi fungsi generik `muatDataTabel(urlJson, daftarKunci)` di `assets/js/app.js`. |
| **3** | **Penambahan Kolom "Kategori"** | Menambahkan atribut `"kategori"` pada `data/buku.json`, kolom `<th>Kategori</th>` pada `buku/list.html`, dan memetakan kunci tersebut pada `assets/js/buku.js`. |
| **4** | **Eksperimen Event Delegation** | Menambahkan `console.log(e.target)` pada `initHapusConfirm()` untuk mengamati *event bubbling* dan penyaringan elemen target klik via `closest()`. |
| **5** | **Modifikasi Delay Simulasi Jaringan** | Mengubah durasi simulasi latensi jaringan dari 600ms menjadi 3000ms (3 detik) untuk mengamati transisi status *loading indicator* dan pengosongan tabel. |

---

## 💻 Cara Menjalankan Aplikasi

> ⚠️ **Catatan Penting (CORS Policy):**
> Permintaan `fetch()` ke berkas lokal akan diblokir oleh kebijakan keamanan *browser* (*CORS policy*) jika berkas dibuka langsung menggunakan protokol `file://`. Aplikasi **wajib dijalankan melalui server lokal**.

### Opsi 1: Menggunakan VS Code Live Server (Direkomendasikan)
1. Buka folder repositori di **Visual Studio Code**.
2. Klik kanan pada berkas `jobsheet6/index.html` atau `jobsheet6/buku/list.html`.
3. Pilih **"Open with Live Server"** (atau klik tombol **Go Live** di *status bar* bawah).
4. Akses melalui peramban di `http://127.0.0.1:5500/jobsheet6/`.

### Opsi 2: Menggunakan PHP Built-in Server
Jalankan perintah berikut di terminal:
```bash
php -S localhost:8000
```
Lalu buka peramban di `http://localhost:8000/jobsheet6/buku/list.html`.
