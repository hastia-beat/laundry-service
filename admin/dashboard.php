<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_admin();

$total = ambil_satu($koneksi, "SELECT COUNT(*) AS n FROM orders")["n"];
$menunggu = ambil_satu($koneksi, "SELECT COUNT(*) AS n FROM orders WHERE status = 'Menunggu Konfirmasi'")["n"];
$diproses = ambil_satu($koneksi, "SELECT COUNT(*) AS n FROM orders WHERE status IN ('Pesanan Diterima','Sedang Dicuci','Sedang Disetrika')")["n"];
$siap = ambil_satu($koneksi, "SELECT COUNT(*) AS n FROM orders WHERE status = 'Siap Diambil'")["n"];
$pendapatan = ambil_satu($koneksi, "SELECT COALESCE(SUM(final_total),0) AS n FROM orders WHERE status = 'Selesai' AND payment_status = 'Sudah Dibayar'")["n"];
$terbaru = ambil_semua($koneksi, "SELECT o.*, u.name AS nama_pelanggan FROM orders o JOIN users u ON u.id = o.user_id ORDER BY o.created_at DESC LIMIT 6");

$judul = "Dashboard Admin";
include "../header.php";
?>
<h1>Dashboard Admin</h1>
<p class="text-muted">Ringkasan operasional LaundryKu.</p>

<div class="row mb-4">
    <div class="col-md mb-3"><div class="card"><div class="card-body"><div class="small text-muted">Total Pesanan</div><div class="fs-3 fw-bold text-primary"><?php echo $total; ?></div></div></div></div>
    <div class="col-md mb-3"><div class="card"><div class="card-body"><div class="small text-muted">Menunggu Konfirmasi</div><div class="fs-3 fw-bold text-warning"><?php echo $menunggu; ?></div></div></div></div>
    <div class="col-md mb-3"><div class="card"><div class="card-body"><div class="small text-muted">Sedang Diproses</div><div class="fs-3 fw-bold text-info"><?php echo $diproses; ?></div></div></div></div>
    <div class="col-md mb-3"><div class="card"><div class="card-body"><div class="small text-muted">Siap Diambil</div><div class="fs-3 fw-bold text-success"><?php echo $siap; ?></div></div></div></div>
    <div class="col-md mb-3"><div class="card"><div class="card-body"><div class="small text-muted">Pendapatan</div><div class="fs-5 fw-bold text-success"><?php echo rupiah($pendapatan); ?></div></div></div></div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between"><strong>Pesanan Terbaru</strong><a href="pesanan.php">Kelola semua</a></div>
    <?php if (!$terbaru) { ?>
        <div class="card-body text-center text-muted">Belum ada pesanan masuk.</div>
    <?php } else { ?>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead><tr><th>No. Pesanan</th><th>Pelanggan</th><th>Layanan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php foreach ($terbaru as $o) { ?>
                <tr>
                    <td><?php echo e($o["order_number"]); ?></td>
                    <td><?php echo e($o["nama_pelanggan"]); ?></td>
                    <td><?php echo e($o["service_name"]); ?></td>
                    <td><span class="<?php echo badge_status($o["status"]); ?>"><?php echo e($o["status"]); ?></span></td>
                    <td><a href="detail_pesanan.php?id=<?php echo (int)$o["id"]; ?>">Kelola</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
<?php include "../footer.php"; ?>
