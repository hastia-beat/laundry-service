<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_admin();
$id = (int)($_GET["id"] ?? 0);

$o = ambil_satu($koneksi, "SELECT o.*, u.name AS nama_pelanggan, u.email, u.phone FROM orders o JOIN users u ON u.id = o.user_id WHERE o.id = ?", "i", $id);
if (!$o) {
    set_pesan("danger", "Pesanan tidak ditemukan.");
    pindah("admin/pesanan.php");
}

$judul = "Detail Pesanan " . $o["order_number"];
include "../header.php";
?>
<a href="pesanan.php">&larr; Kembali ke Data Pesanan</a>
<div class="row mt-3">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><strong>Informasi Pesanan</strong></div>
            <table class="table mb-0">
                <tr><td class="text-muted">No. Pesanan</td><td><?php echo e($o["order_number"]); ?></td></tr>
                <tr><td class="text-muted">Tanggal</td><td><?php echo tanggal($o["created_at"]); ?></td></tr>
                <tr><td class="text-muted">Pelanggan</td><td><?php echo e($o["nama_pelanggan"]); ?></td></tr>
                <tr><td class="text-muted">Email</td><td><?php echo e($o["email"]); ?></td></tr>
                <tr><td class="text-muted">No. HP</td><td><?php echo e($o["phone"]); ?></td></tr>
                <tr><td class="text-muted">Layanan</td><td><?php echo e($o["service_name"]); ?></td></tr>
                <tr><td class="text-muted">Harga Satuan</td><td><?php echo rupiah($o["unit_price"]); ?></td></tr>
                <tr><td class="text-muted">Jumlah Pesan</td><td><?php echo e($o["quantity"]); ?></td></tr>
                <tr><td class="text-muted">Estimasi Total</td><td><?php echo rupiah($o["estimated_total"]); ?></td></tr>
                <?php if ($o["notes"]) { ?>
                <tr><td class="text-muted">Catatan</td><td><?php echo e($o["notes"]); ?></td></tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h6>Status Pengerjaan</h6>
                <p><span class="<?php echo badge_status($o["status"]); ?>"><?php echo e($o["status"]); ?></span></p>
                <form action="proses_pesanan.php" method="post" class="d-flex gap-2">
                    <input type="hidden" name="id" value="<?php echo (int)$o["id"]; ?>">
                    <input type="hidden" name="action" value="update_status">
                    <select name="status" class="form-select">
                        <?php foreach (STATUS_PENGERJAAN as $st) { ?>
                            <option value="<?php echo e($st); ?>" <?php echo $o["status"] === $st ? "selected" : ""; ?>><?php echo e($st); ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6>Jumlah &amp; Total Akhir</h6>
                <form action="proses_pesanan.php" method="post">
                    <input type="hidden" name="id" value="<?php echo (int)$o["id"]; ?>">
                    <input type="hidden" name="action" value="update_final">
                    <div class="mb-2">
                        <label class="form-label small text-muted">Jumlah / Berat Akhir</label>
                        <input type="number" name="final_quantity" class="form-control" step="0.1" min="0.1" value="<?php echo e($o["final_quantity"] ?? $o["quantity"]); ?>">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small text-muted">Total Akhir (Rp)</label>
                        <input type="number" name="final_total" class="form-control" step="0.01" min="0" value="<?php echo e($o["final_total"] ?? $o["estimated_total"]); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6>Status Pembayaran</h6>
                <p><span class="<?php echo badge_bayar($o["payment_status"]); ?>"><?php echo e($o["payment_status"]); ?></span></p>
                <form action="proses_pesanan.php" method="post" class="d-flex gap-2">
                    <input type="hidden" name="id" value="<?php echo (int)$o["id"]; ?>">
                    <input type="hidden" name="action" value="update_payment">
                    <select name="payment_status" class="form-select">
                        <?php foreach (STATUS_BAYAR as $b) { ?>
                            <option value="<?php echo e($b); ?>" <?php echo $o["payment_status"] === $b ? "selected" : ""; ?>><?php echo e($b); ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "../footer.php"; ?>
