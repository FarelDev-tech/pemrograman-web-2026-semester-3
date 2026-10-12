# Draf Naskah Presentasi Demo UAS — SIMPUS-Mini (5–7 Menit)

**Penyaji:** Farel Maulana Firdaus (NIM: 254107060069)  
**Kelas / Prodi:** SIB 2D / D4 Sistem Informasi Bisnis  
**Mata Kuliah:** Pemrograman Web (SIB253007)  
**Aplikasi:** SIMPUS-Mini (Sistem Informasi Manajemen Perpustakaan Mini)

---

## Ringkasan Alur Waktu & Poin Demo

| Menit | Segmen | Fokus Pembahasan & Demo Layar |
| :--- | :--- | :--- |
| **00:00 – 01:00** | **1. Pembukaan & Gambaran Umum** | Salam pembuka, identitas, perkenalan sistem perpustakaan SIMPUS-Mini, serta stack teknologi yang digunakan. |
| **01:00 – 02:30** | **2. Arsitektur Basis Data (ERD)** | Demo ERD 4 tabel (`buku`, `anggota`, `users`, `peminjaman`), relasi FK, dan batasan integritas data. |
| **02:30 – 04:00** | **3. Transaksi Peminjaman & Konkurensi** | Live demo peminjaman, penjelasan atomisitas transaksi ACID, penguncian baris `SELECT ... FOR UPDATE`, dan validasi keterlambatan >14 hari. |
| **04:00 – 05:15** | **4. Pertahanan Keamanan Berlapis** | Penjelasan Prepared Statement, escaping `e()`, proteksi CSRF, header CSP, dan penutupan *Information Disclosure*. |
| **05:15 – 06:15** | **5. Arsitektur Deployment (12-Factor App)** | Penjelasan isolasi konfigurasi `config.php` via `getenv()`, template `.env.example`, dan kalkulasi dinamis `$base`. |
| **06:15 – 07:00** | **6. Penutup & Sesi Tanya Jawab** | Kesimpulan integrasi end-to-end Jobsheet 1–13 dan siap menjawab pertanyaan dosen penguji. |

---

## Teks Naskah Presentasi Lengkap

### 1. Pembukaan & Gambaran Umum Sistem (00:00 – 01:00)
> *"Selamat pagi/siang Bapak Dosen Penguji dan rekan-rekan sekalian.  
> Perkenalkan, nama saya **Farel Maulana Firdaus** dari kelas SIB 2D, NIM 254107060069. Pada kesempatan kali ini, saya akan mempresentasikan dan mendemonstrasikan produk akhir praktikum Pemrograman Web kami, yaitu **SIMPUS-Mini** (Sistem Informasi Manajemen Perpustakaan Mini).
>
> SIMPUS-Mini dibangun secara utuh melalui tahapan 13 jobsheet menggunakan stack **PHP Native 8.2+**, **PostgreSQL** dengan driver **PDO**, antarmuka semantik **HTML5**, layout responsif **CSS Grid & Flexbox**, serta interaktivitas **JavaScript Native**. Sistem ini dirancang untuk mendigitalkan sirkulasi perpustakaan secara aman, efisien, dan siap dideploy di lingkungan produksi."*

---

### 2. Alasan Desain Teknis Arsitektur Basis Data (01:00 – 02:30)
*(Aksi Layar: Membuka diagram ERD di README.md / tabel database di terminal/pgAdmin)*

> *"Mari kita tinjau arsitektur basis data di balik SIMPUS-Mini.  
> Kami merancang 4 entitas utama yang saling terhubung:
> 1. Tabel **`buku`**: Menyimpan katalog pustaka, termasuk kolom `stok` yang dikelola secara real-time.
> 2. Tabel **`anggota`**: Menyimpan data peminjam dengan kolom `no_anggota` yang diberi konstrain `UNIQUE` agar tidak ada duplikasi nomor kartu.
> 3. Tabel **`users`**: Menampung kredensial petugas perpustakaan dengan enkripsi password menggunakan algoritma hashing standar industri `Bcrypt` (`PASSWORD_DEFAULT`).
> 4. Tabel **`peminjaman`**: Bertindak sebagai tabel jembatan relasional yang mengikat `buku_id` dan `anggota_id` melalui Foreign Key dengan klausa `ON DELETE CASCADE`.
>
> **Alasan Desain:** Kami memilih Foreign Key di tingkat database engine (PostgreSQL) agar integritas data terjamin secara konsisten. Basis data akan secara otomatis menolak apabila ada transaksi peminjaman yang mereferensikan buku atau anggota yang tidak terdaftar."*

---

### 3. Alur Transaksi Sirkulasi & Penanganan Konkurensi (02:30 – 04:00)
*(Aksi Layar: Menjalankan live demo peminjaman buku di browser, menunjukkan stok berkurang dan riwayat bertambah)*

> *"Fitur paling krusial pada sistem ini adalah modul **Peminjaman dan Pengembalian**.  
> Saat petugas mencatat peminjaman baru, sistem tidak sekadar menjalankan query insert biasa, melainkan membungkusnya dalam satu **Database Transaction** (`beginTransaction`, `commit`, dan `rollBack`).
>
> Ada 2 aspek teknis penting di sini:
> Pertama, **Pencegahan Race Condition**: Kami menggunakan klausa **`SELECT ... FOR UPDATE`** pada baris buku yang dipilih. Ketika dua petugas mencoba meminjamkan buku terakhir yang stoknya tersisa satu di detik yang sama, transaksi kedua dipaksa antre secara atomik. Begitu transaksi pertama selesai dan stok menjadi 0, transaksi kedua langsung membatalkan proses dan melempar eksepsi stok habis.
>
> Kedua, **Validasi Bisnis Keterlambatan**: Sistem secara otomatis mengeksekusi pemeriksaan `(CURRENT_DATE - tanggal_pinjam) > 14` untuk anggota yang masih memiliki buku berstatus 'dipinjam'. Jika anggota terbukti menunggak pengembalian lebih dari 14 hari, transaksi langsung digagalkan demi menegakkan disiplin peminjaman."*

---

### 4. Arsitektur Keamanan Sistem (04:00 – 05:15)
*(Aksi Layar: Menampilkan file security-checklist.md atau potongan kode helpers.php/koneksi.php)*

> *"Aspek keamanan dibangun dengan pendekatan **Defense-in-Depth** (pertahanan berlapis):
> 1. **Anti-SQL Injection**: Seluruh query interaksi database 100% menggunakan **Prepared Statements** PDO dengan parameter binding terisolasi.
> 2. **Anti-XSS**: Seluruh data dinamis dari pengguna disanitasi menggunakan helper fungsi **`e()`** berbasis `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` sebelum dicetak ke browser.
> 3. **Content-Security-Policy (CSP)**: Kami menyuntikkan header `Content-Security-Policy: default-src 'self'` yang memblokir eksekusi skrip liar dari domain pihak ketiga.
> 4. **Anti-CSRF**: Setiap formulir tipe POST diproteksi oleh token sesi kriptografis `bin2hex(random_bytes(32))` dan diverifikasi menggunakan `hash_equals()`.
> 5. **Pencegahan Kebocoran Informasi (CWE-209)**: Pada berkas koneksi PDO, pesan error teknis mentah dialihkan ke log server internal (`error_log`), sementara pengguna umum hanya disajikan pesan kesalahan generik yang aman."*

---

### 5. Arsitektur Deployment & Konfigurasi Lingkungan (05:15 – 06:15)
*(Aksi Layar: Memperlihatkan berkas .env.example dan includes/config.php)*

> *"Terakhir, untuk aspek deployment, SIMPUS-Mini mengadopsi prinsip **Twelve-Factor App (Config)**:
> 1. Kredensial database dipisahkan sepenuhnya dari kode program ke dalam **`includes/config.php`** yang membaca variabel lingkungan melalui **`getenv()`**. Kami menyertakan berkas template **`.env.example`** di repositori publik dan mendaftarkan `.env` ke `.gitignore`.
> 2. Sistem dilengkapi algoritma resolusi path relatif otomatis (**`$base`**) di dalam `includes/header.php`. Hal ini memungkinkan aplikasi berjalan dengan sempurna di server produksi independen, PHP Built-in server, maupun bersarang di dalam subfolder Laragon/XAMPP tanpa merusak tautan CSS dan navigasi."*

---

### 6. Penutup (06:15 – 07:00)
> *"Sebagai kesimpulan, SIMPUS-Mini bukan hanya sekadar aplikasi CRUD perpustakaan, melainkan sebuah sistem web modular yang menggabungkan integritas transaksi database, penanganan konkurensi stok, keamanan web modern, dan kesiapan deployment yang terdokumentasi rapi.
>
> Sekian presentasi dari saya. Terima kasih atas perhatian Bapak Dosen Penguji, dan saya siap menerima masukan maupun pertanyaan. Terima kasih."*
