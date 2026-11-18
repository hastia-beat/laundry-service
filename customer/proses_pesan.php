<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_customer();

if ($_SERVER["REQUEST_METHOD"] !== "POST") { pindah("customer/pesan.php"); }

$service_id = (int)($_POST["service_id"] ?? 0);
$quantity = (float)($_POST["quantity"] ?? 0);
$notes = trim($_POST["notes"] ?? "");
$notes = ($notes === "") ? null : $notes;

// Harga SELALU diambil dari database, bukan dari form (data-harga bisa diubah user)
$s = ambil_satu($koneksi, "SELECT id, name, price FROM services WHERE id = ? AND is_active = 1", "i", $service_id);
if (!$s) {
    set_pesan("danger", "Layanan tidak valid atau tidak aktif.");
    pindah("customer/pesan.php");
}
if ($quantity <= 0) {
    set_pesan("danger", "Jumlah cucian harus lebih dari 0.");
    pindah("customer/pesan.php?service=" . $service_id);
}

$harga = (float)$s["price"];
$estimasi = $harga * $quantity;
$nomor = buat_nomor_pesanan($koneksi);
$uid = (int)$_SESSION["user_id"];
$nama_layanan = $s["name"];

$stmt = $koneksi->prepare("INSERT INTO orders (order_number, user_id, service_id, service_name, unit_price, quantity, estimated_total, notes, status, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Menunggu Konfirmasi', 'Belum Dibayar')");
$stmt->bind_param("siisddds", $nomor, $uid, $service_id, $nama_layanan, $harga, $quantity, $estimasi, $notes);

if ($stmt->execute()) {
    $id_baru = $koneksi->insert_id;
    set_pesan("success", "Pesanan #" . $nomor . " berhasil dibuat. Silakan antar cucian ke outlet kami.");
    pindah("customer/detail.php?id=" . $id_baru);
} else {
    set_pesan("danger", "Gagal menyimpan pesanan: " . $koneksi->error);
    pindah("customer/pesan.php");
}
$stmt->close();
?>
