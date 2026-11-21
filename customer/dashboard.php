<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_customer();
$uid = (int)$_SESSION["user_id"];

$total = ambil_satu($koneksi, "SELECT COUNT(*) AS n FROM orders WHERE user_id = ?", "i", $uid)["n"];
$proses = ambil_satu($koneksi, "SELECT COUNT(*) AS n FROM orders WHERE user_id = ? AND status NOT IN ('Selesai','Dibatalkan')", "i", $uid)["n"];
$selesai = ambil_satu($koneksi, "SELECT COUNT(*) AS n FROM orders WHERE user_id = ? AND status = 'Selesai'", "i", $uid)["n"];
$terbaru = ambil_semua($koneksi, "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5", "i", $uid);

$judul = "Dashboard Pelanggan";
include "../header.php";
?>
<h1 class="h2 fw-semibold text-biru-tua">Halo, <?php echo e($_SESSION["nama"]); ?>!</h1>
<p class="text-muted">Selamat datang di dashboard LaundryKu Anda.</p>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-muted small mb-1">Total Pesanan</div>
                <div class="fs-2 fw-semibold text-biru-tua"><?php echo $total; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-muted small mb-1">Sedang Diproses</div>
                <div class="fs-2 fw-semibold text-warning"><?php echo $proses; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-muted small mb-1">Pesanan Selesai</div>
                <div class="fs-2 fw-semibold text-success"><?php echo $selesai; ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card card-tabel">
    <div class="card-header border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-biru-tua">Pesanan Terbaru</span>
        <a href="riwayat.php" class="btn btn-biru-tua btn-sm rounded-pill px-3">Lihat Semua</a>
    </div>
    <?php if (!$terbaru) { ?>
        <div class="card-body text-center text-muted py-5">
            <p class="mb-3">Anda belum memiliki pesanan.</p>
            <a href="pesan.php" class="btn btn-biru-tua rounded-pill px-4">Buat Pesanan Pertama</a>
        </div>
    <?php } else { ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4">No. Pesanan</th>
                    <th>Layanan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($terbaru as $o) { ?>
                <tr>
                    <td class="ps-4 fw-medium"><?php echo e($o["order_number"]); ?></td>
                    <td><?php echo e($o["service_name"]); ?></td>
                    <td><?php echo rupiah($o["final_total"] ?? $o["estimated_total"]); ?></td>
                    <td><span class="<?php echo badge_status($o["status"]); ?>"><?php echo e($o["status"]); ?></span></td>
                    <td class="pe-4"><a href="detail.php?id=<?php echo (int)$o["id"]; ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Detail</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
<?php include "../footer.php"; ?>