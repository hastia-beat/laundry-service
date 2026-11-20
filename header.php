<?php
include_once __DIR__ . "/fungsi.php";
if (!isset($judul)) { $judul = "LaundryKu"; }
$role = $_SESSION["role"] ?? null;
$halaman = basename($_SERVER["PHP_SELF"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($judul); ?> — LaundryKu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE; ?>/assets/css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3">
    <div class="container">
        <a class="navbar-brand fw-semibold text-biru-tua fs-4 d-flex align-items-center gap-2" href="<?php echo BASE; ?>/">
            <img src="<?php echo BASE; ?>/assets/img/logo.png" alt="Logo LaundryKu" class="logo-navbar">
            <span>LaundryKu</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                <?php if ($role === "admin") { ?>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'dashboard.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/admin/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'pesanan.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/admin/pesanan.php">Data Pesanan</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'layanan.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/admin/layanan.php">Data Layanan</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'pelanggan.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/admin/pelanggan.php">Data Pelanggan</a></li>
                <?php } elseif ($role === "customer") { ?>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'dashboard.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/customer/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'pesan.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/customer/pesan.php">Buat Pesanan</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'riwayat.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/customer/riwayat.php">Riwayat</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'profil.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/customer/profil.php">Profil</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'index.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $halaman === 'layanan.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/layanan.php">Layanan</a></li>
                <?php } ?>

                <?php if ($role) { ?>
                    <li class="nav-item ms-lg-2"><a class="btn btn-outline-danger btn-sm" href="<?php echo BASE; ?>/logout.php">Logout (<?php echo e($_SESSION["nama"]); ?>)</a></li>
                <?php } else { ?>
                    <li class="nav-item ms-lg-2"><a class="nav-link <?php echo $halaman === 'login.php' ? 'active fw-semibold text-biru-tua' : ''; ?>" href="<?php echo BASE; ?>/login.php">Login</a></li>
                    <li class="nav-item"><a class="btn btn-biru-tua btn-sm px-3 ms-lg-1" href="<?php echo BASE; ?>/register.php">Daftar</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4 flex-grow-1">
<?php
if (!empty($_SESSION["pesan"])) {
    foreach ($_SESSION["pesan"] as $p) {
        echo "<div class='alert alert-" . e($p["tipe"]) . " alert-dismissible' id='notifikasi'>" . e($p["isi"]) . "</div>";
    }
    unset($_SESSION["pesan"]);
}
?>