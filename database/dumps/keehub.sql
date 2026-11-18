-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: keehub
-- ------------------------------------------------------
-- Server version	8.0.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `brands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'AMD','amd',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(2,'Intel','intel',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(3,'ASUS','asus',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(4,'MSI','msi',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(5,'Gigabyte','gigabyte',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(6,'Corsair','corsair',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(7,'Kingston','kingston',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(8,'Samsung','samsung',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(9,'Lian Li','lian-li',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(10,'Cooler Master','cooler-master',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(11,'DeepCool','deepcool',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(12,'NVIDIA','nvidia',NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(13,'VenomRX','venomrx',NULL,1,'2026-11-12 23:29:51','2026-11-12 23:29:51'),(14,'V-GeN','v-gen',NULL,1,'2026-11-16 22:22:15','2026-11-16 22:22:15');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('keehub-cache-356a192b7913b04c54574d18c28d46e6395428ab','i:1;',1794911662),('keehub-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1794911662;',1794911662);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cart_id` bigint unsigned NOT NULL,
  `item_type` enum('product','build','service') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'product',
  `product_id` bigint unsigned DEFAULT NULL,
  `pc_build_id` bigint unsigned DEFAULT NULL,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cart_items_cart_id_foreign` (`cart_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  KEY `cart_items_pc_build_id_foreign` (`pc_build_id`),
  CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_pc_build_id_foreign` FOREIGN KEY (`pc_build_id`) REFERENCES `pc_builds` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
INSERT INTO `cart_items` VALUES (3,2,'product',2,NULL,1,'2026-10-16 08:20:53','2026-10-16 08:20:53'),(4,3,'product',5,NULL,1,'2026-10-16 19:21:07','2026-10-16 19:21:07');
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `pc_build_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_pc_build_id_foreign` (`pc_build_id`),
  KEY `carts_session_id_index` (`session_id`),
  CONSTRAINT `carts_pc_build_id_foreign` FOREIGN KEY (`pc_build_id`) REFERENCES `pc_builds` (`id`) ON DELETE SET NULL,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,NULL,1,NULL,'2026-10-16 01:49:03','2026-10-16 01:49:03'),(2,'TKFyCVJZdqsznAnfwfmdaoTA2pjC2GsvEq38Mkc6',NULL,NULL,'2026-10-16 08:20:45','2026-10-16 08:20:45'),(3,'NhGOI43TidXdaKRxTJ7zBYViMMlalxKsrl4vz6D9',NULL,NULL,'2026-10-16 19:21:07','2026-10-16 19:21:07'),(4,'jbFGC56QRkZ4VwndR6Df7YlOxKSFqmk1mFoEJufX',NULL,NULL,'2026-10-27 23:24:47','2026-10-27 23:24:47'),(5,'FcMZJlzCL9epduAJ6QrFRUGAAUEMqwYIcAj5JZdy',NULL,NULL,'2026-10-27 23:25:08','2026-10-27 23:25:08'),(6,'HIlu7d0UYf2jzlm9LnhMN0COWCsTXfc9rGdnh4uj',NULL,NULL,'2026-11-04 15:06:56','2026-11-04 15:06:56'),(7,NULL,3,NULL,'2026-11-10 23:28:48','2026-11-10 23:28:48');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'CPU','cpu','cpu',NULL,0,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(2,'Motherboard','motherboard','circuit-board',NULL,1,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(3,'GPU','gpu','video-camera',NULL,2,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(4,'RAM','ram','memory-chip',NULL,3,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(5,'SSD','ssd','circle-stack',NULL,4,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(6,'HDD','hdd','archive-box',NULL,5,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(7,'PSU','psu','bolt',NULL,6,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(8,'Casing','casing','squares-2x2',NULL,7,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(9,'CPU Cooler','cpu-cooler','fire',NULL,8,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(10,'Monitor','monitor','tv',NULL,9,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(11,'Keyboard','keyboard','keyboard',NULL,10,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(12,'Mouse','mouse','cursor-arrow-rays',NULL,11,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(13,'Networking','networking','wifi',NULL,12,1,NULL,NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `code_counters`
--

DROP TABLE IF EXISTS `code_counters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `code_counters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_number` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_counters_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code_counters`
--

LOCK TABLES `code_counters` WRITE;
/*!40000 ALTER TABLE `code_counters` DISABLE KEYS */;
INSERT INTO `code_counters` VALUES (1,'SVC:20261025',1,'2026-10-24 19:32:13','2026-10-24 19:32:13'),(2,'INV-SVC:20261025',1,'2026-10-24 19:32:13','2026-10-24 19:32:13'),(3,'SVC:20261031',1,'2026-10-31 04:25:08','2026-10-31 04:25:08'),(4,'INV-SVC:20261031',1,'2026-10-31 04:25:08','2026-10-31 04:25:08'),(5,'SVC:20261101',1,'2026-10-31 18:31:30','2026-10-31 18:31:30'),(6,'INV-SVC:20261101',1,'2026-10-31 18:31:30','2026-10-31 18:31:30'),(7,'ORD:20261111',1,'2026-11-10 23:30:47','2026-11-10 23:30:47'),(8,'INV:20261111',1,'2026-11-10 23:30:47','2026-11-10 23:30:47'),(9,'SVC:20261111',1,'2026-11-10 23:32:47','2026-11-10 23:32:47'),(10,'INV-SVC:20261111',1,'2026-11-10 23:32:47','2026-11-10 23:32:47'),(11,'QT:202611',2,'2026-11-12 23:34:38','2026-11-12 23:37:46');
/*!40000 ALTER TABLE `code_counters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compatibility_rules`
--

DROP TABLE IF EXISTS `compatibility_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compatibility_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rule_key` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `compatibility_rules_rule_key_unique` (`rule_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compatibility_rules`
--

LOCK TABLES `compatibility_rules` WRITE;
/*!40000 ALTER TABLE `compatibility_rules` DISABLE KEYS */;
/*!40000 ALTER TABLE `compatibility_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_addresses`
--

DROP TABLE IF EXISTS `customer_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_addresses_customer_id_foreign` (`customer_id`),
  CONSTRAINT `customer_addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_addresses`
--

LOCK TABLES `customer_addresses` WRITE;
/*!40000 ALTER TABLE `customer_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_user_id_foreign` (`user_id`),
  KEY `customers_whatsapp_index` (`whatsapp`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,NULL,'Budi Santoso','6281234567800','budi@example.test',NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(2,NULL,'Siti Rahma','6281234567801','siti@example.test',NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(3,NULL,'Mas Bolank','085740211773',NULL,NULL,'2026-10-23 21:20:56','2026-10-23 21:20:56'),(4,NULL,'Unggul','085334763900',NULL,NULL,'2026-10-31 04:19:58','2026-10-31 04:19:58'),(5,NULL,'KIM','085740359738',NULL,NULL,'2026-10-31 18:28:42','2026-10-31 18:28:42'),(6,3,'Mustofa Arifin','081567765377',NULL,NULL,'2026-11-10 23:30:47','2026-11-10 23:30:47'),(7,NULL,'Jakon','082227027289',NULL,NULL,'2026-11-12 23:33:36','2026-11-12 23:33:36');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `current_stock` int unsigned NOT NULL DEFAULT '0',
  `min_stock` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventory_product_id_unique` (`product_id`),
  CONSTRAINT `inventory_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` VALUES (1,1,15,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(2,2,12,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(3,3,10,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(4,4,8,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(5,5,20,5,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(6,6,6,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(7,7,9,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(8,8,18,4,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(9,9,14,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(10,10,7,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(11,11,4,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(12,12,11,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(13,13,13,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(14,14,9,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(15,15,4,2,'2026-11-12 20:20:00','2026-11-12 21:50:43'),(16,16,5,2,'2026-11-12 23:31:04','2026-11-16 21:17:26'),(17,17,5,2,'2026-11-16 21:17:26','2026-11-16 21:17:26'),(18,18,5,2,'2026-11-16 21:17:26','2026-11-16 21:17:26'),(19,19,3,2,'2026-11-16 21:17:26','2026-11-16 21:17:26'),(20,20,5,2,'2026-11-16 22:22:15','2026-11-16 22:22:15'),(21,21,5,2,'2026-11-16 22:22:15','2026-11-16 22:22:15'),(22,22,5,2,'2026-11-16 22:22:15','2026-11-16 22:22:15'),(23,23,3,2,'2026-11-16 22:22:15','2026-11-16 22:22:15'),(24,24,2,1,'2026-11-16 22:56:49','2026-11-16 22:56:49'),(25,25,2,1,'2026-11-16 22:56:49','2026-11-16 22:56:49'),(26,26,5,2,'2026-11-16 23:10:29','2026-11-16 23:10:29'),(27,27,5,2,'2026-11-16 23:10:29','2026-11-16 23:10:29'),(28,28,5,2,'2026-11-16 23:10:29','2026-11-16 23:10:29'),(29,29,3,2,'2026-11-16 23:10:29','2026-11-16 23:10:29'),(30,30,5,1,'2026-11-17 00:25:39','2026-11-17 00:25:39'),(31,31,5,1,'2026-11-17 01:01:40','2026-11-17 01:01:40'),(32,32,5,1,'2026-11-17 01:01:40','2026-11-17 01:01:40'),(33,33,5,1,'2026-11-17 01:01:40','2026-11-17 01:01:40'),(34,34,5,1,'2026-11-17 01:01:40','2026-11-17 01:01:40');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_items`
--

DROP TABLE IF EXISTS `invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `price` bigint unsigned NOT NULL DEFAULT '0',
  `total` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_items`
--

LOCK TABLES `invoice_items` WRITE;
/*!40000 ALTER TABLE `invoice_items` DISABLE KEYS */;
INSERT INTO `invoice_items` VALUES (1,1,'Intel Core i5-12400F',NULL,1,1750000,1750000,'2026-11-10 23:30:47','2026-11-10 23:30:47'),(2,1,'MSI RTX 4060 Ventus 2X 8GB',NULL,1,5350000,5350000,'2026-11-10 23:30:47','2026-11-10 23:30:47');
/*!40000 ALTER TABLE `invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `subtotal` bigint unsigned NOT NULL DEFAULT '0',
  `discount` bigint unsigned NOT NULL DEFAULT '0',
  `shipping` bigint unsigned NOT NULL DEFAULT '0',
  `total` bigint unsigned NOT NULL DEFAULT '0',
  `paid_amount` bigint unsigned NOT NULL DEFAULT '0',
  `status` enum('unpaid','partial','paid','refunded','void') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `due_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_code_unique` (`code`),
  KEY `invoices_customer_id_foreign` (`customer_id`),
  KEY `invoices_order_id_status_index` (`order_id`,`status`),
  KEY `invoices_status_index` (`status`),
  CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'INV-20261111-001',1,6,7100000,0,0,7100000,0,'unpaid',NULL,NULL,'2026-11-10 23:30:47','2026-11-10 23:30:47');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_01_01_000001_create_catalog_tables',1),(5,'2026_01_01_000002_create_customer_inventory_settings_tables',1),(6,'2026_01_01_000003_create_business_tables',1),(7,'2026_09_22_080007_create_code_counters_table',1),(8,'2026_10_09_052142_add_b2b_and_part_source_to_services_tables',1),(9,'2026_11_13_025822_create_service_devices_table',2),(10,'2026_11_17_030000_add_variant_columns_to_products_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `item_type` enum('product','build','service','labor','customer_owned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'product',
  `product_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `price` bigint unsigned NOT NULL DEFAULT '0',
  `total` bigint unsigned NOT NULL DEFAULT '0',
  `affects_stock` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_order_id_index` (`order_id`),
  KEY `order_items_item_type_index` (`item_type`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,'product',2,'Intel Core i5-12400F',NULL,1,1750000,1750000,1,'2026-11-10 23:30:47','2026-11-10 23:30:47'),(2,1,'product',6,'MSI RTX 4060 Ventus 2X 8GB',NULL,1,5350000,5350000,1,'2026-11-10 23:30:47','2026-11-10 23:30:47');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status_history`
--

DROP TABLE IF EXISTS `order_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_status_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `from_status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_status_history_user_id_foreign` (`user_id`),
  KEY `order_status_history_order_id_index` (`order_id`),
  CONSTRAINT `order_status_history_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_status_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status_history`
--

LOCK TABLES `order_status_history` WRITE;
/*!40000 ALTER TABLE `order_status_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `type` enum('product','pc_build','service','product_service') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'product',
  `channel` enum('website','admin','whatsapp','offline') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'website',
  `status` enum('pending','confirmed','processing','ready','shipped','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `subtotal` bigint unsigned NOT NULL DEFAULT '0',
  `discount` bigint unsigned NOT NULL DEFAULT '0',
  `shipping_cost` bigint unsigned NOT NULL DEFAULT '0',
  `total` bigint unsigned NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `pc_build_id` bigint unsigned DEFAULT NULL,
  `quotation_id` bigint unsigned DEFAULT NULL,
  `service_id` bigint unsigned DEFAULT NULL,
  `shipping_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_code_unique` (`code`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_pc_build_id_foreign` (`pc_build_id`),
  KEY `orders_customer_id_status_index` (`customer_id`,`status`),
  KEY `orders_status_created_at_index` (`status`,`created_at`),
  KEY `orders_type_index` (`type`),
  KEY `orders_status_index` (`status`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_pc_build_id_foreign` FOREIGN KEY (`pc_build_id`) REFERENCES `pc_builds` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'ORD-20261111-001',6,3,'product','website','pending',7100000,0,0,7100000,'Rakit yg rapi y bang. Hehe\r\nHidup Jokowiiii...',NULL,NULL,NULL,'Mustofa Arifin','081567765377','Pickup at Store','2026-11-10 23:30:47','2026-11-10 23:30:47');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_id` bigint unsigned NOT NULL,
  `method` enum('cash','transfer','qris','ewallet','debit','credit','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
  `amount` bigint unsigned NOT NULL DEFAULT '0',
  `paid_at` date NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_code_unique` (`code`),
  KEY `payments_user_id_foreign` (`user_id`),
  KEY `payments_invoice_id_index` (`invoice_id`),
  CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pc_build_items`
--

DROP TABLE IF EXISTS `pc_build_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pc_build_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pc_build_id` bigint unsigned NOT NULL,
  `slot` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `price` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pc_build_items_pc_build_id_slot_unique` (`pc_build_id`,`slot`),
  KEY `pc_build_items_product_id_foreign` (`product_id`),
  KEY `pc_build_items_slot_index` (`slot`),
  CONSTRAINT `pc_build_items_pc_build_id_foreign` FOREIGN KEY (`pc_build_id`) REFERENCES `pc_builds` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pc_build_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pc_build_items`
--

LOCK TABLES `pc_build_items` WRITE;
/*!40000 ALTER TABLE `pc_build_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_build_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pc_builds`
--

DROP TABLE IF EXISTS `pc_builds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pc_builds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purpose` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` bigint unsigned DEFAULT NULL,
  `total_price` bigint unsigned NOT NULL DEFAULT '0',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `share_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pc_builds_code_unique` (`code`),
  UNIQUE KEY `pc_builds_share_token_unique` (`share_token`),
  KEY `pc_builds_user_id_foreign` (`user_id`),
  KEY `pc_builds_customer_id_foreign` (`customer_id`),
  KEY `pc_builds_status_index` (`status`),
  CONSTRAINT `pc_builds_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pc_builds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pc_builds`
--

LOCK TABLES `pc_builds` WRITE;
/*!40000 ALTER TABLE `pc_builds` DISABLE KEYS */;
/*!40000 ALTER TABLE `pc_builds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (2,2,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(3,3,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(4,4,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(5,5,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(6,6,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(7,7,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(8,8,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(9,9,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(10,10,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(11,11,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(12,12,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(13,13,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(14,14,'products/placeholder.svg',1,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(15,1,'products/01M776RB35B2WRWVGM3KVQKFFQ.jpg',1,0,'2026-11-11 23:22:38','2026-11-11 23:22:38'),(16,20,'products/vgen-ssd-platinum-sata.jpg',0,0,'2026-11-16 22:22:15','2026-11-16 22:40:25'),(17,21,'products/vgen-ssd-platinum-sata.jpg',0,0,'2026-11-16 22:22:15','2026-11-16 22:40:25'),(18,22,'products/vgen-ssd-platinum-sata.jpg',0,0,'2026-11-16 22:22:15','2026-11-16 22:40:25'),(19,23,'products/vgen-ssd-platinum-sata.jpg',0,0,'2026-11-16 22:22:15','2026-11-16 22:40:25'),(20,20,'products/vgen-ssd-sata-3.jpg',1,0,'2026-11-16 22:40:25','2026-11-16 22:40:25'),(21,21,'products/vgen-ssd-sata-3.jpg',1,0,'2026-11-16 22:40:25','2026-11-16 22:40:25'),(22,22,'products/vgen-ssd-sata-3.jpg',1,0,'2026-11-16 22:40:25','2026-11-16 22:40:25'),(23,23,'products/vgen-ssd-sata-3.jpg',1,0,'2026-11-16 22:40:25','2026-11-16 22:40:25'),(24,24,'products/vgen-ssd-sata-3.jpg',1,0,'2026-11-16 22:56:50','2026-11-16 22:56:50'),(25,25,'products/vgen-ssd-sata-3.jpg',1,0,'2026-11-16 22:56:50','2026-11-16 22:56:50'),(26,26,'products/vgen-hyper-nvme.jpg',1,0,'2026-11-16 23:10:29','2026-11-16 23:10:29'),(27,27,'products/vgen-hyper-nvme.jpg',1,0,'2026-11-16 23:10:29','2026-11-16 23:10:29'),(28,28,'products/vgen-hyper-nvme.jpg',1,0,'2026-11-16 23:10:29','2026-11-16 23:10:29'),(29,29,'products/vgen-hyper-nvme.jpg',1,0,'2026-11-16 23:10:29','2026-11-16 23:10:29'),(30,30,'products/intel-core-i3-6100-tray.jpg',1,0,'2026-11-17 00:25:39','2026-11-17 00:25:39'),(33,33,'products/intel-core-i3-7100-tray.jpg',1,0,'2026-11-17 01:01:40','2026-11-17 01:01:40'),(36,31,'products/01M7MGWA7CKJ46W7K4KGY1G4JJ.png',1,0,'2026-11-17 03:29:41','2026-11-17 03:29:41'),(37,34,'products/01M7MH171XX3SDGWDE5N9N1GHA.jpg',1,0,'2026-11-17 03:32:22','2026-11-17 03:32:22'),(39,32,'products/01M7MH33QTTVBGG49Z4SDWJYMM.jfif',1,0,'2026-11-17 03:33:33','2026-11-17 03:33:33');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_specs`
--

DROP TABLE IF EXISTS `product_specs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_specs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_numeric` decimal(14,4) DEFAULT NULL,
  `unit` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_specs_product_id_key_index` (`product_id`,`key`),
  KEY `product_specs_key_value_index` (`key`,`value`),
  CONSTRAINT `product_specs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_specs`
--

LOCK TABLES `product_specs` WRITE;
/*!40000 ALTER TABLE `product_specs` DISABLE KEYS */;
INSERT INTO `product_specs` VALUES (9,2,'socket','LGA1700',NULL,NULL,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(10,2,'core','6',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(11,2,'thread','12',NULL,NULL,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(12,2,'boost_clock','4.4 GHz',NULL,NULL,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(13,2,'tdp_watt','65',65.0000,'W',4,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(14,2,'integrated_graphics','Tidak (F-series)',NULL,NULL,5,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(15,3,'socket','AM4',NULL,NULL,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(16,3,'chipset','A520',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(17,3,'ram_type','DDR4',NULL,NULL,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(18,3,'ram_slots','2',2.0000,NULL,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(19,3,'max_ram_gb','64',64.0000,'GB',4,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(20,3,'m2_slots','1',1.0000,NULL,5,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(21,3,'form_factor','Micro ATX',NULL,NULL,6,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(22,4,'socket','AM4',NULL,NULL,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(23,4,'chipset','B550',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(24,4,'ram_type','DDR4',NULL,NULL,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(25,4,'ram_slots','4',4.0000,NULL,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(26,4,'max_ram_gb','128',128.0000,'GB',4,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(27,4,'m2_slots','2',2.0000,NULL,5,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(28,4,'form_factor','Micro ATX',NULL,NULL,6,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(29,5,'generation','DDR4',NULL,NULL,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(30,5,'capacity_gb','16',16.0000,'GB',1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(31,5,'frequency_mhz','3200',3200.0000,'MHz',2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(32,5,'cas_latency','CL16',NULL,NULL,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(33,5,'module_count','2',NULL,NULL,4,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(34,6,'vram_gb','8',8.0000,'GB',0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(35,6,'memory_type','GDDR6',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(36,6,'power_consumption_watt','115',115.0000,'W',2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(37,6,'length_mm','199',199.0000,'mm',3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(38,6,'recommended_psu_watt','550',550.0000,'W',4,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(39,6,'interface','PCIe 4.0 x8',NULL,NULL,5,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(40,7,'vram_gb','8',8.0000,'GB',0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(41,7,'memory_type','GDDR6',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(42,7,'power_consumption_watt','130',130.0000,'W',2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(43,7,'length_mm','212',212.0000,'mm',3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(44,7,'recommended_psu_watt','550',550.0000,'W',4,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(45,7,'interface','PCIe 4.0 x8',NULL,NULL,5,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(46,8,'capacity_gb','1000',1000.0000,'GB',0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(47,8,'form_factor','M.2 2280',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(48,8,'interface','PCIe 3.0 x4 NVMe',NULL,NULL,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(49,9,'wattage','550',550.0000,'W',0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(50,9,'efficiency','80+ Bronze',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(51,9,'modular','Non-Modular',NULL,NULL,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(52,9,'form_factor','ATX',NULL,NULL,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(53,10,'wattage','650',650.0000,'W',0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(54,10,'efficiency','80+ Bronze',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(55,10,'modular','Non-Modular',NULL,NULL,2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(56,10,'form_factor','ATX',NULL,NULL,3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(57,11,'form_factor','Mini ITX',NULL,NULL,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(58,11,'supported_form_factors','Mini ITX',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(59,11,'gpu_clearance_mm','325',325.0000,'mm',2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(60,11,'cooler_clearance_mm','70',70.0000,'mm',3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(61,12,'form_factor','ATX',NULL,NULL,0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(62,12,'supported_form_factors','ATX, Micro ATX, Mini ITX',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(63,12,'gpu_clearance_mm','360',360.0000,'mm',2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(64,12,'cooler_clearance_mm','161',161.0000,'mm',3,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(65,13,'height_mm','155',155.0000,'mm',0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(66,13,'socket_support','AM4/AM5/LGA1700',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(67,13,'tdp_rating_watt','220',220.0000,'W',2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(68,14,'height_mm','160',160.0000,'mm',0,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(69,14,'socket_support','AM4/AM5/LGA1700',NULL,NULL,1,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(70,14,'tdp_rating_watt','220',220.0000,'W',2,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(79,1,'socket','AM4',NULL,NULL,0,'2026-11-11 23:22:38','2026-11-11 23:22:38'),(80,1,'core','6',NULL,NULL,1,'2026-11-11 23:22:38','2026-11-11 23:22:38'),(81,1,'thread','12',NULL,NULL,2,'2026-11-11 23:22:38','2026-11-11 23:22:38'),(82,1,'base_clock','3.5 GHz',NULL,NULL,3,'2026-11-11 23:22:38','2026-11-11 23:22:38'),(83,1,'boost_clock','4.4 GHz',NULL,NULL,4,'2026-11-11 23:22:38','2026-11-11 23:22:38'),(84,1,'tdp_watt','65',65.0000,'W',5,'2026-11-11 23:22:38','2026-11-11 23:22:38'),(85,1,'architecture','Zen 3',NULL,NULL,6,'2026-11-11 23:22:38','2026-11-11 23:22:38'),(86,1,'integrated_graphics','Tidak',NULL,NULL,7,'2026-11-11 23:22:38','2026-11-11 23:22:38');
/*!40000 ALTER TABLE `product_specs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `variant_group` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant_label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Kapasitas',
  `brand_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` bigint unsigned NOT NULL DEFAULT '0',
  `cost_price` bigint unsigned NOT NULL DEFAULT '0',
  `weight_grams` decimal(10,2) DEFAULT NULL,
  `dimensions` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sold_count` int unsigned NOT NULL DEFAULT '0',
  `view_count` int unsigned NOT NULL DEFAULT '0',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_category_id_brand_id_is_active_index` (`category_id`,`brand_id`,`is_active`),
  KEY `products_price_index` (`price`),
  KEY `products_is_active_index` (`is_active`),
  KEY `products_is_featured_index` (`is_featured`),
  KEY `products_sold_count_index` (`sold_count`),
  KEY `products_variant_group_index` (`variant_group`),
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'CPU-AMD-5600','AMD Ryzen 5 5600','amd-ryzen-5-5600',1,NULL,NULL,'Kapasitas',1,'6 core 12 thread, combo am4 dengan B550M atau A520M, garansi resmi 3 tahun',2350000,2100000,NULL,NULL,'3 Tahun Resmi',1,1,15,9,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-16 21:20:52'),(2,'CPU-INT-12400F','Intel Core i5-12400F','intel-core-i5-12400f',1,NULL,NULL,'Kapasitas',2,'6 core 12 thread LGA1700, performa gaming kelas menengah.',2250000,2050000,NULL,NULL,'3 Tahun Resmi',1,1,12,6,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-17 03:28:20'),(3,'MB-ASUS-A520M','ASUS A520M-K','asus-a520m-k',2,NULL,NULL,'Kapasitas',3,'Micro ATX AM4 DDR4, cocok untuk Ryzen 5000 series.',1050000,950000,NULL,NULL,'3 Tahun Resmi',1,1,10,1,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-05 00:51:31'),(4,'MB-MSI-B550M','MSI B550M PRO-VDH WiFi','msi-b550m-pro-vdh-wifi',2,NULL,NULL,'Kapasitas',4,'Micro ATX AM4 DDR4, PCIe 4.0, WiFi onboard.',1550000,1420000,NULL,NULL,'3 Tahun Resmi',1,0,8,1,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-17 10:31:48'),(5,'RAM-KST-16-3200','Kingston Fury Beast DDR4 16GB (2x8GB) 3200MHz','kingston-fury-beast-ddr4-16gb-3200',4,NULL,NULL,'Kapasitas',7,'Kit dual channel 2x8GB DDR4 3200MHz.',750000,680000,NULL,NULL,'Lifetime',1,1,20,2,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-16 06:50:36'),(6,'GPU-MSI-4060','MSI RTX 4060 Ventus 2X 8GB','msi-rtx-4060-ventus-2x-8gb',3,NULL,NULL,'Kapasitas',4,'RTX 4060 8GB GDDR6, dual fan, 1080p gaming ray tracing.',5650000,5250000,NULL,NULL,'3 Tahun Resmi',1,0,6,3,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-12 03:06:06'),(7,'GPU-GLB-3050','Gigabyte RTX 3050 Eagle OC 8GB','gigabyte-rtx-3050-eagle-oc-8gb',3,NULL,NULL,'Kapasitas',5,'RTX 3050 8GB, entry 1080p gaming.',3500000,3200000,NULL,NULL,'2 Tahun Resmi',1,0,9,1,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-12 03:06:06'),(8,'SSD-SMG-1TB','Samsung 980 1TB NVMe M.2','samsung-980-1tb-nvme',5,NULL,NULL,'Kapasitas',8,'NVMe PCIe 3.0 x4, read up to 3500MB/s.',1250000,1100000,NULL,NULL,'5 Tahun Resmi',1,1,18,6,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-16 22:15:03'),(9,'PSU-CM-550W','Cooler Master MWE 550W 80+ Bronze','cooler-master-mwe-550w-bronze',7,NULL,NULL,'Kapasitas',10,'550W 80+ Bronze, non modular.',750000,670000,NULL,NULL,'5 Tahun',1,1,14,1,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-10-22 21:01:54'),(10,'PSU-CRS-650W','Corsair CV650 650W 80+ Bronze','corsair-cv650-650w-bronze',7,NULL,NULL,'Kapasitas',6,'650W 80+ Bronze.',950000,860000,NULL,NULL,'3 Tahun',1,0,7,1,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-11 04:15:34'),(11,'CASE-LL-Q58','Lian Li Q58 White (ITX)','lian-li-q58-white',8,NULL,NULL,'Kapasitas',9,'Mini ITX, dual chamber, tempered glass.',2490000,2250000,NULL,NULL,'1 Tahun',1,0,4,1,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-12 03:06:06'),(12,'CASE-CM-MB600','Cooler Master MasterBox MB600L V2','cooler-master-masterbox-mb600l-v2',8,NULL,NULL,'Kapasitas',10,'Micro ATX / ATX, mesh front.',720000,650000,NULL,NULL,'1 Tahun',1,1,11,1,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-02 16:27:57'),(13,'CLR-DC-AG400','DeepCool AG400','deepcool-ag400',9,NULL,NULL,'Kapasitas',11,'Tower cooler single fan, height 155mm.',420000,370000,NULL,NULL,'1 Tahun',1,1,13,1,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-01 14:56:05'),(14,'CLR-DC-AK400','DeepCool AK400','deepcool-ak400',9,NULL,NULL,'Kapasitas',11,'Tower cooler, height 160mm.',520000,460000,NULL,NULL,'1 Tahun',1,0,9,1,NULL,NULL,NULL,'2026-10-15 20:29:28','2026-11-02 03:02:12'),(15,'RAM-SMSG-DDR34','RAM DDR3 4GB Longdimm','ram-ddr3-4gb-longdimm',4,NULL,NULL,'Kapasitas',8,'RAM DDR3 12800U Longdimm',145000,120000,NULL,NULL,NULL,1,0,0,1,NULL,NULL,NULL,'2026-11-12 20:20:00','2026-11-15 20:26:18'),(16,'SSD-VNMRX-128gb','SSD SATA VenomRX 128GB','ssd-sata-venomrx-128gb',5,'ssd-sata-venomrx','128GB','Kapasitas',13,'Spesifikasi Produk :\n\n\n\nStorage Capacity : 128GB / 256GB / 512GB / 1TB\n\nForm factor : 2.5\" SATA III (6Gb/s)\n\nMax sequential read speed : 545MB/s\n\nMax sequential write speed : 435MB/s\n\nDimensions (L × W × H) : 100 mm x 69 mm x 7 mm\n\n',520000,400000,NULL,'100 mm x 69 mm x 7 mm','3 Tahun Garansi Resmi',1,0,0,23,NULL,NULL,NULL,'2026-11-12 23:31:04','2026-11-17 00:10:04'),(17,'SSD-VNMRX-256GB','SSD SATA VenomRX 256GB','ssd-sata-venomrx-256gb',5,'ssd-sata-venomrx','256GB','Kapasitas',13,'Spesifikasi Produk :\n\n\n\nStorage Capacity : 128GB / 256GB / 512GB / 1TB\n\nForm factor : 2.5\" SATA III (6Gb/s)\n\nMax sequential read speed : 545MB/s\n\nMax sequential write speed : 435MB/s\n\nDimensions (L × W × H) : 100 mm x 69 mm x 7 mm\n\n',754000,580000,NULL,'100 mm x 69 mm x 7 mm','3 Tahun Garansi Resmi',1,0,0,7,NULL,NULL,NULL,'2026-11-16 21:17:26','2026-11-17 00:04:58'),(18,'SSD-VNMRX-512GB','SSD SATA VenomRX 512GB','ssd-sata-venomrx-512gb',5,'ssd-sata-venomrx','512GB','Kapasitas',13,'Spesifikasi Produk :\n\n\n\nStorage Capacity : 128GB / 256GB / 512GB / 1TB\n\nForm factor : 2.5\" SATA III (6Gb/s)\n\nMax sequential read speed : 545MB/s\n\nMax sequential write speed : 435MB/s\n\nDimensions (L × W × H) : 100 mm x 69 mm x 7 mm\n\n',1300000,1000000,NULL,'100 mm x 69 mm x 7 mm','3 Tahun Garansi Resmi',1,0,0,6,NULL,NULL,NULL,'2026-11-16 21:17:26','2026-11-17 00:04:40'),(19,'SSD-VNMRX-1TB','SSD SATA VenomRX 1TB','ssd-sata-venomrx-1tb',5,'ssd-sata-venomrx','1TB','Kapasitas',13,'Spesifikasi Produk :\n\n\n\nStorage Capacity : 128GB / 256GB / 512GB / 1TB\n\nForm factor : 2.5\" SATA III (6Gb/s)\n\nMax sequential read speed : 545MB/s\n\nMax sequential write speed : 435MB/s\n\nDimensions (L × W × H) : 100 mm x 69 mm x 7 mm\n\n',2730000,2100000,NULL,'100 mm x 69 mm x 7 mm','3 Tahun Garansi Resmi',1,0,0,3,NULL,NULL,NULL,'2026-11-16 21:17:26','2026-11-17 00:04:05'),(20,'SSD-VGEN-PLAT-128GB','V-GeN PLATINUM SSD SATA III 2.5\" 128 GB','v-gen-ssd-platinum-sata-iii-128gb',5,'vgen-ssd-platinum-sata','128GB','Kapasitas',14,'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:\n\n• Brand: V-GeN\n• Model: Platinum SOLID Series\n• Form Factor: 2.5 Inch (7mm Ultra Slim)\n• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)\n• Controller: High Quality Controller\n• Kecepatan Baca (Read): Up to 550 MB/s\n• Kecepatan Tulis (Write): Up to 477 - 520 MB/s\n• Dimensi: 100 x 70 x 7 mm\n• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',647000,498000,NULL,'100 x 70 x 7 mm','3 Tahun Garansi Resmi V-GeN',1,1,0,16,NULL,NULL,NULL,'2026-11-16 22:22:15','2026-11-16 23:17:32'),(21,'SSD-VGEN-PLAT-256GB','V-GeN PLATINUM SSD SATA III 2.5\" 256 GB','v-gen-ssd-platinum-sata-iii-256gb',5,'vgen-ssd-platinum-sata','256GB','Kapasitas',14,'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:\n\n• Brand: V-GeN\n• Model: Platinum SOLID Series\n• Form Factor: 2.5 Inch (7mm Ultra Slim)\n• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)\n• Controller: High Quality Controller\n• Kecepatan Baca (Read): Up to 550 MB/s\n• Kecepatan Tulis (Write): Up to 477 - 520 MB/s\n• Dimensi: 100 x 70 x 7 mm\n• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',1167000,898000,NULL,'100 x 70 x 7 mm','3 Tahun Garansi Resmi V-GeN',1,0,0,3,NULL,NULL,NULL,'2026-11-16 22:22:15','2026-11-16 23:17:32'),(22,'SSD-VGEN-PLAT-512GB','V-GeN PLATINUM SSD SATA III 2.5\" 512 GB','v-gen-ssd-platinum-sata-iii-512gb',5,'vgen-ssd-platinum-sata','512GB','Kapasitas',14,'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:\n\n• Brand: V-GeN\n• Model: Platinum SOLID Series\n• Form Factor: 2.5 Inch (7mm Ultra Slim)\n• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)\n• Controller: High Quality Controller\n• Kecepatan Baca (Read): Up to 550 MB/s\n• Kecepatan Tulis (Write): Up to 477 - 520 MB/s\n• Dimensi: 100 x 70 x 7 mm\n• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',2077000,1598000,NULL,'100 x 70 x 7 mm','3 Tahun Garansi Resmi V-GeN',1,0,0,3,NULL,NULL,NULL,'2026-11-16 22:22:15','2026-11-16 23:17:32'),(23,'SSD-VGEN-PLAT-1TB','V-GeN PLATINUM SSD SATA III 2.5\" 1 TB','v-gen-ssd-platinum-sata-iii-1tb',5,'vgen-ssd-platinum-sata','1TB','Kapasitas',14,'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:\n\n• Brand: V-GeN\n• Model: Platinum SOLID Series\n• Form Factor: 2.5 Inch (7mm Ultra Slim)\n• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)\n• Controller: High Quality Controller\n• Kecepatan Baca (Read): Up to 550 MB/s\n• Kecepatan Tulis (Write): Up to 477 - 520 MB/s\n• Dimensi: 100 x 70 x 7 mm\n• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',4144000,3188000,NULL,'100 x 70 x 7 mm','3 Tahun Garansi Resmi V-GeN',1,0,0,3,NULL,NULL,NULL,'2026-11-16 22:22:15','2026-11-17 00:02:47'),(24,'SSD-VGEN-PLAT-2TB','V-GeN PLATINUM SSD SATA III 2.5\" 2 TB','v-gen-ssd-platinum-sata-iii-2tb',5,'vgen-ssd-platinum-sata','2TB','Kapasitas',14,'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:\n\n• Brand: V-GeN\n• Model: Platinum SOLID Series\n• Form Factor: 2.5 Inch (7mm Ultra Slim)\n• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)\n• Controller: High Quality Controller\n• Kecepatan Baca (Read): Up to 550 MB/s\n• Kecepatan Tulis (Write): Up to 477 - 520 MB/s\n• Dimensi: 100 x 70 x 7 mm\n• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',7524000,5788000,NULL,'100 x 70 x 7 mm','3 Tahun Garansi Resmi V-GeN',1,0,0,1,NULL,NULL,NULL,'2026-11-16 22:56:49','2026-11-16 23:17:32'),(25,'SSD-VGEN-PLAT-4TB','V-GeN PLATINUM SSD SATA III 2.5\" 4 TB','v-gen-ssd-platinum-sata-iii-4tb',5,'vgen-ssd-platinum-sata','4TB','Kapasitas',14,'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:\n\n• Brand: V-GeN\n• Model: Platinum SOLID Series\n• Form Factor: 2.5 Inch (7mm Ultra Slim)\n• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)\n• Controller: High Quality Controller\n• Kecepatan Baca (Read): Up to 550 MB/s\n• Kecepatan Tulis (Write): Up to 477 - 520 MB/s\n• Dimensi: 100 x 70 x 7 mm\n• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',12074000,9288000,NULL,'100 x 70 x 7 mm','3 Tahun Garansi Resmi V-GeN',1,0,0,2,NULL,NULL,NULL,'2026-11-16 22:56:49','2026-11-16 23:17:32'),(26,'SSD-VGEN-HYPER-128GB','V-GeN HYPER SSD M.2 NVMe 128 GB','v-gen-hyper-ssd-m2-nvme-128gb',5,'vgen-hyper-nvme','128GB','Kapasitas',14,'Spesifikasi V-GeN HYPER SSD M.2 NVMe PCIe Gen 3.0 x4:\n\n• Brand: V-GeN\n• Series: HYPER Series\n• Form Factor: M.2 2280 (NGFF)\n• Interface: PCIe Gen 3.0 x4, NVMe 1.3\n• Kecepatan Baca (Read): Up to 3.500 MB/s\n• Kecepatan Tulis (Write): Up to 2.500 MB/s\n• Controller: High Performance NVMe Controller\n• Fitur: TRIM Support, Auto Garbage Collection, S.M.A.R.T, Low Power Management\n• Dimensi: 80.15 x 22.15 x 2.38 mm\n• Garansi: 5 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk laptop gaming, PC desktop motherboard modern dengan slot M.2 NVMe, rendering video, dan multitasking berat.',715000,550000,NULL,'80 x 22 x 2.4 mm','5 Tahun Garansi Resmi V-GeN',1,1,0,1,NULL,NULL,NULL,'2026-11-16 23:10:29','2026-11-16 23:17:32'),(27,'SSD-VGEN-HYPER-256GB','V-GeN HYPER SSD M.2 NVMe 256 GB','v-gen-hyper-ssd-m2-nvme-256gb',5,'vgen-hyper-nvme','256GB','Kapasitas',14,'Spesifikasi V-GeN HYPER SSD M.2 NVMe PCIe Gen 3.0 x4:\n\n• Brand: V-GeN\n• Series: HYPER Series\n• Form Factor: M.2 2280 (NGFF)\n• Interface: PCIe Gen 3.0 x4, NVMe 1.3\n• Kecepatan Baca (Read): Up to 3.500 MB/s\n• Kecepatan Tulis (Write): Up to 2.500 MB/s\n• Controller: High Performance NVMe Controller\n• Fitur: TRIM Support, Auto Garbage Collection, S.M.A.R.T, Low Power Management\n• Dimensi: 80.15 x 22.15 x 2.38 mm\n• Garansi: 5 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk laptop gaming, PC desktop motherboard modern dengan slot M.2 NVMe, rendering video, dan multitasking berat.',1235000,950000,NULL,'80 x 22 x 2.4 mm','5 Tahun Garansi Resmi V-GeN',1,0,0,2,NULL,NULL,NULL,'2026-11-16 23:10:29','2026-11-17 00:10:25'),(28,'SSD-VGEN-HYPER-512GB','V-GeN HYPER SSD M.2 NVMe 512 GB','v-gen-hyper-ssd-m2-nvme-512gb',5,'vgen-hyper-nvme','512GB','Kapasitas',14,'Spesifikasi V-GeN HYPER SSD M.2 NVMe PCIe Gen 3.0 x4:\n\n• Brand: V-GeN\n• Series: HYPER Series\n• Form Factor: M.2 2280 (NGFF)\n• Interface: PCIe Gen 3.0 x4, NVMe 1.3\n• Kecepatan Baca (Read): Up to 3.500 MB/s\n• Kecepatan Tulis (Write): Up to 2.500 MB/s\n• Controller: High Performance NVMe Controller\n• Fitur: TRIM Support, Auto Garbage Collection, S.M.A.R.T, Low Power Management\n• Dimensi: 80.15 x 22.15 x 2.38 mm\n• Garansi: 5 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk laptop gaming, PC desktop motherboard modern dengan slot M.2 NVMe, rendering video, dan multitasking berat.',2145000,1650000,NULL,'80 x 22 x 2.4 mm','5 Tahun Garansi Resmi V-GeN',1,0,0,0,NULL,NULL,NULL,'2026-11-16 23:10:29','2026-11-16 23:17:32'),(29,'SSD-VGEN-HYPER-1TB','V-GeN HYPER SSD M.2 NVMe 1 TB','v-gen-hyper-ssd-m2-nvme-1tb',5,'vgen-hyper-nvme','1TB','Kapasitas',14,'Spesifikasi V-GeN HYPER SSD M.2 NVMe PCIe Gen 3.0 x4:\n\n• Brand: V-GeN\n• Series: HYPER Series\n• Form Factor: M.2 2280 (NGFF)\n• Interface: PCIe Gen 3.0 x4, NVMe 1.3\n• Kecepatan Baca (Read): Up to 3.500 MB/s\n• Kecepatan Tulis (Write): Up to 2.500 MB/s\n• Controller: High Performance NVMe Controller\n• Fitur: TRIM Support, Auto Garbage Collection, S.M.A.R.T, Low Power Management\n• Dimensi: 80.15 x 22.15 x 2.38 mm\n• Garansi: 5 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)\n\nCocok untuk laptop gaming, PC desktop motherboard modern dengan slot M.2 NVMe, rendering video, dan multitasking berat.',4225000,3250000,NULL,'80 x 22 x 2.4 mm','5 Tahun Garansi Resmi V-GeN',1,0,0,0,NULL,NULL,NULL,'2026-11-16 23:10:29','2026-11-16 23:17:32'),(30,'CPU-INT-I3-6100-TRAY','Intel Core i3-6100 Tray','intel-core-i3-6100-tray',1,NULL,NULL,'Kapasitas',2,'Processor Intel Core i3-6100 Skylake (Tray)\n\nSpesifikasi Produk:\n• Brand: Intel\n• Model: Core i3-6100 (Generasi ke-6 / Skylake)\n• Kondisi: Tray (OEM Unit)\n• Socket: LGA 1151\n• Jumlah Core: 2 Cores\n• Jumlah Threads: 4 Threads\n• Base Frequency: 3.70 GHz\n• Intel Smart Cache: 3 MB\n• TDP: 51 Watt\n• Integrated Graphics: Intel HD Graphics 530\n• Garansi: 1 Bulan Garansi Toko (Tukar Unit)\n\nKompatibilitas Motherboard:\n- Chipset Intel Seri 100 & 200 (H110, B150, B250, H170, Z170, Z270)\n- Support Memory DDR4 / DDR3L',267000,205000,NULL,NULL,'1 Bulan Garansi Toko',1,1,0,3,NULL,NULL,NULL,'2026-11-17 00:25:39','2026-11-17 01:06:54'),(31,'CPU-INT-I5-6500-TRAY','Intel Core i5-6500 Tray','intel-core-i5-6500-tray',1,NULL,NULL,'Kapasitas',2,'Processor Intel Core i5-6500 Skylake (Tray)\n\nSpesifikasi Produk:\n• Brand: Intel\n• Model: Core i5-6500 (Generasi ke-6 / Skylake)\n• Kondisi: Tray (OEM Unit)\n• Socket: LGA 1151\n• Jumlah Core: 4 Cores\n• Jumlah Threads: 4 Threads\n• Base Frequency: 3.20 GHz\n• Max Turbo Frequency: 3.60 GHz\n• Intel Smart Cache: 6 MB\n• TDP: 65 Watt\n• Integrated Graphics: Intel HD Graphics 530\n• Garansi: 1 Bulan Garansi Toko (Tukar Unit)\n\nKompatibilitas Motherboard:\n- Chipset Intel Seri 100 & 200 (H110, B150, B250, H170, Z170, Z270)\n- Support Memory DDR4 / DDR3L',663000,510000,NULL,NULL,'1 Bulan Garansi Toko',1,1,0,2,NULL,NULL,NULL,'2026-11-17 01:01:40','2026-11-17 03:28:09'),(32,'CPU-INT-I7-6700-TRAY','Intel Core i7-6700 Tray','intel-core-i7-6700-tray',1,NULL,NULL,'Kapasitas',2,'Processor Intel Core i7-6700 Skylake (Tray)\n\nSpesifikasi Produk:\n• Brand: Intel\n• Model: Core i7-6700 (Generasi ke-6 / Skylake)\n• Kondisi: Tray (OEM Unit)\n• Socket: LGA 1151\n• Jumlah Core: 4 Cores\n• Jumlah Threads: 8 Threads (Hyper-Threading)\n• Base Frequency: 3.40 GHz\n• Max Turbo Frequency: 4.00 GHz\n• Intel Smart Cache: 8 MB\n• TDP: 65 Watt\n• Integrated Graphics: Intel HD Graphics 530\n• Garansi: 1 Bulan Garansi Toko (Tukar Unit)\n\nKompatibilitas Motherboard:\n- Chipset Intel Seri 100 & 200 (H110, B150, B250, H170, Z170, Z270)\n- Support Memory DDR4 / DDR3L',1235000,950000,NULL,NULL,'1 Bulan Garansi Toko',1,1,0,5,NULL,NULL,NULL,'2026-11-17 01:01:40','2026-11-17 03:33:37'),(33,'CPU-INT-I3-7100-TRAY','Intel Core i3-7100 Tray','intel-core-i3-7100-tray',1,NULL,NULL,'Kapasitas',2,'Processor Intel Core i3-7100 Kaby Lake (Tray)\n\nSpesifikasi Produk:\n• Brand: Intel\n• Model: Core i3-7100 (Generasi ke-7 / Kaby Lake)\n• Kondisi: Tray (OEM Unit)\n• Socket: LGA 1151\n• Jumlah Core: 2 Cores\n• Jumlah Threads: 4 Threads\n• Base Frequency: 3.90 GHz\n• Intel Smart Cache: 3 MB\n• TDP: 51 Watt\n• Integrated Graphics: Intel HD Graphics 630\n• Garansi: 1 Bulan Garansi Toko (Tukar Unit)\n\nKompatibilitas Motherboard:\n- Chipset Intel Seri 100 & 200 (H110, B150, B250, H270, Z270)\n- Support Memory DDR4 / DDR3L',312000,240000,NULL,NULL,'1 Bulan Garansi Toko',1,1,0,1,NULL,NULL,NULL,'2026-11-17 01:01:40','2026-11-17 03:30:03'),(34,'CPU-INT-I5-7500-TRAY','Intel Core i5-7500 Tray','intel-core-i5-7500-tray',1,NULL,NULL,'Kapasitas',2,'Processor Intel Core i5-7500 Kaby Lake (Tray)\n\nSpesifikasi Produk:\n• Brand: Intel\n• Model: Core i5-7500 (Generasi ke-7 / Kaby Lake)\n• Kondisi: Tray (OEM Unit)\n• Socket: LGA 1151\n• Jumlah Core: 4 Cores\n• Jumlah Threads: 4 Threads\n• Base Frequency: 3.40 GHz\n• Max Turbo Frequency: 3.80 GHz\n• Intel Smart Cache: 6 MB\n• TDP: 65 Watt\n• Integrated Graphics: Intel HD Graphics 630\n• Garansi: 1 Bulan Garansi Toko (Tukar Unit)\n\nKompatibilitas Motherboard:\n- Chipset Intel Seri 100 & 200 (H110, B150, B250, H270, Z270)\n- Support Memory DDR4 / DDR3L',813000,625000,NULL,NULL,'1 Bulan Garansi Toko',1,1,0,1,NULL,NULL,NULL,'2026-11-17 01:01:40','2026-11-17 03:30:07');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qc_records`
--

DROP TABLE IF EXISTS `qc_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qc_records` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned DEFAULT NULL,
  `order_id` bigint unsigned DEFAULT NULL,
  `technician_id` bigint unsigned DEFAULT NULL,
  `checklist` json DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `result` enum('pass','fail','pending') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `checked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qc_records_service_id_foreign` (`service_id`),
  KEY `qc_records_order_id_foreign` (`order_id`),
  KEY `qc_records_technician_id_foreign` (`technician_id`),
  KEY `qc_records_result_index` (`result`),
  CONSTRAINT `qc_records_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `qc_records_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `qc_records_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qc_records`
--

LOCK TABLES `qc_records` WRITE;
/*!40000 ALTER TABLE `qc_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `qc_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotation_items`
--

DROP TABLE IF EXISTS `quotation_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotation_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `quotation_id` bigint unsigned NOT NULL,
  `item_type` enum('product','service','labor','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'product',
  `product_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `price` bigint unsigned NOT NULL DEFAULT '0',
  `total` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotation_items_quotation_id_foreign` (`quotation_id`),
  KEY `quotation_items_product_id_foreign` (`product_id`),
  CONSTRAINT `quotation_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `quotation_items_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotation_items`
--

LOCK TABLES `quotation_items` WRITE;
/*!40000 ALTER TABLE `quotation_items` DISABLE KEYS */;
INSERT INTO `quotation_items` VALUES (1,1,'product',16,'SSD Sata VenomRX 128gb',NULL,1,400000,400000,'2026-11-12 23:34:39','2026-11-12 23:34:39'),(2,1,'product',15,'RAM DDR3 4GB Longdimm',NULL,1,140000,140000,'2026-11-12 23:34:39','2026-11-12 23:34:39'),(3,1,'labor',NULL,'Instalasi windows + Office',NULL,1,125000,125000,'2026-11-12 23:34:39','2026-11-12 23:34:39'),(4,2,'product',16,'SSD Sata VenomRX 128gb',NULL,1,400000,400000,'2026-11-12 23:37:46','2026-11-12 23:37:46'),(5,2,'product',15,'RAM DDR3 4GB Longdimm',NULL,1,145000,145000,'2026-11-12 23:37:46','2026-11-12 23:37:46'),(6,2,'labor',NULL,'Instalasi Windows + Office',NULL,1,125000,125000,'2026-11-12 23:37:46','2026-11-12 23:37:46');
/*!40000 ALTER TABLE `quotation_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotations`
--

DROP TABLE IF EXISTS `quotations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `pc_build_id` bigint unsigned DEFAULT NULL,
  `quotation_date` date NOT NULL,
  `expired_date` date DEFAULT NULL,
  `subtotal` bigint unsigned NOT NULL DEFAULT '0',
  `discount` bigint unsigned NOT NULL DEFAULT '0',
  `shipping` bigint unsigned NOT NULL DEFAULT '0',
  `total` bigint unsigned NOT NULL DEFAULT '0',
  `status` enum('draft','sent','accepted','rejected','expired','converted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `terms` text COLLATE utf8mb4_unicode_ci,
  `order_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotations_code_unique` (`code`),
  KEY `quotations_customer_id_foreign` (`customer_id`),
  KEY `quotations_pc_build_id_foreign` (`pc_build_id`),
  KEY `quotations_order_id_foreign` (`order_id`),
  KEY `quotations_status_index` (`status`),
  CONSTRAINT `quotations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `quotations_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `quotations_pc_build_id_foreign` FOREIGN KEY (`pc_build_id`) REFERENCES `pc_builds` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotations`
--

LOCK TABLES `quotations` WRITE;
/*!40000 ALTER TABLE `quotations` DISABLE KEYS */;
INSERT INTO `quotations` VALUES (1,'QT-202611-001',NULL,NULL,'2026-11-13','2026-11-27',665000,0,0,665000,'sent',NULL,NULL,NULL,'2026-11-12 23:34:38','2026-11-12 23:35:37'),(2,'QT-202611-002',7,NULL,'2026-11-13','2026-11-27',670000,0,0,670000,'draft',NULL,NULL,NULL,'2026-11-12 23:37:46','2026-11-12 23:37:46');
/*!40000 ALTER TABLE `quotations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_devices`
--

DROP TABLE IF EXISTS `service_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_devices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `device_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_specs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completeness` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `problem_description` text COLLATE utf8mb4_unicode_ci,
  `diagnosis` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_devices_service_id_sort_order_index` (`service_id`,`sort_order`),
  CONSTRAINT `service_devices_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_devices`
--

LOCK TABLES `service_devices` WRITE;
/*!40000 ALTER TABLE `service_devices` DISABLE KEYS */;
INSERT INTO `service_devices` VALUES (1,1,'ROG STRIX','troubleshooting','00327-35847-39110-AAOEM','Intel(R) Core(TM) i7-9750H CPU @ 2.60GHz (2.59 GHz)','Lengkap','Baterai tidak bisa tambah atau berkurang saat di charger dan  Sering mati ketika render','Baterai drop karena 88% stuck.',NULL,NULL,0,'2026-10-24 19:32:13','2026-10-31 04:58:42'),(2,2,'HP 15-da0xxx','other',NULL,'ie-7020U, 8gb',NULL,'LCD warna Pink, Baterai replace','ganti LCD dan Ganti Baterai ',NULL,NULL,0,'2026-10-31 04:25:08','2026-10-31 04:46:45'),(3,3,'Asus AIO','troubleshooting',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'2026-10-31 18:31:30','2026-10-31 18:31:30'),(4,4,'PC Gemeng Rakitan','hardware_checking',NULL,NULL,NULL,'Motherboard ny Intel g ad kak.\n\nKOMPONEN BAWAAN KLIENT:\nI5-12400f, RTX 4060',NULL,NULL,NULL,0,'2026-11-10 23:32:47','2026-11-10 23:32:47');
/*!40000 ALTER TABLE `service_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_items`
--

DROP TABLE IF EXISTS `service_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `service_device_id` bigint unsigned DEFAULT NULL,
  `item_type` enum('product','labor','customer_owned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'labor',
  `part_source` enum('keehub','vendor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'keehub',
  `product_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `warranty_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int unsigned NOT NULL DEFAULT '1',
  `price` bigint unsigned NOT NULL DEFAULT '0',
  `total` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_items_service_id_foreign` (`service_id`),
  KEY `service_items_product_id_foreign` (`product_id`),
  KEY `service_items_item_type_index` (`item_type`),
  KEY `service_items_part_source_index` (`part_source`),
  KEY `service_items_service_device_id_foreign` (`service_device_id`),
  CONSTRAINT `service_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  CONSTRAINT `service_items_service_device_id_foreign` FOREIGN KEY (`service_device_id`) REFERENCES `service_devices` (`id`) ON DELETE SET NULL,
  CONSTRAINT `service_items_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_items`
--

LOCK TABLES `service_items` WRITE;
/*!40000 ALTER TABLE `service_items` DISABLE KEYS */;
INSERT INTO `service_items` VALUES (1,1,1,'product','keehub',NULL,'Baterai Laptop ROG STRIX','KVN202510(P)',NULL,1,661000,661000,'2026-10-24 19:32:13','2026-10-25 03:39:39'),(5,1,1,'product','keehub',NULL,'Cooling Pad Rexus B145',NULL,NULL,1,230000,230000,'2026-10-24 20:57:31','2026-10-24 20:59:59'),(6,1,1,'labor','keehub',NULL,'Pasang dan Repair Housing bottom case',NULL,NULL,1,150000,150000,'2026-10-24 20:58:51','2026-10-24 20:58:51'),(7,2,2,'product','keehub',NULL,'LCD',NULL,NULL,1,850000,850000,'2026-10-31 04:25:08','2026-10-31 04:25:08'),(8,2,2,'product','keehub',NULL,'Baterai','CT8HUFT03TZCABIY','3 Bulan',1,350000,350000,'2026-10-31 04:25:08','2026-10-31 04:26:03'),(9,2,2,'labor','keehub',NULL,'Replace LCD dan Baterai',NULL,NULL,1,150000,150000,'2026-10-31 04:25:08','2026-10-31 04:46:45'),(10,3,3,'product','keehub',NULL,'Adaptor AIO Asus','5HY842(25)','6Bulan',1,350000,350000,'2026-10-31 18:31:30','2026-10-31 18:31:30');
/*!40000 ALTER TABLE `service_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_status_history`
--

DROP TABLE IF EXISTS `service_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_status_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `from_status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_status_history_service_id_foreign` (`service_id`),
  KEY `service_status_history_user_id_foreign` (`user_id`),
  CONSTRAINT `service_status_history_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_status_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_status_history`
--

LOCK TABLES `service_status_history` WRITE;
/*!40000 ALTER TABLE `service_status_history` DISABLE KEYS */;
INSERT INTO `service_status_history` VALUES (1,1,NULL,'processing','Servis baru dibuat oleh admin (B2B / Manual)',1,'2026-10-24 19:32:13','2026-10-24 19:32:13'),(2,2,NULL,'processing','Servis baru dibuat oleh admin (B2B / Manual)',1,'2026-10-31 04:25:08','2026-10-31 04:25:08'),(3,1,'processing','testing',NULL,1,'2026-10-31 04:58:18','2026-10-31 04:58:18'),(4,1,'testing','ready',NULL,1,'2026-10-31 04:58:34','2026-10-31 04:58:34'),(5,1,'ready','completed',NULL,1,'2026-10-31 04:58:42','2026-10-31 04:58:42'),(6,3,NULL,'ready','Servis baru dibuat oleh admin (B2B / Manual)',1,'2026-10-31 18:31:30','2026-10-31 18:31:30');
/*!40000 ALTER TABLE `service_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` enum('website','walk_in','whatsapp','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'website',
  `service_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_specs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completeness` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('received','checking','waiting_approval','processing','testing','ready','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'received',
  `due_date` date DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `problem_description` text COLLATE utf8mb4_unicode_ci,
  `diagnosis` text COLLATE utf8mb4_unicode_ci,
  `estimated_cost` bigint unsigned NOT NULL DEFAULT '0',
  `total_cost` bigint unsigned NOT NULL DEFAULT '0',
  `technician_id` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_code_unique` (`code`),
  UNIQUE KEY `services_invoice_number_unique` (`invoice_number`),
  KEY `services_technician_id_foreign` (`technician_id`),
  KEY `services_customer_id_status_index` (`customer_id`,`status`),
  KEY `services_service_type_index` (`service_type`),
  KEY `services_status_index` (`status`),
  CONSTRAINT `services_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `services_technician_id_foreign` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'SVC-20261025-001','INV-SVC-20261025-001',3,NULL,'admin','troubleshooting','ROG STRIX','00327-35847-39110-AAOEM','Intel(R) Core(TM) i7-9750H CPU @ 2.60GHz (2.59 GHz)','Lengkap','completed','2026-10-26',NULL,'Baterai tidak bisa tambah atau berkurang saat di charger dan  Sering mati ketika render','Baterai drop karena 88% stuck.',0,1041000,1,'Pengunci casing banyak yang sudah aus ','2026-10-24 19:32:13','2026-10-31 04:58:42'),(2,'SVC-20261031-001','INV-SVC-20261031-001',4,NULL,'walk_in','other','HP 15-da0xxx',NULL,'ie-7020U, 8gb',NULL,'processing','2026-11-02',NULL,'LCD warna Pink, Baterai replace','ganti LCD dan Ganti Baterai ',0,1350000,1,NULL,'2026-10-31 04:25:08','2026-10-31 04:46:45'),(3,'SVC-20261101-001','INV-SVC-20261101-001',5,'Karya Indra Mandiri','admin','troubleshooting','Asus AIO',NULL,NULL,NULL,'ready','2026-11-02',NULL,NULL,NULL,0,350000,1,NULL,'2026-10-31 18:31:30','2026-10-31 18:31:30'),(4,'SVC-20261111-001','INV-SVC-20261111-001',6,'PT. MBG Mundur Bersama','website','hardware_checking','PC Gemeng Rakitan',NULL,NULL,NULL,'received',NULL,NULL,'Motherboard ny Intel g ad kak.\n\nKOMPONEN BAWAAN KLIENT:\nI5-12400f, RTX 4060',NULL,0,0,NULL,NULL,'2026-11-10 23:32:47','2026-11-10 23:32:47');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('1Oy7HF24bybN31apwtw9JezUtqFBpwPa6bPtXGqb',NULL,'2404:8000:101d:31d0:a960:c72f:f160:4292','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','eyJfdG9rZW4iOiI1dGtFVmRRMHZyMHUzMzM5cmpnNU1TOTRoODFrRmJ2aHh1dEdzV0ViIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9rZWVodWIua2VldGVjaC5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjp7ImludGVuZGVkIjoiaHR0cHM6XC9cL2tlZWh1Yi5rZWV0ZWNoLm15LmlkXC9hZG1pblwvcHJvZHVjdHNcLzMyXC9lZGl0In19',1794925478),('4iqNMTADc0oK3TQmtPcU3GURHpVBuSPVTqkkI21f',NULL,'34.136.164.98','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJpc2lqRlNHaDlScWt4R0QxVVB4bk5KS3N3emlYeWlId0VTa1hDdEc5IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9rZWVodWIua2VldGVjaC5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794919168),('fJVRnNY1oomGK2xjlKun6UmqTEvYwoKZw4HGOxjx',NULL,'16.216.88.102','Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; Reflectionbot/1.0; +https://reflection.ai/bot) Chrome/151.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJYcDBOT3NZZEJZcUVMeFlTRkZOdUw4bVNwNndQRm13YmxWelllV2t3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9rZWVodWIua2VldGVjaC5teS5pZFwvcHJvZHVrXC9tc2ktYjU1MG0tcHJvLXZkaC13aWZpIiwicm91dGUiOiJzaG9wLnNob3cifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794936708),('FOyU596aotKuq8cxK8HSLsLnjnJYmUKc5cIwZetb',NULL,'2400:9800:a00:37f6:ff6:becc:b43e:e902','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Mobile Safari/537.36','eyJfdG9rZW4iOiJVUzl0VnBFNlE2eGJqNmJNNjc0bG1MWGdyaE94MDRBTjdQMGk3YThKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9rZWVodWIua2VldGVjaC5teS5pZFwvYnVpbGRlclwvYXBpXC9jb21wb25lbnRzXC9ncHU/aXRlbXMlNUJjcHUlNUQ9MiZpdGVtcyU1QnJhbSU1RD01Iiwicm91dGUiOiJidWlsZGVyLmNvbXBvbmVudHMifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1794920531),('gK5qU7uVWDilN50GFtt33lKGueiUQcattbtdJAXO',NULL,'182.8.193.221','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ4S0VJZjFJdjRwQVRtSjNzbTUyUENpTjRBNEFPWmowUVJXU2EwUDJDIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9rZWVodWIua2VldGVjaC5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794963233),('hmfvgl7zW5VaTNwCUITOXx7uWtghHz3BTyaFr2VS',NULL,'2404:8000:101d:31d0:b56b:4e5f:e19e:9323','WhatsApp/2.23.20.0','eyJfdG9rZW4iOiI4eENsQXlQbTViZjZ6aFhvZkdhZERYbUkyaGpQNDVMWnVKeUlWalJaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9rZWVodWIua2VldGVjaC5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794920203),('qRCD9p8zy0peRw2Ql7gw4CkqfH22tNrIRNTUK955',NULL,'2404:8000:101d:31d0:405c:9cfe:d24b:eb9b','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJmN0Z4ZjFHMFQ2OTRjWjVVT3BFcUVPQ3FQMk12NHN5VmVzeXg0UnYwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9rZWVodWIua2VldGVjaC5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794935258),('xfBkEB3YoTzwccjaKgZ5ooIiWsrc5k4TnwRa3hjo',NULL,'2404:8000:101d:31d0:b56b:4e5f:e19e:9323','Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.6.1 Mobile/15E148 Safari/604.1','eyJfdG9rZW4iOiJDellQbGxDRlpVSk9BanpsUEFmbXZSaE9ScFB6emMyNHRCSmJJdE1SIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9rZWVodWIua2VldGVjaC5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1794920443);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('bank_account_holder','Yoga Aris Purwanto','2026-10-16 19:23:56','2026-10-24 19:48:36'),('bank_account_number','8030808861','2026-10-16 19:23:55','2026-10-24 19:48:36'),('bank_name','BCA','2026-10-16 19:23:55','2026-10-24 19:48:36'),('courier_api_enabled','0','2026-10-16 19:23:56','2026-10-16 19:23:56'),('courier_api_key','','2026-10-16 19:23:56','2026-10-16 19:23:56'),('courier_api_provider','rajaongkir','2026-10-16 19:23:56','2026-10-16 19:23:56'),('courier_available_list','[\"jne\",\"jnt\",\"sicepat\"]','2026-10-16 19:23:57','2026-10-16 19:23:57'),('courier_coming_soon_note','Fitur cek ongkir otomatis via kurir segera hadir. Saat ini kami melayani Pickup di Toko atau koordinasi pengiriman langsung via WhatsApp.','2026-10-16 19:23:57','2026-10-16 19:23:57'),('courier_origin_city','Semarang','2026-10-16 19:23:56','2026-10-16 19:23:56'),('courier_origin_subdistrict','','2026-10-16 19:23:57','2026-10-16 19:23:57'),('hero_background','settings/01M7518FHXGC91WWX9P1TMTEB8.png','2026-11-11 03:07:42','2026-11-11 03:08:06'),('hero_background_fit','auto','2026-11-11 03:07:42','2026-11-11 03:07:42'),('hero_background_height','compact','2026-11-11 03:07:42','2026-11-11 03:07:42'),('hero_background_position','center','2026-11-11 03:07:42','2026-11-11 03:07:42'),('instagram_url','https://instagram.com/keehub','2026-10-15 20:29:28','2026-10-15 20:29:28'),('invoice_footer_notes','','2026-10-16 19:23:56','2026-10-16 19:23:56'),('invoice_header_brand','','2026-10-24 20:40:43','2026-10-24 20:40:43'),('invoice_header_contact','','2026-10-24 20:40:43','2026-10-24 20:40:43'),('invoice_header_tagline','','2026-10-24 20:40:43','2026-10-24 20:40:43'),('invoice_payment_instructions','','2026-10-24 20:40:43','2026-10-24 20:40:43'),('invoice_signature_name','','2026-10-24 20:40:43','2026-10-24 20:40:43'),('operating_hours','Senin - Sabtu: 10:00 - 20:00 WIB','2026-10-16 19:23:55','2026-10-16 19:23:55'),('printer_auto_cut','1','2026-10-16 19:23:56','2026-10-16 19:23:56'),('printer_connection_type','browser','2026-10-16 19:23:56','2026-10-16 19:23:56'),('printer_copies','1','2026-10-16 19:23:56','2026-10-16 19:23:56'),('printer_footer_text','Terima kasih telah berbelanja di KeeHub!','2026-10-16 19:23:56','2026-10-16 19:23:56'),('printer_header_text','','2026-10-16 19:23:56','2026-10-16 19:23:56'),('printer_name','Thermal Receipt Printer 58mm','2026-10-16 19:23:56','2026-10-16 19:23:56'),('printer_open_cash_drawer','0','2026-10-16 19:23:56','2026-10-16 19:23:56'),('printer_paper_size','58mm','2026-10-16 19:23:56','2026-10-16 19:23:56'),('printer_print_logo','1','2026-10-16 19:23:56','2026-10-16 19:23:56'),('service_invoice_footer','','2026-10-24 20:40:43','2026-10-24 20:40:43'),('service_warranty_terms','','2026-10-16 19:23:56','2026-10-16 19:23:56'),('shipping_cost','15000','2026-10-16 19:23:55','2026-10-16 19:23:55'),('stock_deduct_status','confirmed','2026-10-15 20:29:28','2026-10-15 20:29:28'),('store_address','Jl. Pudaksari V Bumirejo RT01 RW06','2026-10-15 20:29:28','2026-10-24 19:47:43'),('store_description','','2026-10-16 19:23:55','2026-10-16 19:23:55'),('store_email','','2026-10-16 19:23:55','2026-10-16 19:23:55'),('store_favicon','','2026-10-16 19:23:55','2026-10-27 07:31:59'),('store_logo','settings/01M5YWBS0HGHSD45Y6XMT01NZ5.png','2026-10-16 19:23:55','2026-10-27 07:31:23'),('store_name','KeeHub','2026-10-15 20:29:28','2026-10-15 20:29:28'),('store_tagline','Build. Buy. Upgrade.','2026-10-15 20:29:28','2026-10-15 20:29:28'),('tiktok_url','https://tiktok.com/@keehub','2026-10-15 20:29:28','2026-10-15 20:29:28'),('whatsapp_number','085799410169','2026-10-15 20:29:28','2026-10-24 20:40:43');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `courier` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_cost` bigint unsigned NOT NULL DEFAULT '0',
  `shipped_at` date DEFAULT NULL,
  `status` enum('preparing','shipped','in_transit','delivered','pickup') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'preparing',
  `is_pickup` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipments_order_id_foreign` (`order_id`),
  KEY `shipments_tracking_number_index` (`tracking_number`),
  KEY `shipments_status_index` (`status`),
  CONSTRAINT `shipments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipments`
--

LOCK TABLES `shipments` WRITE;
/*!40000 ALTER TABLE `shipments` DISABLE KEYS */;
/*!40000 ALTER TABLE `shipments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_movements`
--

DROP TABLE IF EXISTS `stock_movements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_movements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `type` enum('in','out','adjustment','reversal') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `stock_before` int unsigned NOT NULL,
  `stock_after` int unsigned NOT NULL,
  `reference_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stock_movements_user_id_foreign` (`user_id`),
  KEY `stock_movements_product_id_created_at_index` (`product_id`,`created_at`),
  KEY `stock_movements_reference_type_reference_id_index` (`reference_type`,`reference_id`),
  KEY `stock_movements_type_index` (`type`),
  CONSTRAINT `stock_movements_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_movements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_movements`
--

LOCK TABLES `stock_movements` WRITE;
/*!40000 ALTER TABLE `stock_movements` DISABLE KEYS */;
INSERT INTO `stock_movements` VALUES (1,15,'in',4,0,4,'manual',NULL,1,NULL,'2026-11-12 21:50:43','2026-11-12 21:50:43');
/*!40000 ALTER TABLE `stock_movements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('owner','staff','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Owner KeeHub','admin@keetech.my.id',NULL,'$2y$12$xe5DzgSt7UdMgPl5ZdsQiu3LbBFch86BVmH9VcP8IKINv7cMDfi0.','owner','081234567890',NULL,'2026-10-15 20:29:27','2026-10-15 20:29:27'),(2,'Staff Gudang','staff@keetech.my.id',NULL,'$2y$12$1QBCYsrWj7QK7XNeoxIPWOlOiF8LEcOnc6KVgb6nhpRbvyRVcJad6','staff','081234567891',NULL,'2026-10-15 20:29:28','2026-10-15 20:29:28'),(3,'Jokowi','ijaza@jokowi.com',NULL,'$2y$12$fb6PyAOlupRWULXu4xk8pe7VjJWfY/7zKHsqi59IRBuFYq6gWnCm.','customer',NULL,NULL,'2026-11-10 23:28:28','2026-11-10 23:28:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-18  8:00:31
