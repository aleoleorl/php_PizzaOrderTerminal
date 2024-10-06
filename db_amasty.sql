-- MySQL dump 10.13  Distrib 8.4.2, for Win64 (x86_64)
--
-- Host: localhost    Database: amasty
-- ------------------------------------------------------
-- Server version	8.4.2

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
-- Table structure for table `good_pizza`
--

DROP TABLE IF EXISTS `good_pizza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `good_pizza` (
  `id` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `good_pizza`
--

LOCK TABLES `good_pizza` WRITE;
/*!40000 ALTER TABLE `good_pizza` DISABLE KEYS */;
INSERT INTO `good_pizza` VALUES (1,'Пепперони',8.95,'pizza_pep.png'),(2,'Деревенская',9.61,'pizza_vil.png'),(3,'Гавайская',10.88,'pizza_haw.png'),(4,'Грибная',9.41,'pizza_mus.png');
/*!40000 ALTER TABLE `good_pizza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `good_sauces`
--

DROP TABLE IF EXISTS `good_sauces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `good_sauces` (
  `id` int NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `price` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `good_sauces`
--

LOCK TABLES `good_sauces` WRITE;
/*!40000 ALTER TABLE `good_sauces` DISABLE KEYS */;
INSERT INTO `good_sauces` VALUES (1,'сырный',0.36),(2,'кисло-сладкий',0.38),(3,'чесночный',0.37),(4,'барбекю',0.4);
/*!40000 ALTER TABLE `good_sauces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `good_size`
--

DROP TABLE IF EXISTS `good_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `good_size` (
  `id` int NOT NULL,
  `desc` varchar(45) DEFAULT NULL,
  `coefficient` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `good_size`
--

LOCK TABLES `good_size` WRITE;
/*!40000 ALTER TABLE `good_size` DISABLE KEYS */;
INSERT INTO `good_size` VALUES (1,'21 см',1),(2,'26 см',1.35),(3,'31 см',1.7),(4,'45 см',2.1);
/*!40000 ALTER TABLE `good_size` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-06 22:42:23
