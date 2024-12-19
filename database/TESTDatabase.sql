CREATE DATABASE `gofuel_test` DEFAULT CHARACTER SET = 'utf8mb4';

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!50503 SET NAMES utf8 */
;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;
/*!40103 SET TIME_ZONE='+00:00' */
;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `auth_assignment` (
    `item_name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
    `user_id` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
    `created_at` int DEFAULT NULL,
    PRIMARY KEY (`item_name`, `user_id`),
    KEY `idx-auth_assignment-user_id` (`user_id`),
    CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `auth_item` (
    `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
    `type` smallint NOT NULL,
    `description` text COLLATE utf8mb3_unicode_ci,
    `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
    `data` blob,
    `created_at` int DEFAULT NULL,
    `updated_at` int DEFAULT NULL,
    PRIMARY KEY (`name`),
    KEY `rule_name` (`rule_name`),
    KEY `idx-auth_item-type` (`type`),
    CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `auth_item_child` (
    `parent` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
    `child` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
    PRIMARY KEY (`parent`, `child`),
    KEY `child` (`child`),
    CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `auth_rule` (
    `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
    `data` blob,
    `created_at` int DEFAULT NULL,
    `updated_at` int DEFAULT NULL,
    PRIMARY KEY (`name`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `categories` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `client_station`
--

DROP TABLE IF EXISTS `client_station`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `client_station` (
    `client_id` int NOT NULL,
    `station_id` int NOT NULL,
    PRIMARY KEY (`client_id`, `station_id`),
    KEY `fk_client_station_station` (`station_id`),
    CONSTRAINT `fk_client_station_client` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_client_station_station` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `invoice_lines`
--

DROP TABLE IF EXISTS `invoice_lines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `invoice_lines` (
    `id` int NOT NULL AUTO_INCREMENT,
    `item_id` int NOT NULL,
    `qty` double NOT NULL,
    `total` double NOT NULL,
    `invoice_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx-invoice_lines-invoice_id` (`invoice_id`),
    KEY `idx-invoice_lines-item_id` (`item_id`),
    CONSTRAINT `fk-invoice_lines-invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
    CONSTRAINT `fk-invoice_lines-item_id` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 18 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `invoice_states`
--

DROP TABLE IF EXISTS `invoice_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `invoice_states` (
    `id` int NOT NULL AUTO_INCREMENT,
    `description` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `invoices` (
    `id` int NOT NULL AUTO_INCREMENT,
    `client_id` int NOT NULL,
    `station_id` int NOT NULL,
    `invoice_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `total` double NOT NULL,
    `state_id` int NOT NULL DEFAULT '2',
    `code` varchar(45) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx-invoices-station_id` (`station_id`),
    KEY `idx-invoices-state_id` (`state_id`),
    KEY `idx-invoices-client_id` (`client_id`),
    CONSTRAINT `fk-invoices-client_id` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
    CONSTRAINT `fk-invoices-state_id` FOREIGN KEY (`state_id`) REFERENCES `invoice_states` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
    CONSTRAINT `fk-invoices-station_id` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 13 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `items` (
    `id` int NOT NULL AUTO_INCREMENT,
    `description` varchar(255) NOT NULL,
    `subcategory_id` int NOT NULL,
    `restock_qty` int NOT NULL,
    `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `fk_items_subcategory` (`subcategory_id`),
    CONSTRAINT `fk_items_subcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `manager_station`
--

DROP TABLE IF EXISTS `manager_station`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `manager_station` (
    `manager_id` int NOT NULL,
    `station_id` int NOT NULL,
    PRIMARY KEY (`manager_id`, `station_id`),
    KEY `fk_manager_station_station` (`station_id`),
    CONSTRAINT `fk_manager_station_manager` FOREIGN KEY (`manager_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_manager_station_station` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `pumps`
--

DROP TABLE IF EXISTS `pumps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `pumps` (
    `id` int NOT NULL AUTO_INCREMENT,
    `station_id` int NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_pumps_station` (`station_id`),
    CONSTRAINT `fk_pumps_station` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `station_items`
--

DROP TABLE IF EXISTS `station_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `station_items` (
    `station_id` int NOT NULL,
    `item_id` int NOT NULL,
    `price` decimal(10, 2) DEFAULT NULL,
    `stock` int NOT NULL DEFAULT '0',
    `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`station_id`, `item_id`),
    KEY `fk_station_items_item` (`item_id`),
    CONSTRAINT `fk_station_items_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_station_items_station` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `station_users`
--

DROP TABLE IF EXISTS `station_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `station_users` (
    `station_id` int NOT NULL,
    `user_id` int NOT NULL,
    PRIMARY KEY (`station_id`, `user_id`),
    KEY `fk_station_users_user` (`user_id`),
    CONSTRAINT `fk_station_users_station` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_station_users_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `stations`
--

DROP TABLE IF EXISTS `stations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `stations` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `address` varchar(255) NOT NULL,
    `postal_code` varchar(20) NOT NULL,
    `manager_id` int NOT NULL,
    `phone` varchar(45) DEFAULT NULL,
    `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `idx-stations-manager_id` (`manager_id`),
    CONSTRAINT `fk-stations-manager_id` FOREIGN KEY (`manager_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `subcategories` (
    `id` int NOT NULL AUTO_INCREMENT,
    `description` varchar(255) NOT NULL,
    `category_id` int NOT NULL,
    `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `fk_subcategories_category` (`category_id`),
    CONSTRAINT `fk_subcategories_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `user` (
    `id` int NOT NULL AUTO_INCREMENT,
    `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
    `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
    `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
    `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
    `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
    `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
    `status` smallint NOT NULL DEFAULT '10',
    `created_at` int NOT NULL,
    `updated_at` int NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `user_info` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `nif` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `address` varchar(255) DEFAULT NULL,
    `postal_code` varchar(255) DEFAULT NULL,
    `phone` varchar(15) DEFAULT NULL,
    `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
    `is_banned` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `fk_user_info_user` (`user_id`),
    CONSTRAINT `fk_user_info_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 8 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;

-- Dump completed on 2024-12-16 20:46:51