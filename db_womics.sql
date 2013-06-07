/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50508
Source Host           : localhost:3306
Source Database       : db_womics

Target Server Type    : MYSQL
Target Server Version : 50508
File Encoding         : 65001

Date: 2013-06-07 03:33:11
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(100) NOT NULL,
  `prenume` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `parola` varchar(100) NOT NULL,
  `id_punct_de_lucru` int(11) NOT NULL,
  `id_sesiune` varchar(100) NOT NULL,
  `tip_admin` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO admin VALUES ('4', 'Mihaila', 'Adrian', 'adi@timelife.ro', 'NTVhNzRlMTY3NGQ1ZDUwYmRjNTY1NjJlZTgwZjBlNzk=', '0', 'pd0btl3hvc63sphtvoggfis8f1', '1');
INSERT INTO admin VALUES ('8', 'Saveluc', 'Diana', 'didut@timelife.ro', 'YmFiZmU0Y2I4NjdiZDJjZDNlYjljNWQ4YjcwZGViMTk=', '2', '', '2');
INSERT INTO admin VALUES ('9', 'asdasda', 'dasdasd', 'asdasd@asda.ro', 'OWZiZjJhZTc3ZDFlMjYyOGFkMjhhNmNjODk5NmZjODc=', '1', '', '2');
INSERT INTO admin VALUES ('10', 'asdasdasd', 'asdasdasd', 'adi@timelife.ro', 'OWZiZjJhZTc3ZDFlMjYyOGFkMjhhNmNjODk5NmZjODc=', '1', 'pd0btl3hvc63sphtvoggfis8f1', '2');
INSERT INTO admin VALUES ('11', 'asdasfd', 'dfgdfgdf', 'sss@ff.com', 'OWZiZjJhZTc3ZDFlMjYyOGFkMjhhNmNjODk5NmZjODc=', '1', '', '2');
INSERT INTO admin VALUES ('12', '123asdasd', 'asd32e23', 'adas@ff.com', 'OWZiZjJhZTc3ZDFlMjYyOGFkMjhhNmNjODk5NmZjODc=', '1', '', '2');
INSERT INTO admin VALUES ('13', 'cristi', 'gigi', 'aa@gg', 'OWZiZjJhZTc3ZDFlMjYyOGFkMjhhNmNjODk5NmZjODc=', '1', '', '2');

-- ----------------------------
-- Table structure for `contracte`
-- ----------------------------
DROP TABLE IF EXISTS `contracte`;
CREATE TABLE `contracte` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_utilizator` int(10) NOT NULL,
  `nr_bucati` int(10) NOT NULL,
  `pret_inchiriere` text NOT NULL,
  `data_incheiere` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contracte
-- ----------------------------
INSERT INTO contracte VALUES ('13', '1', '10', '1.34', '2013-06-05 03:16:11');
INSERT INTO contracte VALUES ('14', '1', '2', '4.02', '2013-06-05 03:38:50');
INSERT INTO contracte VALUES ('15', '4', '1', '1.34', '2013-06-06 20:32:07');
INSERT INTO contracte VALUES ('16', '4', '1', '1.34', '2013-06-06 21:00:00');

-- ----------------------------
-- Table structure for `import_trotinete`
-- ----------------------------
DROP TABLE IF EXISTS `import_trotinete`;
CREATE TABLE `import_trotinete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume_fisier` varchar(100) NOT NULL,
  `data_import` datetime NOT NULL,
  `id_utilizator` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of import_trotinete
-- ----------------------------
INSERT INTO import_trotinete VALUES ('1', 'Book1.csv', '2013-05-22 15:35:41', '4');

-- ----------------------------
-- Table structure for `inchirieri`
-- ----------------------------
DROP TABLE IF EXISTS `inchirieri`;
CREATE TABLE `inchirieri` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_utilizator` int(10) NOT NULL,
  `id_trotineta` int(10) NOT NULL,
  `id_contract` int(10) NOT NULL,
  `locatie_start` varchar(100) NOT NULL,
  `locatie_finala` varchar(100) NOT NULL,
  `data_inchiriere` varchar(100) NOT NULL,
  `data_restituire` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of inchirieri
-- ----------------------------
INSERT INTO inchirieri VALUES ('16', '4', '1', '15', 'canta, iasi, ro', 'canta, iasi, ro', '06/06/2013 20:31PM', '06/06/2013 20:31PM');
INSERT INTO inchirieri VALUES ('17', '4', '1', '16', 'canta, iasi, ro', 'canta, iasi, ro', '06/07/2013 08:59PM', '07/12/2013 08:59PM');

-- ----------------------------
-- Table structure for `puncte_de_lucru`
-- ----------------------------
DROP TABLE IF EXISTS `puncte_de_lucru`;
CREATE TABLE `puncte_de_lucru` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(100) NOT NULL,
  `judet` varchar(100) NOT NULL,
  `oras` varchar(100) NOT NULL,
  `adresa` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of puncte_de_lucru
-- ----------------------------
INSERT INTO puncte_de_lucru VALUES ('2', 'Pacurari', 'Iasi', 'Iasi', 'canta, iasi, ro');
INSERT INTO puncte_de_lucru VALUES ('3', 'Tatarasi', 'Iasi', 'Iasi', 'pacurari, iasi, ro');
INSERT INTO puncte_de_lucru VALUES ('4', 'Copou ', 'Iasi', 'Iasi', 'copou, iasi, ro');
INSERT INTO puncte_de_lucru VALUES ('5', 'Iasi', 'Iasi', 'Iasi', 'Iasi, Bularga, str, Ion Creanga');

-- ----------------------------
-- Table structure for `tip_adaugare_trotinete`
-- ----------------------------
DROP TABLE IF EXISTS `tip_adaugare_trotinete`;
CREATE TABLE `tip_adaugare_trotinete` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `nume` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tip_adaugare_trotinete
-- ----------------------------
INSERT INTO tip_adaugare_trotinete VALUES ('1', 'import');
INSERT INTO tip_adaugare_trotinete VALUES ('2', 'single add');

-- ----------------------------
-- Table structure for `tip_utilizator`
-- ----------------------------
DROP TABLE IF EXISTS `tip_utilizator`;
CREATE TABLE `tip_utilizator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tip_utilizator
-- ----------------------------
INSERT INTO tip_utilizator VALUES ('1', 'Super Admin');
INSERT INTO tip_utilizator VALUES ('2', 'Admin');
INSERT INTO tip_utilizator VALUES ('3', 'User');

-- ----------------------------
-- Table structure for `trotinete`
-- ----------------------------
DROP TABLE IF EXISTS `trotinete`;
CREATE TABLE `trotinete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denumire` varchar(100) NOT NULL,
  `descriere` longtext,
  `caracteristici` text NOT NULL,
  `imagine` varchar(100) NOT NULL,
  `pret_inchiriere` text NOT NULL,
  `tip_adaugare` int(2) NOT NULL,
  `data_adaugare` datetime NOT NULL,
  `id_punct_de_lucru` int(3) NOT NULL,
  `nr_bucati` int(10) NOT NULL,
  `nr_bucati_inchiriate` int(10) NOT NULL DEFAULT '0',
  `discounts` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of trotinete
-- ----------------------------
INSERT INTO trotinete VALUES ('1', 'Trotineta Logan', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. ', 'handles=rubber;horn=no;', 'img/trotinete/trotineta-cu-surprize.png', '1.34', '2', '2013-05-22 01:19:28', '2', '10', '10', '0');
INSERT INTO trotinete VALUES ('3', 'Trotineta Kinder', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. ', 'handles=plastic;wheels=iron;', 'img/trotinete/trotineta-cu-surprize.png', '2.45', '2', '2013-05-22 11:08:46', '2', '4', '0', '0');
INSERT INTO trotinete VALUES ('12', 'a', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. ', 'wheels=aluminum;', 'img/trotinete/trotineta-cu-surprize.png', '4.02', '1', '2013-05-22 15:35:41', '2', '3', '2', '0');
INSERT INTO trotinete VALUES ('13', 'b', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. ', 'horn=yes;wheels=iron;', 'img/trotinete/trotineta-cu-surprize.png', '2.00', '1', '2013-05-22 15:35:41', '2', '1', '0', '0');
INSERT INTO trotinete VALUES ('14', 'c', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. ', 'c', 'img/trotinete/trotineta-cu-surprize.png', '1.25', '1', '2013-05-22 15:35:41', '2', '10', '0', '10');
INSERT INTO trotinete VALUES ('15', 'd', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. ', 'd', 'img/trotinete/trotineta-cu-surprize.png', '7.31', '1', '2013-05-22 15:35:41', '2', '100', '0', '20');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nume` varchar(100) DEFAULT NULL,
  `prenume` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cnp` varchar(13) DEFAULT NULL,
  `judet` varchar(100) DEFAULT NULL,
  `oras` varchar(100) DEFAULT NULL,
  `serie` varchar(100) DEFAULT NULL,
  `numar` varchar(100) DEFAULT NULL,
  `parola` varchar(255) DEFAULT NULL,
  `tip_utilizator` decimal(2,0) DEFAULT NULL,
  `data_inregistrare` datetime DEFAULT NULL,
  `id_sesiune` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO user VALUES ('1', 'Mihaila', 'Adrian', 'adi@timelife.ro', '123456789', 'Neamt', 'Piatra Neamt', 'NT', '488238', 'NTVhNzRlMTY3NGQ1ZDUwYmRjNTY1NjJlZTgwZjBlNzk=', '1', '2013-05-20 22:50:33', 'dg4ivj7thfj9cjbn14bp8o4d54');
INSERT INTO user VALUES ('3', 'Vlad', 'Coroeanu', 'mihaila_adryan@yahoo.com', '1910901270062', 'Bucuresti', 'Chitila', 'NT', '488238', 'MGI4NGNhZTI0YjdhMjlhMGIzNzFhYWVkMjIwY2ZlNDk=', '3', '2013-06-01 19:36:58', '8jf0g77bg9gkd07b80pg6tgpg6');
INSERT INTO user VALUES ('4', 'Cristi', 'Chiric', '', '1910901270062', 'Galati', 'Galati', 'GL', '123456', 'MGQ0MWJlNWM0ZWY3MjRmNjI5ZDBjNWVmMjRmMzU4MWY=', '3', '2013-06-01 19:40:09', '4egtv46j83cj78630kim5akj36');
