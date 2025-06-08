/*
SQLyog Enterprise
MySQL - 8.0.30 : Database - manajemendonasi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`manajemendonasi` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `manajemendonasi`;

/*Table structure for table `distribusi` */

DROP TABLE IF EXISTS `distribusi`;

CREATE TABLE `distribusi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_penerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `distribusi` */

insert  into `distribusi`(`id`,`nama_penerima`) values 
(1,'yayasan a'),
(2,'yayasan b'),
(3,'yayasan c'),
(5,'yayasan d');

/*Table structure for table `donatur` */

DROP TABLE IF EXISTS `donatur`;

CREATE TABLE `donatur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_donasi` decimal(10,2) DEFAULT NULL,
  `id_pekerjaan` int DEFAULT NULL,
  `id_distribusi` int DEFAULT NULL,
  `tanggal_donasi` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pekerjaan` (`id_pekerjaan`),
  KEY `id_distribusi` (`id_distribusi`),
  CONSTRAINT `donatur_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id`),
  CONSTRAINT `donatur_ibfk_2` FOREIGN KEY (`id_distribusi`) REFERENCES `distribusi` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `donatur` */

insert  into `donatur`(`id`,`nama`,`jumlah_donasi`,`id_pekerjaan`,`id_distribusi`,`tanggal_donasi`) values 
(1,'Frankie Steinlie',10000.00,2,1,'2025-06-08'),
(2,'Jus Mangga',200000.00,2,2,'2025-06-06'),
(3,'Jayabaya',100000.00,3,5,'2025-06-08');

/*Table structure for table `pekerjaan` */

DROP TABLE IF EXISTS `pekerjaan`;

CREATE TABLE `pekerjaan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pekerjaan` */

insert  into `pekerjaan`(`id`,`nama_pekerjaan`) values 
(1,'Wiraswasta'),
(2,'wirausaha'),
(3,'coba lagi');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`password`,`nama`) values 
(1,'admin','admin','Frankie Steinlie');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
