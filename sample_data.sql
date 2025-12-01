-- =========================================================
-- PCForge Sample Data (8 Entries Per Category)
-- Run this in phpMyAdmin to populate your database
-- =========================================================

-- 1. CPUs (8 Entries)
INSERT INTO parts (category_id, name, brand, model, price, socket_type) VALUES
((SELECT id FROM categories WHERE slug = 'cpu'), 'Intel Core i9-13900K', 'Intel', 'i9-13900K', 54000.00, 'LGA1700'),
((SELECT id FROM categories WHERE slug = 'cpu'), 'Intel Core i7-13700K', 'Intel', 'i7-13700K', 38000.00, 'LGA1700'),
((SELECT id FROM categories WHERE slug = 'cpu'), 'Intel Core i5-13600K', 'Intel', 'i5-13600K', 28000.00, 'LGA1700'),
((SELECT id FROM categories WHERE slug = 'cpu'), 'Intel Core i5-12400F', 'Intel', 'i5-12400F', 14000.00, 'LGA1700'),
((SELECT id FROM categories WHERE slug = 'cpu'), 'AMD Ryzen 9 7950X', 'AMD', 'Ryzen 9 7950X', 58000.00, 'AM5'),
((SELECT id FROM categories WHERE slug = 'cpu'), 'AMD Ryzen 7 7800X3D', 'AMD', 'Ryzen 7 7800X3D', 42000.00, 'AM5'),
((SELECT id FROM categories WHERE slug = 'cpu'), 'AMD Ryzen 5 7600X', 'AMD', 'Ryzen 5 7600X', 22000.00, 'AM5'),
((SELECT id FROM categories WHERE slug = 'cpu'), 'AMD Ryzen 5 5600X', 'AMD', 'Ryzen 5 5600X', 15000.00, 'AM4');

-- 2. Motherboards (8 Entries)
INSERT INTO parts (category_id, name, brand, model, price, socket_type, ram_type, form_factor) VALUES
((SELECT id FROM categories WHERE slug = 'motherboard'), 'ASUS ROG Maximus Z790 Hero', 'ASUS', 'Z790 Hero', 62000.00, 'LGA1700', 'DDR5', 'ATX'),
((SELECT id FROM categories WHERE slug = 'motherboard'), 'MSI MAG Z790 Tomahawk WiFi', 'MSI', 'Z790 Tomahawk', 32000.00, 'LGA1700', 'DDR5', 'ATX'),
((SELECT id FROM categories WHERE slug = 'motherboard'), 'Gigabyte B760M AORUS ELITE', 'Gigabyte', 'B760M', 18000.00, 'LGA1700', 'DDR5', 'mATX'),
((SELECT id FROM categories WHERE slug = 'motherboard'), 'ASUS Prime B660-PLUS D4', 'ASUS', 'B660-PLUS', 14000.00, 'LGA1700', 'DDR4', 'ATX'),
((SELECT id FROM categories WHERE slug = 'motherboard'), 'ASUS ROG Crosshair X670E Hero', 'ASUS', 'X670E Hero', 65000.00, 'AM5', 'DDR5', 'ATX'),
((SELECT id FROM categories WHERE slug = 'motherboard'), 'MSI MAG B650 Tomahawk WiFi', 'MSI', 'B650 Tomahawk', 24000.00, 'AM5', 'DDR5', 'ATX'),
((SELECT id FROM categories WHERE slug = 'motherboard'), 'Gigabyte B650M DS3H', 'Gigabyte', 'B650M', 15000.00, 'AM5', 'DDR5', 'mATX'),
((SELECT id FROM categories WHERE slug = 'motherboard'), 'MSI B550-A PRO', 'MSI', 'B550-A', 12000.00, 'AM4', 'DDR4', 'ATX');

-- 3. RAM (8 Entries)
INSERT INTO parts (category_id, name, brand, model, price, ram_type) VALUES
((SELECT id FROM categories WHERE slug = 'ram'), 'G.Skill Trident Z5 RGB 32GB (2x16GB) 6000MHz', 'G.Skill', 'Trident Z5', 18000.00, 'DDR5'),
((SELECT id FROM categories WHERE slug = 'ram'), 'Corsair Vengeance 32GB (2x16GB) 5600MHz', 'Corsair', 'Vengeance', 14000.00, 'DDR5'),
((SELECT id FROM categories WHERE slug = 'ram'), 'Kingston FURY Beast 16GB (2x8GB) 5200MHz', 'Kingston', 'FURY Beast', 8000.00, 'DDR5'),
((SELECT id FROM categories WHERE slug = 'ram'), 'TeamGroup T-Force Delta RGB 32GB (2x16GB) 6000MHz', 'TeamGroup', 'Delta RGB', 16000.00, 'DDR5'),
((SELECT id FROM categories WHERE slug = 'ram'), 'G.Skill Trident Z RGB 32GB (2x16GB) 3600MHz', 'G.Skill', 'Trident Z', 9000.00, 'DDR4'),
((SELECT id FROM categories WHERE slug = 'ram'), 'Corsair Vengeance LPX 16GB (2x8GB) 3200MHz', 'Corsair', 'Vengeance LPX', 4500.00, 'DDR4'),
((SELECT id FROM categories WHERE slug = 'ram'), 'Crucial Ballistix 16GB (2x8GB) 3200MHz', 'Crucial', 'Ballistix', 5000.00, 'DDR4'),
((SELECT id FROM categories WHERE slug = 'ram'), 'TeamGroup T-Force Vulcan Z 16GB (2x8GB) 3600MHz', 'TeamGroup', 'Vulcan Z', 4800.00, 'DDR4');

-- 4. Storage (8 Entries)
INSERT INTO parts (category_id, name, brand, model, price, interface) VALUES
((SELECT id FROM categories WHERE slug = 'storage'), 'Samsung 990 PRO 2TB NVMe SSD', 'Samsung', '990 PRO', 22000.00, 'NVMe'),
((SELECT id FROM categories WHERE slug = 'storage'), 'Samsung 980 PRO 1TB NVMe SSD', 'Samsung', '980 PRO', 12000.00, 'NVMe'),
((SELECT id FROM categories WHERE slug = 'storage'), 'WD Black SN850X 1TB NVMe SSD', 'Western Digital', 'SN850X', 11500.00, 'NVMe'),
((SELECT id FROM categories WHERE slug = 'storage'), 'Crucial P5 Plus 1TB NVMe SSD', 'Crucial', 'P5 Plus', 9000.00, 'NVMe'),
((SELECT id FROM categories WHERE slug = 'storage'), 'Kingston NV2 1TB NVMe SSD', 'Kingston', 'NV2', 5500.00, 'NVMe'),
((SELECT id FROM categories WHERE slug = 'storage'), 'Samsung 870 EVO 1TB SATA SSD', 'Samsung', '870 EVO', 8000.00, 'SATA'),
((SELECT id FROM categories WHERE slug = 'storage'), 'Crucial MX500 1TB SATA SSD', 'Crucial', 'MX500', 6500.00, 'SATA'),
((SELECT id FROM categories WHERE slug = 'storage'), 'Seagate Barracuda 2TB HDD', 'Seagate', 'Barracuda', 4500.00, 'SATA');

-- 5. GPUs (8 Entries)
INSERT INTO parts (category_id, name, brand, model, price, min_psu_wattage) VALUES
((SELECT id FROM categories WHERE slug = 'gpu'), 'NVIDIA GeForce RTX 4090', 'NVIDIA', 'RTX 4090', 165000.00, 850),
((SELECT id FROM categories WHERE slug = 'gpu'), 'NVIDIA GeForce RTX 4080', 'NVIDIA', 'RTX 4080', 110000.00, 750),
((SELECT id FROM categories WHERE slug = 'gpu'), 'NVIDIA GeForce RTX 4070 Ti', 'NVIDIA', 'RTX 4070 Ti', 85000.00, 700),
((SELECT id FROM categories WHERE slug = 'gpu'), 'NVIDIA GeForce RTX 3060', 'NVIDIA', 'RTX 3060', 28000.00, 550),
((SELECT id FROM categories WHERE slug = 'gpu'), 'AMD Radeon RX 7900 XTX', 'AMD', 'RX 7900 XTX', 98000.00, 800),
((SELECT id FROM categories WHERE slug = 'gpu'), 'AMD Radeon RX 7900 XT', 'AMD', 'RX 7900 XT', 85000.00, 750),
((SELECT id FROM categories WHERE slug = 'gpu'), 'AMD Radeon RX 6700 XT', 'AMD', 'RX 6700 XT', 35000.00, 650),
((SELECT id FROM categories WHERE slug = 'gpu'), 'AMD Radeon RX 6600', 'AMD', 'RX 6600', 22000.00, 450);

-- 6. Power Supplies (8 Entries)
INSERT INTO parts (category_id, name, brand, model, price, wattage) VALUES
((SELECT id FROM categories WHERE slug = 'psu'), 'Corsair RM1000x 1000W 80+ Gold', 'Corsair', 'RM1000x', 16000.00, 1000),
((SELECT id FROM categories WHERE slug = 'psu'), 'Corsair RM850x 850W 80+ Gold', 'Corsair', 'RM850x', 11500.00, 850),
((SELECT id FROM categories WHERE slug = 'psu'), 'EVGA SuperNOVA 850 G6 850W 80+ Gold', 'EVGA', 'SuperNOVA G6', 11000.00, 850),
((SELECT id FROM categories WHERE slug = 'psu'), 'MSI MPG A850G 850W 80+ Gold', 'MSI', 'MPG A850G', 10500.00, 850),
((SELECT id FROM categories WHERE slug = 'psu'), 'Corsair RM750e 750W 80+ Gold', 'Corsair', 'RM750e', 9500.00, 750),
((SELECT id FROM categories WHERE slug = 'psu'), 'Cooler Master MWE Gold 750 V2', 'Cooler Master', 'MWE Gold', 8500.00, 750),
((SELECT id FROM categories WHERE slug = 'psu'), 'Corsair CX650M 650W 80+ Bronze', 'Corsair', 'CX650M', 5500.00, 650),
((SELECT id FROM categories WHERE slug = 'psu'), 'EVGA 600 W1 600W 80+ White', 'EVGA', '600 W1', 4000.00, 600);
