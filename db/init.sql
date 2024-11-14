CREATE DATABASE IF NOT EXISTS `VinylsShop` /*!40100 DEFAULT CHARACTER SET utf8 */;

CREATE USER 'admin'@'%' IDENTIFIED WITH mysql_native_password BY '***';GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'admin'@'%';ALTER USER 'admin'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

CREATE TABLE IF NOT EXISTS `VinylsShop`.`Users` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `mail` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `balance` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `su` TINYINT(1) NOT NULL DEFAULT 0,
  `newsletter` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_user`), UNIQUE INDEX `mail_UNIQUE` (`mail` ASC));

INSERT INTO `VinylsShop`.`Users`(`mail`, `password`, `su`) VALUES ('admin', 'admin', 1)
INSERT INTO `VinylsShop`.`Users`(`mail`, `password`, `su`) VALUES ('alexmaz03@hotmail.it', '', 1)