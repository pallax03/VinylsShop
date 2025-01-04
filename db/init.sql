CREATE DATABASE IF NOT EXISTS `vinylsshop`;

-- add privileges to the user 'admin'@'%' with password 'admin' to access the database 'vinylsshop' from any host 
-- and grant SELECT, INSERT, UPDATE, DELETE, FILE privileges on all tables to the user 'admin'@'%'
-- for security reasons.

FLUSH PRIVILEGES;
CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY 'admin';
GRANT SELECT, INSERT, DELETE, UPDATE ON `vinylsshop`.* TO 'admin'@'%';


CREATE TABLE IF NOT EXISTS `vinylsshop`.`users` (
    `id_user` INT NOT NULL AUTO_INCREMENT,
    `mail` VARCHAR(45) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `balance` DECIMAL(10,2) NOT NULL DEFAULT 0,
    `su` TINYINT(1) NOT NULL DEFAULT 0,
    `newsletter` TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id_user`), UNIQUE INDEX `mail_UNIQUE` (`mail` ASC)
);


-- DEFAULT USERS
INSERT IGNORE INTO `vinylsshop`.`users` (`mail`, `password`, `su`) VALUES ('admin', '21232f297a57a5a743894a0e4a801fc3', 1);
-- it's the md5 hash of the password 'admin'.
INSERT IGNORE INTO `vinylsshop`.`users` (`mail`, `password`, `su`) VALUES ('alexmaz03@hotmail.it', '0cc175b9c0f1b6a831c399e269772661', 0);
-- it's the md5 hash of the password 'a'.


CREATE TABLE IF NOT EXISTS `vinylsshop`.`cards` (
    `id_card` INT NOT NULL AUTO_INCREMENT,
    `card_number` VARCHAR(255) NOT NULL,
    `exp_date` VARCHAR(5) NOT NULL,
    `cvc` VARCHAR(3) NOT NULL,
    `id_user` INT,
    PRIMARY KEY (`id_card`),
    FOREIGN KEY (`id_user`) REFERENCES `vinylsshop`.`users` (`id_user`)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`addresses` (
    `id_address` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(55) NOT NULL,
    `city` VARCHAR(100) NOT NULL,
    `postal_code` VARCHAR(5) NOT NULL,
    `street_number` VARCHAR(255) NOT NULL,
    `id_user` INT,
    PRIMARY KEY (`id_address`),
    FOREIGN KEY (`id_user`) REFERENCES `vinylsshop`.`users` (`id_user`)
);

-- userpreferences: default_card and default_address are nullable
-- because the user could not have them set
CREATE TABLE IF NOT EXISTS `vinylsshop`.`userpreferences` (
    `id_user` INT NOT NULL,
    `default_card` INT,
    `default_address` INT,
    PRIMARY KEY (`id_user`),
    FOREIGN KEY (`id_user`) REFERENCES `vinylsshop`.`users` (`id_user`),
    FOREIGN KEY (`default_card`) REFERENCES `vinylsshop`.`cards` (`id_card`),
    FOREIGN KEY (`default_address`) REFERENCES `vinylsshop`.`addresses` (`id_address`)
);


CREATE TABLE IF NOT EXISTS `vinylsshop`.`artists` (
    `id_artist` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_artist`)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`albums` (
    `id_album` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `genre` VARCHAR(100),
    `cover` VARCHAR(255),
    `release_date` DATE,
    `id_artist` INT NOT NULL,
    PRIMARY KEY (`id_album`),
    FOREIGN KEY (`id_artist`) REFERENCES `vinylsshop`.`artists` (`id_artist`)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`tracks` (
    `id_track` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `duration` TIME NOT NULL,
    PRIMARY KEY (`id_track`)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`albumstracks` (
    `id_album` INT NOT NULL,
    `id_track` INT NOT NULL,
    PRIMARY KEY (`id_album`, `id_track`),
    FOREIGN KEY (`id_album`) REFERENCES `vinylsshop`.`albums` (`id_album`),
    FOREIGN KEY (`id_track`) REFERENCES `vinylsshop`.`tracks` (`id_track`)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`coupons` (
    `id_coupon` INT NOT NULL AUTO_INCREMENT,
    `discount_code` VARCHAR(50) NOT NULL,
    `percentage` DECIMAL(10, 2) NOT NULL,
    `valid_from` DATE NOT NULL,
    `valid_until` DATE NOT NULL,
    PRIMARY KEY (`id_coupon`),
    UNIQUE INDEX `code_UNIQUE` (`discount_code` ASC)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`orders` (
    `id_order` INT NOT NULL AUTO_INCREMENT,
    `order_date` DATE NOT NULL,
    `total_cost` DECIMAL(10, 2) NOT NULL DEFAULT 0,
    `id_card` INT,
    `order_status` VARCHAR(50) NOT NULL,
    `discount_code` VARCHAR(50),
    `id_user` INT NOT NULL,
    PRIMARY KEY (`id_order`),
    FOREIGN KEY (`id_user`) REFERENCES `vinylsshop`.`users` (`id_user`),
    FOREIGN KEY (`id_card`) REFERENCES `vinylsshop`.`cards` (`id_card`),
    FOREIGN KEY (`discount_code`) REFERENCES `vinylsshop`.`coupons` (`discount_code`)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`shipments` (
    `id_shipment` INT NOT NULL AUTO_INCREMENT,
    `tracking_number` VARCHAR(100) NOT NULL,
    `shipment_date` DATE NOT NULL,
    `delivery_date` DATE,
    `shipment_status` VARCHAR(50) NOT NULL,
    `courier` VARCHAR(50) NOT NULL,
    `notes` TEXT,
    `cost` DECIMAL(10, 2) NOT NULL,
    `id_order` INT NOT NULL,
    `id_address` INT NOT NULL,
    PRIMARY KEY (`id_shipment`),
    FOREIGN KEY (`id_order`) REFERENCES `vinylsshop`.`orders` (`id_order`),
    FOREIGN KEY (`id_address`) REFERENCES `vinylsshop`.`addresses` (`id_address`)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`vinyls` (
    `id_vinyl` INT NOT NULL AUTO_INCREMENT,
    `cost` DECIMAL(10, 2) NOT NULL,
    `rpm` INT NOT NULL,
    `inch` INT NOT NULL,
    `stock` INT NOT NULL,
    `type` ENUM('LP', 'EP') NOT NULL,
    `id_album` INT NOT NULL,
    PRIMARY KEY (`id_vinyl`),
    FOREIGN KEY (`id_album`) REFERENCES `vinylsshop`.`albums` (`id_album`)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`carts` (
    `id_vinyl` INT NOT NULL,
    `id_user` INT NOT NULL,
    `quantity` INT NOT NULL CHECK (`quantity` > 0),
    PRIMARY KEY (`id_vinyl`, `id_user`),
    FOREIGN KEY (`id_vinyl`) REFERENCES `vinylsshop`.`vinyls` (`id_vinyl`),
    FOREIGN KEY (`id_user`) REFERENCES `vinylsshop`.`users` (`id_user`)
);

CREATE TABLE IF NOT EXISTS `vinylsshop`.`checkouts` (
    `id_order` INT NOT NULL,
    `id_vinyl` INT NOT NULL,
    `quantity` INT NOT NULL CHECK (`quantity` > 0),
    PRIMARY KEY (`id_order`, `id_vinyl`),
    FOREIGN KEY (`id_order`) REFERENCES `vinylsshop`.`orders` (`id_order`),
    FOREIGN KEY (`id_vinyl`) REFERENCES `vinylsshop`.`vinyls` (`id_vinyl`)
);

-- Redundancy check for cost: ORDER->costo_totale = SHIPMENT(costo) + costo(VINYL)
CREATE OR REPLACE VIEW `vinylsshop`.`order_total_cost` AS
SELECT o.id_order, (s.cost + SUM(v.cost * c.quantity)) AS total_cost
FROM `vinylsshop`.`orders` o
JOIN `vinylsshop`.`shipments` s ON o.id_order = s.id_order
JOIN `vinylsshop`.`carts` c ON c.id_user = o.id_user
JOIN `vinylsshop`.`vinyls` v ON c.id_vinyl = v.id_vinyl
GROUP BY o.id_order;