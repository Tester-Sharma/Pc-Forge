-- =========================================================
-- PCForge Database Schema
-- Save as: pcforge_schema.sql
-- =========================================================

-- 1. Create Database
CREATE DATABASE IF NOT EXISTS pcforge_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE pcforge_db;

-- =========================================================
-- 2. Drop Tables if they exist (for reset purposes)
--    Order matters due to foreign keys
-- =========================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS builds;
DROP TABLE IF EXISTS parts;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS admins;

SET FOREIGN_KEY_CHECKS = 1;

-- =========================================================
-- 3. Admins Table (For Admin Panel Login)
-- =========================================================

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- You can later insert an admin like:
-- INSERT INTO admins (username, password_hash)
-- VALUES ('admin', '<paste password_hash("yourpassword") here>');

-- =========================================================
-- 4. Users Table (Normal Users)
-- =========================================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================================
-- 5. Categories Table (CPU, Motherboard, RAM, etc.)
-- =========================================================

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Optional: Pre-insert core categories
INSERT INTO categories (name, slug) VALUES
('CPU', 'cpu'),
('Motherboard', 'motherboard'),
('RAM', 'ram'),
('Storage', 'storage'),
('GPU', 'gpu'),
('Power Supply', 'psu');

-- =========================================================
-- 6. Parts Table (Generic Parts for All Categories)
-- =========================================================

CREATE TABLE parts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(100),
    model VARCHAR(100),
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,

    -- Compatibility-related fields (nullable where not applicable)
    socket_type VARCHAR(50),      -- for CPU + Motherboard
    ram_type VARCHAR(50),         -- for RAM + Motherboard (e.g., DDR4, DDR5)
    form_factor VARCHAR(50),      -- for Motherboards, Cases, etc. (ATX, mATX, etc.)
    interface VARCHAR(50),        -- for Storage (SATA, NVMe, etc.)
    wattage INT,                  -- for PSUs (e.g., 650W)
    min_psu_wattage INT,          -- for GPUs (minimum PSU required)

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_parts_category
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Optional: Sample parts (you can change or remove these)
-- CPU sample
INSERT INTO parts (category_id, name, brand, model, price, socket_type)
VALUES
((SELECT id FROM categories WHERE slug = 'cpu'),
 'Intel Core i5-12400F', 'Intel', 'i5-12400F', 15000.00, 'LGA1700');

-- Motherboard sample
INSERT INTO parts (category_id, name, brand, model, price, socket_type, ram_type, form_factor)
VALUES
((SELECT id FROM categories WHERE slug = 'motherboard'),
 'ASUS PRIME B660M-A', 'ASUS', 'B660M-A', 12000.00, 'LGA1700', 'DDR4', 'mATX');

-- RAM sample
INSERT INTO parts (category_id, name, brand, model, price, ram_type)
VALUES
((SELECT id FROM categories WHERE slug = 'ram'),
 'Corsair Vengeance 16GB (2x8GB) DDR4 3200MHz', 'Corsair', 'Vengeance DDR4', 5000.00, 'DDR4');

-- GPU sample
INSERT INTO parts (category_id, name, brand, model, price, min_psu_wattage)
VALUES
((SELECT id FROM categories WHERE slug = 'gpu'),
 'NVIDIA GeForce RTX 3060', 'NVIDIA', 'RTX 3060', 28000.00, 550);

-- PSU sample
INSERT INTO parts (category_id, name, brand, model, price, wattage)
VALUES
((SELECT id FROM categories WHERE slug = 'psu'),
 'Corsair 650W 80+ Bronze', 'Corsair', 'CX650', 6000.00, 650);

-- Storage sample
INSERT INTO parts (category_id, name, brand, model, price, interface)
VALUES
((SELECT id FROM categories WHERE slug = 'storage'),
 'Samsung 970 EVO Plus 500GB NVMe SSD', 'Samsung', '970 EVO Plus', 7000.00, 'NVMe');

-- Indexes for faster filtering
CREATE INDEX idx_parts_category ON parts(category_id);
CREATE INDEX idx_parts_socket_type ON parts(socket_type);
CREATE INDEX idx_parts_ram_type ON parts(ram_type);
CREATE INDEX idx_parts_interface ON parts(interface);

-- =========================================================
-- 7. Builds Table (Saved PC Builds by Users)
-- =========================================================

CREATE TABLE builds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,

    -- Budget & pricing
    budget DECIMAL(10,2) DEFAULT NULL,
    total_price DECIMAL(10,2) DEFAULT 0.00,

    -- Selected parts (FKs to parts.id)
    cpu_id INT NULL,
    motherboard_id INT NULL,
    ram_id INT NULL,
    storage_id INT NULL,
    gpu_id INT NULL,
    psu_id INT NULL,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_builds_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_builds_cpu
        FOREIGN KEY (cpu_id)
        REFERENCES parts(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_builds_motherboard
        FOREIGN KEY (motherboard_id)
        REFERENCES parts(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_builds_ram
        FOREIGN KEY (ram_id)
        REFERENCES parts(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_builds_storage
        FOREIGN KEY (storage_id)
        REFERENCES parts(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_builds_gpu
        FOREIGN KEY (gpu_id)
        REFERENCES parts(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_builds_psu
        FOREIGN KEY (psu_id)
        REFERENCES parts(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_builds_user ON builds(user_id);

-- =========================================================
-- Done
-- =========================================================
