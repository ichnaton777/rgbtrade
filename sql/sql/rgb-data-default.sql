-- DEFAULT DATABASE FOR RGBTRADE
-- VERSION 0.11
-- TABLE DEFINITION IS IN THE phpmyadmin.sql file. This is the data you will need.
-- MySQL dump 10.11
--
-- Host: localhost    Database: rgb
-- ------------------------------------------------------
-- Server version	5.0.45-Debian_1ubuntu3-log

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
-- Dumping data for table `rgbAdCategories`
--

delete from rgbAdCategories;
delete from rgbUsers;
delete from rgbAds;
delete from rgbBalances;
delete from rgbTransfers;

LOCK TABLES `rgbAdCategories` WRITE;
/*!40000 ALTER TABLE `rgbAdCategories` DISABLE KEYS */;
INSERT INTO `rgbAdCategories` (`adCategoryId`, `adCategoryTitleEn`, `adCategoryTitleNl`, `adCategoryParentId`, `adCategoryText`, `adCategoryStatus`, `adCategoryMainColour`) VALUES (0,'Universe Super Category','Universum Super Categorie',3,'','available','none'),(1,'- Red Categorie','- Rode Categorie',0,NULL,'unavailable','red'),(2,'- Green Categorie','- Groene Categorie',0,NULL,'unavailable','green'),(3,'- Blue Categoerie','- Blauwe Categorie',3,NULL,'unavailable','blue'),(137,'Jobs, Work','Banen & Werk',1,NULL,'available','red'),(1000,'Care','Zorg',137,NULL,'available','red'),(1015,'Glass (not broken)','Glas (niet gebroken)',2,NULL,'available','green'),(1006,'Agriculture & Gardening','Landbouw & Tuinieren',1,NULL,'available','red'),(1003,'Education','Onderwijs & Educatie',137,NULL,'available','red'),(1004,'Food','Voeding',1,NULL,'available','red'),(1005,'Fruits & Vegetables','Groenten & Fruit',1004,NULL,'available','red'),(1007,'Seeds','Zaden',1006,NULL,'available','red'),(1008,'Plants & Trees','Planten & Bomen',1006,NULL,'available','red'),(1009,'Animals & Livestock','Dieren & Vee',1,NULL,'available','red'),(1010,'Food and Garden Waste','GFT Afval',2,NULL,'available','green'),(1011,'Compost','Compost',2,NULL,'available','green'),(1014,'Paper (used)','Papier (gebruikt)',2,NULL,'available','green'),(1016,'Electronics','Electronica',3,NULL,'available','blue'),(1018,'White Good','Witgoed',3,NULL,'available','blue');
/*!40000 ALTER TABLE `rgbAdCategories` ENABLE KEYS */;
UNLOCK TABLES;

--
--
-- Dumping data for table `rgbUserPreference`
--

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2007-10-26 16:50:41
