<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_admin();

if ($_SERVER["REQUEST_METHOD"] !== "POST") { pindah("admin/pesanan.php"); }

$id = (int)($_POST["id"] ?? 0);
$action = $_POST["action"] ?? "";

if ($action === "update_status") {
    $status = trim($_POST["status"] ?? "");
    if (!in_array($status, STATUS_PENGERJAAN, true)) {
        set_pesan("danger", "Status tidak valid.");
    } else {
        $stmt = $koneksi->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
        set_pesan("success", "Status pengerjaan diperbarui menjadi \"" . $status . "\".");
    }
} elseif ($action === "update_final") {
    $fq = (float)($_POST["final_quantity"] ?? 0);
    $ft = (float)($_POST["final_total"] ?? 0);
    if ($fq <= 0) {
        set_pesan("danger", "Jumlah akhir harus lebih dari 0.");
    } elseif ($ft < 0) {
        set_pesan("danger", "Total akhir tidak boleh negatif.");
    } else {
        $stmt = $koneksi->prepare("UPDATE orders SET final_quantity = ?, final_total = ? WHERE id = ?");
        $stmt->bind_param("ddi", $fq, $ft, $id);
        $stmt->execute();
        $stmt->close();
        set_pesan("success", "Jumlah dan total akhir berhasil diperbarui.");
    }
} elseif ($action === "update_payment") {
    $bayar = trim($_POST["payment_status"] ?? "");
    if (!in_array($bayar, STATUS_BAYAR, true)) {
        set_pesan("danger", "Status pembayaran tidak valid.");
    } else {
        $stmt = $koneksi->prepare("UPDATE orders SET payment_status = ? WHERE id = ?");
        $stmt->bind_param("si", $bayar, $id);
        $stmt->execute();
        $stmt->close();
        set_pesan("success", "Status pembayaran diperbarui.");
    }
} else {
    set_pesan("danger", "Aksi tidak dikenali.");
}
pindah("admin/detail_pesanan.php?id=" . $id);
?>
