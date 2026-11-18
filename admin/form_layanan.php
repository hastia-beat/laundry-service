<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_admin();

// Satu form untuk tambah & edit: jika ada ?id= berarti mode edit
$id = (int)($_GET["id"] ?? 0);
$s = ["name" => "", "description" => "", "price" => "", "unit" => ""];
if ($id > 0) {
    $s = ambil_satu($koneksi, "SELECT * FROM services WHERE id = ?", "i", $id);
    if (!$s) {
        set_pesan("danger", "Layanan tidak ditemukan.");
        pindah("admin/layanan.php");
    }
}

$judul = $id > 0 ? "Edit Layanan" : "Tambah Layanan";
include "../header.php";
?>
<a href="layanan.php">&larr; Kembali ke Data Layanan</a>
<h1 class="my-3"><?php echo $judul; ?></h1>
<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form action="proses_layanan.php" method="post">
            <input type="hidden" name="action" value="simpan">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label class="form-label">Nama Layanan</label>
                <input type="text" name="name" class="form-control" value="<?php echo e($s["name"]); ?>" placeholder="Contoh: Cuci Selimut" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" required><?php echo e($s["description"]); ?></textarea>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-control" step="0.01" min="0" value="<?php echo e($s["price"]); ?>" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="unit" class="form-control" value="<?php echo e($s["unit"]); ?>" placeholder="Kg / Item / Pasang" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Simpan Layanan</button>
        </form>
    </div>
</div>
<?php include "../footer.php"; ?>
