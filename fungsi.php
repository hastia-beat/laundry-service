<?php
// Fungsi pembantu + penjaga session (Modul VI & VII)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("BASE", "/laundryku");   // ubah jika nama folder di htdocs berbeda

const STATUS_PENGERJAAN = ["Menunggu Konfirmasi", "Pesanan Diterima", "Sedang Dicuci",
    "Sedang Disetrika", "Siap Diambil", "Selesai", "Dibatalkan"];
const STATUS_TIMELINE = ["Menunggu Konfirmasi", "Pesanan Diterima", "Sedang Dicuci",
    "Sedang Disetrika", "Siap Diambil", "Selesai"];
const STATUS_BAYAR = ["Belum Dibayar", "Sudah Dibayar"];

// htmlspecialchars: mencegah XSS saat menampilkan data
function e($teks) {
    return htmlspecialchars((string)$teks, ENT_QUOTES, "UTF-8");
}
function rupiah($angka) {
    return "Rp" . number_format((float)$angka, 0, ",", ".");
}
function tanggal($waktu) {
    return date("d M Y, H:i", strtotime($waktu));
}
function pindah($halaman) {
    header("Location: " . BASE . "/" . $halaman);
    exit();
}
function set_pesan($tipe, $isi) {
    $_SESSION["pesan"][] = ["tipe" => $tipe, "isi" => $isi];
}

// ---- penjaga halaman ----
function wajib_login() {
    if (!isset($_SESSION["status_login"]) || $_SESSION["status_login"] !== true) {
        set_pesan("danger", "Silakan login terlebih dahulu.");
        pindah("login.php");
    }
}
function wajib_customer() {
    wajib_login();
    if ($_SESSION["role"] === "admin") {
        pindah("admin/dashboard.php");
    }
}
function wajib_admin() {
    wajib_login();
    if ($_SESSION["role"] !== "admin") {
        set_pesan("danger", "Akses ditolak. Halaman ini khusus admin.");
        pindah("customer/dashboard.php");
    }
}

// ---- query baca (selalu prepared statement) ----
function ambil_semua($koneksi, $sql, $tipe = "", ...$param) {
    $stmt = $koneksi->prepare($sql);
    if ($tipe !== "") {
        $stmt->bind_param($tipe, ...$param);
    }
    $stmt->execute();
    $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $data;
}
function ambil_satu($koneksi, $sql, $tipe = "", ...$param) {
    $data = ambil_semua($koneksi, $sql, $tipe, ...$param);
    return $data ? $data[0] : null;
}

// ---- badge Bootstrap ----
function badge_status($status) {
    $warna = ["Menunggu Konfirmasi" => "warning", "Pesanan Diterima" => "info",
        "Sedang Dicuci" => "primary", "Sedang Disetrika" => "secondary",
        "Siap Diambil" => "success", "Selesai" => "dark", "Dibatalkan" => "danger"];
    return "badge text-bg-" . ($warna[$status] ?? "light");
}
function badge_bayar($status) {
    return "badge text-bg-" . ($status === "Sudah Dibayar" ? "success" : "danger");
}

function buat_nomor_pesanan($koneksi) {
    $prefix = "INV" . date("ymd");
    $baris = ambil_satu($koneksi, "SELECT COUNT(*) AS jml FROM orders WHERE order_number LIKE ?", "s", $prefix . "%");
    return $prefix . str_pad($baris["jml"] + 1, 4, "0", STR_PAD_LEFT);
}
?>
