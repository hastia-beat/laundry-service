<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_customer();
$uid = (int)$_SESSION["user_id"];
$id = (int)($_GET["id"] ?? 0);

// "AND user_id = ?" memastikan pelanggan hanya bisa melihat pesanannya sendiri
$o = ambil_satu($koneksi, "SELECT o.*, u.name AS nama_pelanggan FROM orders o JOIN users u ON u.id = o.user_id WHERE o.id = ? AND o.user_id = ?", "ii", $id, $uid);
if (!$o) {
    set_pesan("danger", "Pesanan tidak ditemukan.");
    pindah("customer/riwayat.php");
}
$posisi = array_search($o["status"], STATUS_TIMELINE);

$judul = "Detail Pesanan";
include "../header.php";
?>
<a href="riwayat.php">&larr; Kembali ke Riwayat</a>
<div class="row mt-3">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><strong>Informasi Pesanan</strong></div>
            <table class="table mb-0">
                <tr><td class="text-muted">Nomor Pesanan</td><td><?php echo e($o["order_number"]); ?></td></tr>
                <tr><td class="text-muted">Tanggal</td><td><?php echo tanggal($o["created_at"]); ?></td></tr>
                <tr><td class="text-muted">Nama Pelanggan</td><td><?php echo e($o["nama_pelanggan"]); ?></td></tr>
                <tr><td class="text-muted">Layanan</td><td><?php echo e($o["service_name"]); ?></td></tr>
                <tr><td class="text-muted">Harga Satuan</td><td><?php echo rupiah($o["unit_price"]); ?></td></tr>
                <tr><td class="text-muted">Jumlah Cucian</td><td><?php echo e($o["quantity"]); ?> &rarr; <?php echo $o["final_quantity"] !== null ? e($o["final_quantity"]) . " (final)" : "menunggu"; ?></td></tr>
                <tr><td class="text-muted">Estimasi Total</td><td><?php echo rupiah($o["estimated_total"]); ?></td></tr>
                <tr><td class="text-muted">Total Akhir</td><td class="fw-bold text-primary"><?php echo $o["final_total"] !== null ? rupiah($o["final_total"]) : "menunggu"; ?></td></tr>
                <tr><td class="text-muted">Pembayaran</td><td><span class="<?php echo badge_bayar($o["payment_status"]); ?>"><?php echo e($o["payment_status"]); ?></span></td></tr>
                <?php if ($o["notes"]) { ?>
                <tr><td class="text-muted">Catatan</td><td><?php echo e($o["notes"]); ?></td></tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><strong>Status Pengerjaan</strong></div>
            <div class="card-body">
                <?php if ($o["status"] === "Dibatalkan") { ?>
                    <div class="alert alert-danger mb-0">Pesanan ini telah dibatalkan.</div>
                <?php } else { ?>
                    <ol class="list-group list-group-numbered">
                        <?php foreach (STATUS_TIMELINE as $i => $langkah) {
                            $selesai = ($posisi !== false && $i <= $posisi);
                            $aktif = ($i === $posisi);
                            $kelas = $aktif ? "list-group-item-primary fw-bold" : ($selesai ? "list-group-item-success" : "text-muted");
                        ?>
                            <li class="list-group-item <?php echo $kelas; ?>"><?php echo e($langkah); ?><?php echo $selesai && !$aktif ? " ✓" : ""; ?></li>
                        <?php } ?>
                    </ol>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include "../footer.php"; ?>
