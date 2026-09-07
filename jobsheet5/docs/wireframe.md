# Wireframe & User Flow — SIMPUS-Mini

Sub-CPMK: Merancang UI/UX aplikasi (proyek).

Halaman yang sudah ada belum mencakup fitur Login, Dashboard Petugas, dan Peminjaman/Pengembalian. Dokumen ini merancang wireframe untuk halam (Beranda, Daftar/Tambah Buku, Daftar/Tambah Anggota — Jobsheet 1-3)an-halaman tersebut sebelum diimplementasikan mulai Jobsheet 5 dan seterusnya.

## Aktor
- **Tamu**: hanya bisa melihat katalog buku (Beranda, Daftar Buku) tanpa login.
- **Petugas**: login untuk mengakses seluruh fitur CRUD dan transaksi peminjaman.

## User Flow — Peminjaman Buku

```
[Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"]
        -> [Pilih Anggota] -> [Pilih Buku (stok > 0)]
        -> [Simpan] -> [Stok buku berkurang 1] -> [Kembali ke Dashboard]
```

## User Flow — Pengembalian Buku

```
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)]
        -> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1]
        -> [Kembali ke Dashboard]
```

## User Flow — Pemeriksaan Tunggakan Buku Terlambat
<!-- Jobsheet 4 Soal 2: Menambahkan User Flow Baru untuk Pemeriksaan Buku Terlambat -->

```
[Dashboard] -> [Pilih menu/kartu "Buku Terlambat"]
        -> [Sistem menyaring transaksi: Tanggal Sekarang > Batas Kembali]
        -> [Pilih Anggota Terlambat] -> [Klik "Kirim Peringatan / Hitung Denda"]
        -> [Sistem mencatat denda keterlambatan] -> [Kembali ke Dashboard]
```


## Wireframe: Halaman Login

```
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|        [ Login Petugas ]             |
|                                      |
|   Username : [______________]        |
|   Password : [______________]        |
|                                      |
|          [   Masuk   ]               |
|                                      |
|   Belum punya akun? Daftar di sini   |
+--------------------------------------+
```

## Wireframe: Dashboard Petugas

```
+--------------------------------------------------------------------------------+
| SIMPUS-Mini      Beranda | Buku | Anggota | Peminjaman | (Nama Petugas) Logout |
|--------------------------------------------------------------------------------|
|  [Total Buku]   [Total Anggota]   [Sedang Dipinjam]                            |
|                                                                                |
|  Aksi Cepat:                                                                   |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]                                    |
|                                                                                |
|  Transaksi Terbaru                                                             |
|  ------------------------------------------------------------------------------|
|  Anggota | Buku | Tgl Pinjam | Status                                          |
+--------------------------------------------------------------------------------+
```

## Wireframe: Form Peminjaman

```
+--------------------------------------+
|  Form Peminjaman Buku                |
|--------------------------------------|
|  Anggota : [ dropdown pilih anggota ]|
|  Buku    : [ dropdown, hanya stok>0 ]|
|  Tanggal Pinjam : [ auto: hari ini ] |
|                                      |
|          [  Simpan Peminjaman  ]     |
+--------------------------------------+
```

## Wireframe: Form Pengembalian

```
+---------------------------------------------+
|  Pengembalian Buku                          |        
|---------------------------------------------|
|  Cari transaksi aktif:                      |
|  [ nama anggota / judul buku ______ ]       |
|                                             |
|  Anggota | Buku | Tgl Pinjam | [Kembalikan] |
+---------------------------------------------+
```

## Wireframe: Riwayat Peminjaman per Anggota

```
+-------------------------------------------------+
|  Riwayat Peminjaman — Siti Aminah               |
|-------------------------------------------------|
|  Buku           | Pinjam   | Kembali | Status   |
|  Laskar Pelangi | 01/07    | 10/07   | Selesai  |
|  Bumi Manusia   | 15/07    | -       | Dipinjam |
+-------------------------------------------------+
```

## Wireframe: Registrasi Anggota Baru

<!-- Jobsheet 4 Latihan 1: Menambahkan Wireframe baru untuk anggota baru -->

```
+-------------------------------------------------+
|                   SIMPUS-Mini                   |
|-------------------------------------------------|
|                                                 |
|          [ Registrasi Anggota Baru ]            |
|                                                 |
|   Nama Lengkap    : [________________________]  |
|   Alamat          : [________________________]  |
|   Nomor WhatsApp  : [________________________]  |
|   Alamat Email    : [________________________]  |
|   Kata Sandi      : [________________________]  |
|                                                 |
|              [  Daftar Sekarang  ]              |
|                                                 |
|      Sudah punya akun? Masuk di sini            |
+-------------------------------------------------+
```