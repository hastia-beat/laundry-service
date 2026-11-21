<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_admin();

$pelanggan = ambil_semua($koneksi, "SELECT id, name, email, phone, created_at FROM users WHERE role = 'customer' ORDER BY created_at DESC");

$judul = "Data Pelanggan";
include "../header.php";
?>
<h1>Data Pelanggan</h1>
<p class="text-muted">Daftar seluruh pelanggan terdaftar.</p>
<div class="card">
    <div class="card card-tabel">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Nama</th><th>Email</th><th>No. HP</th><th>Terdaftar</th></tr></thead>
                <tbody>
                <?php if (!$pelanggan) { ?>
                    <tr><td colspan="4" class="text-center text-muted">Belum ada pelanggan.</td></tr>
                <?php } else { foreach ($pelanggan as $p) { ?>
                    <tr>
                        <td class="fw-normal"><?php echo e($p["name"]); ?></td>
                        <td><?php echo e($p["email"]); ?></td>
                        <td><?php echo e($p["phone"]); ?></td>
                        <td class="small"><?php echo tanggal($p["created_at"]); ?></td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "../footer.php"; ?>
