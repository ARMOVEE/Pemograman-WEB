CREATE DATABASE IF NOT EXISTS db_inventory
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_inventory;

DROP TABLE IF EXISTS transactions, items, categories, users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin','staff','manager') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    category_id INT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit VARCHAR(20) NOT NULL DEFAULT 'unit',
    price DECIMAL(15,2) NOT NULL DEFAULT 0,
    entry_date DATE NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_items_category FOREIGN KEY (category_id)
        REFERENCES categories(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('IN','OUT') NOT NULL,
    quantity INT NOT NULL,
    notes VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_transactions_item FOREIGN KEY (item_id)
        REFERENCES items(id) ON DELETE CASCADE,
    CONSTRAINT fk_transactions_user FOREIGN KEY (user_id)
        REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (username, password, full_name, role) VALUES
('admin',   '$2y$10$g1GrZ0rdoCTRpdRZJM/H3eP6OUSvXZ/mn1m8yoW8ztOOCkSDXhxu.', 'Administrator',       'admin'),
('staff',   '$2y$10$g1GrZ0rdoCTRpdRZJM/H3eP6OUSvXZ/mn1m8yoW8ztOOCkSDXhxu.', 'Staf Gudang',         'staff'),
('manager', '$2y$10$g1GrZ0rdoCTRpdRZJM/H3eP6OUSvXZ/mn1m8yoW8ztOOCkSDXhxu.', 'Manajer Operasional', 'manager');

INSERT INTO categories (name, description) VALUES
('Elektronik',              'Perangkat elektronik dan aksesorisnya'),
('Alat Tulis Kantor',       'Perlengkapan tulis dan kertas'),
('Perabot Kantor',          'Meja, kursi, dan lemari'),
('Perlengkapan Kebersihan', 'Alat dan bahan kebersihan');

INSERT INTO items (code, name, category_id, quantity, unit, price, entry_date, description) VALUES
('ITM0001', 'Laptop Asus Vivobook 14',    1,   8, 'unit',  12500000, '2026-09-01', 'Laptop untuk staf'),
('ITM0002', 'Monitor LED 24 Inci',        1,  15, 'unit',   1850000, '2026-09-01', 'Monitor kantor'),
('ITM0003', 'Keyboard Wireless',          1,  25, 'unit',    275000, '2026-09-03', 'Keyboard nirkabel'),
('ITM0004', 'Mouse Optik',                1,   4, 'unit',     85000, '2026-09-03', 'Mouse kabel'),
('ITM0005', 'Kertas A4 80 gsm',           2, 120, 'rim',      52000, '2026-09-05', 'Kertas fotokopi'),
('ITM0006', 'Pulpen Hitam',               2,   5, 'lusin',    36000, '2026-09-05', 'Pulpen tinta hitam'),
('ITM0007', 'Stapler Besar',              2,  18, 'buah',     45000, '2026-09-08', 'Stapler meja'),
('ITM0008', 'Meja Kerja',                 3,  10, 'unit',   1200000, '2026-09-10', 'Meja kerja staf'),
('ITM0009', 'Kursi Kantor Ergonomis',     3,   3, 'unit',   1650000, '2026-09-10', 'Kursi dengan sandaran'),
('ITM0010', 'Lemari Arsip Besi',          3,   6, 'unit',   2300000, '2026-09-12', 'Lemari arsip 4 laci'),
('ITM0011', 'Sapu Lantai',                4,  30, 'buah',     22000, '2026-09-15', 'Sapu ijuk'),
('ITM0012', 'Cairan Pembersih Lantai 1 L',4,   2, 'botol',    18000, '2026-09-15', 'Cairan pembersih aroma lemon');

INSERT INTO transactions (item_id, user_id, type, quantity, notes, created_at) VALUES
(1, 2, 'IN',  10, 'Pembelian awal laptop',   '2026-10-01 09:15:00'),
(5, 2, 'OUT', 30, 'Pemakaian bulanan kantor','2026-10-03 10:30:00'),
(4, 1, 'OUT',  6, 'Dipinjam divisi IT',      '2026-10-05 13:45:00'),
(9, 2, 'IN',   5, 'Restock kursi',           '2026-10-07 08:20:00');
