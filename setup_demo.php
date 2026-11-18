<?php
// Jalankan SEKALI di browser: http://localhost/laundryku/setup_demo.php lalu HAPUS file ini.
include "koneksi.php";
$hash = password_hash("password123", PASSWORD_DEFAULT);

$koneksi->query("DELETE FROM users WHERE email IN ('pelanggan@demo.com','admin@demo.com')");
$stmt = $koneksi->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");

$n = "Pelanggan Demo"; $e = "pelanggan@demo.com"; $p = "081234567890"; $r = "customer";
$stmt->bind_param("sssss", $n, $e, $p, $hash, $r);
$stmt->execute();

$n = "Admin Demo"; $e = "admin@demo.com"; $p = "081234567891"; $r = "admin";
$stmt->bind_param("sssss", $n, $e, $p, $hash, $r);
$stmt->execute();

echo "<h2>Akun demo dibuat.</h2><ul>";
echo "<li>Customer: pelanggan@demo.com / password123</li>";
echo "<li>Admin: admin@demo.com / password123</li></ul>";
echo "<p><b>Hapus setup_demo.php sekarang.</b></p>";
?>
