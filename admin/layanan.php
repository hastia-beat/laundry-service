<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_admin();

$layanan = ambil_semua($koneksi, "SELECT s.*, (SELECT COUNT(*) FROM orders o WHERE o.service_id = s.id) AS dipakai FROM services s ORDER BY s.id");

$judul = "Data Layanan";
include "../header.php";
?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="mb-0">Data Layanan</h1>
        <p class="text-muted mb-0">Kelola katalog layanan laundry.</p>
    </div>
    <a href="form_layanan.php" class="btn btn-primary">+ Tambah Layanan</a>
</div>

<div class="card">
    <div class="card card-tabel">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead><tr><th>Nama</th><th>Deskripsi</th><th>Harga</th><th>Satuan</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($layanan as $s) { ?>
                    <tr>
                        <td class="fw-normal"><?php echo e($s["name"]); ?></td>
                        <td class="small text-muted"><?php echo e($s["description"]); ?></td>
                        <td><?php echo rupiah($s["price"]); ?></td>
                        <td><?php echo e($s["unit"]); ?></td>
                        <td><span class="badge text-bg-<?php echo $s["is_active"] ? "success" : "secondary"; ?>"><?php echo $s["is_active"] ? "Aktif" : "Nonaktif"; ?></span></td>
                        <td class="text-nowrap">
                            <a href="form_layanan.php?id=<?php echo (int)$s["id"]; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="proses_layanan.php" method="post" class="d-inline">
                                <input type="hidden" name="action" value="toggle">
                                <input type="hidden" name="id" value="<?php echo (int)$s["id"]; ?>">
                                <button type="submit" class="btn btn-sm btn-outline-warning"><?php echo $s["is_active"] ? "Nonaktifkan" : "Aktifkan"; ?></button>
                            </form>
                            <?php if ((int)$s["dipakai"] === 0) { ?>
                            <form action="proses_layanan.php" method="post" class="d-inline">
                                <input type="hidden" name="action" value="hapus">
                                <input type="hidden" name="id" value="<?php echo (int)$s["id"]; ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" data-konfirmasi="Yakin menghapus layanan ini?">Hapus</button>
                            </form>
                            <?php } else { ?>
                                <button class="btn btn-sm btn-outline-secondary" disabled title="Sudah dipakai dalam pesanan">Hapus</button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "../footer.php"; ?>
