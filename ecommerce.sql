/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.2.0 : Database - konco_studio
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`konco_studio` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `konco_studio`;

/*Table structure for table `detail_orders` */

DROP TABLE IF EXISTS `detail_orders`;

CREATE TABLE `detail_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `order_id` int NOT NULL,
  `total` int NOT NULL,
  `total_price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `detail_orders` */

insert  into `detail_orders`(`id`,`product_id`,`order_id`,`total`,`total_price`,`created_at`,`updated_at`) values 
(53,2,43,100,2230,'2024-03-20 19:38:38','2024-03-20 19:38:38');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_reset_tokens_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1),
(5,'2024_03_17_221804_create_products_table',1),
(6,'2024_03_17_222239_create_orders_table',1),
(7,'2024_03_17_222407_create_detail_orders_table',1),
(8,'2014_10_12_100000_create_password_resets_table',2);

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `total_price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `orders` */

insert  into `orders`(`id`,`user_id`,`date`,`status`,`total_price`,`created_at`,`updated_at`) values 
(43,1,'2024-03-20',0,2230,'2024-03-20 19:38:38','2024-03-20 19:38:38');

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `stock` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descriptions` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `products` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`address`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Purwo Fitriyanto Rahmadi','rahmadipurwo@gmail.com',NULL,'$2y$12$dN0O.zMQSnLDxVfWflVZ4OHXSecCh5Elu.TfWvTZOkdJy5lnEKWtS',NULL,NULL,'2024-03-18 06:18:58','2024-03-18 06:18:58'),
(2,'Billie Lesch','fleta20@example.com','2024-03-18 19:08:20','$2y$12$33puf5OlHYzR4Jht0ij7U.kHImuQM6i6vKRWffTf3eeSx/vkGm1QG',NULL,'j4RiwrobNt','2024-03-18 19:08:20','2024-03-18 19:08:20'),
(3,'Alvis Ferry','mcclure.florida@example.net','2024-03-18 19:09:52','$2y$12$uBN0lsY4/M1U8tsYhixsNOZ1pRtinZSJSdSRFAf9JgwDWJQjo9LAq',NULL,'xiS1PMzj1G','2024-03-18 19:09:53','2024-03-18 19:09:53'),
(4,'Cheyanne Ward','nolan.queen@example.net','2024-03-18 19:11:08','$2y$12$OIBXhCroyEBHy1KaQt6ERe8dVyfOWjmOyTzDOPyYeSn3xYzT7dJbW',NULL,'0v0eJ5x7xU','2024-03-18 19:11:09','2024-03-18 19:11:09'),
(5,'Dr. Sherman Brakus','schuster.lessie@example.net','2024-03-18 19:11:30','$2y$12$14Vnm4HWVz78hr2VpmlrOOc.hTSfNsQXTdXfcNfF/GfWEokJATYz6',NULL,'WtBo74n7Yx','2024-03-18 19:11:30','2024-03-18 19:11:30'),
(6,'Reagan Runolfsdottir MD','jaylen38@example.com','2024-03-18 19:12:16','$2y$12$1mp1GC3p8XpO.oJjyIVNF.7PSKcbT7SzQaI9PdG8bwUtuV.4EzVmq',NULL,'2IEGDApBxi','2024-03-18 19:12:16','2024-03-18 19:12:16'),
(7,'Nelson Tillman','bartoletti.hobart@example.org','2024-03-18 19:14:25','$2y$12$gwnS9.ZToQq3xUVFEO76bOQUrMSc7Nw1IPJ4iSLX19Oz0YpdLz89y',NULL,'7gaTbnHWcC','2024-03-18 19:14:26','2024-03-18 19:14:26'),
(8,'Jazmyne Walker III','reinger.julie@example.org','2024-03-18 19:16:28','$2y$12$0ftZRzszEy58MRuqj6qh1OHeBa/3qiT7wIkOZDHrZ1njJyfbQ6w0C',NULL,'X3Ac0Fljpe','2024-03-18 19:16:28','2024-03-18 19:16:28'),
(9,'Jefferey Bartell','kristian.renner@example.net','2024-03-18 19:18:18','$2y$12$IGVCGMiwz/KuXPAh01x05OsArJADwNB3Pl1qnggZ0/5hz5evQofL6',NULL,'v8YdH1Yl4K','2024-03-18 19:18:18','2024-03-18 19:18:18'),
(10,'Elvera Fritsch','gina.hills@example.net','2024-03-18 19:18:40','$2y$12$4PSgmmUkTqHZKCYZ8FwAWugpw8wbZ.f.ZWWB4WRhXaiTGcU7gyiSi',NULL,'lb2fghHZE5','2024-03-18 19:18:40','2024-03-18 19:18:40'),
(11,'Chyna Moen','ray56@example.com','2024-03-18 19:19:02','$2y$12$kRGslPwv.UFDb2HasuKxKOCGfAfPl.JjLOwTMBaj4QnFdBrZNUO4m',NULL,'qzX44GRvPX','2024-03-18 19:19:03','2024-03-18 19:19:03'),
(12,'Mr. Will Hegmann','abbigail24@example.org','2024-03-18 19:19:59','$2y$12$EkEY1RDSDM7fIl8lCi.mderEoO36TYA6ZDtovEYGDILozxJBiZ5ba',NULL,'89shj4ooeU','2024-03-18 19:20:00','2024-03-18 19:20:00'),
(13,'Dr. Milton Vandervort II','francis08@example.net','2024-03-18 19:22:18','$2y$12$7Vqb7wClFWr8jrXcs7C0ouLCI0GEvO7Q48x1Lo7W9iQMiN1XSmWKi',NULL,'uJwe81aqyR','2024-03-18 19:22:19','2024-03-18 19:22:19'),
(14,'Lysanne Reynolds Jr.','cristal.schimmel@example.org','2024-03-18 19:24:38','$2y$12$TheFD4Uq5NwigeFxCPa2zeYszb3tivCLn1sw0Q3zEtZLdOFDrPokW',NULL,'Voh0wqQ6TW','2024-03-18 19:24:38','2024-03-18 19:24:38'),
(15,'Jena Wiegand MD','alvera.prohaska@example.net','2024-03-18 19:24:47','$2y$12$3Wy900WgMY9wS7x6EDsGcerdaEDqTn1NMR8FIZmiEbXThQAZtSsPW',NULL,'c3WtTIfMll','2024-03-18 19:24:47','2024-03-18 19:24:47');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
