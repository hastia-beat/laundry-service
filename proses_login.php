<?php
include "fungsi.php";
include "koneksi.php";

$email = trim($_POST["email"] ?? "");
$password_asli = $_POST["password"] ?? "";

if ($email === "" || $password_asli === "") {
    set_pesan("danger", "Email dan password wajib diisi.");
    pindah("login.php");
}

// Prepared statement: nilai input tidak disisipkan langsung ke teks query
$stmt = $koneksi->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($id, $nama, $password_hash, $role);
$stmt->fetch();
$stmt->close();

if ($password_hash && password_verify($password_asli, $password_hash)) {
    session_regenerate_id(true);
    $_SESSION["status_login"] = true;
    $_SESSION["user_id"] = $id;
    $_SESSION["nama"] = $nama;
    $_SESSION["role"] = $role;
    set_pesan("success", "Selamat datang kembali, " . $nama . "!");
    pindah($role === "admin" ? "admin/dashboard.php" : "customer/dashboard.php");
} else {
    set_pesan("danger", "Email atau password salah.");
    pindah("login.php");
}
?>
