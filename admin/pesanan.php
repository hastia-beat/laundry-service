<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_admin();

$cari = trim($_GET["search"] ?? "");
$filter = trim($_GET["status"] ?? "");

$sql = "SELECT o.*, u.name AS nama_pelanggan FROM orders o JOIN users u ON u.id = o.user_id WHERE 1=1";
$tipe = "";
$param = [];
if ($cari !== "") {
    $sql .= " AND (o.order_number LIKE ? OR u.name LIKE ?)";
    $tipe .= "ss";
    $param[] = "%" . $cari . "%";
    $param[] = "%" . $cari . "%";
}
if ($filter !== "" && in_array($filter, STATUS_PENGERJAAN, true)) {
    $sql .= " AND o.status = ?";
    $tipe .= "s";
    $param[] = $filter;
}
$sql .= " ORDER BY o.created_at DESC";
$pesanan = ambil_semua($koneksi, $sql, $tipe, ...$param);

$judul = "Data Pesanan";
include "../header.php";
?>
<h1>Data Pesanan</h1>
<p class="text-muted">Kelola seluruh pesanan pelanggan.</p>

<form method="get" class="row g-2 mb-4">
    <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Cari nomor pesanan / nama pelanggan..." value="<?php echo e($cari); ?>"></div>
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
        <a href="pesanan.php" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card">
<?php if (!$pesanan) { ?>
    <div class="card-body text-center text-muted">Tidak ada pesanan ditemukan.</div>
<?php } else { ?>
    <div class="table-responsive">
        <table class="table table-hover mb-0 small">
            <thead><tr><th>No. Pesanan</th><th>Pelanggan</th><th>Tanggal</th><th>Layanan</th><th>Jumlah</th><th>Total</th><th>Status</th><th>Bayar</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($pesanan as $o) { ?>
                <tr>
                    <td><?php echo e($o["order_number"]); ?></td>
                    <td><?php echo e($o["nama_pelanggan"]); ?></td>
                    <td><?php echo tanggal($o["created_at"]); ?></td>
                    <td><?php echo e($o["service_name"]); ?></td>
                    <td><?php echo e($o["final_quantity"] ?? $o["quantity"]); ?></td>
                    <td><?php echo rupiah($o["final_total"] ?? $o["estimated_total"]); ?></td>
                    <td><span class="<?php echo badge_status($o["status"]); ?>"><?php echo e($o["status"]); ?></span></td>
                    <td><span class="<?php echo badge_bayar($o["payment_status"]); ?>"><?php echo e($o["payment_status"]); ?></span></td>
                    <td><a href="detail_pesanan.php?id=<?php echo (int)$o["id"]; ?>">Kelola</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
</div>
<?php include "../footer.php"; ?>
