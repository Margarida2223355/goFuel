-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: gofuel
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Gasoline',0),(2,'Diesel',0),(3,'Snacks',0),(4,'Accessories',0),(5,'Tobacco',0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `client_station`
--

LOCK TABLES `client_station` WRITE;
/*!40000 ALTER TABLE `client_station` DISABLE KEYS */;
INSERT INTO `client_station` VALUES (5,2);
/*!40000 ALTER TABLE `client_station` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `invoice_lines`
--

LOCK TABLES `invoice_lines` WRITE;
/*!40000 ALTER TABLE `invoice_lines` DISABLE KEYS */;
INSERT INTO `invoice_lines` VALUES (10,5,2,2,8),(11,2,1,1.5,10),(12,1,10,13,11),(17,2,1,1.5,12);
/*!40000 ALTER TABLE `invoice_lines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `invoice_states`
--

LOCK TABLES `invoice_states` WRITE;
/*!40000 ALTER TABLE `invoice_states` DISABLE KEYS */;
INSERT INTO `invoice_states` VALUES (1,'Cart'),(2,'Pending'),(3,'Cancelled'),(4,'Finished');
/*!40000 ALTER TABLE `invoice_states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (8,5,2,'2024-10-31 21:22:19',2,2,'AQL1L6'),(10,5,1,'2024-11-04 19:24:55',1.5,2,'IZG4ME'),(11,5,1,'2024-11-12 21:02:36',13,4,'F3XMY9'),(12,5,1,'2024-11-14 18:52:23',1.6,1,NULL);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,'Unleaded 95 - 1L',1,1000,0),(2,'Unleaded 98 - 1L',2,1000,0),(3,'Diesel Regular - 1L',3,1200,0),(4,'Diesel Premium - 1L',4,1200,0),(5,'Pack of Chips',5,24,0),(8,'Car Charger',8,16,0);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `manager_station`
--

LOCK TABLES `manager_station` WRITE;
/*!40000 ALTER TABLE `manager_station` DISABLE KEYS */;
INSERT INTO `manager_station` VALUES (3,1),(3,2);
/*!40000 ALTER TABLE `manager_station` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `pumps`
--

LOCK TABLES `pumps` WRITE;
/*!40000 ALTER TABLE `pumps` DISABLE KEYS */;
/*!40000 ALTER TABLE `pumps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `station_items`
--

LOCK TABLES `station_items` WRITE;
/*!40000 ALTER TABLE `station_items` DISABLE KEYS */;
INSERT INTO `station_items` VALUES (1,1,1.30,5000,0),(1,2,1.60,5000,0),(1,3,1.00,25,0),(2,5,1.00,1000,0),(2,8,4.30,1000,0);
/*!40000 ALTER TABLE `station_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `station_users`
--

LOCK TABLES `station_users` WRITE;
/*!40000 ALTER TABLE `station_users` DISABLE KEYS */;
INSERT INTO `station_users` VALUES (2,3),(2,4);
/*!40000 ALTER TABLE `station_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `stations`
--

LOCK TABLES `stations` WRITE;
/*!40000 ALTER TABLE `stations` DISABLE KEYS */;
INSERT INTO `stations` VALUES (1,'Station 1','001 Main St','1000-001',2,'914241533',0),(2,'Station 2','002 Main St','1000-002',2,'236598556',0),(3,'Station 3','003 Main Nd','1000-003',2,'221896745',0);
/*!40000 ALTER TABLE `stations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` VALUES (1,'Unleaded 95',1,0),(2,'Unleaded 98',1,0),(3,'Diesel Regular',2,0),(4,'Diesel Premium',2,0),(5,'Chips',3,0),(6,'Soda',3,0),(7,'Car Fresheners',4,0),(8,'Car Chargers',4,0),(9,'Conventional Tobacco',5,0),(10,'Heated Tobacco',5,0),(14,'Leaded 95',1,0),(15,'Leaded 98',1,0),(16,'Rolling Tabacco',5,0),(17,'Filters',5,0);
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','adminAuthKey','$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.',NULL,'admin@example.com',NULL,10,0,0),(2,'manager','managerAuthKey','$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.',NULL,'manager@example.com',NULL,10,0,0),(3,'incharge','inchargeAuthKey','$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.',NULL,'incharge@example.com',NULL,10,0,0),(4,'employee','employeeAuthKey','$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.',NULL,'employee@example.com',NULL,10,0,0),(5,'client','clientAuthKey','$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.',NULL,'client@example.com',NULL,10,0,1731168731),(6,'cliente','clienteAuthKey','$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.',NULL,'cliente@example.com',NULL,10,0,0),(7,'teste','_YAsSf7caKtgmCBLPYNDGcgkoVqPl7Id','$2y$10$aWKuiO3Eqm9iYWqOTZT8.eomK7VLcx/evTLXK1R89MZ9/xJ.1P1O.',NULL,'client@ct.com','ydq-EgDiwmFDEGvX19hFstC94S1uUfUa_1734735189',10,1734735189,1734735189);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (1,1,'123456789','Admin','Rua Admin 1','1000-001','926326333',0,0),(2,2,'987654321','Manager','Rua Manager 2','1000-002','911234564',0,0),(3,3,'123789456','In Charge','Rua InCharge 3','1000-003','963963963',0,0),(4,4,'456123789','Employee','Rua Employee 4','1000-004','914914500',0,0),(5,5,'456123784','Client','Rua Client 5','1000-005','926926596',0,0),(6,6,'111223344','Cliente','Rua Cliente 6','1000-006','934567890',0,0),(7,7,'911911911','David Afonso Domingues','Cat Castanheira de Pera','3280-113','910324185',0,0);
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-01 17:34:50
