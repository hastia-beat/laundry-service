<?php
include "fungsi.php";
include "koneksi.php";
$judul = "Beranda";
$layanan = ambil_semua($koneksi, "SELECT * FROM services WHERE is_active = 1 ORDER BY id LIMIT 6");
include "header.php";
?>
<div class="hero mb-5 text-center">
    <h1 class="fw-semibold mb-3 ">Pakaian Bersih Tanpa Ribet!</h1>
    <p class="lead fw-normal mb-4">Pesan laundry online, harga transparan, dan pantau status cucian secara online.</p>
    <a href="<?php echo BASE; ?>/customer/pesan.php" class="btn btn-light text-biru-tua fw-medium btn-lg px-4 me-2">Pesan Sekarang</a>
    <a href="<?php echo BASE; ?>/layanan.php" class="btn btn-outline-light btn-lg px-4">Lihat Layanan</a>
</div>

<h2 class="h4 fw-semibold text-biru-tua text-center mb-4">Layanan Unggulan</h2>
<div class="row">
    <?php foreach ($layanan as $s) { ?>
    <div class="col-md-4 mb-4">
        <div class="card kartu-layanan h-100 ">
            <div class="card-body p-4 d-flex flex-column">
                <h5 class="card-title fw-semibold mb-2"><?php echo e($s["name"]); ?></h5>
                <p class="card-text text-muted small flex-grow-1"><?php echo e($s["description"]); ?></p>
                <hr class="my-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-biru-tua fs-5"><?php echo rupiah($s["price"]); ?> <small class="text-muted fw-normal fs-6">/ <?php echo e($s["unit"]); ?></small></span>
                    <a href="<?php echo BASE; ?>/customer/pesan.php?service=<?php echo (int)$s["id"]; ?>" class="btn btn-biru-tua btn-sm px-3">Pesan</a>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<div class="my-5" id="tentang">
    <h2 class="h4 fw-semibold text-biru-tua text-center mb-4">Cara Kerja</h2>
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card kartu-layanan h-100 p-4 shadow-sm">
                <h5 class="fw-semibold text-biru-tua">1. Pilih Layanan</h5>
                <p class="text-muted small mb-0">Tentukan jenis layanan yang sesuai kebutuhan.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card kartu-layanan h-100 p-4 shadow-sm">
                <h5 class="fw-semibold text-biru-tua">2. Buat Pesanan</h5>
                <p class="text-muted small mb-0">Isi estimasi berat, biaya dihitung otomatis.</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card kartu-layanan h-100 p-4 shadow-sm">
                <h5 class="fw-semibold text-biru-tua">3. Antar &amp; Pantau</h5>
                <p class="text-muted small mb-0">Antar cucian ke outlet dan pantau statusnya.</p>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>