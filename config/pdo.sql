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
                           `last_update` TIMESTAMP(6)  NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;