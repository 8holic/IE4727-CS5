-- Run this once in phpMyAdmin -> SQL (or import this .sql file).
CREATE DATABASE IF NOT EXISTS price CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE price;

-- Retain the original table name 'coffeprice' for compatibility with CS5 starter.
CREATE TABLE IF NOT EXISTS coffeprice (
    name VARCHAR(40) NOT NULL PRIMARY KEY,
    price DECIMAL(5,2) NOT NULL
);

-- INSERT IGNORE prevents rerunning setup from overwriting prices set by the admin.
INSERT IGNORE INTO coffeprice (name, price) VALUES
 ('Just_Java', 2.00),
 ('Cafe_au_Lait_single', 2.00),
 ('Cafe_au_Lait_double', 3.00),
 ('Iced_Cappuccino_sing', 4.75),
 ('Iced_Cappuccino_doub', 5.75);

CREATE TABLE IF NOT EXISTS orders (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ordered_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX (ordered_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS order_items (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product VARCHAR(40) NOT NULL,
    category VARCHAR(10) NULL,
    quantity INT UNSIGNED NOT NULL,
    unit_price DECIMAL(5,2) NOT NULL,
    line_total DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id)
        REFERENCES orders(id) ON DELETE CASCADE,
    INDEX (product),
    INDEX (category)
) ENGINE=InnoDB;
