<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_customer();

$layanan = ambil_semua($koneksi, "SELECT id, name, price, unit FROM services WHERE is_active = 1 ORDER BY id");
$pilih = (int)($_GET["service"] ?? 0);

$judul = "Buat Pesanan";
include "../header.php";
?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Buat Pesanan Laundry</h1>
        <p class="text-muted">Pilih layanan dan masukkan estimasi berat/jumlah. Total dihitung otomatis.</p>
        <div class="card ">
            <div class="card-body p-4">
                <form action="proses_pesan.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Pilih Layanan</label>
                        <select name="service_id" id="layanan" class="form-select" required>
                            <option value="" data-harga="0" data-satuan="">-- Pilih layanan --</option>
                            <?php foreach ($layanan as $s) { ?>
                                <option value="<?php echo (int)$s["id"]; ?>" data-harga="<?php echo (float)$s["price"]; ?>" data-satuan="<?php echo e($s["unit"]); ?>" <?php echo $pilih === (int)$s["id"] ? "selected" : ""; ?>>
                                    <?php echo e($s["name"]); ?> — <?php echo rupiah($s["price"]); ?>/<?php echo e($s["unit"]); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah / Estimasi Berat (satuan: <span id="satuan">-</span>)</label>
                        <input type="number" name="quantity" id="jumlah" class="form-control" step="0.1" min="0.1" placeholder="Contoh: 3.5" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan (opsional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Misal: pisahkan pakaian putih"></textarea>
                    </div>
                    <div class="kotak-estimasi mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small text-muted">Estimasi Total Biaya</div>
                            <div class="fs-3 fw-bold text-primary" id="estimasi">Rp0</div>
                        </div>
                        <div class="small text-muted text-end">Harga akhir dikonfirmasi admin<br>setelah cucian ditimbang.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" <?php echo !$layanan ? "disabled" : ""; ?>>Kirim Pesanan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "../footer.php"; ?>
