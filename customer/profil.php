<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_customer();
$uid = (int)$_SESSION["user_id"];
$u = ambil_satu($koneksi, "SELECT name, email, phone, created_at FROM users WHERE id = ?", "i", $uid);

$judul = "Profil";
include "../header.php";
?>
<h1 class="h2 fw-semibold text-biru-tua mb-4">Profil Saya</h1>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header py-3 px-4 fw-semibold text-biru-tua">Informasi Akun</div>
            <table class="table align-middle mb-0">
                <tr>
                    <td class="ps-4 text-muted">Email</td>
                    <td class="pe-4"><?php echo e($u["email"]); ?></td>
                </tr>
                <tr>
                    <td class="ps-4 text-muted border-bottom-0">Terdaftar</td>
                    <td class="pe-4 border-bottom-0"><?php echo tanggal($u["created_at"]); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header py-3 px-4 fw-semibold text-biru-tua">Ubah Profil</div>
            <div class="card-body p-4">
                <form action="proses_profil.php" method="post">
                    <div class="mb-3">
                        <label class="form-label small">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control rounded-pill px-3" value="<?php echo e($u["name"]); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small">Nomor HP</label>
                        <input type="text" name="phone" class="form-control rounded-pill px-3" value="<?php echo e($u["phone"]); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-biru-tua rounded-pill w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "../footer.php"; ?>