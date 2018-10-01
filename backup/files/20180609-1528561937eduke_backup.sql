-- MySQL dump 10.13  Distrib 5.5.8, for Win32 (x86)
--
-- Host: localhost    Database: schooldb
-- ------------------------------------------------------
-- Server version	5.5.8-log

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
-- Table structure for table `advancedgrading`
--

DROP TABLE IF EXISTS `advancedgrading`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advancedgrading` (
  `advancedgrading_id` int(11) NOT NULL,
  `score_type` varchar(2) NOT NULL,
  `score_value` int(11) NOT NULL,
  `max_score` int(11) NOT NULL,
  `min_score` int(11) NOT NULL,
  PRIMARY KEY (`score_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advancedgrading`
--

LOCK TABLES `advancedgrading` WRITE;
/*!40000 ALTER TABLE `advancedgrading` DISABLE KEYS */;
INSERT INTO `advancedgrading` VALUES (8,'A',6,12,2),(2,'B',5,6,7),(3,'C',4,8,9),(4,'D',3,10,11),(5,'E',2,12,13),(7,'F',0,17,18),(6,'O',1,14,16);
/*!40000 ALTER TABLE `advancedgrading` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classcategory`
--

DROP TABLE IF EXISTS `classcategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classcategory` (
  `class_category_id` int(11) NOT NULL,
  `class_category` varchar(30) NOT NULL,
  PRIMARY KEY (`class_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classcategory`
--

LOCK TABLES `classcategory` WRITE;
/*!40000 ALTER TABLE `classcategory` DISABLE KEYS */;
INSERT INTO `classcategory` VALUES (1,'SCIENCES'),(2,'ARTS'),(3,'ARTS AND SCIENCES');
/*!40000 ALTER TABLE `classcategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classenrolled`
--

DROP TABLE IF EXISTS `classenrolled`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classenrolled` (
  `classesenrolled_id` int(11) NOT NULL,
  `academic_term_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`academic_term_id`,`student_id`),
  KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `classenrolled_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `schoolstudents` (`student_id`),
  CONSTRAINT `classenrolled_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `schoolclass` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classenrolled`
--

LOCK TABLES `classenrolled` WRITE;
/*!40000 ALTER TABLE `classenrolled` DISABLE KEYS */;
INSERT INTO `classenrolled` VALUES (39,1,2,1),(6,1,5,2),(8,1,7,3),(9,1,8,3),(10,1,9,3),(11,1,10,3),(33,1,11,1),(13,1,12,3),(14,1,13,3),(15,1,14,3),(16,1,15,3),(20,1,19,4),(42,1,31,1),(40,2,2,1),(7,2,6,2),(34,2,11,1),(19,2,18,4),(21,2,20,5),(22,2,21,5),(43,2,31,1),(41,3,2,1),(4,3,3,1),(35,3,11,1),(17,3,16,4),(18,3,17,4),(23,3,22,5),(24,3,23,5),(25,3,24,5),(26,3,25,5),(27,3,26,5),(28,3,27,5),(29,3,28,5),(44,3,31,1),(5,4,4,2);
/*!40000 ALTER TABLE `classenrolled` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classlevel`
--

DROP TABLE IF EXISTS `classlevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classlevel` (
  `classlevel_id` int(11) NOT NULL,
  `classlevel_name` varchar(30) NOT NULL,
  `report_type` varchar(20) NOT NULL,
  PRIMARY KEY (`classlevel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classlevel`
--

LOCK TABLES `classlevel` WRITE;
/*!40000 ALTER TABLE `classlevel` DISABLE KEYS */;
INSERT INTO `classlevel` VALUES (1,'O-LEVEL','Type B'),(2,'A-LEVEL','Type C');
/*!40000 ALTER TABLE `classlevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `events_id` int(11) NOT NULL,
  `events_name` varchar(30) NOT NULL,
  `description` varchar(128) NOT NULL,
  `event_date` date NOT NULL,
  `academic_term_id` int(11) NOT NULL,
  PRIMARY KEY (`events_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'SPEAK DAY','the term will beging on 22nd of may 2018','2018-01-11',6),(2,'MEDS DAY','the term will beging on 22nd of may 2018','2018-01-11',6),(3,'FIRST PTA MEETING','the term will beging on 22nd of may 2018','2016-04-11',6),(4,'SPORTS DAY','the term will beging on 22nd of may 2018','2017-04-11',6),(5,'PRAYER WEEK','the term will beging ovvnfv rgfi6','2018-08-11',6);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exams` (
  `exam_id` int(11) NOT NULL,
  `academic_term_id` int(11) NOT NULL,
  `examtypes_id` int(11) NOT NULL,
  `exam_date` date NOT NULL,
  `exam_comment` varchar(40) NOT NULL,
  PRIMARY KEY (`exam_id`),
  KEY `examtypes_id` (`examtypes_id`),
  CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`examtypes_id`) REFERENCES `examtypes` (`examtypes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exams`
--

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;
INSERT INTO `exams` VALUES (1,1,1,'2016-04-11','Good performance'),(2,1,2,'2016-04-11',''),(3,1,3,'2016-04-11',''),(4,2,1,'2016-04-11',''),(5,2,2,'2016-04-11',''),(6,2,3,'2016-04-11','Trying perfomance'),(7,3,1,'2016-04-11',''),(8,3,2,'2016-04-11',''),(9,3,3,'2016-04-11',''),(10,4,2,'2016-04-11',''),(11,4,3,'2016-04-11','');
/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examtypes`
--

DROP TABLE IF EXISTS `examtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `examtypes` (
  `examtypes_id` int(11) NOT NULL,
  `exam_name` varchar(10) NOT NULL,
  `exam_abreviation` varchar(5) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`examtypes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examtypes`
--

LOCK TABLES `examtypes` WRITE;
/*!40000 ALTER TABLE `examtypes` DISABLE KEYS */;
INSERT INTO `examtypes` VALUES (1,'Beginning ','BOT','Begining of term for the school'),(2,'Mid term','MTE','Mid term for the school of term for the '),(3,'end of ter','EOT','');
/*!40000 ALTER TABLE `examtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_waiver`
--

DROP TABLE IF EXISTS `fee_waiver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_waiver` (
  `fee_waiver_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `description` varchar(128) NOT NULL,
  `fee_waiver_percentage` int(3) NOT NULL,
  `academic_term_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`academic_term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_waiver`
--

LOCK TABLES `fee_waiver` WRITE;
/*!40000 ALTER TABLE `fee_waiver` DISABLE KEYS */;
INSERT INTO `fee_waiver` VALUES (7,1,'',50,1),(9,1,'',50,3),(6,3,'',14,1),(3,3,'',34,4),(4,3,'',34,5),(5,3,'',34,6);
/*!40000 ALTER TABLE `fee_waiver` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grading`
--

DROP TABLE IF EXISTS `grading`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grading` (
  `grading_id` int(11) NOT NULL,
  `classlevel_id` int(11) NOT NULL,
  `score_type` varchar(2) NOT NULL,
  `score_value` int(11) NOT NULL,
  `max_score` int(11) NOT NULL,
  `min_score` int(11) NOT NULL,
  PRIMARY KEY (`classlevel_id`,`score_type`),
  CONSTRAINT `grading_ibfk_1` FOREIGN KEY (`classlevel_id`) REFERENCES `classlevel` (`classlevel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grading`
--

LOCK TABLES `grading` WRITE;
/*!40000 ALTER TABLE `grading` DISABLE KEYS */;
INSERT INTO `grading` VALUES (3,1,'C3',3,80,71),(4,1,'C4',4,70,61),(5,1,'C5',5,60,51),(6,1,'C6',6,50,41),(19,1,'D1',1,100,91),(2,1,'D2',2,90,81),(9,1,'F9',9,20,0),(7,1,'P7',7,40,31),(8,1,'P8',8,30,21),(12,2,'C3',3,80,71),(13,2,'C4',4,70,61),(14,2,'C5',5,60,51),(15,2,'C6',6,50,41),(10,2,'D1',1,100,91),(11,2,'D2',2,90,81),(18,2,'F9',9,20,0),(16,2,'P7',7,40,31),(17,2,'P8',8,30,21);
/*!40000 ALTER TABLE `grading` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grading2`
--

DROP TABLE IF EXISTS `grading2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grading2` (
  `grading2_id` int(11) NOT NULL,
  `classlevel_id` int(11) NOT NULL,
  `score_type` varchar(2) NOT NULL,
  `score_value` int(11) NOT NULL,
  `max_score` int(11) NOT NULL,
  `min_score` int(11) NOT NULL,
  PRIMARY KEY (`classlevel_id`,`score_type`),
  CONSTRAINT `grading2_ibfk_1` FOREIGN KEY (`classlevel_id`) REFERENCES `classlevel` (`classlevel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grading2`
--

LOCK TABLES `grading2` WRITE;
/*!40000 ALTER TABLE `grading2` DISABLE KEYS */;
INSERT INTO `grading2` VALUES (1,1,'A',1,90,90),(2,1,'B',2,91,70);
/*!40000 ALTER TABLE `grading2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `noticeboard`
--

DROP TABLE IF EXISTS `noticeboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `noticeboard` (
  `notice_id` int(11) NOT NULL,
  `notice_title` varchar(40) NOT NULL,
  `notice_message` varchar(128) NOT NULL,
  `date_of_notice` date NOT NULL,
  `academic_term_id` int(11) NOT NULL,
  PRIMARY KEY (`notice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `noticeboard`
--

LOCK TABLES `noticeboard` WRITE;
/*!40000 ALTER TABLE `noticeboard` DISABLE KEYS */;
INSERT INTO `noticeboard` VALUES (1,'THE BEGINING OF SCHOOL','the term will beging on 22nd of may 2018','2018-01-11',6),(2,'SCHOOL PRACTICE','the term will beging on 22nd of may 2018','2018-01-11',6),(3,'BEGINING OF SCHOOL','the term will beging on 22nd of may 2018','2018-01-11',6),(4,'STUDENTS WITH MISSING MARKS ','the term will beging on 22nd of may 2018','2018-01-11',6),(5,'SPORTS CLUB NEEDED','the term will beging ovvnfv rgfi6','2018-01-11',6);
/*!40000 ALTER TABLE `noticeboard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parents`
--

DROP TABLE IF EXISTS `parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parents` (
  `parent_id` int(11) NOT NULL,
  `parent_firstname` varchar(30) NOT NULL,
  `parent_lastname` varchar(30) NOT NULL,
  `gender` char(1) NOT NULL,
  `address` varchar(30) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `phone_alt` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `photo` varchar(90) NOT NULL,
  PRIMARY KEY (`email`,`phone`),
  KEY `parent_firstname` (`parent_firstname`(15)),
  KEY `parent_lastname` (`parent_lastname`(15))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parents`
--

LOCK TABLES `parents` WRITE;
/*!40000 ALTER TABLE `parents` DISABLE KEYS */;
INSERT INTO `parents` VALUES (20,'WE','WE','M','E','0775771533','','admin@fdd.com','password','default'),(19,'JOHN','MWESE','M','','0775771501','','derrickedghhhh@gmail.com','password','default'),(10,'DAVID','KYOGA','M','Kasangati, Kira','0775771510','','derrickedrins11@gmail.com','password','default'),(1,'BRIAN','KISUULE','M','Kasangati, Kira','0775771501','','derrickedrins1@gmail.com','password','default'),(11,'HON','BIFA','F','Kasangati, Kira','0775771511','','derrickedrins22@gmail.com','password','default'),(2,'TENER','LUBWAMA','M','Kasangati, Kira','0775771502','','derrickedrins2@gmail.com','password','default'),(12,'KIN','KISUBA','M','Kasangati, Kira','0775771512','','derrickedrins33@gmail.com','password','default'),(3,'TENDO','PRAISE','F','Kasangati, Kira','0775771503','','derrickedrins3@gmail.com','password','default'),(13,'KARIM','ABUDUL','M','Kasangati, Kira','0775771513','','derrickedrins44@gmail.com','password','default'),(4,'KEN','LUBWAMA','M','Kasangati, Kira','0775771504','','derrickedrins4@gmail.com','password','default'),(14,'MR','SEBBO','M','Kasangati, Kira','0775771514','','derrickedrins55@gmail.com','password','default'),(5,'ALFRED','BOMBO','M','Kasangati, Kira','0775771505','','derrickedrins5@gmail.com','password','default'),(15,'PAPI','KIMERA','M','Kasangati, Kira','0775771515','','derrickedrins66@gmail.com','password','default'),(6,'SHISA','NAMUBIRU','F','Kasangati, Kira','0775771506','','derrickedrins6@gmail.com','password','default'),(16,'NASSER','NTEGE','M','Kasangati, Kira','0775771516','','derrickedrins77@gmail.com','password','default'),(7,'FRED','MUTABAAZI','M','Kasangati, Kira','0775771507','','derrickedrins7@gmail.com','password','default'),(17,'TENERO','MASUGA','F','Kasangati, Kira','0775771517','','derrickedrins88@gmail.com','password','default'),(8,'DORAH','MAYILUNGI','F','Kasangati, Kira','0775771508','','derrickedrins8@gmail.com','password','default'),(18,'DENAL','LUTE','M','Kasangati, Kira','0775771518','','derrickedrins99@gmail.com','password','default'),(9,'NATHAN','MUKISA','M','Kasangati, Kira','0775771509','','derrickedrins9@gmail.com','password','default');
/*!40000 ALTER TABLE `parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rolebystudent`
--

DROP TABLE IF EXISTS `rolebystudent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rolebystudent` (
  `rolebystudent_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_roles_id` int(11) NOT NULL,
  `academic_term_id` int(11) NOT NULL,
  PRIMARY KEY (`student_id`,`student_roles_id`,`academic_term_id`),
  KEY `student_roles_id` (`student_roles_id`),
  CONSTRAINT `rolebystudent_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `schoolstudents` (`student_id`),
  CONSTRAINT `rolebystudent_ibfk_2` FOREIGN KEY (`student_roles_id`) REFERENCES `student_roles` (`student_roles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rolebystudent`
--

LOCK TABLES `rolebystudent` WRITE;
/*!40000 ALTER TABLE `rolebystudent` DISABLE KEYS */;
INSERT INTO `rolebystudent` VALUES (1,1,1,4),(2,1,1,5),(3,1,1,6),(4,2,2,1);
/*!40000 ALTER TABLE `rolebystudent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolclass`
--

DROP TABLE IF EXISTS `schoolclass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolclass` (
  `class_id` int(11) NOT NULL,
  `class_alias` varchar(30) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `classlevel_id` int(11) NOT NULL,
  `class_category_id` int(11) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolclass`
--

LOCK TABLES `schoolclass` WRITE;
/*!40000 ALTER TABLE `schoolclass` DISABLE KEYS */;
INSERT INTO `schoolclass` VALUES (1,'CLASS ONE BLUE',1,1,3),(2,'CLASS ONE YELLOW',1,1,3),(3,'CLASS TWO',2,1,3),(4,'CLASS TWO RED',2,1,3),(5,'CLASS THREE',3,1,3),(6,'CLASS FOUR',3,2,1),(7,'CLASS FIVE SCIENCES',4,2,1),(8,'CLASS FIVE ARTS',4,2,2),(9,'CLASS SIX SCIENCES',4,2,1),(10,'CLASS SIX ARTS',4,2,2),(11,'D',19,1,1);
/*!40000 ALTER TABLE `schoolclass` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolclassfees`
--

DROP TABLE IF EXISTS `schoolclassfees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolclassfees` (
  `schoolclassfees_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `fee_name` varchar(15) NOT NULL,
  `class_fees` decimal(10,2) NOT NULL,
  `academic_term_id` int(11) NOT NULL,
  `priority` varchar(15) NOT NULL,
  PRIMARY KEY (`schoolclassfees_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `schoolclassfees_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `schoolclass` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolclassfees`
--

LOCK TABLES `schoolclassfees` WRITE;
/*!40000 ALTER TABLE `schoolclassfees` DISABLE KEYS */;
INSERT INTO `schoolclassfees` VALUES (1,1,'TUTION',400000.00,1,'Compulsary'),(2,1,'REGISTRATION',130000.00,1,'Compulsary'),(3,1,'LAB FEE',220000.00,1,'Optional'),(4,1,'TUTION',400000.00,2,'Compulsary'),(5,1,'TUTION',400000.00,3,'Compulsary'),(6,1,'TUTION',400000.00,4,'Compulsary'),(7,2,'TUTION',500000.00,1,'Compulsary'),(8,2,'TUTION',500000.00,2,'Compulsary'),(9,2,'TUTION',500000.00,3,'Compulsary'),(10,2,'TUTION',500000.00,4,'Compulsary'),(11,3,'TUTION',500000.00,1,'Compulsary'),(12,3,'TUTION',500000.00,2,'Compulsary'),(13,3,'TUTION',500000.00,3,'Compulsary'),(14,3,'TUTION',500000.00,4,'Compulsary'),(15,4,'TUTION',500000.00,1,'Compulsary'),(16,4,'TUTION',500000.00,2,'Compulsary'),(17,4,'TUTION',500000.00,3,'Compulsary'),(18,4,'TUTION',500000.00,4,'Compulsary'),(20,9,'TUTION',600000.00,1,'Compulsary');
/*!40000 ALTER TABLE `schoolclassfees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolfees`
--

DROP TABLE IF EXISTS `schoolfees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolfees` (
  `schoolfees_id` int(11) NOT NULL,
  `priority` varchar(15) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `bank_slip_number` varchar(8) NOT NULL,
  `fees_paid` decimal(10,2) NOT NULL,
  `fees_balance` decimal(10,2) NOT NULL,
  `academic_term_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  `approved_by` varchar(10) NOT NULL,
  PRIMARY KEY (`schoolfees_id`),
  KEY `class_id` (`class_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `schoolfees_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `schoolclass` (`class_id`),
  CONSTRAINT `schoolfees_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `schoolstudents` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolfees`
--

LOCK TABLES `schoolfees` WRITE;
/*!40000 ALTER TABLE `schoolfees` DISABLE KEYS */;
INSERT INTO `schoolfees` VALUES (3,'Compulsary',2,1,'0996',300000.00,100000.00,2,'2005-03-27',1,'Pending',''),(4,'Compulsary',3,1,'0933',300000.00,100000.00,3,'2005-03-27',1,'Pending',''),(5,'Compulsary',4,2,'0193',300000.00,100000.00,4,'2005-03-27',1,'Pending','');
/*!40000 ALTER TABLE `schoolfees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolhouses`
--

DROP TABLE IF EXISTS `schoolhouses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolhouses` (
  `house_id` int(11) NOT NULL,
  `house_name` varchar(30) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`house_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolhouses`
--

LOCK TABLES `schoolhouses` WRITE;
/*!40000 ALTER TABLE `schoolhouses` DISABLE KEYS */;
INSERT INTO `schoolhouses` VALUES (1,'LEOPARD','House named eggypt'),(2,'ANGOLA','House named eggypt'),(3,'VICTORIA','House named eggypt'),(4,'EGYPT','House named eggypt'),(5,'EE','eee');
/*!40000 ALTER TABLE `schoolhouses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolstudents`
--

DROP TABLE IF EXISTS `schoolstudents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolstudents` (
  `student_id` int(11) NOT NULL,
  `admission_number` varchar(15) NOT NULL,
  `student_firstname` varchar(30) NOT NULL,
  `student_lastname` varchar(30) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` varchar(1) NOT NULL,
  `address` varchar(30) NOT NULL,
  `religion` varchar(30) NOT NULL,
  `house_id` varchar(30) NOT NULL,
  `photo` varchar(90) NOT NULL,
  `class_id` int(11) NOT NULL,
  `status` varchar(15) NOT NULL,
  PRIMARY KEY (`student_id`),
  KEY `student_firstname` (`student_firstname`(15)),
  KEY `student_lastname` (`student_lastname`(15))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolstudents`
--

LOCK TABLES `schoolstudents` WRITE;
/*!40000 ALTER TABLE `schoolstudents` DISABLE KEYS */;
INSERT INTO `schoolstudents` VALUES (1,'HIL/2010/1','DERRICK','SSENTUMBWE','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',0,'Active'),(2,'HIL/2010/2','TOM','LUBALAATA','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','2','default',1,'Active'),(3,'HIL/2010/3','MOSES','KIMBUGWE','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',1,'Active'),(4,'HIL/2010/4','MOSES','KYAGULANYI','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',2,'Active'),(5,'HIL/2010/5','ERIYA','KINTU','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','2','default',2,'Active'),(6,'HIL/2010/6','ERIC','SSENTUMBWE','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',2,'Active'),(7,'HIL/2010/7','BABY','BOLINGO','1992-03-29','F','KSANGATI, KIRA','PROTESTANT','1','default',3,'Alumni'),(8,'HIL/2010/8','BARBIE','BONGOLE','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','2','default',3,'Alumni'),(9,'HIL/2010/9','ALEX','POTA','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',3,'Alumni'),(10,'HIL/2010/10','LINCON','NAMUKWAYA','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',3,'Active'),(11,'HIL/2010/11','LITE','KISAAKYE','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',1,'Active'),(12,'HIL/2010/12','MEGA','NALO','1992-03-29','F','KSANGATI, KIRA','PROTESTANT','1','default',3,'Active'),(13,'HIL/2010/13','EVELYN','NALUNKUUMA','1992-03-29','F','KSANGATI, KIRA','PROTESTANT','2','default',3,'Active'),(14,'HIL/2010/14','EVA','BONGO','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',3,'Active'),(15,'HIL/2010/15','EMMA','LUBEGA','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','2','default',3,'Active'),(16,'HIL/2010/16','JOSEPH','BALIKUDEMBE','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',4,'Alumni'),(17,'HIL/2010/17','RITA','ORAH','1992-03-29','F','KSANGATI, KIRA','PROTESTANT','3','default',4,'Active'),(18,'HIL/2010/18','DOREEN','DONCAINS','1992-03-29','F','KSANGATI, KIRA','PROTESTANT','1','default',4,'Active'),(19,'HIL/2010/19','CAKE','TOMUSANGE','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',4,'Active'),(20,'HIL/2010/29','DICKENS','KISA','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','3','default',5,'Active'),(21,'HIL/2010/21','MUSA','BODE','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',5,'Active'),(22,'HIL/2010/22','HASACHA','LUBWAMA','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',5,'Active'),(23,'HIL/2010/23','HOPE','NAMBALILWA','1992-03-29','F','KSANGATI, KIRA','PROTESTANT','3','default',5,'Active'),(24,'HIL/2010/24','FRED','OMUNTU','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',5,'Active'),(25,'HIL/2010/25','ALI','KIBER','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',5,'Active'),(26,'HIL/2010/26','WALL','PEACE','1992-03-29','F','KSANGATI, KIRA','PROTESTANT','3','default',5,'Active'),(27,'HIL/2010/27','SHANITA','KENE','1992-03-29','F','KSANGATI, KIRA','PROTESTANT','1','default',5,'Active'),(28,'HIL/2010/28','DERRICK','LOMU','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',5,'Active'),(29,'HIL/2010/29','DERRICK','KIMWANYI','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','3','default',0,'Active'),(30,'HIL/2010/30','DERRICK','JAKI','1992-03-29','M','KSANGATI, KIRA','PROTESTANT','1','default',0,'Active'),(31,'9090','PAUL','MWASE','1992-03-01','M','KWERI','PROTESTANT','1','default',1,'Active');
/*!40000 ALTER TABLE `schoolstudents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolsubjects`
--

DROP TABLE IF EXISTS `schoolsubjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolsubjects` (
  `subject_id` int(11) NOT NULL,
  `number_of_papers` int(2) NOT NULL,
  `subject_name` varchar(50) NOT NULL,
  `classlevel_id` int(11) NOT NULL,
  `class_category_id` int(11) NOT NULL,
  `description` varchar(40) NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolsubjects`
--

LOCK TABLES `schoolsubjects` WRITE;
/*!40000 ALTER TABLE `schoolsubjects` DISABLE KEYS */;
INSERT INTO `schoolsubjects` VALUES (1,2,'MATH PURE',2,1,'Math one for the A-level students in all'),(2,2,'CRE',1,3,'Math for hac'),(3,2,'AGRICULTURE ONE',2,1,'agric qfdQ'),(4,2,'AGRICULTURE TWO',1,1,'agric qfdQ'),(5,2,'AGRICULTURE PRACT',1,3,'agric qfdQ'),(6,2,'AGRICULTURE PRACT',2,1,'agric qfdQ'),(7,2,'AGRICULTURE THEORY',1,3,'agric qfdQ'),(8,2,'AGRICULTURE THEORY',2,1,'agric qfdQ'),(9,2,'GEOGRAPHY ONE',1,3,'goeg FD'),(10,2,'GEOGRAPHY ONE',2,3,'goeg FD'),(11,2,'GEOGRAPHY TWO',1,3,'goeg FD'),(12,2,'GEOGRAPHY TWO',2,3,'goeg FD'),(13,5,'FINE ART',1,3,'fine art  EFE'),(14,5,'FINE ART',2,3,'fine art  EFE'),(15,2,'BIOLOGY',1,3,'biology ec'),(16,2,'BIOLOGY',2,1,'biology ec'),(17,3,'CHEMISTRY',1,3,' chem E3'),(18,3,'CHEMISTRY',2,1,' chem E3'),(19,2,'PHYSICS',1,1,'phys icn 3FRG'),(20,2,'PHYSICS',2,3,'phys icn 3FRG'),(21,2,'COMPUTER',1,3,'comp GFT'),(22,2,'COMPUTER',2,3,'comp GFT'),(23,2,'ECONOMICS',2,2,'comp GFT'),(24,2,'LUGANDA',1,3,'comp GFT'),(25,2,'LUGANDA',2,3,'comp GFT'),(26,2,'COMMERCE',1,3,'comp GFT'),(27,2,'ENTREPRENURE',1,3,'comp GFT'),(28,2,'ENTREPRENURE',2,3,'comp GFT'),(29,2,'FRENCH WRITTEN',1,3,'comp GFT'),(30,2,'FRENCH WRITTEN',2,3,'comp GFT'),(31,2,'HISTORY E.A',2,2,'comp GFT'),(32,2,'HISTORY BRITISH',2,2,'comp GFT'),(33,2,'GENERAL PAPER',2,1,'comp GFT'),(34,2,'GENERAL PAPER',2,2,'comp GFT'),(35,2,'DIVINITY',2,2,'comp GFT');
/*!40000 ALTER TABLE `schoolsubjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolteachers`
--

DROP TABLE IF EXISTS `schoolteachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolteachers` (
  `teacher_id` int(11) NOT NULL,
  `teacher_firstname` varchar(30) NOT NULL,
  `teacher_lastname` varchar(30) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` char(1) NOT NULL,
  `address` varchar(30) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `phone_alt` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `photo` varchar(90) NOT NULL,
  PRIMARY KEY (`email`,`phone`),
  KEY `teacher_firstname` (`teacher_firstname`(15)),
  KEY `teacher_lastname` (`teacher_lastname`(15))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolteachers`
--

LOCK TABLES `schoolteachers` WRITE;
/*!40000 ALTER TABLE `schoolteachers` DISABLE KEYS */;
INSERT INTO `schoolteachers` VALUES (19,'E','E','1992-03-01','M','YTRYUEGJ','0775771533','','admin@fdd.com','password','default'),(10,'DAVID','KYOGA','1992-02-03','M','Kasangati, Kira','0775771510','','derrickedrins10@gmail.com','password','default'),(11,'HON','BIFA','1992-02-03','M','Kasangati, Kira','0775771511','','derrickedrins11@gmail.com','password','default'),(12,'KIN','KISUBA','1992-02-03','M','Kasangati, Kira','0775771512','','derrickedrins12@gmail.com','password','default'),(13,'KARIM','ABUDUL','1992-02-03','M','Kasangati, Kira','0775771513','','derrickedrins13@gmail.com','password','default'),(14,'MR','SEBBO','1992-02-03','M','Kasangati, Kira','0775771514','','derrickedrins14@gmail.com','password','default'),(15,'PAPI','KIMERA','1992-02-03','M','Kasangati, Kira','0775771515','','derrickedrins15@gmail.com','password','default'),(16,'NASSER','NTEGE','1992-02-03','M','Kasangati, Kira','0775771516','','derrickedrins16@gmail.com','password','default'),(17,'TENERO','MASUGA','1992-02-03','M','Kasangati, Kira','0775771517','','derrickedrins17@gmail.com','password','default'),(18,'DENAL','LUTE','1992-02-03','M','Kasangati, Kira','0775771518','','derrickedrins18@gmail.com','password','default'),(1,'BRIAN','KISUULE','1992-02-03','M','Kasangati, Kira','0775771501','','derrickedrins1@gmail.com','password','default'),(2,'TENER','LUBWAMA','1992-02-03','M','Kasangati, Kira','0775771502','','derrickedrins2@gmail.com','password','default'),(3,'ALBERT','KYOGA','1992-02-03','M','Kasangati, Kira','0775771503','','derrickedrins3@gmail.com','password','default'),(4,'KEN','LUBWAMA','1992-02-03','M','Kasangati, Kira','0775771504','','derrickedrins4@gmail.com','password','default'),(5,'ALFRED','BOMBO','1992-02-03','M','Kasangati, Kira','0775771505','','derrickedrins5@gmail.com','password','default'),(6,'SHISA','NAMUBIRU','1992-02-03','F','Kasangati, Kira','0775771506','','derrickedrins6@gmail.com','password','default'),(7,'FRED','MUTABAAZI','1992-02-03','M','Kasangati, Kira','0775771507','','derrickedrins7@gmail.com','password','default'),(8,'DORAH','MAYILUNGI','1992-02-03','F','Kasangati, Kira','0775771508','','derrickedrins8@gmail.com','password','default'),(9,'NATHAN','MUKISA','1992-02-03','M','Kasangati, Kira','0775771509','','derrickedrins9@gmail.com','password','default');
/*!40000 ALTER TABLE `schoolteachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schoolterm`
--

DROP TABLE IF EXISTS `schoolterm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schoolterm` (
  `academic_term_id` int(11) NOT NULL,
  `academic_year` char(4) NOT NULL,
  `academic_term` varchar(2) NOT NULL,
  `academic_start_date` date NOT NULL,
  `academic_end_date` date NOT NULL,
  PRIMARY KEY (`academic_year`,`academic_term`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schoolterm`
--

LOCK TABLES `schoolterm` WRITE;
/*!40000 ALTER TABLE `schoolterm` DISABLE KEYS */;
INSERT INTO `schoolterm` VALUES (1,'2017','1','2017-02-01','2017-05-01'),(2,'2017','2','2017-05-17','2017-08-17'),(3,'2017','3','2017-08-30','2017-11-01'),(4,'2018','1','2018-02-01','2018-05-01'),(5,'2018','2','2018-02-17','2018-08-17'),(6,'2018','3','2018-03-30','2018-11-30');
/*!40000 ALTER TABLE `schoolterm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(50) NOT NULL,
  `school_address` varchar(30) NOT NULL,
  `school_po_box` varchar(30) NOT NULL,
  `school_phone` char(10) NOT NULL,
  `school_phone_alt` char(10) NOT NULL,
  `school_code` varchar(5) NOT NULL,
  `school_email` varchar(30) NOT NULL,
  `school_email_alt` varchar(30) NOT NULL,
  `school_website` varchar(30) NOT NULL,
  `school_logo` varchar(90) NOT NULL,
  `school_moto` varchar(30) NOT NULL,
  `number_of_terms` int(11) NOT NULL,
  PRIMARY KEY (`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'HILTON HIGH SCHOOL','Kinawataka, Kijabijo','P.O.Box 4100','0759104676','0759104689','HILT','testingschool@gmail.com','testingschool2@gmail.com','www.hilton.com','default','ekula yebuuka',3);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_behaviour`
--

DROP TABLE IF EXISTS `student_behaviour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_behaviour` (
  `student_behaviour_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `student_behaviour_log` varchar(120) NOT NULL,
  `academic_term_id` int(11) NOT NULL,
  PRIMARY KEY (`student_behaviour_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_behaviour`
--

LOCK TABLES `student_behaviour` WRITE;
/*!40000 ALTER TABLE `student_behaviour` DISABLE KEYS */;
INSERT INTO `student_behaviour` VALUES (1,1,'Poor, He beat someone',1),(2,2,'Poor, pushed someone',1);
/*!40000 ALTER TABLE `student_behaviour` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_roles`
--

DROP TABLE IF EXISTS `student_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_roles` (
  `student_roles_id` int(11) NOT NULL,
  `student_roles_name` varchar(30) NOT NULL,
  `description` varchar(128) NOT NULL,
  PRIMARY KEY (`student_roles_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_roles`
--

LOCK TABLES `student_roles` WRITE;
/*!40000 ALTER TABLE `student_roles` DISABLE KEYS */;
INSERT INTO `student_roles` VALUES (1,'HEAD BOY','This is the head boy of the school'),(2,'HEAD GIRL','This is the head girl of the school');
/*!40000 ALTER TABLE `student_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentmarks`
--

DROP TABLE IF EXISTS `studentmarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentmarks` (
  `student_marks_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `subject_paper` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `remark` varchar(30) NOT NULL,
  PRIMARY KEY (`student_id`,`subject_id`,`subject_paper`,`class_id`,`exam_id`),
  KEY `subject_id` (`subject_id`),
  KEY `class_id` (`class_id`),
  KEY `exam_id` (`exam_id`),
  CONSTRAINT `studentmarks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `schoolstudents` (`student_id`),
  CONSTRAINT `studentmarks_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `schoolsubjects` (`subject_id`),
  CONSTRAINT `studentmarks_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `schoolclass` (`class_id`),
  CONSTRAINT `studentmarks_ibfk_4` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentmarks`
--

LOCK TABLES `studentmarks` WRITE;
/*!40000 ALTER TABLE `studentmarks` DISABLE KEYS */;
INSERT INTO `studentmarks` VALUES (1,1,1,1,1,1,87,'Very good'),(2,1,1,2,1,1,85,'Very good'),(3,2,2,1,1,1,87,'Very good'),(4,2,2,2,1,1,87,'Very good'),(5,3,1,1,1,1,87,'Very good'),(6,3,2,2,1,1,87,'Very good'),(7,4,1,1,1,1,87,'Very good'),(8,4,2,2,1,1,87,'Very good'),(9,5,1,1,1,1,87,'Very good'),(10,5,2,2,2,1,87,'Very good'),(11,6,1,1,2,1,87,'Very good'),(12,6,2,2,2,1,87,'Very good'),(13,7,1,1,2,1,87,'Very good'),(14,7,2,2,2,1,87,'Very good'),(15,8,1,1,2,1,87,'Very good'),(16,8,2,2,2,1,87,'Very good'),(17,9,1,1,3,1,87,'Very good'),(18,9,2,2,3,1,87,'Very good'),(19,10,1,1,3,1,87,'Very good'),(20,10,2,2,3,1,87,'Very good'),(21,11,1,1,3,1,87,'Very good'),(22,11,2,2,3,1,87,'Very good'),(23,12,1,1,3,1,87,'Very good'),(24,12,2,2,3,1,87,'Very good'),(25,13,1,1,3,1,87,'Very good'),(26,13,2,2,3,1,87,'Very good');
/*!40000 ALTER TABLE `studentmarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `studentparent`
--

DROP TABLE IF EXISTS `studentparent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `studentparent` (
  `studentparent_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `relationship` varchar(30) NOT NULL,
  PRIMARY KEY (`parent_id`,`student_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `studentparent_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `schoolstudents` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `studentparent`
--

LOCK TABLES `studentparent` WRITE;
/*!40000 ALTER TABLE `studentparent` DISABLE KEYS */;
INSERT INTO `studentparent` VALUES (1,1,1,'Father'),(2,2,2,'Father'),(3,2,3,'Father'),(4,3,3,'Mother'),(5,4,4,'Father'),(6,5,5,'Father'),(7,6,6,'Father'),(8,7,7,'Father'),(9,8,8,'Mother'),(10,9,9,'Father'),(11,10,10,'Father'),(12,11,11,'Mother'),(13,12,12,'Father'),(14,13,13,'Father'),(15,14,14,'Father'),(16,19,31,'Father');
/*!40000 ALTER TABLE `studentparent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjectbyteacher`
--

DROP TABLE IF EXISTS `subjectbyteacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjectbyteacher` (
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  PRIMARY KEY (`teacher_id`,`subject_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `subjectbyteacher_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `schoolsubjects` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjectbyteacher`
--

LOCK TABLES `subjectbyteacher` WRITE;
/*!40000 ALTER TABLE `subjectbyteacher` DISABLE KEYS */;
INSERT INTO `subjectbyteacher` VALUES (1,1),(3,1),(5,1),(8,1),(11,1),(1,2),(3,2),(6,2),(9,2),(10,2),(1,3),(4,3),(7,3),(2,4),(2,5),(2,6);
/*!40000 ALTER TABLE `subjectbyteacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `systemdetails`
--

DROP TABLE IF EXISTS `systemdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `systemdetails` (
  `version` varchar(5) NOT NULL,
  `registrationdetails` varchar(40) NOT NULL,
  PRIMARY KEY (`registrationdetails`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `systemdetails`
--

LOCK TABLES `systemdetails` WRITE;
/*!40000 ALTER TABLE `systemdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `systemdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `password` varchar(30) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `gender` char(1) NOT NULL,
  `address` varchar(30) NOT NULL,
  `photo` varchar(90) NOT NULL,
  `phone_alt` varchar(10) NOT NULL,
  PRIMARY KEY (`username`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'2eeeeeeeee','0775771539','password','1','admin@fdd.com','WE','WEW','M','WWE','default',''),(1,'admin','0775771508','password','1','derrickedrins@gmail.com','Richard','Bbossa','M','Bugolobi','default',''),(2,'derro','0775771518','password','2','derrickedrins1@gmail.com','Gulamuni','Edema','M','Kitgum','default',''),(3,'otheradmin','0775771518','password','1','derrickedrins2@gmail.com','Gulamuni','Edema','M','Kitgum','default','');
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

-- Dump completed on 2018-06-09 19:32:18
