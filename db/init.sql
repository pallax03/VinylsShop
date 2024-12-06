CREATE DATABASE IF NOT EXISTS `VinylsShop`;

-- add privileges to the user 'admin'@'%' with password 'admin' to access the database 'VinylsShop' from any host 
-- and grant SELECT, INSERT, UPDATE, DELETE, FILE privileges on all tables to the user 'admin'@'%'
-- for security reasons.

FLUSH PRIVILEGES;
CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY 'admin';
GRANT SELECT, INSERT, DELETE, UPDATE ON `VinylsShop`.* TO 'admin'@'%';


CREATE TABLE IF NOT EXISTS `VinylsShop`.`Users` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `mail` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `balance` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `su` TINYINT(1) NOT NULL DEFAULT 0,
  `newsletter` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_user`), UNIQUE INDEX `mail_UNIQUE` (`mail` ASC));

-- DEFAULT USERS
INSERT IGNORE INTO `VinylsShop`.`Users` (`mail`, `password`, `su`) VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 1);
INSERT IGNORE INTO `VinylsShop`.`Users` (`mail`, `password`, `su`) VALUES ('alexmaz03@hotmail.it', 'd41d8cd98f00b204e9800998ecf8427e', 0);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Cards` (
    `id_card` INT NOT NULL AUTO_INCREMENT,
    `card_number` VARCHAR(16) NOT NULL,
    `cvc` VARCHAR(3) NOT NULL,
    `expiration_date` DATE NOT NULL,
    `id_user` INT NOT NULL,
    PRIMARY KEY (`id_card`),
    FOREIGN KEY (`id_user`) REFERENCES `VinylsShop`.`Users` (`id_user`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Addresses` (
    `id_address` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(55) NOT NULL,
    `city` VARCHAR(100) NOT NULL,
    `postal_code` VARCHAR(20) NOT NULL,
    `street_number` VARCHAR(20) NOT NULL,
    `id_user` INT NOT NULL,
    PRIMARY KEY (`id_address`),
    FOREIGN KEY (`id_user`) REFERENCES `VinylsShop`.`Users` (`id_user`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Artists` (
    `id_artist` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_artist`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Albums` (
    `id_album` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `genre` VARCHAR(100),
    `cover_img` VARCHAR(255),
    `release_date` DATE,
    `id_artist` INT NOT NULL,
    PRIMARY KEY (`id_album`),
    FOREIGN KEY (`id_artist`) REFERENCES `VinylsShop`.`Artists` (`id_artist`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Tracks` (
    `id_track` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `duration` TIME NOT NULL,
    PRIMARY KEY (`id_track`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`AlbumsTracks` (
    `id_album` INT NOT NULL,
    `id_track` INT NOT NULL,
    PRIMARY KEY (`id_album`, `id_track`),
    FOREIGN KEY (`id_album`) REFERENCES `VinylsShop`.`Albums` (`id_album`),
    FOREIGN KEY (`id_track`) REFERENCES `VinylsShop`.`Tracks` (`id_track`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Coupons` (
    `id_coupon` INT NOT NULL AUTO_INCREMENT,
    `discount_code` VARCHAR(50) NOT NULL,
    `percentage` DECIMAL(10, 2) NOT NULL,
    `valid_until` DATE NOT NULL,
    PRIMARY KEY (`id_coupon`),
    UNIQUE INDEX `code_UNIQUE` (`discount_code` ASC)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Orders` (
    `id_order` INT NOT NULL AUTO_INCREMENT,
    `order_date` DATE NOT NULL,
    `total_cost` DECIMAL(10, 2) NOT NULL,
    `id_card` INT,
    `order_status` VARCHAR(50) NOT NULL,
    `discount_code` VARCHAR(50),
    `id_user` INT NOT NULL,
    PRIMARY KEY (`id_order`),
    FOREIGN KEY (`id_user`) REFERENCES `VinylsShop`.`Users` (`id_user`),
    FOREIGN KEY (`id_card`) REFERENCES `VinylsShop`.`Cards` (`id_card`),
    FOREIGN KEY (`discount_code`) REFERENCES `VinylsShop`.`Coupons` (`discount_code`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Shipments` (
    `id_shipment` INT NOT NULL AUTO_INCREMENT,
    `tracking_number` VARCHAR(100) NOT NULL,
    `shipment_date` DATE NOT NULL,
    `delivery_date` DATE,
    `shipment_status` VARCHAR(50) NOT NULL,
    `carrier` VARCHAR(50) NOT NULL,
    `notes` TEXT,
    `cost` DECIMAL(10, 2) NOT NULL,
    `id_order` INT NOT NULL,
    `id_address` INT NOT NULL,
    PRIMARY KEY (`id_shipment`),
    FOREIGN KEY (`id_order`) REFERENCES `VinylsShop`.`Orders` (`id_order`),
    FOREIGN KEY (`id_address`) REFERENCES `VinylsShop`.`Addresses` (`id_address`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Vinyls` (
    `id_vinyl` INT NOT NULL AUTO_INCREMENT,
    `cost` DECIMAL(10, 2) NOT NULL,
    `rpm` INT NOT NULL,
    `inch` INT NOT NULL,
    `quantity` INT NOT NULL,
    `type` ENUM('LP', 'EP') NOT NULL,
    `id_album` INT NOT NULL,
    PRIMARY KEY (`id_vinyl`),
    FOREIGN KEY (`id_album`) REFERENCES `VinylsShop`.`Albums` (`id_album`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Carts` (
    `id_vinyl` INT NOT NULL,
    `id_user` INT NOT NULL,
    `quantity` INT NOT NULL CHECK (`quantity` > 0),
    PRIMARY KEY (`id_vinyl`, `id_user`),
    FOREIGN KEY (`id_vinyl`) REFERENCES `VinylsShop`.`Vinyls` (`id_vinyl`),
    FOREIGN KEY (`id_user`) REFERENCES `VinylsShop`.`Users` (`id_user`)
);

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Checkouts` (
    `id_order` INT NOT NULL,
    `id_vinyl` INT NOT NULL,
    `quantity` INT NOT NULL CHECK (`quantity` > 0),
    PRIMARY KEY (`id_order`, `id_vinyl`),
    FOREIGN KEY (`id_order`) REFERENCES `VinylsShop`.`Orders` (`id_order`),
    FOREIGN KEY (`id_vinyl`) REFERENCES `VinylsShop`.`Vinyls` (`id_vinyl`)
);

-- Redundancy check for cost: ORDER->costo_totale = SHIPMENT(costo) + costo(VINYL)
CREATE OR REPLACE VIEW `VinylsShop`.`order_total_cost` AS
SELECT o.id_order, (s.cost + SUM(v.cost * c.quantity)) AS total_cost
FROM `VinylsShop`.`Orders` o
JOIN `VinylsShop`.`Shipments` s ON o.id_order = s.id_order
JOIN `VinylsShop`.`Carts` c ON c.id_user = o.id_user
JOIN `VinylsShop`.`Vinyls` v ON c.id_vinyl = v.id_vinyl
GROUP BY o.id_order;