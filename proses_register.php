<?php
include "fungsi.php";
include "koneksi.php";

$nama = trim($_POST["nama"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$password_asli = $_POST["password"] ?? "";
$konfirmasi = $_POST["konfirmasi"] ?? "";
$_SESSION["input_lama"] = ["nama" => $nama, "email" => $email, "phone" => $phone];

// Validasi sisi server (mengikat, berbeda dengan validasi JavaScript)
$error = [];
if ($nama === "") $error[] = "Nama lengkap wajib diisi.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error[] = "Format email tidak valid.";
if (!preg_match('/^[0-9+\-\s]{8,20}$/', $phone)) $error[] = "Nomor HP tidak valid.";
if (strlen($password_asli) < 6) $error[] = "Password minimal 6 karakter.";
if ($password_asli !== $konfirmasi) $error[] = "Konfirmasi password tidak sesuai.";

if (!$error) {
    $ada = ambil_satu($koneksi, "SELECT id FROM users WHERE email = ?", "s", $email);
    if ($ada) $error[] = "Email sudah terdaftar.";
}
if ($error) {
    foreach ($error as $pesan) set_pesan("danger", $pesan);
    pindah("register.php");
}

$password_hash = password_hash($password_asli, PASSWORD_DEFAULT);
// role di-hardcode 'customer': admin tidak bisa dipilih lewat form
$stmt = $koneksi->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, 'customer')");
$stmt->bind_param("ssss", $nama, $email, $phone, $password_hash);
if ($stmt->execute()) {
    unset($_SESSION["input_lama"]);
    set_pesan("success", "Pendaftaran berhasil. Silakan masuk.");
    pindah("login.php");
} else {
    set_pesan("danger", "Pendaftaran gagal: " . $koneksi->error);
    pindah("register.php");
}
$stmt->close();
?>
