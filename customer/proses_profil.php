<?php
include "../fungsi.php";
include "../koneksi.php";
wajib_customer();

$nama = trim($_POST["nama"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$uid = (int)$_SESSION["user_id"];

if ($nama === "" || !preg_match('/^[0-9+\-\s]{8,20}$/', $phone)) {
    set_pesan("danger", "Nama wajib diisi dan nomor HP harus valid.");
    pindah("customer/profil.php");
}

$stmt = $koneksi->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
$stmt->bind_param("ssi", $nama, $phone, $uid);
if ($stmt->execute()) {
    $_SESSION["nama"] = $nama;
    set_pesan("success", "Profil berhasil diperbarui.");
} else {
    set_pesan("danger", "Gagal memperbarui profil.");
}
$stmt->close();
pindah("customer/profil.php");
?>
