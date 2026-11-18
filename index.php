<?php
include "fungsi.php";
include "koneksi.php";
$judul = "Beranda";
$layanan = ambil_semua($koneksi, "SELECT * FROM services WHERE is_active = 1 ORDER BY id LIMIT 6");
include "header.php";
?>
<div class="hero rounded mb-5 text-center">
    <h1 class="fw-bold text-primary">Pakaian Bersih Tanpa Ribet!</h1>
    <p class="lead">Pesan laundry online, harga transparan, dan pantau status cucian secara online.</p>
    <a href="<?php echo BASE; ?>/customer/pesan.php" class="btn btn-primary btn-lg">Pesan Sekarang</a>
    <a href="<?php echo BASE; ?>/layanan.php" class="btn btn-outline-primary btn-lg">Lihat Layanan</a>
</div>

<h2 class="text-center mb-4">Layanan Unggulan</h2>
<div class="row">
    <?php foreach ($layanan as $s) { ?>
    <div class="col-md-4 mb-4">
        <div class="card kartu-layanan h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?php echo e($s["name"]); ?></h5>
                <p class="card-text text-muted flex-grow-1"><?php echo e($s["description"]); ?></p>
                <p class="fw-bold text-primary fs-5 mb-2"><?php echo rupiah($s["price"]); ?> <small class="text-muted fs-6">/ <?php echo e($s["unit"]); ?></small></p>
                <a href="<?php echo BASE; ?>/customer/pesan.php?service=<?php echo (int)$s["id"]; ?>" class="btn btn-primary">Pesan</a>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<div class="row text-center my-5" id="tentang">
    <h2 class="mb-4">Cara Kerja</h2>
    <div class="col-md-4"><h5>1. Pilih Layanan</h5><p class="text-muted">Tentukan jenis layanan yang sesuai kebutuhan.</p></div>
    <div class="col-md-4"><h5>2. Buat Pesanan</h5><p class="text-muted">Isi estimasi berat, biaya dihitung otomatis.</p></div>
    <div class="col-md-4"><h5>3. Antar &amp; Pantau</h5><p class="text-muted">Antar cucian ke outlet dan pantau statusnya.</p></div>
</div>
<?php include "footer.php"; ?>
