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
<h1>Halo, <?php echo e($_SESSION["nama"]); ?>!</h1>
<p class="text-muted">Selamat datang di dashboard LaundryKu Anda.</p>

<div class="row mb-4">
    <div class="col-md-4 mb-3"><div class="card"><div class="card-body"><div class="text-muted small">Total Pesanan</div><div class="fs-2 fw-bold text-primary"><?php echo $total; ?></div></div></div></div>
    <div class="col-md-4 mb-3"><div class="card"><div class="card-body"><div class="text-muted small">Sedang Diproses</div><div class="fs-2 fw-bold text-warning"><?php echo $proses; ?></div></div></div></div>
    <div class="col-md-4 mb-3"><div class="card"><div class="card-body"><div class="text-muted small">Pesanan Selesai</div><div class="fs-2 fw-bold text-success"><?php echo $selesai; ?></div></div></div></div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <strong>Pesanan Terbaru</strong>
        <a href="riwayat.php">Lihat semua</a>
    </div>
    <?php if (!$terbaru) { ?>
        <div class="card-body text-center text-muted">
            Anda belum memiliki pesanan.<br>
            <a href="pesan.php" class="btn btn-primary mt-3">Buat Pesanan Pertama</a>
        </div>
    <?php } else { ?>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>No. Pesanan</th><th>Layanan</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($terbaru as $o) { ?>
                <tr>
                    <td><?php echo e($o["order_number"]); ?></td>
                    <td><?php echo e($o["service_name"]); ?></td>
                    <td><?php echo rupiah($o["final_total"] ?? $o["estimated_total"]); ?></td>
                    <td><span class="<?php echo badge_status($o["status"]); ?>"><?php echo e($o["status"]); ?></span></td>
                    <td><a href="detail.php?id=<?php echo (int)$o["id"]; ?>">Detail</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
<?php include "../footer.php"; ?>
