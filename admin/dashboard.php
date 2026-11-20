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
<h1 class="h2 fw-semibold text-biru-tua">Dashboard Admin</h1>
<p class="text-muted">Ringkasan operasional LaundryKu.</p>

<div class="row mb-4">
    <div class="col-md mb-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body p-3">
                <div class="small text-muted mb-1">Total Pesanan</div>
                <div class="fs-3 fw-semibold text-biru-tua"><?php echo $total; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md mb-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body p-3">
                <div class="small text-muted mb-1">Menunggu Konfirmasi</div>
                <div class="fs-3 fw-semibold text-warning"><?php echo $menunggu; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md mb-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body p-3">
                <div class="small text-muted mb-1">Sedang Diproses</div>
                <div class="fs-3 fw-semibold text-info"><?php echo $diproses; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md mb-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body p-3">
                <div class="small text-muted mb-1">Siap Diambil</div>
                <div class="fs-3 fw-semibold text-success"><?php echo $siap; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md mb-3">
        <div class="card h-100 shadow-sm">
            <div class="card-body p-3">
                <div class="small text-muted mb-1">Pendapatan</div>
                <div class="fs-5 fw-semibold text-success"><?php echo rupiah($pendapatan); ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card card-tables">
    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <span class="fw-semibold text-biru-tua">Pesanan Terbaru</span>
        <a href="pesanan.php" class="btn btn-biru-tua btn-sm rounded-pill px-3">Kelola Semua</a>
    </div>
    <?php if (!$terbaru) { ?>
        <div class="card-body text-center text-muted py-5">Belum ada pesanan masuk.</div>
    <?php } else { ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th class="pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($terbaru as $o) { ?>
                <tr>
                    <td class="ps-4 fw-medium"><?php echo e($o["order_number"]); ?></td>
                    <td><?php echo e($o["nama_pelanggan"]); ?></td>
                    <td><?php echo e($o["service_name"]); ?></td>
                    <td><span class="<?php echo badge_status($o["status"]); ?>"><?php echo e($o["status"]); ?></span></td>
                    <td class="pe-4"><a href="detail_pesanan.php?id=<?php echo (int)$o["id"]; ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">Kelola</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
<?php include "../footer.php"; ?>