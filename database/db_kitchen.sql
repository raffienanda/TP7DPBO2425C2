CREATE DATABASE db_kitchen;
USE db_kitchen;

CREATE TABLE foods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    food_name VARCHAR(255) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0
);

CREATE TABLE drinks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    drink_name VARCHAR(255) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL DEFAULT 0
);

CREATE TABLE tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_name VARCHAR(10) NOT NULL
);

CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_name VARCHAR(255)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    food_id INT NOT NULL,
    drink_id INT NOT NULL,
    table_id INT NOT NULL,
    member_id INT NOT NULL,
    order_date DATETIME NOT NULL,
    FOREIGN KEY (food_id) REFERENCES foods(id),
    FOREIGN KEY (drink_id) REFERENCES drinks(id),
    FOREIGN KEY (table_id) REFERENCES tables(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
); 

INSERT INTO foods (food_name, harga, stok) VALUES
('-', 0, 0),
('Indomie Goreng', 9000, 40),
('Indomie Rebus', 9000, 40),
('Nasi Goreng', 18000, 15),
('Rice Bowl', 15000, 15),
('Nasi Ayam', 16000, 20),
('Kentang Sosis', 12000, 20);

INSERT INTO drinks (drink_name, harga, stok) VALUES
('-', 0, 0),
('Nutrisari', 5000, 12),
('Milo', 5000, 12),
('Air Mineral', 4000, 48),
('Kopi', 5000, 24),
('Josu', 6000, 18),
('Es Batu', 1000, 84);

INSERT INTO tables (table_name) VALUES
('Reg001'),
('Reg002'),
('Reg003'),
('Reg004'),
('Reg005'),
('VIP001'),
('VIP002'),
('VIP003'),
('VIP004'),
('VIP005'),
('VVIP001'),
('VVIP002'),
('VVIP003'),
('VVIP004'),
('VVIP005');

INSERT INTO members (member_name) VALUES
('away'),
('yassar'),
('arap'),
('harri'),
('anas'),
('azmi'),
('nanda'),
('aji');