CREATE DATABASE IF NOT EXISTS `vinylsshop`;
USE `vinylsshop`;

-- add privileges to the user 'admin'@'%' with password 'admin' to access the database from any host 
-- and grant SELECT, INSERT, UPDATE, DELETE, FILE privileges on all tables to the user 'admin'@'%'
-- for security reasons.

FLUSH PRIVILEGES;
CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY 'admin';
GRANT SELECT, INSERT, DELETE, UPDATE ON * TO 'admin'@'%';


CREATE TABLE IF NOT EXISTS `users` (
    `id_user` INT NOT NULL AUTO_INCREMENT,
    `mail` VARCHAR(45) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `balance` DECIMAL(10,2) NOT NULL DEFAULT 0,
    `su` TINYINT(1) NOT NULL DEFAULT 0,
    `notifications` TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id_user`), UNIQUE INDEX `mail_UNIQUE` (`mail` ASC)
);


-- DEFAULT USERS
INSERT IGNORE INTO `users` (`mail`, `password`, `su`) VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 1);
-- mail: 'admin', password: 'admin'.

INSERT IGNORE INTO `users` (`mail`, `password`, `su`) VALUES ('user', 'ee11cbb19052e40b07aac0ca060c23ee', 0);
-- mail: 'user', password: 'user'.


CREATE TABLE IF NOT EXISTS `cards` (
    `id_card` INT NOT NULL AUTO_INCREMENT,
    `card_number` VARCHAR(255) NOT NULL,
    `exp_date` VARCHAR(5) NOT NULL,
    `cvc` VARCHAR(3) NOT NULL,
    `id_user` INT,
    PRIMARY KEY (`id_card`),
    FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
);

CREATE TABLE IF NOT EXISTS `addresses` (
    `id_address` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(55) NOT NULL,
    `city` VARCHAR(100) NOT NULL,
    `postal_code` VARCHAR(5) NOT NULL,
    `street_number` VARCHAR(255) NOT NULL,
    `id_user` INT,
    PRIMARY KEY (`id_address`),
    FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
);

-- userpreferences: default_card and default_address are nullable
-- because the user could not have them set
CREATE TABLE IF NOT EXISTS `userpreferences` (
    `id_user` INT NOT NULL,
    `default_card` INT,
    `default_address` INT,
    PRIMARY KEY (`id_user`),
    FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
    FOREIGN KEY (`default_card`) REFERENCES `cards` (`id_card`),
    FOREIGN KEY (`default_address`) REFERENCES `addresses` (`id_address`)
);


CREATE TABLE IF NOT EXISTS `artists` (
    `id_artist` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_artist`)
);

CREATE TABLE IF NOT EXISTS `albums` (
    `id_album` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `genre` VARCHAR(100),
    `cover` VARCHAR(255),
    `release_date` DATE,
    `id_artist` INT NOT NULL,
    PRIMARY KEY (`id_album`),
    FOREIGN KEY (`id_artist`) REFERENCES `artists` (`id_artist`)
);

CREATE TABLE IF NOT EXISTS `tracks` (
    `id_track` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `duration` VARCHAR(60) NOT NULL,
    PRIMARY KEY (`id_track`)
);

CREATE TABLE IF NOT EXISTS `albumstracks` (
    `id_album` INT NOT NULL,
    `id_track` INT NOT NULL,
    PRIMARY KEY (`id_album`, `id_track`),
    FOREIGN KEY (`id_album`) REFERENCES `albums` (`id_album`),
    FOREIGN KEY (`id_track`) REFERENCES `tracks` (`id_track`)
);

CREATE TABLE IF NOT EXISTS `coupons` (
    `id_coupon` INT NOT NULL AUTO_INCREMENT,
    `discount_code` VARCHAR(50) NOT NULL,
    `percentage` DECIMAL(10, 2) NOT NULL,
    `valid_from` DATE NOT NULL,
    `valid_until` DATE NOT NULL,
    PRIMARY KEY (`id_coupon`),
    UNIQUE INDEX `code_UNIQUE` (`discount_code` ASC)
);

CREATE TABLE IF NOT EXISTS `orders` (
    `id_order` INT NOT NULL AUTO_INCREMENT,
    `order_date` DATE NOT NULL,
    `total_cost` DECIMAL(10, 2) NOT NULL DEFAULT 0,
    `id_card` INT,
    `discount_code` VARCHAR(50),
    `id_user` INT NOT NULL,
    PRIMARY KEY (`id_order`),
    FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
    FOREIGN KEY (`id_card`) REFERENCES `cards` (`id_card`),
    FOREIGN KEY (`discount_code`) REFERENCES `coupons` (`discount_code`)
);

CREATE TABLE IF NOT EXISTS `shipments` (
    `id_shipment` INT NOT NULL AUTO_INCREMENT,
    `tracking_number` VARCHAR(100) NOT NULL,
    `shipment_date` DATE NOT NULL,
    `delivery_date` DATE NOT NULL,
    `shipment_status` VARCHAR(50) NOT NULL,
    `shipment_progress` INT DEFAULT 0,
    `courier` VARCHAR(50) NOT NULL,
    `notes` TEXT,
    `cost` DECIMAL(10, 2) NOT NULL,
    `id_order` INT NOT NULL,
    `id_address` INT NOT NULL,
    `id_user` INT NOT NULL,
    PRIMARY KEY (`id_shipment`),
    FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`),
    FOREIGN KEY (`id_address`) REFERENCES `addresses` (`id_address`),
    FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
);

CREATE TABLE IF NOT EXISTS `vinyls` (
    `id_vinyl` INT NOT NULL AUTO_INCREMENT,
    `cost` DECIMAL(10, 2) NOT NULL,
    `rpm` INT NOT NULL,
    `inch` INT NOT NULL,
    `stock` INT NOT NULL,
    `type` ENUM('LP', 'EP') NOT NULL,
    `id_album` INT NOT NULL,
    `is_deleted` BOOLEAN DEFAULT 0,
    PRIMARY KEY (`id_vinyl`),
    FOREIGN KEY (`id_album`) REFERENCES `albums` (`id_album`)
);

CREATE TABLE IF NOT EXISTS `carts` (
    `id_vinyl` INT NOT NULL,
    `id_user` INT NOT NULL,
    `quantity` INT NOT NULL CHECK (`quantity` > 0),
    PRIMARY KEY (`id_vinyl`, `id_user`),
    FOREIGN KEY (`id_vinyl`) REFERENCES `vinyls` (`id_vinyl`),
    FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
);

CREATE TABLE IF NOT EXISTS `checkouts` (
    `id_order` INT NOT NULL,
    `id_vinyl` INT NOT NULL,
    `quantity` INT NOT NULL CHECK (`quantity` > 0),
    PRIMARY KEY (`id_order`, `id_vinyl`),
    FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`),
    FOREIGN KEY (`id_vinyl`) REFERENCES `vinyls` (`id_vinyl`)
);

CREATE TABLE IF NOT EXISTS `notifications` (
    `id_notification` INT NOT NULL AUTO_INCREMENT,
    `id_user` INT NOT NULL,
    `message` TEXT NOT NULL,
    `link` VARCHAR(255),
    `is_read` BOOLEAN DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_notification`),
    FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
);

-- Redundancy check for cost: ORDER->costo_totale = SHIPMENT(costo) + costo(VINYL)
CREATE OR REPLACE VIEW `order_total_cost` AS
SELECT o.id_order, (s.cost + SUM(v.cost * c.quantity)) AS total_cost
FROM `orders` o
JOIN `shipments` s ON o.id_order = s.id_order
JOIN `carts` c ON c.id_user = o.id_user
JOIN `vinyls` v ON c.id_vinyl = v.id_vinyl
GROUP BY o.id_order;

