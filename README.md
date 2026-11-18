# LaundryKu (versi gaya Modul Praktikum)

PHP + MySQLi + Bootstrap 5.3.3 (CDN) + JavaScript. Dijalankan di XAMPP.

## Menjalankan
1. Salin folder `laundryku/` ke `htdocs`.
2. phpMyAdmin → Import `database/laundryku.sql`.
3. Buka `http://localhost/laundryku/setup_demo.php` sekali (membuat akun demo), lalu **hapus file itu**.
4. Buka `http://localhost/laundryku/`.
   - Customer: pelanggan@demo.com / password123
   - Admin: admin@demo.com / password123

Jika nama folder bukan `laundryku`, ubah `BASE` di `fungsi.php`.

## Pemetaan ke modul
| Modul | Penerapan |
|---|---|
| I–II HTML, CSS, Bootstrap | `header.php`/`footer.php` (navbar, grid, card, badge, table), `assets/css/style.css` |
| III JavaScript | `assets/js/script.js` (kalkulator estimasi, validasi register, classList, transition) |
| IV PHP dasar | percabangan, perulangan `foreach`, array asosiatif (`STATUS_PENGERJAAN`, dll.) |
| V–VIII | `koneksi.php` (mysqli OOP), CRUD layanan, JOIN pesanan+pelanggan |
| VI Session | `$_SESSION["status_login"]`, `wajib_login()` di tiap halaman |
| VII Authentication | `password_hash`/`password_verify`, prepared statement di login & register |

## Struktur
```
koneksi.php  fungsi.php  header.php  footer.php
index.php  layanan.php  login.php  proses_login.php
register.php  proses_register.php  logout.php  setup_demo.php
customer/  dashboard, pesan, proses_pesan, riwayat, detail, profil, proses_profil
admin/     dashboard, pesanan, detail_pesanan, proses_pesanan,
           layanan, form_layanan, proses_layanan, pelanggan
assets/css/style.css  assets/js/script.js  database/laundryku.sql
```
