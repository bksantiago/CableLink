# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.1.44)
# Database: call_center_db
# Generation Time: 2013-06-05 07:15:46 +0800
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table announcement_tb
# ------------------------------------------------------------

DROP TABLE IF EXISTS `announcement_tb`;

CREATE TABLE `announcement_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(255) DEFAULT NULL,
  `information` longtext,
  `created_date` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `creau` (`created_by`),
  CONSTRAINT `creau` FOREIGN KEY (`created_by`) REFERENCES `users_tb` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `announcement_tb` WRITE;
/*!40000 ALTER TABLE `announcement_tb` DISABLE KEYS */;

INSERT INTO `announcement_tb` (`id`, `header`, `information`, `created_date`, `created_by`)
VALUES
	(1,'Testing! ^_^','jaketrent (Jake Trent) · GitHub\nhttps://github.com/jaketrent?\njquery-readmore 15 jQuery plugin to show partial text and a toggle for more · xquery-suez 3 A bit of MarkLogic xquery code to extract channel info and display ...\nJquery Plugin: readmore - RockyCode\n\nrockycode.com/.../jquery-plugin-readmo...?\nIsalin ang pahinang ito\nni Jake Trent - sa 172 (na) lupon ng Google+\nHun 28, 2010 – Jquery plugins are a joy to use, and they are surprisingly easy to write. ... To combat this, there is the UI pattern on the site that there is a \"read more\" link available to show the remaining text for the ... About Jake Trent ...\njaketrent / jquery-plugins — Bitbucket\nhttps://bitbucket.org/jaketrent/jquery-plugins?\nOkt 28, 2009 – Allow breaking marker to be inserted manually. Jake Trent reported issue #3 to jaketrent/jquery-plugins. 2011-02-02. Readmore - allow hiding ...\njaketrent / jquery-plugins / issues / #2 - Readmore - handle markup ...\nhttps://bitbucket.org/jaketrent/jquery.../readmore-handle-markup-gracefu...?\nPeb 2, 2011 – Sign up · Log in · jaketrent/jquery-plugins ... Readmore - handle markup gracefully. Jake Trent avatar Jake Trent created an issue 2011-02-02 ...','2013-05-09 15:35:45',1);

/*!40000 ALTER TABLE `announcement_tb` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table city_tb
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city_tb`;

CREATE TABLE `city_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `city_tb` WRITE;
/*!40000 ALTER TABLE `city_tb` DISABLE KEYS */;

INSERT INTO `city_tb` (`id`, `city`)
VALUES
	(1,'Pasig City'),
	(2,'Pasay City'),
	(3,'Taguig'),
	(4,'Mandaluyong City'),
	(5,'Paranaque City'),
	(6,'Makati City'),
	(7,'Manila'),
	(8,'Quezon City'),
	(9,'Caloocan City'),
	(10,'Valenzuela City'),
	(11,'Novaliches'),
	(12,'Muntinlupa City'),
	(13,'Las Pinas City'),
	(14,'Taytay Province');

/*!40000 ALTER TABLE `city_tb` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customer_tb
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_tb`;

CREATE TABLE `customer_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `franchise` int(11) DEFAULT NULL,
  `billing_cycle` int(11) DEFAULT NULL,
  `application_date` timestamp NULL DEFAULT NULL,
  `application_type` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_no1` varchar(255) DEFAULT NULL,
  `contact_no2` varchar(255) DEFAULT NULL,
  `contact_no3` varchar(255) DEFAULT NULL,
  `landmarks` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cityfk` (`franchise`),
  KEY `user` (`created_by`),
  CONSTRAINT `cityfk` FOREIGN KEY (`franchise`) REFERENCES `city_tb` (`id`),
  CONSTRAINT `user` FOREIGN KEY (`created_by`) REFERENCES `users_tb` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `customer_tb` WRITE;
/*!40000 ALTER TABLE `customer_tb` DISABLE KEYS */;

INSERT INTO `customer_tb` (`id`, `franchise`, `billing_cycle`, `application_date`, `application_type`, `prefix`, `first_name`, `middle_name`, `last_name`, `address`, `account_type`, `birthdate`, `email`, `contact_no1`, `contact_no2`, `contact_no3`, `landmarks`, `created_by`)
VALUES
	(1,2,1,'2013-05-02 04:58:35','1','Mr.','Bernard','Mercado','Santiago','3A Villa Rosa Sto. tomas pasig city',1,'1993-04-03','biksantiago@gmail.com','09068261956','','','Malapit sa Court',1),
	(2,4,2,'2013-05-05 04:56:36','2','Ms.','Blair Venice','Santiago','Ocinar','Katipunan Pasig City 1600',0,'2012-02-25','jencamillesantiago@gmail.com','','','0905123456','malapit sa sumilang XD',1),
	(3,7,1,'2013-05-29 23:44:50','2','Mr.','Someone','hehe','Nice','Tondo Manila',1,'1991-01-10','tondomanila@hotmail.com','','','','Don Bosco malapit',1);

/*!40000 ALTER TABLE `customer_tb` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table position_tb
# ------------------------------------------------------------

DROP TABLE IF EXISTS `position_tb`;

CREATE TABLE `position_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `position_tb` WRITE;
/*!40000 ALTER TABLE `position_tb` DISABLE KEYS */;

INSERT INTO `position_tb` (`id`, `code`, `position`)
VALUES
	(1,'Admin','Administrator'),
	(2,'CSR Tier 1','Customer Service Representative (Tier 1)'),
	(3,'CSR Tier 2','Customer Service Representative (Tier 2)'),
	(4,'NOC','Network Operation Center'),
	(5,'C','Contractor');

/*!40000 ALTER TABLE `position_tb` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table ticket_assigned_tb
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ticket_assigned_tb`;

CREATE TABLE `ticket_assigned_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) DEFAULT NULL,
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `remarks` longtext,
  PRIMARY KEY (`id`),
  KEY `ticketrel` (`ticket_id`),
  CONSTRAINT `ticketrel` FOREIGN KEY (`ticket_id`) REFERENCES `tickets_tb` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `ticket_assigned_tb` WRITE;
/*!40000 ALTER TABLE `ticket_assigned_tb` DISABLE KEYS */;

INSERT INTO `ticket_assigned_tb` (`id`, `ticket_id`, `date_start`, `date_end`, `assigned_to`, `remarks`)
VALUES
	(1,1,'2013-05-08 10:35:47','2013-05-09 16:08:06',2,'First Notes ^_^ hehehe'),
	(2,34,'2013-05-09 15:58:46','2013-05-10 01:03:39',2,'hmmm'),
	(4,34,'2013-05-10 01:03:39',NULL,4,''),
	(6,36,'2013-05-10 01:24:27',NULL,2,'Nothing unusual! hehehe. XDXD');

/*!40000 ALTER TABLE `ticket_assigned_tb` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tickets_tb
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tickets_tb`;

CREATE TABLE `tickets_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_no` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accnofk` (`account_no`),
  KEY `assginedfk` (`assigned_to`),
  CONSTRAINT `accnofk` FOREIGN KEY (`account_no`) REFERENCES `customer_tb` (`id`),
  CONSTRAINT `assginedfk` FOREIGN KEY (`assigned_to`) REFERENCES `users_tb` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tickets_tb` WRITE;
/*!40000 ALTER TABLE `tickets_tb` DISABLE KEYS */;

INSERT INTO `tickets_tb` (`id`, `account_no`, `assigned_to`, `date_start`, `date_end`)
VALUES
	(1,1,2,'2013-05-08 10:35:47','2013-05-09 16:08:06'),
	(34,2,4,'2013-05-09 15:58:46',NULL),
	(36,1,2,'2013-05-10 01:24:27',NULL);

/*!40000 ALTER TABLE `tickets_tb` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users_tb
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_tb`;

CREATE TABLE `users_tb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` longtext NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `positionFK` (`position`),
  CONSTRAINT `positionFK` FOREIGN KEY (`position`) REFERENCES `position_tb` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users_tb` WRITE;
/*!40000 ALTER TABLE `users_tb` DISABLE KEYS */;

INSERT INTO `users_tb` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `email`, `contact_no`, `position`)
VALUES
	(1,'admin','21232f297a57a5a743894a0e4a801fc3','Bernard','Mercado','Santiago','biksantiago@gmail.com','12345',1),
	(2,'csr1','912ec803b2ce49e4a541068d495ab570','DJ','emeses','Nacpil','dj@migo.ph','09111111111',2),
	(3,'bk','912ec803b2ce49e4a541068d495ab570','bk','Mercado','Santiago','biksantiago@gmail.com','09068261956',5),
	(4,'csr2','912ec803b2ce49e4a541068d495ab570','Antonette','hmm','Fernandez','ahf@gmail.com','09012349384',3);

/*!40000 ALTER TABLE `users_tb` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
