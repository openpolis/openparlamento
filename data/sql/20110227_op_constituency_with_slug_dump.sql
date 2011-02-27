-- MySQL dump 10.13  Distrib 5.1.53, for apple-darwin10.5.0 (i386)
--
-- Host: localhost    Database: op_openpolis
-- ------------------------------------------------------
-- Server version	5.1.53

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
-- Table structure for table `op_constituency`
--

DROP TABLE IF EXISTS `op_constituency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `op_constituency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `election_type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `op_constituency_FKIndex1` (`election_type_id`),
  CONSTRAINT `op_constituency_ibfk_1` FOREIGN KEY (`election_type_id`) REFERENCES `op_election_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `op_constituency`
--

LOCK TABLES `op_constituency` WRITE;
/*!40000 ALTER TABLE `op_constituency` DISABLE KEYS */;
INSERT INTO `op_constituency` VALUES (1,1,'Italia centrale','italia-centrale',NULL),(2,1,'Italia nord occidentale','italia-nord-occidentale',NULL),(3,1,'Italia nord orientale','italia-nord-orientale',NULL),(4,1,'Italia insulare','italia-insulare',NULL),(5,1,'Italia meridionale','italia-meridionale',NULL),(6,2,'Friuli-Venezia Giulia','friuli-venezia-giulia',NULL),(7,2,'Valle d\'Aosta','valle-d-aosta',NULL),(8,2,'Sicilia 2','sicilia-2',NULL),(9,2,'Molise','molise',NULL),(10,2,'Marche','marche',NULL),(11,2,'Lombardia 2','lombardia-2',NULL),(12,2,'Piemonte 2','piemonte-2',NULL),(13,2,'Veneto 1','veneto-1',NULL),(14,2,'Lombardia 1','lombardia-1',NULL),(15,2,'Trentino-Alto Adige','trentino-alto-adige',NULL),(16,2,'Umbria','umbria',NULL),(17,2,'Calabria','calabria',NULL),(18,2,'Campania 2','campania-2',NULL),(19,2,'Lazio 1','lazio-1',NULL),(20,2,'Emilia-Romagna','emilia-romagna',NULL),(21,2,'Abruzzo','abruzzo',NULL),(22,2,'Puglia','puglia',NULL),(23,2,'Piemonte 1','piemonte-1',NULL),(24,2,'Toscana','toscana',NULL),(25,2,'Sicilia 1','sicilia-1',NULL),(26,2,'Liguria','liguria',NULL),(27,2,'Veneto 2','veneto-2',NULL),(28,2,'Basilicata','basilicata',NULL),(29,2,'Sardegna','sardegna',NULL),(30,2,'Campania 1','campania-1',NULL),(31,2,'Lombardia 3','lombardia-3',NULL),(32,2,'Lazio 2','lazio-2',NULL),(33,3,'Friuli-Venezia Giulia','friuli-venezia-giulia',NULL),(34,3,'Valle d\'Aosta','valle-d-aosta',NULL),(35,3,'Molise','molise',NULL),(36,3,'Marche','marche',NULL),(37,3,'Trentino-Alto Adige','trentino-alto-adige',NULL),(38,3,'Umbria','umbria',NULL),(39,3,'Calabria','calabria',NULL),(40,3,'Campania','campania',NULL),(41,3,'Lombardia','lombardia',NULL),(42,3,'Emilia-Romagna','emilia-romagna',NULL),(43,3,'Sicilia','sicilia',NULL),(44,3,'Abruzzo','abruzzo',NULL),(45,3,'Piemonte','piemonte',NULL),(46,3,'Toscana','toscana',NULL),(47,3,'Lazio','lazio',NULL),(48,3,'Puglia','puglia',NULL),(49,3,'Veneto','veneto',NULL),(50,3,'Liguria','liguria',NULL),(51,3,'Basilicata','basilicata',NULL),(52,3,'Sardegna','sardegna',NULL),(53,3,'Senatore a vita','senatore-a-vita',NULL),(54,3,'America meridionale','america-meridionale',NULL),(55,3,'Europa','europa',NULL),(56,3,'Asia-Africa-Oceania-Antartide','asia-africa-oceania-antartide',NULL),(57,3,'America settentrionale e centrale','america-settentrionale-e-centrale',NULL),(58,2,'America meridionale','america-meridionale',NULL),(59,2,'Europa','europa',NULL),(60,2,'Asia-Africa-Oceania-Antartide','asia-africa-oceania-antartide',NULL),(61,2,'America settentrionale e centrale','america-settentrionale-e-centrale',NULL);
/*!40000 ALTER TABLE `op_constituency` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-02-27 16:00:36
