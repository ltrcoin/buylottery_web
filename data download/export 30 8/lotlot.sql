-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 35.240.140.109    Database: thelottery
-- ------------------------------------------------------
-- Server version	5.5.60-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_customers`
--

DROP TABLE IF EXISTS `tbl_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `wallet_btc` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL,
  `country` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `portraitimage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `passportimage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_email_unique` (`email`),
  UNIQUE KEY `customer_tel_unique` (`tel`),
  UNIQUE KEY `customer_wallet_btc_unique` (`wallet_btc`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customers`
--

LOCK TABLES `tbl_customers` WRITE;
/*!40000 ALTER TABLE `tbl_customers` DISABLE KEYS */;
INSERT INTO `tbl_customers` VALUES (1,'Admin','customer@thelotter.com','0987654321','123456789','2018-07-12',1,241,NULL,1,'dsds','dsdsds','$2y$10$UWRvFt8OHEyH3DolmFCwHefs8q3dOhAkJNi2qJ5Ys5uMjhhvcii0m','Be3i9M9iIcUnzrvJxT4ZFYTDAOCLtcYvhqXLaHE8viVEpUxT1a2DhKbAH7rw','0000-00-00 00:00:00',NULL),(2,'Admin','admin1@thelotter.com','0987654320','123456780','2018-07-12',1,241,'',1,'dsds','dsdsds','$2y$10$UWRvFt8OHEyH3DolmFCwHefs8q3dOhAkJNi2qJ5Ys5uMjhhvcii0m','5JoS0VeGoWWzg5Mqw59niU2zvFC3O1yokAWNGhbMFYOKLiybOXtVn8BZC8fq','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'Nguyen Huy','vnnvh80@gmail.com','0979776427','121212121212','1980-07-13',1,241,'Bac Linh Dam, Ha Noi',1,'upload/profile/vnnvh80@gmail.com2018/08/22/RZTxJOhUBRTxyAUNdS9tBV4pKuQRu4ngOqzzHei8.jpeg','upload/profile/vnnvh80@gmail.com2018/08/22/EWKmQV8Y3xQsdNQLMKeHFdY79CCIaf7ZXHMFEE7g.jpeg','$2y$10$mGfPhmtFyEgDByYMNpxq7ujHdFSF85NnlPlnrsrssH63PFj0TJEQG','2E3KZD4qX9oTkKJSAqa0SQpwibcFVrCjJMpSIUvJBpc8UWn6PeeByWWZR8fn','2018-08-22 03:49:43','2018-08-22 03:49:43'),(6,'Nguyễn Tiến Đạt','nguyendatbn90@gmail.com','0987654222','123456888','1990-10-03',1,241,'Bắc Ninh',1,'upload/profile/nguyendatbn90@gmail.com2018/08/23/KDdESb7s3Yh9RUTvUqQ1E4Po2n6X0gQmZNcPv7sg.jpeg','upload/profile/nguyendatbn90@gmail.com2018/08/23/NugLutpSlQJhNuq2jStlYKxNypQFRPP3MvXAGzpN.jpeg','$2y$10$7nbutAvrcKYoJVFMplg6oulibpNCI.X09QVKRzyW22ePDXkBxMtRO','CN633wizoVC42HgJBkytjsFCpKLw7REhu4O7swFBcd3ODtToiO1WrITL799e','2018-08-23 02:41:21','2018-08-23 02:41:21'),(7,'Tester','tester@yopmail.com','098xxxxxxx','9821487182','1991-04-28',1,241,NULL,1,'upload/profile/tester@yopmail.com2018/08/23/F2jiBWk0tpSw11S6UCpCzCL2MNGAZ8XCYcG7QV44.jpeg','upload/profile/tester@yopmail.com2018/08/23/IAhx8XbWx3Id1itK4cszNkkMluEnOHOUX7f2AKes.jpeg','$2y$10$Pn2L2Vustr3mfHPomvGNCelqsExVZJNVcn8NCaHqV7gvkRcMtZWSy',NULL,'2018-08-23 07:03:15','2018-08-23 07:03:15'),(8,'vu van kien','kienktire@gmail.com','0904188666','1MJ3n5q5sCnpyofLvZrUV5DUHhw1UMrEay','1972-07-02',1,241,'16 TT06A Tay Nam Linh Dam',1,'upload/profile/kienktire@gmail.com2018/08/23/9OuRVamMBpuYlFsdkpjF2ZgQKXaAmaQ9rm8mhh6Z.html','upload/profile/kienktire@gmail.com2018/08/23/Ou3Vn3WNY2XV6jEHzgCuL10wm9f2aYTmwcgjtL5F.jpeg','$2y$10$kmGyPWTgOrYyf5DPG3luE.08Emdlnld6AFi08vHriq9eDJJ6cLV2e',NULL,'2018-08-23 12:11:48','2018-08-23 12:11:48'),(9,'Nguyễn Viết Huy','huybaichay@yahoo.com','0964108688','2121212','1980-07-13',1,241,'Bac Linh Dam',1,'upload/profile/huybaichay@yahoo.com2018/08/24/F7oI7zFoXE1qj1aPFU7Dv5Tc99bHHFfX1l5s6pRg.jpeg','upload/profile/huybaichay@yahoo.com2018/08/24/5A4V5NbBv8HcKRd12Mx6inJkdawVFq4F1jqbEtfD.jpeg','$2y$10$XeR2p1.Ml.mXwNdTVAHGM.m42b/sFe1QLBSZBNF9/wVngcSWtzDDe',NULL,'2018-08-24 08:20:26','2018-08-24 08:20:26'),(10,'Ken nguyen','bnonline1003@gmail.com','09999999','88888888','1990-10-03',1,184,'sdsdsd',1,NULL,NULL,'$2y$10$rzhPSeCD3Gjz86VRPvzQnekKBFwBDp7Eq.CNSf46wxJuhNmb.aySy',NULL,'2018-08-26 12:09:17','2018-08-26 12:09:17'),(11,'nam','nviet91@gmail.com','0982838658','sss','2018-08-08',1,15,'ha noi',1,NULL,'upload/profile/nviet91@gmail.com2018/08/27/IQl91rNamdQq9LwaB9gyVfuAHxat4CWzZzJtM7Y2.jpeg','$2y$10$Xn2xKbeuZapMUXQIt8oxFuyn0Gd7D33jEjh9.jP7tBhLVc3jO5fvm',NULL,'2018-08-27 10:18:24','2018-08-27 10:18:24'),(12,'dsdsdsd','abc@gmail.com','0987654555','12345646','2018-08-01',1,14,'3 Lê Văn Lương, Cầu Giấy, Hà Nội, Việt Nam',1,NULL,NULL,'$2y$10$qXfjngayLCNWYg1ImSto2.mHqwxHahCRu84b.B0Q99Ww7uteG2ORu',NULL,'2018-08-27 16:26:54','2018-08-28 15:48:14'),(13,'Viet Nguyen Văn','viet91@gmail.com','0982838688','1221','2018-08-16',1,241,'627X6 đường số 5, Phường 5, quận Gò Vấp',1,NULL,'upload/profile/viet91@gmail.com2018/08/28/ofkPePZNRhAMqwWqaaN4hYDajoLORdKKtrdhmsYt.jpeg','$2y$10$HAc3mEJRwq0xIajS1cLDr.oF3rOOkYp6Uh3vY2OVpBZecZAhibzH6',NULL,'2018-08-28 15:39:29','2018-08-28 15:39:29'),(14,'Nguyen Minh Giang','ntubuysell@gmail.com','0906047892','wurwiofskfcndskfhpwuruye','1980-02-25',1,241,'60/30 Phan DInh Giot, Phuong Liet, Thanh Xuan, Ha Noi, Vietnam',1,NULL,'upload/profile/ntubuysell@gmail.com2018/08/29/YL3mM8yGzpfqrWogqil444xfVEq7swZ68NqhByYZ.png','$2y$10$KgCqmUPjs1CFdc52C0BKvefHE9XNEiioNzjvIwSzLBJ01mOogmK8m','9KwpAvFBekKEfTOgBUN3jLXo8Q8qq95BMxQyka3D4GG6HgYIba3dqa4YxPKf','2018-08-29 04:07:35','2018-08-29 04:07:35'),(15,'thanh nguyen','nmgiangoki@gmail.com','0906047893','fkdjflkafjlldnvlkndkf','1980-02-25',2,241,'linh dam ha noi',1,NULL,NULL,'$2y$10$siiNOnlJADxmy06S9fKs2.HaQmyXGnPGQZzVX4nwa.78YkTrakaHi','j2lShcQLaXaNziAx1vJwqMM2xRs13ZTco0Luy88zlDHoaXXPA46jueZ15QGN','2018-08-30 06:16:12','2018-08-30 06:16:12');
/*!40000 ALTER TABLE `tbl_customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_games`
--

DROP TABLE IF EXISTS `tbl_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci,
  `ticket_price` double(8,2) NOT NULL,
  `numbers` tinyint(3) unsigned NOT NULL,
  `min_number` tinyint(3) unsigned NOT NULL,
  `max_number` tinyint(3) unsigned NOT NULL,
  `has_special_number` tinyint(1) NOT NULL DEFAULT '0',
  `min_special` tinyint(3) unsigned DEFAULT NULL,
  `max_special` tinyint(3) unsigned DEFAULT NULL,
  `draw_time` time NOT NULL,
  `draw_day` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `class_html` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `special_numbers` tinyint(4) DEFAULT NULL,
  `id_game_api` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `games_alias_unique` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_games`
--

LOCK TABLES `tbl_games` WRITE;
/*!40000 ALTER TABLE `tbl_games` DISABLE KEYS */;
INSERT INTO `tbl_games` VALUES (1,'EuroJackpot','eurojackpot','games/eurojackpot.png',1000.00,5,1,50,1,1,10,'19:00:00','5','How to Play EuroJackpot Online\r\nPlay EuroJackpot online with your selection of five main numbers from a guess range of 1-50, and two additional numbers from a separate guess range of 1-10. Select your numbers with quick pick, use your saved lucky numbers, or make manual selection. When you buy official lottery tickets online at theLotter, we scan a copy of your ticket to your account before the draw as part of our See Your Ticket Service. Learn how we buy official EuroJackpot tickets here.\r\n\r\nEuroJackpot draws take place on Friday nights in Helsinki, Finland, at 19:00 GMT and span 18 participating countries. The European lottery offers 12 fantastic prize divisions, including an official starting jackpot of €10 million.','2018-08-08 16:14:26','2018-08-08 16:14:26',NULL,'game-jackpot-euro',2,'eurojackpot'),(2,'Mega Millions','mega-millions','games/megamillions.png',500.00,5,1,70,1,1,25,'04:00:00','3,6','How to Play Mega Millions Online\r\nMega Millions winning numbers are drawn on Tuesdays and Fridays at 23:00 EST*. Buy Mega Millions tickets online by selecting five main numbers (from 1-70) and a Mega Ball (from 25) for each line. Choose your Mega Millions number manually, with quick pick, or from your saved numbers to buy your official Mega Millions lottery ticket. Match 5+1 to become an American lottery multi-millionaire and win a guaranteed $1,000,000 second place prize for all five main numbers! Learn how to purchase official lottery tickets on theLotter and how it works here.','2018-08-23 01:08:42','2018-08-23 01:08:46',NULL,'game-mega-million',1,'us_mega_millions'),(3,'LTR Jackpot','ltr-jackpot','games/2018/08/24/ltr-jackpot-1535104880.png',2000.00,5,1,56,1,1,55,'18:30:00','0,1,2,3,4,5,6','Very Big Prize','2018-08-24 07:27:20','2018-08-24 10:01:20',NULL,NULL,1,NULL);
/*!40000 ALTER TABLE `tbl_games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_migrations`
--

DROP TABLE IF EXISTS `tbl_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_migrations`
--

LOCK TABLES `tbl_migrations` WRITE;
/*!40000 ALTER TABLE `tbl_migrations` DISABLE KEYS */;
INSERT INTO `tbl_migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2018_07_12_124539_create_password_securities_table',2),(3,'2018_07_12_142743_create_customer_table',3),(4,'2018_07_07_181251_create_games_table',4),(5,'2018_07_07_203322_create_winning_numbers_table',4),(6,'2018_07_07_204226_create_prizes_table',4),(7,'2018_07_07_205108_create_tickets_table',4),(8,'2018_07_29_143931_add_ticket_price_to_games_table',4),(9,'2018_08_14_024231_add_class_column_to_games',5),(10,'2018_08_14_152350_add_special_numbers_to_games_table',6),(11,'2018_08_15_184603_alter_games_table',7),(12,'2018_08_17_102102_create_winner_table',7),(13,'2018_08_19_093601_add_id_game_api_column_to_game_table',7),(14,'2018_08_19_105509_update_ticket_table',7),(15,'2018_08_19_122950_alter_tickets_table',7),(16,'2018_08_20_145631_alter_winning_numbers_table',8),(17,'2018_08_20_150517_rename_winner_and_customer_table',9),(18,'2018_08_20_151518_add_introimage_and_description_to_winners_table',10),(20,'2018_08_20_165022_change_special_numbers_to_sstring_winning_numbers_table',11),(21,'2018_08_23_072453_drop_foreign_user_id_from_tickets_table',12);
/*!40000 ALTER TABLE `tbl_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_password_securities`
--

DROP TABLE IF EXISTS `tbl_password_securities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_password_securities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `google2fa_enable` tinyint(1) NOT NULL DEFAULT '0',
  `google2fa_secret` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_password_securities`
--

LOCK TABLES `tbl_password_securities` WRITE;
/*!40000 ALTER TABLE `tbl_password_securities` DISABLE KEYS */;
INSERT INTO `tbl_password_securities` VALUES (8,6,1,'TL7UDSK3PQJMPBYT','2018-07-30 10:36:24','2018-08-16 10:59:55'),(10,1,1,'CQHAZPYTLMELQFIP','2018-08-20 17:40:41','2018-08-20 17:41:30'),(11,3,1,'DFBX3YAJBQGS3O7E','2018-08-23 06:13:08','2018-08-23 06:13:52'),(12,7,0,'H42QNASECLZO6GMI','2018-08-23 16:48:44','2018-08-23 16:48:44'),(13,11,1,'EYJEGVHORQCBJEHL','2018-08-27 10:18:27','2018-08-29 16:08:03'),(14,11,0,'CYABEYHZ3HDPTRR6','2018-08-27 10:18:29','2018-08-27 10:18:29'),(15,11,0,'FHPV3KXWYVLKENJL','2018-08-27 10:18:30','2018-08-27 10:18:30'),(16,11,0,'WG3XAEUBSNCHZANF','2018-08-27 10:25:30','2018-08-27 10:25:30'),(17,12,1,'YWNR2NCQDLS3R3N4','2018-08-27 16:27:00','2018-08-27 16:52:07'),(18,13,0,'RKABRGS4PYSOEI6Q','2018-08-28 15:40:07','2018-08-28 15:40:07'),(19,14,1,'SP4FXG5Y5KCFVBEB','2018-08-29 04:08:05','2018-08-29 04:11:48'),(20,15,1,'XMJFBXE6S6XA6VGM','2018-08-30 06:16:18','2018-08-30 06:16:44');
/*!40000 ALTER TABLE `tbl_password_securities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_prizes`
--

DROP TABLE IF EXISTS `tbl_prizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_prizes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `match` tinyint(3) unsigned NOT NULL,
  `match_special` tinyint(1) NOT NULL DEFAULT '0',
  `value` int(10) unsigned NOT NULL,
  `unit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prizes_game_id_foreign` (`game_id`),
  CONSTRAINT `prizes_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `tbl_games` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_prizes`
--

LOCK TABLES `tbl_prizes` WRITE;
/*!40000 ALTER TABLE `tbl_prizes` DISABLE KEYS */;
INSERT INTO `tbl_prizes` VALUES (1,1,'Jackpot',5,2,10000,'BTC','2018-08-23 02:46:56','2018-08-23 02:46:59'),(2,2,'Special',5,1,5000,'BTC','2018-08-23 02:47:51','2018-08-23 02:47:54'),(7,3,'Jackpot',5,1,6000,'BTC','2018-08-24 10:01:20','2018-08-24 10:01:20');
/*!40000 ALTER TABLE `tbl_prizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_tickets`
--

DROP TABLE IF EXISTS `tbl_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `numbers` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `special_numbers` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` double(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_game_id_foreign` (`game_id`),
  KEY `tickets_user_id_foreign` (`user_id`),
  KEY `tickets_created_at_index` (`created_at`),
  CONSTRAINT `tickets_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `tbl_games` (`id`),
  CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_customers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tickets`
--

LOCK TABLES `tbl_tickets` WRITE;
/*!40000 ALTER TABLE `tbl_tickets` DISABLE KEYS */;
INSERT INTO `tbl_tickets` VALUES (1,1,7,'2 15 25 33 38',1,'2018-08-23 16:49:44',NULL,'3 9',1000.00),(2,1,7,'9 11 18 30 36',1,'2018-08-23 16:49:44',NULL,'3 7',1000.00),(3,1,7,'7 19 26 38 47',1,'2018-08-23 16:49:44',NULL,'4 10',1000.00);
/*!40000 ALTER TABLE `tbl_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `introimage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tel` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_users`
--

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` VALUES (1,'Admin','admin@buylottery.org',NULL,NULL,NULL,'$2y$10$UWRvFt8OHEyH3DolmFCwHefs8q3dOhAkJNi2qJ5Ys5uMjhhvcii0m',1,'','2018-08-14 09:52:34','2018-08-14 09:52:37');
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_winners`
--

DROP TABLE IF EXISTS `tbl_winners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_winners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `prize_id` int(11) NOT NULL,
  `winning_number_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `introimage` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_winners`
--

LOCK TABLES `tbl_winners` WRITE;
/*!40000 ALTER TABLE `tbl_winners` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_winners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_winning_numbers`
--

DROP TABLE IF EXISTS `tbl_winning_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_winning_numbers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `draw_date` date NOT NULL,
  `numbers` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `special_numbers` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `winning_numbers_game_id_foreign` (`game_id`),
  CONSTRAINT `winning_numbers_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `tbl_games` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_winning_numbers`
--

LOCK TABLES `tbl_winning_numbers` WRITE;
/*!40000 ALTER TABLE `tbl_winning_numbers` DISABLE KEYS */;
INSERT INTO `tbl_winning_numbers` VALUES (2,1,'2018-08-17','2,12,32,43,44','2018-08-23 00:38:44','2018-08-23 00:38:47','3,4'),(3,1,'2018-08-10','4,15,17,21,23','2018-08-23 00:43:50','2018-08-23 00:43:53','6,7'),(4,1,'2018-08-03','4,8,12,25,31','2018-08-23 00:44:35','2018-08-23 00:44:38','7,8'),(5,1,'2018-07-27','2,22,40,43,50','2018-08-23 00:48:49','2018-08-23 00:48:46','3,8'),(6,1,'2018-07-20','13,33,40,42,43','2018-08-23 00:49:38','2018-08-23 00:49:35','7,9'),(8,2,'2018-08-21','14,16,19,38,57','2018-08-23 00:52:24','2018-08-23 00:52:28','11'),(9,2,'2018-08-17','1,31,32,47,56','2018-08-23 00:54:53','2018-08-23 00:54:51','3'),(10,2,'2018-08-14','11,26,44,45,46','2018-08-23 00:55:17','2018-08-23 00:55:20','11'),(11,2,'2018-08-10','1,3,12,22,42','2018-08-23 00:57:46','2018-08-23 00:57:44','6'),(13,2,'2018-08-07','2,13,15,21,62','2018-08-23 00:58:35','2018-08-23 00:58:32','2'),(14,1,'2018-08-24','8,25,26,38,48','2018-08-24 19:16:27','2018-08-24 19:16:34','6,9'),(15,2,'2018-08-24','1,6,13,18,49','2018-08-24 19:18:36','2018-08-24 19:18:40','8'),(16,2,'2018-08-28','3,20,33,34,41','2018-08-28 23:30:48','2018-08-28 23:30:48','20');
/*!40000 ALTER TABLE `tbl_winning_numbers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-30 15:07:14
