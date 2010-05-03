-- MySQL dump 10.13  Distrib 5.1.40, for apple-darwin10.0.0 (i386)
--
-- Host: localhost    Database: op_openparlamento
-- ------------------------------------------------------
-- Server version	5.1.40

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
-- Table structure for table `opp_gruppo_ramo`
--

DROP TABLE IF EXISTS `opp_gruppo_ramo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opp_gruppo_ramo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gruppo_id` int(11) NOT NULL,
  `ramo` varchar(1) DEFAULT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `opp_gruppo_ramo_gruppo_id_index` (`gruppo_id`),
  CONSTRAINT `opp_gruppo_ramo_FK_1` FOREIGN KEY (`gruppo_id`) REFERENCES `opp_gruppo` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opp_gruppo_ramo`
--

LOCK TABLES `opp_gruppo_ramo` WRITE;
/*!40000 ALTER TABLE `opp_gruppo_ramo` DISABLE KEYS */;
INSERT INTO `opp_gruppo_ramo` VALUES (1,3,'C','2008-04-28',NULL),(2,7,'C','2008-04-28',NULL),(3,7,'S','2008-04-28',NULL),(4,9,'C','2008-04-28',NULL),(5,9,'S','2008-04-28',NULL),(6,13,'C','2008-04-28',NULL),(7,13,'S','2008-04-28',NULL),(8,18,'C','2008-04-28',NULL),(9,18,'S','2008-04-28',NULL),(10,19,'S','2008-04-28',NULL),(11,19,'C','2008-04-28',NULL),(12,20,'S','2008-04-28',NULL);
/*!40000 ALTER TABLE `opp_gruppo_ramo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-05-03 18:13:29
