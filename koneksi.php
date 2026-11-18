<?php
// Koneksi database (MySQLi gaya OOP, seperti Modul VII & VIII)
$koneksi = new mysqli("localhost", "root", "", "laundryku");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
$koneksi->set_charset("utf8mb4");
?>
