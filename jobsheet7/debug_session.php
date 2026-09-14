<?php
// Jobsheet 7 Latihan 3: Halaman array mentah $_SESSION
$page_title = "Debug Sesi (Latihan 3)";
include __DIR__ . '/includes/header.php';
?>
        <section>
            <h2>Debug Sesi (Latihan 3)</h2>
            <p>Halaman ini menampilkan struktur isi data mentah yang tersimpan di dalam server</p>

            <pre><?php print_r($_SESSION); ?></pre>
        </section>
<?php include __DIR__ . '/includes/footer.php'; ?>
