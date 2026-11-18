<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_customer();
$uid = (int)$_SESSION["user_id"];
$u = ambil_satu($koneksi, "SELECT name, email, phone, created_at FROM users WHERE id = ?", "i", $uid);

$judul = "Profil";
include "../header.php";
?>
<h1 class="mb-4">Profil Saya</h1>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><strong>Informasi Akun</strong></div>
            <table class="table mb-0">
                <tr><td class="text-muted">Email</td><td><?php echo e($u["email"]); ?></td></tr>
                <tr><td class="text-muted">Terdaftar</td><td><?php echo tanggal($u["created_at"]); ?></td></tr>
            </table>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header"><strong>Ubah Profil</strong></div>
            <div class="card-body">
                <form action="proses_profil.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo e($u["name"]); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo e($u["phone"]); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "../footer.php"; ?>
