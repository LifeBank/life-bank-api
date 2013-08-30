/*
SQLyog Ultimate v9.02 
MySQL - 5.5.32 : Database - life-bank
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`life-bank` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `life-bank`;

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groups_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `groups` */

LOCK TABLES `groups` WRITE;

insert  into `groups`(`id`,`name`,`permissions`,`created_at`,`updated_at`) values (1,'hospital_admin',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'hospital_user',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'site_admin',NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00');

UNLOCK TABLES;

/*Table structure for table `location` */

DROP TABLE IF EXISTS `location`;

CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `state_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=latin1;

/*Data for the table `location` */

LOCK TABLES `location` WRITE;

insert  into `location`(`id`,`location`,`short_name`,`parent_id`,`state_id`,`created_by`) values (7,'Ikoyi','ikoyi',0,1,1),(8,'Ikoyi Dolphin','ikoyidolphin',0,1,1),(9,'Lekki Phase 1','lekki',0,1,1),(10,'Victoria Island','vi',0,1,1),(11,'Ikeja','ikeja',0,1,1),(12,'Magodo Phase 2','magodo',0,1,1),(13,'Yaba/Akoka','yaba',0,1,1),(14,'Ebute Metta','ebutemeta',0,1,1),(15,'Surulere','surulere',0,1,1),(16,'Anthony','anthony',0,1,1),(17,'Ikeja GRA','ikejagra',0,1,1),(18,'Ikeja Alausa','ikejaalausa',0,1,1),(19,'Ikeja Allen','ikejaallen',0,1,1),(20,'Ikeja Aromire','ikejaaromire',0,1,1),(21,'Ikeja Awolowo Road','ikejaawolowo',0,1,1),(22,'Ikeja Maruwa Gardens','ikejamaruwa',0,1,1),(23,'Ikeja Kudirat Abiola','ikejakudirat',0,1,1),(24,'Ikeja Opebi','ikejaopebi',0,1,1),(25,'Ikeja Toyin Street','ikejatoyin',0,1,1),(26,'Oniru','oniru',0,1,1),(27,'Isolo Ajao','isoloajao',0,1,1),(28,'Apapa','apapa',0,1,1),(29,'Maryland','maryland',0,1,1),(30,'Bariga','bariga',0,1,1),(31,'Lekki(6th Roundabout/Chevron Drive area)','chevron',0,1,1),(32,'Marina','marina',0,1,1),(33,'Ojodu Berger','ojoduberger',0,1,1),(34,'Omole Phase 1','omole1',0,1,1),(35,'Omole Phase 2','omole2',0,1,1),(36,'Magodo Phase 1 / Isheri','magodo1',0,1,1),(37,'Onikan','onikan',0,1,1),(38,'Ajah','ajah',0,1,1),(43,'Awolowo Road','awoloworoad',7,1,69),(44,'Falomo Round About','falomoroundabout',7,1,69),(45,'Obalende','obalende',7,1,69),(46,'Keffi Street','keffistreet',7,1,69),(47,'Club Road','clubroad',7,1,69),(48,'Osborne','osborne',7,1,69),(49,'Around Adeyemi Lawson','aroundadeyemilawson',7,1,69),(50,'Around Raymond Njoku','aroundraymondnjoku',7,1,69),(51,'Around Gerald Road','aroundgeraldroad',7,1,69),(52,'Banana Island','bananaisland',7,1,69),(53,'Around Oyinkan Abayomi','aroundoyinkanabayomi',7,1,69),(54,'Mcpherson','mcpherson',7,1,69),(55,'Around Lugard or Cameroon Road','aroundlugardorcameroonroad',7,1,69),(56,'Walter Carington','waltercarington',7,1,69),(57,'Festac','festac',0,1,69),(58,'Ojo','ojo',0,1,69),(59,'Satalite Town','satalitetown',0,1,69),(60,'Navy Town','navytown',0,1,69),(61,'Maza-Maza','mazamaza',0,1,69),(62,'Mile 2 Estate','mile2estate',0,1,69),(63,'Mile 2','mile2',0,1,69),(64,'Orile','orile',0,1,69),(65,'Lasu','lasu',0,1,69),(66,'Around Salvation Road','aroundsalvationroad',11,1,85),(67,'Seven-up','sevenup',11,1,85),(68,'Medical road','medicalroad',11,1,85),(69,'Anifowose','Anifowos',11,1,85),(70,'Computer Village Area','computervillagearea',11,1,85),(71,'Mobolaji Bank Anthony','mobolajibankanthony',11,1,85),(72,'Toll gate area','tollgatearea',0,1,85),(73,'Onipanu','onipanu',0,1,85),(74,'Ilupeju','ilupeju',0,1,85),(75,'Adeniyi Jones','adeniyijones',11,1,610),(76,'VGC/Ikota','vgc',0,1,601),(77,'Lekki(4th and 5th roundabout)','4thand5throundabout',0,1,601),(78,'within Uba House, Tinubu & Net House','aroundtinubu',32,1,69),(79,'Oke Arin','okearin',32,1,69),(80,'Idumota','idumota',0,1,69),(81,'Gbagada Phase 1','gbagadaphase1',0,1,69),(82,'Gbagada Phase 2','gbagadaphase2',0,1,69),(83,'Palmgrove','palmgrove',0,1,69),(84,'Mushin','mushin',0,1,69),(85,'Ikorodu','ikorodu',0,1,69),(86,'Gowon Estate','gowonestate',0,1,69),(87,'Akowonjo','akowonjo',0,1,69),(88,'Gemade Estate','gemadeestate',0,1,69),(89,'Abesan Estate','abesanestate',0,1,69),(90,'Idimu','idimu',0,1,69),(91,'Ogba','ogba',0,1,810),(92,'Ketu','ketu',0,1,69),(93,'Lagos Island','lagosisland',0,1,69),(94,'Costain','Costain',14,1,69),(95,'Yaba Bustop and Environs','yababustopandenvirons',13,1,69),(96,'Akoka Unilag Area','akokaunilagarea',13,1,69),(97,'Aguda','Aguda',15,1,69),(98,'Jibowu','Jibowu',0,1,69),(99,'Jibowu Area','Jibowu Area',13,1,69),(100,'Agege','agege',0,1,69),(101,'Ajegunle','ajegunle',0,1,69),(102,'Around Mobil Road','aroundmobilhouse',28,1,69),(103,'Around Waterside','aroundwaterside',28,1,69),(104,'5 Mile Radius Around TFC Outlet','ikorodutfcoutlet',85,1,69),(105,'Around Lagos Road','aroundlagosroad',85,1,69),(106,'Around Beach Road','aroundbeachroad',85,1,69),(107,'Around Sabo Road','aroundsaboroad',85,1,69),(108,'Around Sagamu Road','aroundsagamuroad',85,1,69),(109,'Around Eta- Elewa','aroundetaelewa',85,1,69),(110,'Around Low Cost Housing Estate','aroundlowcosthousingestate',85,1,69),(111,'Around Sheri/Police Barracks','aroundsheripolicebarrack',85,1,69),(112,'Around Agric/Secretariat/General Hospital','Aroundagricsecretariatgeneralhospital',85,1,69),(113,'Very Close to Ikeja City Mall','veryclosetoikejacitymall',21,1,69),(114,'UNILAG','unilag',0,1,69),(115,'Amuwo Odofin','amuwoodofin',0,1,1073);

UNLOCK TABLES;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

LOCK TABLES `migrations` WRITE;

UNLOCK TABLES;

/*Table structure for table `throttle` */

DROP TABLE IF EXISTS `throttle`;

CREATE TABLE `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attempts` int(11) NOT NULL DEFAULT '0',
  `suspended` tinyint(4) NOT NULL DEFAULT '0',
  `banned` tinyint(4) NOT NULL DEFAULT '0',
  `last_attempt_at` timestamp NULL DEFAULT NULL,
  `suspended_at` timestamp NULL DEFAULT NULL,
  `banned_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `throttle` */

LOCK TABLES `throttle` WRITE;

UNLOCK TABLES;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(14) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `blood_group` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_activation_code_index` (`activation_code`),
  KEY `users_reset_password_code_index` (`reset_password_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

LOCK TABLES `users` WRITE;

insert  into `users`(`id`,`email`,`password`,`phone_number`,`location`,`blood_group`,`image_path`,`permissions`,`activated`,`status`,`activation_code`,`activated_at`,`last_login`,`persist_code`,`reset_password_code`,`first_name`,`last_name`,`created_at`,`updated_at`) values (1,'testing@test.com','$2y$10$EhBcHswzgDNQfc4c/A9dJeS5Yf/BP.NWAbkKwaJ/lt69J10up926i','','','','http://a0.twimg.com/profile_images/1639928704/Photo_00001_normal.jpg','{\"test\":1,\"other\":-1,\"admin\":1}',0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2013-08-27 16:41:00','2013-08-27 16:41:00'),(2,'adedayokunle@gmail.com','$2y$10$dICBEUP6GP7NacQ1LUkGH.AwBNseyYKM2Gqoad5V13g8w3S9v2hCa','08027031907','ikejaopebi','B-','http://a0.twimg.com/profile_images/1639928704/Photo_00001_normal.jpg','{\"test\":1,\"other\":-1,\"admin\":1}',0,1,NULL,NULL,NULL,NULL,NULL,'Adekunle','Adedayo','2013-08-29 20:24:32','2013-08-30 20:20:59'),(3,'kayfun2004@yahoo.com','$2y$10$2aJJ0zMtss29j/.rl/YJou9nBmOTJa6ZckdiHtz6B/R8CKoTjTj/.','08033257777','ikoyi','A-','http://a0.twimg.com/profile_images/1639928704/Photo_00001_normal.jpg','{\"test\":1,\"other\":-1,\"admin\":1}',0,1,NULL,NULL,NULL,NULL,NULL,'Kunle','Adedayo','2013-08-29 20:41:40','2013-08-29 20:41:40'),(4,'gbemisola@yahoo.com','$2y$10$sbccL/zHEmfkr5sPpQ7evOOGeugPDBptf3BOoiPEZk3SkoiCPQWzG','0803322222','ikoyi','A-','http://a0.twimg.com/profile_images/1639928704/Photo_00001_normal.jpg','{\"test\":1,\"other\":-1,\"admin\":1}',0,1,NULL,NULL,NULL,NULL,NULL,'Gbemi','Kuleyi','2013-08-29 20:58:13','2013-08-29 20:58:13');

UNLOCK TABLES;

/*Table structure for table `users_groups` */

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users_groups` */

LOCK TABLES `users_groups` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
