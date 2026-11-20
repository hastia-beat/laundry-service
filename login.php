<?php
include "fungsi.php";
if (isset($_SESSION["status_login"])) {
    pindah($_SESSION["role"] === "admin" ? "admin/dashboard.php" : "customer/dashboard.php");
}
$judul = "Login";
include "header.php";
?>
<div class="row justify-content-center my-4">
    <div class="col-md-5">
        <div class="card kartu-layanan">
            <div class="card-body p-4">
                <h2 class="h4 fw-semibold text-biru-tua text-center mb-1">Masuk ke LaundryKu</h2>
                <p class="text-center text-muted small mb-4">Silakan masuk untuk memesan laundry.</p>
                <form action="proses_login.php" method="post">
                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" class="form-control rounded-pill px-3" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small">Password</label>
                        <input type="password" name="password" class="form-control rounded-pill px-3" required>
                    </div>
                    <button type="submit" class="btn btn-biru-tua w-100">Masuk</button>
                </form>
                <p class="text-center text-muted small mt-3 mb-0">Belum punya akun? <a href="register.php" class="text-biru-tua fw-medium">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>