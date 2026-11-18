<?php
include "fungsi.php";
include "koneksi.php";
$judul = "Layanan";
$layanan = ambil_semua($koneksi, "SELECT * FROM services WHERE is_active = 1 ORDER BY id");
include "header.php";
?>
<h1 class="text-center mb-1">Katalog Layanan Laundry</h1>
<p class="text-center text-muted mb-4">Pilih layanan yang sesuai dengan kebutuhan Anda.</p>

<?php if (!$layanan) { ?>
    <p class="text-center text-muted">Belum ada layanan tersedia.</p>
<?php } ?>
<div class="row">
    <?php foreach ($layanan as $s) { ?>
    <div class="col-md-4 mb-4">
        <div class="card kartu-layanan h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?php echo e($s["name"]); ?></h5>
                <p class="card-text text-muted flex-grow-1"><?php echo e($s["description"]); ?></p>
                <p class="fw-bold text-primary fs-5 mb-2"><?php echo rupiah($s["price"]); ?> <small class="text-muted fs-6">/ <?php echo e($s["unit"]); ?></small></p>
                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") { ?>
                    <span class="text-muted small">Login sebagai admin</span>
                <?php } elseif (isset($_SESSION["role"])) { ?>
                    <a href="<?php echo BASE; ?>/customer/pesan.php?service=<?php echo (int)$s["id"]; ?>" class="btn btn-primary">Pesan Sekarang</a>
                <?php } else { ?>
                    <a href="<?php echo BASE; ?>/login.php" class="btn btn-primary">Pesan Sekarang</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php include "footer.php"; ?>
