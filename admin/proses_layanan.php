<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_admin();

if ($_SERVER["REQUEST_METHOD"] !== "POST") { pindah("admin/layanan.php"); }

$action = $_POST["action"] ?? "";
$id = (int)($_POST["id"] ?? 0);

if ($action === "simpan") {
    $nama = trim($_POST["name"] ?? "");
    $deskripsi = trim($_POST["description"] ?? "");
    $harga = (float)($_POST["price"] ?? 0);
    $satuan = trim($_POST["unit"] ?? "");

    $error = [];
    if ($nama === "") $error[] = "Nama layanan wajib diisi.";
    if ($deskripsi === "") $error[] = "Deskripsi wajib diisi.";
    if ($harga <= 0) $error[] = "Harga harus lebih dari 0.";
    if ($satuan === "") $error[] = "Satuan wajib diisi.";
    if ($error) {
        foreach ($error as $pesan) set_pesan("danger", $pesan);
        pindah("admin/form_layanan.php" . ($id > 0 ? "?id=" . $id : ""));
    }

    if ($id > 0) {
        $stmt = $koneksi->prepare("UPDATE services SET name = ?, description = ?, price = ?, unit = ? WHERE id = ?");
        $stmt->bind_param("ssdsi", $nama, $deskripsi, $harga, $satuan, $id);
        $pesan = "Layanan diperbarui.";
    } else {
        $stmt = $koneksi->prepare("INSERT INTO services (name, description, price, unit, is_active) VALUES (?, ?, ?, ?, 1)");
        $stmt->bind_param("ssds", $nama, $deskripsi, $harga, $satuan);
        $pesan = "Layanan baru ditambahkan.";
    }
    $stmt->execute();
    $stmt->close();
    set_pesan("success", $pesan);

} elseif ($action === "toggle") {
    $stmt = $koneksi->prepare("UPDATE services SET is_active = 1 - is_active WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    set_pesan("success", "Status layanan diperbarui.");

} elseif ($action === "hapus") {
    // layanan yang sudah dipakai pesanan tidak boleh dihapus (foreign key)
    $pakai = ambil_satu($koneksi, "SELECT COUNT(*) AS n FROM orders WHERE service_id = ?", "i", $id)["n"];
    if ($pakai > 0) {
        set_pesan("danger", "Layanan sudah dipakai dalam pesanan. Nonaktifkan saja, jangan dihapus.");
    } else {
        $stmt = $koneksi->prepare("DELETE FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        set_pesan("success", "Layanan dihapus.");
    }
} else {
    set_pesan("danger", "Aksi tidak dikenali.");
}
pindah("admin/layanan.php");
?>
