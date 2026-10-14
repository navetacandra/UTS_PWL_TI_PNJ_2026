/*M!999999\- enable the sandbox mode */
-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: PBL_TI_2025_B_NavetaCandra
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `account_type`
--

DROP TABLE IF EXISTS `account_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `account_type` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_type`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `account_type` WRITE;
/*!40000 ALTER TABLE `account_type` DISABLE KEYS */;
INSERT INTO `account_type` VALUES
('09748dc0-c7e0-11f1-96d4-00155d832b44','Mahasiswa','Punya Mahasiswa','2026-10-14 22:00:47','2026-10-14 22:05:05','2026-10-14 22:05:50'),
('3464fa33-c769-11f1-bc93-00155da39f42','Admin','Role untuk','2026-10-14 07:50:08','2026-10-14 20:11:09',NULL),
('bb25cb81-c7e0-11f1-96d4-00155d832b44','Dosen','Khusus Dosen','2026-10-14 22:05:45','2026-10-14 22:05:58',NULL),
('be61e0e1-c7d0-11f1-bf3c-00155d9189be','asd','asdasd','2026-10-14 20:11:18','2026-10-14 20:11:18','2026-10-14 20:11:24'),
('d35ebc3c-c7dd-11f1-bf3c-00155d9189be','Mahasiswa','Role Mahasiswa','2026-10-14 21:44:57','2026-10-14 21:52:29','2026-10-14 22:00:53');
/*!40000 ALTER TABLE `account_type` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `accounts` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` text NOT NULL,
  `account_type_id` varchar(36) DEFAULT NULL,
  `status` varchar(128) DEFAULT NULL,
  `identification_number` varchar(128) NOT NULL,
  `identification_type` enum('NIM','NIP') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_account_type` (`account_type_id`),
  KEY `email_hash` (`email`) USING HASH,
  KEY `identification_number_hash` (`identification_number`) USING HASH,
  CONSTRAINT `fk_account_type` FOREIGN KEY (`account_type_id`) REFERENCES `account_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES
('238f90cd-c7e0-11f1-96d4-00155d832b44','Ikbal','ikbal@pnj.ac.id','$2y$12$NS5YJfYR7FUFSnAtUYQpjunOHvLZJdwEb/TvTodAevMLqpbKF2kYe',NULL,'aktif','987654321','NIP','2026-10-14 22:01:30','2026-10-14 22:04:45','2026-10-14 22:04:50'),
('405d4cee-c769-11f1-bc93-00155da39f42','John Doe','john@example.com','securepassword123',NULL,'active','1234567890','NIM','2026-10-14 07:50:29','2026-10-14 07:50:29','2026-10-14 08:09:08'),
('5780cb62-c770-11f1-bc93-00155da39f42','Admin','admin@example.com','$2y$12$39g72iSI4.ZHFPqGj2IIn.ksWYqlOrzxSq1CDly53rjshLkM/abP6','3464fa33-c769-11f1-bc93-00155da39f42','active','1234567890','NIP','2026-10-14 08:41:14','2026-10-14 21:35:01',NULL),
('d974f013-c7e0-11f1-96d4-00155d832b44','Ikbal Maulana','ikbal@pnj.ac.id','$2y$12$c6nmyECHq3Vm.oaRUiZkkes5YFTa3GRdHMfokLPaypx9xomAsjH56',NULL,'aktif','987654321','NIP','2026-10-14 22:06:36','2026-10-14 22:06:52','2026-10-14 22:06:57'),
('e03f894b-c76b-11f1-bc93-00155da39f42','John Doe','john@example.com','$2y$12$SPARnAFRZJiIyNTS7itra.ZCU9QqTePBCtm6TJyiElZxiAuG4PmRm',NULL,'active','1234567890','NIM','2026-10-14 08:09:16','2026-10-14 08:09:16','2026-10-14 08:24:34');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `actions` (
  `id` varchar(36) NOT NULL DEFAULT uuid(),
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `actions` WRITE;
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` VALUES
('23c61826-c7ca-11f1-bf3c-00155d9189be','CREATE','Untuk tambah tambah','2026-10-14 19:24:02','2026-10-14 20:06:15','2026-10-14 20:09:43'),
('2a25a8f7-c7c8-11f1-bf3c-00155d9189be','CREATE','Operasi menambahkan','2026-10-14 19:09:53','2026-10-14 19:09:53','2026-10-14 19:19:08'),
('34aa557c-c769-11f1-bc93-00155da39f42','CREATE','Operasi menambahkan','2026-10-14 07:50:09','2026-10-14 07:50:09','2026-10-14 19:06:51'),
('4a7a128e-c7d0-11f1-bf3c-00155d9189be','DELETE','hapusss','2026-10-14 20:08:04','2026-10-14 20:08:04','2026-10-14 20:09:41'),
('64a91397-c7d0-11f1-bf3c-00155d9189be','UPDATE','asd','2026-10-14 20:08:48','2026-10-14 20:08:48','2026-10-14 20:08:52'),
('6f354988-c7d0-11f1-bf3c-00155d9189be','UPDATE','edit','2026-10-14 20:09:05','2026-10-14 20:09:36','2026-10-14 20:09:38'),
('ad2edc2f-c7c9-11f1-bf3c-00155d9189be','CREATE','Operasi menambahkan','2026-10-14 19:20:43','2026-10-14 19:20:43','2026-10-14 19:20:49'),
('dc5e340e-c7c9-11f1-bf3c-00155d9189be','CREATE','Operasi menambahkan','2026-10-14 19:22:02','2026-10-14 19:22:02','2026-10-14 19:23:43'),
('e22a5b62-c7c9-11f1-bf3c-00155d9189be','CREATE','Operasi menambahkan','2026-10-14 19:22:12','2026-10-14 19:22:12','2026-10-14 19:24:00'),
('f0d3760d-c7e0-11f1-96d4-00155d832b44','Delete','Action Hapus Data','2026-10-14 22:07:15','2026-10-14 22:07:24','2026-10-14 22:07:28');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-10-14 23:18:37
