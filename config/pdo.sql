SET NAMES utf8;
SET SQL_MODE='';

CREATE DATABASE IF NOT EXISTS `api` DEFAULT CHARACTER SET  utf8;

USE `api`;

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `name` varchar(255) NOT NULL,
                           `size` int NOT NULL DEFAULT 0,
                           `is_available` BOOLEAN NOT NULL DEFAULT FALSE,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;