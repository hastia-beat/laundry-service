<?php
include "fungsi.php";
if (isset($_SESSION["status_login"])) {
    pindah($_SESSION["role"] === "admin" ? "admin/dashboard.php" : "customer/dashboard.php");
}
$judul = "Daftar";
include "header.php";
$lama = $_SESSION["input_lama"] ?? [];
unset($_SESSION["input_lama"]);
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="text-center mb-1">Daftar Akun Baru</h2>
                <p class="text-center text-muted">Buat akun untuk mulai memesan laundry.</p>
                <form action="proses_register.php" method="post" id="form-register">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo e($lama["nama"] ?? ""); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo e($lama["email"] ?? ""); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="phone" class="form-control" placeholder="0812xxxxxxx" value="<?php echo e($lama["phone"] ?? ""); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi" id="konfirmasi" class="form-control" required>
                        <div id="error-konfirmasi" class="text-danger"></div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Daftar</button>
                </form>
                <p class="text-center mt-3 mb-0">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
