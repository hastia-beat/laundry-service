<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_customer();
$uid = (int)$_SESSION["user_id"];

$cari = trim($_GET["search"] ?? "");
$filter = trim($_GET["status"] ?? "");

$sql = "SELECT * FROM orders WHERE user_id = ?";
$tipe = "i";
$param = [$uid];
if ($cari !== "") {
    $sql .= " AND order_number LIKE ?";
    $tipe .= "s";
    $param[] = "%" . $cari . "%";
}
if ($filter !== "" && in_array($filter, STATUS_PENGERJAAN, true)) {
    $sql .= " AND status = ?";
    $tipe .= "s";
    $param[] = $filter;
}
$sql .= " ORDER BY created_at DESC";
$pesanan = ambil_semua($koneksi, $sql, $tipe, ...$param);

$judul = "Riwayat Pesanan";
include "../header.php";
?>
<h1>Riwayat Pesanan</h1>
<p class="text-muted">Semua pesanan Anda, dari yang terbaru.</p>

<form method="get" class="row g-2 mb-4">
    <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Cari nomor pesanan..." value="<?php echo e($cari); ?>"></div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <?php foreach (STATUS_PENGERJAAN as $st) { ?>
                <option value="<?php echo e($st); ?>" <?php echo $filter === $st ? "selected" : ""; ?>><?php echo e($st); ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-3">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="riwayat.php" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card">
<?php if (!$pesanan) { ?>
    <div class="card-body text-center text-muted">Tidak ada pesanan ditemukan.<br><a href="pesan.php" class="btn btn-primary mt-3">Buat Pesanan</a></div>
<?php } else { ?>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>No. Pesanan</th><th>Tanggal</th><th>Layanan</th><th>Total</th><th>Status</th><th>Pembayaran</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($pesanan as $o) { ?>
                <tr>
                    <td><?php echo e($o["order_number"]); ?></td>
                    <td class="small"><?php echo tanggal($o["created_at"]); ?></td>
                    <td><?php echo e($o["service_name"]); ?></td>
                    <td><?php echo rupiah($o["final_total"] ?? $o["estimated_total"]); ?></td>
                    <td><span class="<?php echo badge_status($o["status"]); ?>"><?php echo e($o["status"]); ?></span></td>
                    <td><span class="<?php echo badge_bayar($o["payment_status"]); ?>"><?php echo e($o["payment_status"]); ?></span></td>
                    <td><a href="detail.php?id=<?php echo (int)$o["id"]; ?>">Detail</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
</div>
<?php include "../footer.php"; ?>
