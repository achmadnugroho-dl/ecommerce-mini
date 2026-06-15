-- ================================================================
-- Database setup untuk ecommerce-mini 🔥
-- Jalankan di phpMyAdmin: Import file ini
-- ================================================================

CREATE DATABASE IF NOT EXISTS ecommerce_mini CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ecommerce_mini;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price INT NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    hp VARCHAR(20) NOT NULL,
    total INT NOT NULL,
    metode VARCHAR(50),
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    qty INT DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- ================================================================
-- AKUN ADMIN  =>  username: admin  |  password: admin123
-- ================================================================
INSERT INTO users (username, password, role) VALUES
(
    'admin',
    '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77bqIy',
    'admin'
)
ON DUPLICATE KEY UPDATE role = 'admin';

-- Produk contoh
INSERT IGNORE INTO products (name, description, price, image) VALUES
('Stick Rumput Laut Pedas', 'Stick renyah dari rumput laut pilihan dengan bumbu pedas gurih khas.', 12000, 'basreng.jpg'),
('Keripik Rumput Laut Pedas', 'Keripik tipis gurih pedas, cocok banget buat camilan santai kapan saja.', 15000, 'kripik.jpg'),
('Makaroni Pedas', 'Makaroni kriuk dengan bumbu pedas spesial yang bikin ketagihan!', 10000, 'makaroni.jpg');
