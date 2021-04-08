-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: social_media
-- ------------------------------------------------------
-- Server version	8.0.18

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
-- Current Database: `social_media`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `social_media` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `social_media`;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `activity_performed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activity_object` varchar(255) DEFAULT NULL,
  `parent_activity_id` int(11) DEFAULT NULL,
  `parent_activity_text` varchar(255) DEFAULT NULL,
  `child_activity_text` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_user_id` (`user_id`),
  CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=667 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (90,7,'You updated your ','update','2021-01-18 14:54:41','password',7,NULL,NULL),(91,7,'You logged into your ','login','2021-01-18 14:54:41','profile',7,NULL,NULL),(92,7,'You updated your ','update','2021-01-18 14:54:55','password',7,NULL,NULL),(93,7,'You logged into your ','login','2021-01-18 14:54:55','profile',7,NULL,NULL),(94,7,'You logged out from your','logout','2021-01-18 15:14:59','profile',7,NULL,NULL),(95,7,'You updated your ','update','2021-01-18 15:15:22','password',7,NULL,NULL),(96,7,'You logged into your ','login','2021-01-18 15:15:22','profile',7,NULL,NULL),(98,7,'You logged out from your','logout','2021-01-18 18:38:08','profile',7,NULL,NULL),(120,73,'An admin registered your ','register','2021-01-23 20:42:45','profile',NULL,NULL,NULL),(526,30,'You created a ','create','2021-02-11 16:09:34','post',139,'karma towards me',NULL),(529,30,'You created a ','create','2021-02-12 01:20:58','post',140,'karma came towards me',NULL),(530,30,'You created a ','create','2021-02-12 01:35:50','post',141,'mnnnnnnn',NULL),(619,2,'You created a ','create','2021-03-17 01:45:46','post',142,'p',NULL),(654,2,'You created a ','create','2021-03-17 09:03:20','post',145,' ffffffffffffff',NULL),(655,2,'You deleted a','delete','2021-03-17 09:03:38','post',145,'ffffffffffffff',NULL),(656,2,'You updated ','update','2021-03-17 09:59:18','post',50,'author of the month in january',NULL),(657,2,'You updated ','update','2021-03-17 10:09:27','post',50,'author of the month in january',NULL),(658,2,'You updated ','update','2021-03-17 10:10:32','post',50,'author of the month in january',NULL),(659,2,'You updated ','update','2021-03-17 10:10:47','post',50,'author of the month in january',NULL),(660,2,'You logged out from your','logout','2021-03-17 14:10:37','profile',NULL,NULL,NULL),(661,2,'You logged into your ','login','2021-03-17 14:11:41','profile',NULL,NULL,NULL),(662,2,'You logged into your ','login','2021-04-03 23:37:03','profile',NULL,NULL,NULL),(663,2,'You updated your ','update','2021-04-03 23:38:56','profile picture',NULL,NULL,NULL),(664,2,'You deleted your ','delete','2021-04-03 23:39:10','profile picture',NULL,NULL,NULL),(665,2,'You logged out from your','logout','2021-04-03 23:56:45','profile',NULL,NULL,NULL),(666,2,'You logged into your ','login','2021-04-03 23:57:03','profile',NULL,NULL,NULL);
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `alert` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` enum('info','warning','success','delete','money','comment','reply','follow','like','dislike','update','reset','unfollow') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'info',
  `alert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_by_user` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts`
--

LOCK TABLES `alerts` WRITE;
/*!40000 ALTER TABLE `alerts` DISABLE KEYS */;
INSERT INTO `alerts` VALUES (1,2,'A new monthly report is ready to download!','info','2020-12-05 01:22:26','no'),(2,2,'€220.5 has been deposited into your account!','money','2020-12-07 01:22:26','no'),(3,2,'Spam Alert: We\'ve noticed unusually high comments for your post.','warning','2020-12-12 01:24:12','no'),(4,1,'A new monthly report is ready to download!','info','2020-12-05 01:22:26','no'),(5,1,'€290.29 has been deposited into your account!','money','2020-12-07 01:22:26','no'),(6,1,'Spending Alert: We\'ve noticed unusually high spending for your account.','warning','2020-12-12 01:24:12','no'),(7,3,'Puskar commented on your post my progress till date','comment','2021-01-20 22:15:19','no'),(12,3,'Puskar liked your post my progress till date','dislike','2021-01-22 17:05:23','no'),(20,1,'Your post Five Habits that can improve your life was successfully updated ','update','2021-01-25 00:32:42','no'),(23,1,'Puskar followed you ','follow','2021-01-25 14:55:00','no'),(51,3,'Puskar liked your post my progress till  now','like','2021-02-06 00:16:14','no'),(156,3,'Bishal followed you ','follow','2021-02-10 15:32:40','no'),(221,30,'Puskar commented on your post karma came towards me','comment','2021-02-12 05:13:41','no'),(237,1,'Your post certainly of course was successfully updated ','update','2021-02-13 10:18:32','no'),(252,1,'Your post Five Habits that can improve your life was successfully updated ','update','2021-03-17 05:31:49','no'),(253,1,'Your post Five Habits that can improve your life was successfully updated ','update','2021-03-17 05:33:40','no'),(255,1,'Your post Second post on hamro katha blog was successfully updated ','update','2021-03-17 06:11:10','no'),(256,1,'Your post Five Habits that can improve your life was successfully updated ','update','2021-03-17 06:14:45','no'),(279,1,'Your post Five Habits that can improve your life was successfully updated ','update','2021-03-17 07:53:56','no');
/*!40000 ALTER TABLE `alerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alerts_log`
--

DROP TABLE IF EXISTS `alerts_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alerts_log` (
  `user_id` int(11) NOT NULL,
  `type` enum('info','warning','success','danger','money','comment','reply','follow','like','dislike','update') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'info',
  `notification` enum('on','off') NOT NULL DEFAULT 'on',
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alerts_log`
--

LOCK TABLES `alerts_log` WRITE;
/*!40000 ALTER TABLE `alerts_log` DISABLE KEYS */;
INSERT INTO `alerts_log` VALUES (2,'info','on'),(2,'money','on'),(2,'warning','on'),(1,'info','on'),(1,'money','on'),(1,'warning','on'),(3,'comment','on'),(2,'follow','on'),(3,'dislike','on'),(1,'update','on'),(2,'update','on'),(1,'follow','on'),(3,'like','on'),(1,'like','on'),(1,'dislike','on'),(3,'follow','on'),(2,'comment','on'),(2,'dislike','on'),(30,'comment','on'),(30,'update','on');
/*!40000 ALTER TABLE `alerts_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `body` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` enum('Visible','Hidden','In-Review','') NOT NULL DEFAULT 'Visible',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (102,2,1,'ok there was a problem of not being logged in. thank god i patched the big on time','Visible','2020-11-27 13:54:08','2021-02-08 20:48:22'),(108,1,3,'this is my comment','Visible','2020-11-28 00:33:21',NULL),(109,1,129,'jjhmh','Visible','2020-12-17 07:51:21',NULL),(140,1,121,'jk.jk.','Visible','2021-01-01 09:16:00',NULL),(151,2,7,'look at this','Visible','2021-01-08 16:59:57',NULL),(177,2,129,'ok this is the test of the activity log','Visible','2021-01-14 19:21:27',NULL),(178,2,1,'now is the test of activity log789','Visible','2021-01-14 23:38:11','2021-02-08 20:55:28'),(179,2,50,'hello people','Visible','2021-01-15 21:04:10',NULL),(180,2,3,'ok','Visible','2021-01-20 22:15:18',NULL),(181,1,121,'welcome bro','Visible','2021-01-20 22:24:01',NULL),(182,1,121,'looks','Visible','2021-02-06 03:41:32',NULL),(183,1,121,'kich kich','Visible','2021-02-06 03:53:55',NULL),(184,1,121,'new looks and new button','Visible','2021-02-06 04:15:46',NULL),(185,1,121,'new looks butons','Visible','2021-02-06 04:17:44',NULL),(191,2,47,'reply','Visible','2021-02-06 06:57:57',NULL),(192,2,47,'hfghfgh','Visible','2021-02-06 07:04:40',NULL),(195,2,121,'hhhhhh','Visible','2021-02-06 07:42:09',NULL),(206,2,1,'encode','Visible','2021-02-07 11:08:41',NULL),(237,2,1,'mmmmmmmmmmmmmmolkp','Visible','2021-02-07 11:59:15','2021-02-08 20:47:16'),(241,2,50,'new comment','Visible','2021-02-08 19:52:34',NULL),(242,30,129,'','Visible','2021-02-10 17:18:59',NULL),(243,30,129,'','Visible','2021-02-10 17:19:09',NULL),(245,30,136,'oh my god what a great news','Visible','2021-02-10 17:24:01',NULL),(250,30,140,'bbbbbbbbbbbb           ziz7iknzizui','Visible','2021-02-12 02:22:25',NULL),(260,2,3,'zzzzznuuuuuunooooonppp','Visible','2021-02-12 08:57:51',NULL),(261,2,3,'tttnionyounwillnbe given right','Visible','2021-02-12 08:58:23',NULL),(262,2,3,'you will be given right','Visible','2021-02-12 08:58:49',NULL),(263,2,140,'helli','Visible','2021-02-13 10:26:09',NULL);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `first name` text NOT NULL,
  `last name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic` (`topic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `followers` (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  PRIMARY KEY (`follow_id`),
  KEY `receiver_id` (`receiver_id`),
  KEY `sender_id` (`sender_id`),
  CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followers`
--

LOCK TABLES `followers` WRITE;
/*!40000 ALTER TABLE `followers` DISABLE KEYS */;
INSERT INTO `followers` VALUES (3,3,2),(45,3,1),(49,2,1);
/*!40000 ALTER TABLE `followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_log`
--

DROP TABLE IF EXISTS `message_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message_log` (
  `user_id` int(15) NOT NULL,
  `sender_id` int(15) NOT NULL,
  `notification` enum('on','off') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'on',
  `archive` enum('no','yes') NOT NULL DEFAULT 'no',
  KEY `user_id` (`user_id`),
  KEY `sender_id` (`sender_id`),
  CONSTRAINT `message_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `offline_messages` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `message_log_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `offline_messages` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `message_log_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `message_log_ibfk_4` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_log`
--

LOCK TABLES `message_log` WRITE;
/*!40000 ALTER TABLE `message_log` DISABLE KEYS */;
INSERT INTO `message_log` VALUES (1,2,'on','no'),(2,4,'on','no'),(2,5,'on','no'),(2,6,'on','no'),(2,7,'on','no'),(1,4,'on','no'),(1,5,'on','no'),(1,6,'on','no'),(1,7,'on','no'),(3,4,'on','no'),(3,5,'on','no'),(3,6,'on','no'),(3,7,'on','no'),(1,1,'on','no'),(2,2,'on','no');
/*!40000 ALTER TABLE `message_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offline_messages`
--

DROP TABLE IF EXISTS `offline_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `offline_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `sent_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_by_user` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no',
  `notification` enum('on','off') NOT NULL DEFAULT 'on',
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `offline_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offline_messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offline_messages`
--

LOCK TABLES `offline_messages` WRITE;
/*!40000 ALTER TABLE `offline_messages` DISABLE KEYS */;
INSERT INTO `offline_messages` VALUES (1,2,4,'Hi there! I am wondering if you can help me with a problem I\'ve been having.','2020-12-14 16:38:45','yes','off'),(2,2,5,'I have the photos that you ordered last month!','2020-12-08 16:34:40','yes','off'),(3,2,6,'Last month\'s report looks great, I am very happy with the progress so far, keep up the good work!','2020-12-06 16:37:11','yes','off'),(4,2,7,'Did you solve the posting issue of last week that a user reported to us?','2020-12-01 16:37:56','yes','off'),(5,1,4,'Hi there! I am wondering if you can help me with a problem I\'ve been having.','2020-12-09 16:38:45','no','on'),(6,1,5,'I have the photos that you ordered last month!','2020-12-08 16:34:40','no','on'),(7,1,6,'Last month\'s report looks great, I am very happy with the progress so far, keep up the good work!','2020-12-06 16:37:11','no','on'),(8,1,7,'Did you solve the posting issue of last week that a user reported to us?','2020-12-01 16:37:56','no','on'),(9,3,4,'Hi there! I am wondering if you can help me with a problem I\'ve been having.','2020-12-09 16:38:45','no','on'),(10,3,5,'I have the photos that you ordered last month!','2020-12-08 16:34:40','no','on'),(11,3,6,'Last month\'s report looks great, I am very happy with the progress so far, keep up the good work!','2020-12-06 16:37:11','no','on'),(12,3,7,'Did you solve the posting issue of last week that a user reported to us?','2020-12-01 16:37:56','no','on'),(13,1,1,'hh','2021-01-25 17:38:19','no','on'),(14,1,1,'kuzkukuzk','2021-01-25 17:39:21','no','on'),(17,2,2,'hey bro... thank you. i like your school of thought','2021-01-26 00:18:06','no','on'),(18,2,2,'thank you bro for your appreciation','2021-01-26 00:27:45','no','on');
/*!40000 ALTER TABLE `offline_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_topic`
--

DROP TABLE IF EXISTS `post_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_id` (`post_id`),
  KEY `topic relation with topic` (`topic_id`),
  CONSTRAINT `post relation with post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `topic relation with topic` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_topic`
--

LOCK TABLES `post_topic` WRITE;
/*!40000 ALTER TABLE `post_topic` DISABLE KEYS */;
INSERT INTO `post_topic` VALUES (1,1,1),(2,2,2),(3,47,6),(8,3,1),(11,7,2),(20,50,3),(72,121,6),(76,125,1),(79,129,3),(80,130,3),(84,135,2),(85,136,1),(88,140,3),(92,144,2);
/*!40000 ALTER TABLE `post_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `body` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `anonymity` enum('yes','no') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,'Five Habits that can improve your life','five-habits-that-can-improve-your-life',12,'banner.jpg','<p>first is eat and sleep well</p>','no',1,'2020-11-06 08:12:35','2021-03-17 07:53:56'),(2,1,'Second post on hamro katha blog','second-post-on-hamro-katha-blog',31,'banner.jpg','<p>This is the body of the second post on this site</p>','yes',1,'2020-11-12 10:24:55','2021-03-17 06:27:27'),(3,3,'my progress till date','my-progress-till-date',12,'','<p>till this date on november 5 i have progressed enough to pull all the post from the database as a relational table. i havealso progressed in editing and deleing them</p>\r\n\r\n<p>today november 14th, i have solve all my problems till date. now other tasks that are left are to sanitize the css and check the server side code from the user panel</p>\r\n\r\n<p>today(november 18th): solved the problem where the post lost its image when the author only updated the post and did not upload any new image.</p>\r\n\r\n<p> </p>\r\n\r\n<p>DECEMBER 13th. i am still not able to figure out why there is a paragraph tag automatically added in ckeditor through ajax call but it is fine when it is called through php server directly</p>\r\n','no',1,'2020-11-19 11:49:09','2020-12-13 14:25:07'),(7,3,'my progress till  now','my-progress-till-now',8,'','<p>till this date on november 5 i have progressed enough to pull all the post from the database as a relational table. i havealso progressed in editing and deleing them. but i still need to add some features</p>\r\n\r\n<p>Today (25th november 2020):</p>\r\n\r\n<p>today was the most progress that i achoeved in my project. I was able to allow user to view the author of the post in filtered post section and single post section. allow users to post the post as anonymous and display the author name in the post according to the selection of the user if he has posted it as anonymous or not. i also solved the problem where no author is seen for the user who has not set his username yet or who has not set his user first name or last name</p>\r\n\r\n<p> </p>\r\n','no',1,'2020-07-14 07:10:06','2020-11-25 15:11:22'),(47,1,'lets see the latest deals','lets-see-the-latest-deals',3,'','<p>ok this tis the latest deals</p>\r\n\r\n<p>only for november</p>\r\n','no',1,'2020-06-19 10:49:31','2020-11-14 10:04:38'),(50,1,'author of the month in january','author-of-the-month-in-january',9,'banner.jpg','<p>bad days</p>','yes',1,'2020-05-14 12:31:54','2021-03-17 10:10:46'),(121,2,'Introduction to puskar','introduction-to-puskar',23,'','<p>hello people,</p>\r\n\r\n<p>I am the new admin of this website.  please welcome me</p>','no',1,'2020-12-13 19:20:57','2021-01-25 00:34:15'),(125,2,'new features for the website','new-features-for-the-website',4,'','<p>thankk you for your patience. the new features are sooing going to be added.</p>','no',1,'2020-12-13 19:44:12','2021-03-17 08:09:35'),(129,1,'my complicated relationship','my-complicated-relationship',3,'','<p>sorry i do not have any complicted relationship.</p>\r\n\r\n<p>thanks for coming</p>','yes',1,'2021-02-03 06:42:47','2021-01-24 04:46:49'),(130,1,'certainly of course','certainly-of-course',1,'','<p>of course</p>\r\n\r\n<p>&nbsp;</p>','yes',0,'2020-12-17 06:57:21','2021-02-13 10:24:36'),(135,2,'my new way','my-new-way',1,'','<p><p>now i will go toward android programming to improve my skills. i have learnt enough to gain enough knowledge about jav. now i want to get more information with android programming.</p></p>','no',1,'2021-01-24 01:22:27','2021-01-24 04:09:31'),(136,2,'CK editor problems','ck-editor-problems',1,'','<p><p><p>Ck editor is having problems and i am trying to repair it</p></p></p>','no',1,'2021-01-24 04:13:41','2021-01-24 04:18:28'),(140,30,'karma came towards me','karma-came-towards-me',0,'','<p>I&nbsp;have&nbsp;been&nbsp;in&nbsp;a&nbsp;relationship&nbsp;for&nbsp;one&nbsp;and&nbsp;half&nbsp;year.It&nbsp;all&nbsp;started&nbsp;when&nbsp;he(&nbsp;H****)&nbsp;proposed&nbsp;me,firstly&nbsp;I&nbsp;said&nbsp;no&nbsp;and&nbsp;we&nbsp;became&nbsp;friends&nbsp;after nthat.We&nbsp;used&nbsp;2&nbsp;chat&nbsp;whole&nbsp;day&nbsp;long&nbsp;and&nbsp;shared&nbsp;everything&nbsp;with&nbsp;each&nbsp;other&nbsp;and&nbsp;after&nbsp;few&nbsp;months&nbsp;he&nbsp;asked&nbsp;me&nbsp;again&nbsp;and&nbsp;I&nbsp;agreed..He&nbsp;was the best&nbsp;guy&nbsp;any&nbsp;girll&nbsp;can&nbsp;have&nbsp;,extreme&nbsp;loving&nbsp;and&nbsp;caring&nbsp;but&nbsp;I&nbsp;was&nbsp;very&nbsp;careless&nbsp;and&nbsp;casual&nbsp;in&nbsp;the&nbsp;relationship&nbsp;and&nbsp;used to&nbsp;fight&nbsp;on&nbsp;silly&nbsp;matters. he&nbsp;tried&nbsp;his&nbsp;level&nbsp;best&nbsp;at&nbsp;each and every&nbsp;&nbsp;point to&nbsp;make&nbsp;it&nbsp;work&nbsp;and&nbsp;saved&nbsp;it&nbsp;always..He&nbsp;was&nbsp;damn&nbsp;serious&nbsp;and&nbsp;wanted to&nbsp;marry&nbsp;me&nbsp;but&nbsp;I&nbsp;treated&nbsp;him&nbsp;as&nbsp;an&nbsp;option (but&nbsp;I&nbsp;loved&nbsp;him&nbsp;a&nbsp;lot)..Till&nbsp;now&nbsp;everything&nbsp;was&nbsp;just&nbsp;like a&nbsp;fairy&nbsp;tale for&nbsp;me&nbsp;but&nbsp;time changed. he&nbsp;came to&nbsp;know that&nbsp;his&nbsp;father&nbsp;had&nbsp;cancer..He&nbsp;was&nbsp;broken&nbsp;but&nbsp;still&nbsp;I&nbsp;didn&#39;t&nbsp;realized&nbsp;anything and&nbsp;kept&nbsp;my&nbsp;ego&nbsp;and&nbsp;attitude&nbsp;above&nbsp;all. Due to&nbsp;some&nbsp;problems, he&nbsp;had to&nbsp;leave&nbsp;his&nbsp;home&nbsp;and&nbsp;was&nbsp;left&nbsp;all&nbsp;alone&nbsp;and&nbsp;still&nbsp;I&nbsp;was&nbsp;at&nbsp;my&nbsp;worst and never&nbsp;supported&nbsp;him. Then&nbsp;after&nbsp;few&nbsp;months&nbsp;he&nbsp;lost&nbsp;his&nbsp;father. After&nbsp;that&nbsp;gradually&nbsp;our&nbsp;relation&nbsp;lost&nbsp;importance to&nbsp;him. He&nbsp;started&nbsp;avoiding&nbsp;my&nbsp;messages,calls,his&nbsp;behavior&nbsp;changed&nbsp;towards&nbsp;me. Finally&nbsp;he&nbsp;broke&nbsp;up&nbsp;with&nbsp;me&nbsp;few&nbsp;months&nbsp;ago. I&nbsp;apologized to&nbsp;him&nbsp;several&nbsp;times&nbsp;but&nbsp;he&nbsp;doesnt&nbsp;wanna&nbsp;listen anythng . I&nbsp;tried&nbsp;a&nbsp;lot to&nbsp;make&nbsp;him&nbsp;stay&nbsp;but&nbsp;nothing&nbsp;worked..Now&nbsp;he&nbsp;doesnt&nbsp;even&nbsp;&nbsp;care&nbsp;about&nbsp;me&nbsp;if&nbsp;I&nbsp;will&nbsp;even&nbsp;die. I&nbsp;don&#39;t&nbsp;know what to&nbsp;do to&nbsp;make&nbsp;him&nbsp;realize that&nbsp;I&nbsp;have&nbsp;changed&nbsp;I&nbsp;still&nbsp;love him&nbsp;and&nbsp;will&nbsp;love for&nbsp;ever and cant&nbsp;even&nbsp;think&nbsp;of&nbsp;living&nbsp;without&nbsp;him. I&nbsp;know&nbsp;I&nbsp;am&nbsp;being&nbsp;punished&nbsp;for&nbsp;what&nbsp;I&nbsp;did to&nbsp;him&nbsp;(#&nbsp;Karma) and I&nbsp;have&nbsp;faced&nbsp;every&nbsp;single&nbsp;thing&nbsp;which&nbsp;I&nbsp;did to&nbsp;him&nbsp;earlier and now&nbsp;I&nbsp;realized&nbsp;how&nbsp;much&nbsp;he&nbsp;was&nbsp;hurt&nbsp;but&nbsp;&nbsp;will&nbsp;it&nbsp;come to&nbsp;an&nbsp;end and everything&nbsp;would&nbsp;be&nbsp;like&nbsp;before???&quot;</p>','yes',1,'2021-02-12 01:20:57','2021-02-13 10:25:11'),(144,2,'my lovejjj','my-lovejjj',0,NULL,'<p>jjhjjjjjjjjjjjjj</p>\r\n','yes',1,'2021-03-17 04:59:26',NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rating_info`
--

DROP TABLE IF EXISTS `rating_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rating_info` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `rating_action` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  UNIQUE KEY `UC_rating_info` (`user_id`,`post_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `rating_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `rating_info_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating_info`
--

LOCK TABLES `rating_info` WRITE;
/*!40000 ALTER TABLE `rating_info` DISABLE KEYS */;
INSERT INTO `rating_info` VALUES (3,1,'like'),(3,2,'dislike'),(3,3,'dislike'),(3,7,'like'),(1,7,'like'),(1,130,'dislike'),(2,121,'like'),(1,50,'dislike'),(1,3,'like'),(1,121,'like'),(2,3,'like'),(2,125,'like'),(2,129,'like'),(2,47,'like'),(2,2,'dislike'),(2,135,'like'),(2,50,'like'),(2,1,'dislike'),(2,7,'like'),(1,129,'dislike'),(1,135,'like'),(1,125,'dislike'),(30,136,'dislike'),(30,129,'dislike');
/*!40000 ALTER TABLE `rating_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `replies`
--

DROP TABLE IF EXISTS `replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `replies` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `comment_id` int(255) NOT NULL,
  `body` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `status` enum('Visible','Hidden','In-Review','') NOT NULL DEFAULT 'Visible',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `replies_ibfk_2` (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replies`
--

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
INSERT INTO `replies` VALUES (93,1,151,'ok bro','Visible','2021-01-08 18:33:30',NULL),(96,2,151,'bro thid is mine','Visible','2021-01-09 13:16:26',NULL),(97,2,109,'this is the reply test for the activity log','Visible','2021-01-14 19:32:05',NULL),(100,1,180,'very nice job once gain','Visible','2021-01-20 22:45:27',NULL),(102,1,180,'you also motivate me to code','Visible','2021-01-20 22:51:53',NULL),(103,1,180,'i am working right now to make alerts appear on top of the navigation bar','Visible','2021-01-20 22:53:54',NULL),(104,1,180,'you are greatly motivated. very nice','Visible','2021-01-20 23:08:23',NULL),(110,1,109,'','Visible','2021-02-07 09:40:00',NULL),(111,1,109,'','Visible','2021-02-07 09:40:07',NULL),(112,1,109,'','Visible','2021-02-07 09:40:14',NULL),(113,1,109,'','Visible','2021-02-07 09:40:21',NULL);
/*!40000 ALTER TABLE `replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `msg` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('open','closed','resolved','pending','on-hold') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'open',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'Test Ticket','This is your first ticket.','support@codeshack.io','2020-06-10 13:06:17','pending'),(12,'i hate tigerdeald','they have not yet paid my money','prakhar.deutschland@gmail.com','2020-11-28 15:23:59','resolved'),(30,'my love','123','prakhar.deutschland@gmail.com','2020-12-11 00:19:56','on-hold'),(33,'b','b','b.b.gyawali@gmail.com','2020-12-11 00:48:24','closed'),(36,'    mmmmmmmm','jjjjj','Kancha@mailpoof.com','2020-12-11 01:03:11','pending'),(42,'i hate tigerdeald','iiii','prakhar.deutschland@gmail.com','2020-12-12 07:23:17','closed'),(48,'newboy in town','very nice','prakhar.deutschland@gmail.com','2021-01-24 13:31:11','open'),(49,'data tables issue','datatables sorting not working after dynamicallyadded data','prakhar.deutschland@gmail.com','2021-01-24 13:43:45','open'),(51,'data tabletest','8888888888','prakhar.deutschland@gmail.com','2021-01-24 13:50:07','open'),(52,'my love in house','i','prakhar.deutschland@gmail.com','2021-01-24 13:57:02','open'),(53,'my love','iiu','prakhar.deutschland@gmail.com','2021-01-24 14:31:09','open'),(58,'data id check','hhh','prakhar.deutschland@gmail.com','2021-01-24 16:18:09','on-hold');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets_comments`
--

DROP TABLE IF EXISTS `tickets_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets_comments`
--

LOCK TABLES `tickets_comments` WRITE;
/*!40000 ALTER TABLE `tickets_comments` DISABLE KEYS */;
INSERT INTO `tickets_comments` VALUES (123,12,'kill me','2020-12-12 06:38:55'),(124,12,'kill me please','2020-12-12 06:39:24'),(125,12,'ok bro','2020-12-12 06:44:31'),(126,12,'bro','2020-12-12 06:44:44'),(127,12,'here is the sign','2020-12-12 06:45:03'),(130,30,'ok','2020-12-12 06:58:48'),(131,30,'ok hu','2020-12-12 06:59:50'),(132,30,'ok singh','2020-12-12 07:00:02'),(134,1,'point','2020-12-12 07:02:10'),(135,30,'g','2020-12-12 07:03:41'),(136,30,'ploster','2020-12-12 07:04:34'),(137,30,'see?','2020-12-12 07:04:46'),(138,42,'i hate when such things happen','2020-12-12 07:24:08'),(140,42,'dddd','2021-01-24 23:41:10'),(141,49,'made some improvements but finally quit datatables','2021-01-24 23:43:57'),(142,58,'data id check is a blessing','2021-01-24 23:45:27'),(143,58,'it has worked perfectly','2021-01-24 23:45:42'),(144,58,'and helped me a lot as well','2021-01-24 23:47:39'),(145,58,'tgrtgsgdfg','2021-01-24 23:50:04'),(146,58,'ok','2021-01-24 23:51:10'),(147,58,'olo','2021-01-24 23:52:31'),(148,51,'it is good but it also has some issues','2021-01-24 23:53:40'),(149,48,'wow','2021-01-24 23:55:17'),(150,58,'ok','2021-01-24 23:57:01'),(151,58,'ok','2021-01-24 23:57:14'),(152,58,'ok','2021-01-24 23:57:54'),(153,58,'kk','2021-01-24 23:58:45'),(154,58,'ok','2021-01-25 00:00:48'),(155,58,'kkjjjj&lt;&lt;&lt;p&gt;','2021-01-25 00:02:26'),(156,36,'cvbcvbcvb','2021-01-25 00:40:46');
/*!40000 ALTER TABLE `tickets_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Other',
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'other',
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_topic` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (1,'Inspirations','inspirations'),(2,'Motivations','motivations'),(3,'Confessions','confessions'),(6,'Stories','stories'),(45,'love stories','love-stories');
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userlogs`
--

DROP TABLE IF EXISTS `userlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userlogs` (
  `user_id` int(255) NOT NULL,
  `login_status` int(255) NOT NULL DEFAULT '0',
  `last_login_attempt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_logout` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_password_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hash_method` int(11) NOT NULL DEFAULT '2',
  `user_status` enum('Disabled','Locked','Unauthenticated','Enabled') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Unauthenticated',
  `verified` enum('yes','no') NOT NULL DEFAULT 'no',
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_2` (`user_id`),
  UNIQUE KEY `user_id_3` (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userlogs`
--

LOCK TABLES `userlogs` WRITE;
/*!40000 ALTER TABLE `userlogs` DISABLE KEYS */;
INSERT INTO `userlogs` VALUES (1,0,'2021-03-13 00:18:59','2021-03-13 00:20:33','2021-01-03 01:35:20',2,'Enabled','yes','needs to be checked'),(2,0,'2021-04-03 23:57:03','2021-04-03 23:56:45','2021-02-03 15:45:17',2,'Enabled','yes',''),(3,0,'2020-12-23 04:23:45','2020-12-16 19:43:47','2020-12-14 13:01:36',1,'Enabled','no',''),(4,0,'2020-12-05 03:33:38','2020-12-16 19:43:47','2020-12-14 13:01:36',1,'Enabled','no',NULL),(5,5,'2020-12-05 03:33:38','2020-12-16 19:43:47','2020-12-14 13:01:36',1,'Locked','no','was blocked dueto spam attack'),(6,1,'2021-01-18 13:33:22','2021-01-17 11:51:37','2020-12-14 13:01:36',2,'Enabled','no',''),(7,2,'2021-03-13 00:21:11','2021-01-18 18:38:08','2020-12-14 13:05:19',1,'Enabled','no',NULL),(12,0,'2020-12-14 13:05:19','2020-12-16 19:43:47','2020-12-14 13:05:19',1,'Enabled','no',NULL),(27,0,'2020-12-14 13:05:19','2020-12-16 19:43:47','2020-12-14 13:05:19',1,'Enabled','no','o'),(30,0,'2021-03-13 05:57:46','2021-03-13 05:56:22','2021-02-10 08:30:11',1,'Enabled','no',NULL),(36,0,'2020-12-14 13:05:19','2020-12-16 19:43:47','2020-12-14 13:05:19',1,'Enabled','no',NULL),(56,0,'2020-12-14 21:24:32','2020-12-16 19:43:47','2020-12-14 21:24:32',1,'Enabled','no',NULL),(58,3,'2020-12-14 21:58:07','2020-12-16 19:43:47','2020-12-14 21:58:07',1,'Enabled','no',NULL),(60,0,'2020-12-14 22:27:15','2020-12-16 19:43:47','2020-12-14 22:27:15',1,'Enabled','no',NULL),(65,0,'2020-12-17 02:56:05','2020-12-17 02:56:05','2020-12-17 02:56:05',1,'Enabled','no',NULL),(66,5,'2020-12-17 02:58:42','2020-12-17 02:58:42','2020-12-17 02:58:42',1,'Locked','no',NULL),(71,0,'2021-01-09 19:55:10','2021-01-09 19:55:10','2021-01-09 19:55:10',2,'Enabled','no',NULL),(72,17,'2021-01-14 12:24:16','2021-01-10 16:03:26','2021-01-10 16:03:26',2,'Unauthenticated','no',NULL),(73,0,'2021-01-23 20:42:45','2021-01-23 20:42:45','2021-01-23 20:42:45',2,'Unauthenticated','no',NULL);
/*!40000 ALTER TABLE `userlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `user_type` enum('user','admin','editor','owner') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'user',
  `login` enum('home','dashboard','index') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'home',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sex` enum('male','female','other','not mentioned') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'not mentioned',
  `profile_image` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `googleplus` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Prakhar','dd@dd.com','$2y$10$yiAfNJjz7obQY4pcnwh/mOWXQNLkVDp3Fs8S9XvkdYd1dqaKGanKi','admin','home','2020-10-31 05:34:00','2021-02-04 04:16:16','Prakhar','Gyawali','not mentioned','712283377_1_01_11_21_3209.jpg','p','p','p'),(2,'Puskar','prakhar.deutschland@gmail.com','$2y$10$h9rccJwLT3h25upxvSL5OuAwXYT/clJEH1zvcxcoIhtkJ5knmiKNK','owner','dashboard','2020-10-31 05:34:00','2021-04-03 23:39:10','Puskar','Gyawali','not mentioned','1617493150.png','prkr.pskr','@philieep','@puskar'),(3,'Bishal','vishal.b.gyawali@gmail.com','0f846e792ce4ca829550ade3c1ee7a34','user','home','2020-11-04 03:32:00',NULL,'Bishal Bikram','gyawali','not mentioned','meadmin.png',NULL,NULL,NULL),(4,'Emily','Emily.Fowler@gmail.com','0f846e792ce4ca829550ade3c1ee7a34','user','home','2020-10-31 05:34:00','2021-01-23 21:00:13','Emily','Fowler','female','avatar4.jpeg',NULL,NULL,NULL),(5,'JaeChun','Jae.Chun@gmail.com','0f846e792ce4ca829550ade3c1ee7a34','user','home','2020-10-31 05:34:00','2021-01-23 21:08:54','Jae','Chun','male','avatar2.jpeg','','',''),(6,'Morgan.Alvarez','Morgan.Alvarez@gmail.com','$2y$10$/2Rwu2Vs6fERQD9IAYH.HOyEp2PGSccNrl.z4l0Xp5Ls1jhm6m3Fq','user','home','2020-11-04 03:32:00','2021-01-17 11:27:54','Morgan','Alvarez','male','avatar3.jpeg',NULL,NULL,NULL),(7,'Pagal.Manche','Pagal.Manche@gmail.com','$2y$10$iOmP5MgyghqfVexIIZ7gEOcYI6C821duX8YoceQM3UiIBfVkja/zS','user','home','2020-11-04 03:32:00','2021-01-18 15:15:22','Pagal','Manche','male','avatar5.jpeg',NULL,NULL,NULL),(12,'Prakharu','prakrar.b.gyawvbbbali@gmail.com','0f846e792ce4ca829550ade3c1ee7a34','admin','home','2020-10-31 05:34:00','2021-01-23 15:41:08','Prakhar','Gyawali','female','',NULL,NULL,NULL),(27,'Puskarbabu','prakhar.newzealand@gmail.com','0f846e792ce4ca829550ade3c1ee7a34','editor','home','2020-10-31 05:34:00','2021-01-23 21:29:54','Puskar','Gyawali','male',NULL,NULL,NULL,NULL),(30,'gyawali','123@wert.com','$2y$10$ZXq1uM2w8KYVqHB9555wi.h6Deu7ie7/kPaeYgOwL47BQuYrRY2fW','user','home','2020-11-01 17:03:29','2021-03-13 05:57:45','pokche','','male',NULL,NULL,NULL,NULL),(36,'puskarbhagat','prhar.deutschland@gmail.com','$2y$10$yVbuIPkUDN/17Ipt2ZcHOeYVhO3pYBjWegWgYb9N3KZ9aX9C5vene','admin','home','2020-11-08 12:23:18','2021-01-31 07:28:57',NULL,NULL,'other','1611415155.png',NULL,NULL,NULL),(56,'nbaplayer','nba@fff.com','0c01a11037b7d979ebf71b45efb21306','user','home','2020-12-14 21:24:32','2021-01-23 21:52:13','','','not mentioned','1611415156.png',NULL,NULL,NULL),(58,'zzzzzzzzz','zzzzzzzzz@zzzz.com','0be286a3583a0b7209bdc2b1cfe78577','user','home','2020-12-14 21:58:07','2021-01-23 21:54:52','','','not mentioned','1611415156.png',NULL,NULL,NULL),(60,'zzzzz','2@44.bom','5059437b8a54d05c09884405ebaf7fb1','user','home','2020-12-14 22:27:14','2021-01-23 21:59:30','','','not mentioned','1611415157.png',NULL,NULL,NULL),(65,'puskarthegreatest','puskarthegeed@gmail.com','c4ca4238a0b923820dcc509a6f75849b','user','home','2020-12-17 02:56:05','2021-01-23 15:19:17',NULL,NULL,'not mentioned','1611415157.png',NULL,NULL,NULL),(66,'puskarmlserty','puskarmlserty@gh.com','4f66bd78fd09d940b183ad356fd58070','user','home','2020-12-17 02:58:42','2021-01-23 15:19:17',NULL,NULL,'not mentioned','1611415157.png',NULL,NULL,NULL),(71,'posinterüpo','pr.land@gmail.com','$2y$10$k1s/gpQCgii9FXolnXTiPua0aFIJrQCBEhIdp9nFBNJEHz3WbM8.6','user','home','2021-01-09 19:55:10','2021-01-23 15:19:18',NULL,NULL,'not mentioned','1611415158.png',NULL,NULL,NULL),(72,'posinterprok','prakhar.b.gyawali@gmail.com','$2y$10$DDl/8lSrH9vqEhFpF2qz5eX7i.GolQ3BZIs69nnqgizFz.LeebA8W','user','home','2021-01-10 16:03:26','2021-01-23 15:19:18',NULL,NULL,'not mentioned','1611415158.png',NULL,NULL,NULL),(73,'gyawalibabu','gyawalibabu@gmail.com','$2y$10$Y9.jhmWcQHQV7v1HeM/xpuFxNCWj19uDYu9SHMX7FD10oG/THVIB2','user','home','2021-01-23 20:42:44','2021-01-23 20:55:11','','','not mentioned','1611434564.png',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verify_table`
--

DROP TABLE IF EXISTS `verify_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `verify_table` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `token_type` enum('password_reset','account_verify','email_verify','password_verify') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'password_reset',
  `token_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verify_table`
--

LOCK TABLES `verify_table` WRITE;
/*!40000 ALTER TABLE `verify_table` DISABLE KEYS */;
INSERT INTO `verify_table` VALUES (4,NULL,'vishal.deutschland@gmail.com','a04c78ced3a724a02c5dc9ddeb9dbbe35f003ab2406346ac1a386c0a46e8f12b2b1db3f917e7b91e759334264b0acc5d0c8a','password_reset','2021-01-01 13:32:08'),(6,NULL,'123@wert.com','36b6e796769c6464e9121abc8fc2b367273d0a9138d6366b6b4742ec54448409579ec926847b67d8130f24f99a35f048911a','password_reset','2021-01-01 13:32:08'),(11,NULL,'123111111111@w.com','9e87e5651b4b6314518c1e9169808be0c4a39166c9ee64cb1f0f75d60218bf473279344f0831fc6a78934d2431ebb9628428','password_reset','2021-01-01 13:32:08'),(12,NULL,'123@wert.com','6485ef4a4341086f27e6180ea686ec7101fe7aae112f18e6fda00e6f37a43dde3178b2981124cdbd767c098254fffda9aa97','password_reset','2021-01-01 13:32:08'),(36,NULL,'prakhar.b.gyawali@gmail.com','e7ca5f08af45c3fd12947d98d73b6233614af11a3324c6bd82296be215e5ea0c3d8f4e91513b7b2ac59676ffad2c6fb8991a','account_verify','2021-01-10 16:03:27'),(38,NULL,'gyawalibabu@gmail.com','7b1f4459f65699f3064cf87932e9c41deae605abb331824fd7221b79b0966d9d0373040bc6dd0b6713f5b9340dfa1fdbdd99','account_verify','2021-01-23 20:42:45'),(50,NULL,'prakhar.deutschland@gmail.com','153507034be68d50472814ae62a6c1827f8a4c2bc7780b73092e08372ad5d2a95ec27702265fe5d9b4a3a2ca2ae38e270e38','password_reset','2021-01-31 10:27:18'),(51,NULL,'prakhar.deutschland@gmail.com','28ab5f5ff9fcfd677be76f32b46689202405d1fe900e82330b3329aadeb319502dacf7e95b031b021b5379995a5e5b5a94ad','password_reset','2021-01-31 08:53:19'),(52,NULL,'prakhar.deutschland@gmail.com','cb0b9904206d7caee71fa17c63eea60de416d8794f5dba4ed041adf6e1b3f878ce7526a765592627e7d2b2268d887ba331cc','password_reset','2021-01-31 10:55:48'),(53,2,'prakhar.deutschland@gmail.com','ae41ef3e305075db16e3d57cd4d670ca93266830bb27b6d87eec73a6402effeb8cb06a91cf9fc2ed2ec07ca306e109d4411f','password_reset','2021-01-31 09:25:33'),(54,2,'prakhar.deutschland@gmail.com','cdb691dcc1b43925e1c45ad914e4322b04943587d40f2fb02713cfdf8e2ec79f4184a9bc5190ebf80af8b5dbae2c96c728d1','password_reset','2021-01-31 09:33:33');
/*!40000 ALTER TABLE `verify_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor_log`
--

DROP TABLE IF EXISTS `visitor_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitor_log` (
  `views_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `views` bigint(25) GENERATED ALWAYS AS (((`chrome` + `firefox`) + `safari`)) STORED NOT NULL,
  `chrome` bigint(15) NOT NULL DEFAULT '0',
  `firefox` bigint(15) NOT NULL DEFAULT '0',
  `safari` bigint(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`views_id`),
  UNIQUE KEY `post_id` (`post_id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor_log`
--

LOCK TABLES `visitor_log` WRITE;
/*!40000 ALTER TABLE `visitor_log` DISABLE KEYS */;
INSERT INTO `visitor_log` (`views_id`, `post_id`, `owner_id`, `chrome`, `firefox`, `safari`) VALUES (1,1,60,4,3,13),(2,121,2,3,0,0),(3,125,2,3,0,0),(4,50,1,3,0,23),(5,3,3,4,0,0),(8,47,1,1,9,4),(14,7,3,1,0,0),(16,135,2,1,0,9),(19,2,1,0,1,0),(20,130,1,1,0,0),(22,136,2,1,0,0);
/*!40000 ALTER TABLE `visitor_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `website_data`
--

DROP TABLE IF EXISTS `website_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `website_data` (
  `website_id` int(11) NOT NULL AUTO_INCREMENT,
  `website_name` varchar(255) DEFAULT NULL,
  `website_tagline` varchar(255) DEFAULT NULL,
  `website_logo` varchar(255) DEFAULT NULL,
  `website_theme` enum('white','dark') NOT NULL DEFAULT 'white',
  `website_address` varchar(255) DEFAULT NULL,
  `user_target` bigint(25) NOT NULL,
  `website_email` varchar(255) DEFAULT NULL,
  `website_timezone` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_email` varchar(255) DEFAULT NULL,
  `owner_address` varchar(255) DEFAULT NULL,
  `owner_contact_no` bigint(25) DEFAULT NULL,
  `owner_postal_code` varchar(255) DEFAULT NULL,
  `owner_country` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`website_id`),
  UNIQUE KEY `website_address` (`website_address`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website_data`
--

LOCK TABLES `website_data` WRITE;
/*!40000 ALTER TABLE `website_data` DISABLE KEYS */;
INSERT INTO `website_data` VALUES (1,'Hamro Katha','Read and learn ok','logo with words_4_02_01_21_5226.png','dark','unknown',50,'contact@hamrokatha.com','Europe/Berlin','Prakhar Gyawali','prakhar.b.gyawali@gmail.com','hahnenstrasse, 7b',1745642303,'50354, hürth','Germany');
/*!40000 ALTER TABLE `website_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-08 18:30:52
