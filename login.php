<?php
include "fungsi.php";
if (isset($_SESSION["status_login"])) {
    pindah($_SESSION["role"] === "admin" ? "admin/dashboard.php" : "customer/dashboard.php");
}
$judul = "Login";
include "header.php";
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="text-center mb-1">Masuk ke LaundryKu</h2>
                <p class="text-center text-muted">Silakan masuk untuk memesan laundry.</p>
                <form action="proses_login.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
                <p class="text-center mt-3 mb-0">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
