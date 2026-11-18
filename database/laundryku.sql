-- LaundryKu - skema & data awal (import via phpMyAdmin)
CREATE DATABASE IF NOT EXISTS laundryku DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE laundryku;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  phone VARCHAR(20) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  unit VARCHAR(20) NOT NULL DEFAULT 'Kg',
  is_active BOOLEAN NOT NULL DEFAULT TRUE,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_number VARCHAR(20) NOT NULL UNIQUE,
  user_id INT NOT NULL,
  service_id INT NOT NULL,
  service_name VARCHAR(100) NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  quantity DECIMAL(10,2) NOT NULL,
  final_quantity DECIMAL(10,2) NULL DEFAULT NULL,
  estimated_total DECIMAL(10,2) NOT NULL,
  final_total DECIMAL(10,2) NULL DEFAULT NULL,
  notes TEXT NULL,
  status VARCHAR(30) NOT NULL DEFAULT 'Menunggu Konfirmasi',
  payment_status VARCHAR(20) NOT NULL DEFAULT 'Belum Dibayar',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT fk_orders_service FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO services (name, description, price, unit, is_active) VALUES
('Cuci Kering', 'Layanan cuci dan kering tanpa setrika. Cocok untuk pakaian harian.', 7000.00, 'Kg', TRUE),
('Cuci + Setrika', 'Layanan cuci, kering, dan setrika rapi. Hasil siap pakai.', 10000.00, 'Kg', TRUE),
('Setrika Saja', 'Setrika rapi untuk pakaian yang sudah dicuci. Hasil wangi dan rapi.', 6000.00, 'Kg', TRUE),
('Cuci Bed Cover', 'Pencucian khusus bed cover, selimut, dan sprei tebal.', 20000.00, 'Item', TRUE),
('Cuci Sepatu', 'Pencucian khusus sepatu dengan perawatan tepat sesuai material.', 25000.00, 'Pasang', TRUE);
-- Akun demo: jalankan setup_demo.php sekali di browser, lalu hapus file tersebut.
