-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: kercode_network
-- ------------------------------------------------------
-- Server version	5.7.36

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
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Id de l''user ayant créé cette article',
  `content` text CHARACTER SET utf8 NOT NULL COMMENT 'Texte de l''article',
  `images` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Booléen servant à savoir si on doit charger des images ou pas',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `article_ibfk_1` (`user_id`),
  CONSTRAINT `article_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (1,1,'Les photos sont superbes !!',0,'2022-03-24 09:46:10','2022-05-19 11:41:50'),(3,1,'Test de post avec 2 images !',1,'2022-03-24 09:46:53','2022-03-24 09:46:53'),(4,1,'Test de post avec 3 images !',1,'2022-03-24 09:47:25','2022-03-24 09:47:25'),(5,1,'Test de post avec 5 images !',1,'2022-03-24 09:47:56','2022-03-24 09:47:56'),(6,1,'Test de publication avec le temps !',0,'2022-03-24 09:58:03','2022-03-24 09:58:03'),(18,3,'Test de publication avec un compte utilisateur !',1,'2022-04-06 11:10:06','2022-04-06 11:10:06'),(28,1,'Ceci est un post de test !',1,'2022-04-08 09:58:15','2022-04-08 09:58:15'),(29,1,'Article de test contenant beaucoup de caractères pour pouvoir faire des tests dans le panneau d&#039;administration ! J&#039;espère que le nombre de caractères sera suffisant pour les tests ! Blabla !!!',1,'2022-04-08 14:28:33','2022-04-08 15:28:55'),(32,1,'Blablabla123',1,'2022-04-20 13:56:46','2022-04-20 13:56:46'),(33,1,'Test blablacar',1,'2022-05-04 14:52:20','2022-05-04 14:52:20'),(36,1,'Test',1,'2022-05-06 11:21:07','2022-05-06 11:21:07'),(37,1,'Voici quelques photos de mon dernier voyage ! En espérant y retourner rapidement :P',1,'2022-05-07 09:41:20','2022-05-20 13:27:19'),(39,1,'Test du nouveau ORM !!!!',1,'2022-05-20 10:02:13','2022-05-20 13:27:10'),(41,9,'Test compte user',1,'2022-05-21 11:15:18','2022-05-21 11:15:18'),(42,9,'Test du nouveau helper !',1,'2022-05-21 11:36:39','2022-05-21 11:36:39'),(43,9,'3 images !',1,'2022-05-21 11:40:34','2022-05-21 11:40:34'),(44,1,'Test nouvelles statistiques !',1,'2022-05-26 12:25:16','2022-05-26 12:25:16');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_image`
--

DROP TABLE IF EXISTS `article_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_image` (
  `name` varchar(255) NOT NULL,
  `id` int(11) NOT NULL COMMENT 'id de l''article',
  KEY `article_id` (`id`),
  CONSTRAINT `article_image_ibfk_1` FOREIGN KEY (`id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_image`
--

LOCK TABLES `article_image` WRITE;
/*!40000 ALTER TABLE `article_image` DISABLE KEYS */;
INSERT INTO `article_image` VALUES ('1648111613_0.jpeg',3),('1648111613_1.jpeg',3),('1648111645_0.jpeg',4),('1648111645_1.jpeg',4),('1648111645_2.jpeg',4),('1648111676_0.jpeg',5),('1648111676_1.jpeg',5),('1648111676_2.jpeg',5),('1648111676_3.jpeg',5),('1648111676_4.jpeg',5),('1648203006_0.jpeg',18),('1649404695_0.jpeg',28),('1649420913_0.jpeg',29),('1649420913_1.jpeg',29),('1650455806_0.jpeg',32),('1650455806_1.jpeg',32),('1650459140_0.jpeg',33),('1650459140_1.jpeg',33),('1650459140_2.jpeg',33),('1650459140_3.jpeg',33),('1650459140_4.jpeg',33),('1650532867_0.png',36),('1650613280_0.jpeg',37),('1650613280_1.jpeg',37),('1650613280_2.jpeg',37),('1650613280_3.jpeg',37),('1650613280_4.jpeg',37),('1653040933_0.jpeg',39),('1653124518_0.jpeg',41),('1653124518_1.jpeg',41),('1653124518_2.jpeg',41),('1653124518_3.jpeg',41),('1653124518_4.jpeg',41),('1653125799_0.jpeg',42),('1653125799_1.jpeg',42),('1653125799_2.jpeg',42),('1653125799_3.jpeg',42),('1653126034_0.jpeg',43),('1653126034_1.jpeg',43),('1653126034_2.jpeg',43),('1653560716_0.jpeg',44),('1653560716_1.jpeg',44),('1653560716_2.jpeg',44);
/*!40000 ALTER TABLE `article_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_interaction_type`
--

DROP TABLE IF EXISTS `article_interaction_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_interaction_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'Nom de l''intéraction',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Type d''interactions pour les articles';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_interaction_type`
--

LOCK TABLES `article_interaction_type` WRITE;
/*!40000 ALTER TABLE `article_interaction_type` DISABLE KEYS */;
INSERT INTO `article_interaction_type` VALUES (1,'add_comment'),(2,'delete_comment'),(3,'add_like'),(4,'remove_like');
/*!40000 ALTER TABLE `article_interaction_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_user_interaction`
--

DROP TABLE IF EXISTS `article_user_interaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_user_interaction` (
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `interaction_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `article_interation_FK` (`article_id`),
  KEY `article_interation_FK_1` (`user_id`),
  KEY `article_user_interaction_FK` (`interaction_id`),
  CONSTRAINT `article_interation_FK` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  CONSTRAINT `article_interation_FK_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `article_user_interaction_FK` FOREIGN KEY (`interaction_id`) REFERENCES `article_interaction_type` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Enregistre toutes les intéractions liées aux articles (commentaires, likes, clic sur les images, etc...)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_user_interaction`
--

LOCK TABLES `article_user_interaction` WRITE;
/*!40000 ALTER TABLE `article_user_interaction` DISABLE KEYS */;
INSERT INTO `article_user_interaction` VALUES (43,1,3,'2022-05-26 10:18:52'),(43,1,4,'2022-05-26 10:18:54'),(42,1,3,'2022-05-26 10:18:58'),(43,1,3,'2022-05-26 10:19:01'),(43,1,1,'2022-05-26 10:54:04'),(43,1,2,'2022-05-26 10:54:11'),(44,1,3,'2022-05-26 12:33:27'),(44,1,1,'2022-05-26 12:33:44'),(44,1,1,'2022-05-26 12:35:00'),(43,1,4,'2022-05-26 12:43:47'),(43,1,3,'2022-05-26 12:43:50'),(43,1,1,'2022-05-26 12:43:59'),(43,1,1,'2022-05-27 09:20:58'),(36,1,3,'2022-05-28 22:33:38');
/*!40000 ALTER TABLE `article_user_interaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_user_like`
--

DROP TABLE IF EXISTS `article_user_like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_user_like` (
  `article_id` int(11) DEFAULT NULL COMMENT 'Id de l''article concerné',
  `user_id` int(11) DEFAULT NULL COMMENT 'Id de l''utilisateur qui a liké',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `article_like_FK` (`article_id`),
  KEY `article_like_FK_1` (`user_id`),
  CONSTRAINT `article_like_FK` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  CONSTRAINT `article_like_FK_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table de liaison entre les articles et les utilisateurs pour enregistrer les likes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_user_like`
--

LOCK TABLES `article_user_like` WRITE;
/*!40000 ALTER TABLE `article_user_like` DISABLE KEYS */;
INSERT INTO `article_user_like` VALUES (41,1,'2022-05-22 18:14:44','2022-05-22 18:14:44'),(39,1,'2022-05-22 18:27:12','2022-05-22 18:27:12'),(42,1,'2022-05-26 10:18:58','2022-05-26 10:18:58'),(44,1,'2022-05-26 12:33:27','2022-05-26 12:33:27'),(43,1,'2022-05-26 12:43:50','2022-05-26 12:43:50'),(36,1,'2022-05-28 22:33:38','2022-05-28 22:33:38');
/*!40000 ALTER TABLE `article_user_like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,37,3,'Les photos sont superbes !','2022-04-25 09:04:51','2022-05-19 11:43:13'),(2,37,5,'Ca donne envie de partir en voyage !','2022-04-25 09:05:54','2022-04-25 09:05:54'),(3,37,6,'J\'y ai été il y a 2 ans aussi. Que de bons souvenirs ! Une destination de rêve ! Je conseil vraiment ;)','2022-04-25 09:08:04','2022-04-25 09:08:04'),(4,36,1,'First !\r\n','2022-04-26 11:16:47','2022-05-17 19:00:17'),(5,36,1,'Commentaire de test\r\n','2022-04-26 11:17:22','2022-04-26 11:17:22'),(8,37,1,'Test\r\n','2022-04-26 11:24:39','2022-04-26 11:24:39'),(9,37,1,'Test\r\n','2022-04-26 11:24:45','2022-04-26 11:24:45'),(10,37,1,'Hello World!','2022-04-26 11:27:19','2022-04-26 11:27:19'),(11,37,1,'Blabla !','2022-04-26 11:28:38','2022-04-26 11:28:38'),(12,36,3,'Super test de commentaire !','2022-04-26 11:32:37','2022-04-26 11:32:37'),(13,37,3,'Superbes photos !','2022-04-26 11:33:07','2022-04-26 11:33:07'),(15,37,1,'Hourra !','2022-04-26 11:35:54','2022-05-17 18:59:04'),(20,36,1,'Test de commentaire','2022-05-07 11:48:49','2022-05-07 11:48:49'),(22,37,1,'Test','2022-05-20 19:08:59','2022-05-20 19:08:59'),(23,37,1,'Okay okay !!!','2022-05-20 19:09:25','2022-05-20 19:26:28'),(26,39,1,'Test !','2022-05-22 16:36:23','2022-05-22 16:36:23'),(27,42,1,'Pas mal !!!','2022-05-22 16:36:38','2022-05-22 16:44:49'),(28,43,1,'Sympa les photos !','2022-05-22 18:15:15','2022-05-22 18:15:15'),(29,43,1,'Test pour le graph !','2022-05-26 08:35:36','2022-05-26 08:35:36'),(30,43,1,'Test intéraction !','2022-05-26 10:53:18','2022-05-26 10:53:18'),(32,44,1,'Superbe photos comme d&#039;habitude :)','2022-05-26 12:33:44','2022-05-26 12:33:44'),(33,44,1,'J&#039;ai l&#039;impression de les avoir déjà vu ?!!','2022-05-26 12:35:00','2022-05-26 12:35:00'),(34,43,1,'Blablabla !!!!','2022-05-26 12:43:59','2022-05-26 12:43:59'),(35,43,1,'Test !!','2022-05-27 09:20:58','2022-05-27 09:20:58');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(80) NOT NULL,
  `firstname` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL DEFAULT 'undefined',
  `job` varchar(120) NOT NULL DEFAULT 'undefined',
  `birthday_date` date NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = woman; 1 = man',
  `image_profile` varchar(40) DEFAULT NULL COMMENT 'Nom de l''image de profil',
  `image_cover` varchar(40) DEFAULT NULL COMMENT 'Nom de l''image de couverture',
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = admin',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Admin','Administrateur','admin@gmail.com','$2y$10$UOv7KMlJshzsWqbj5m19Ter3e/Sc0W.rBr7TEipM0nHViwELmB.RO','Vannes (56)','Développeur Web','2022-03-01',0,'1646321094.png','',1,'2022-03-03 10:58:25','2022-04-20 15:01:09'),(3,'Goulard','Daniel','dgd.contact@gmail.com','$2y$10$NOkHd8q.st6CT0zcL9J2OOaGOtL9HIZiFkzNAi54Sy4LfN/UsRj0q','undefined','undefined','1983-12-15',0,'1648133355.png','',0,'2022-05-04 15:49:15','2022-05-04 15:49:15'),(4,'Goulard','Daniel','contact@gmail.com','$2y$10$cHg3zhQYOBVioMox/aAuI.kjO2XgsouAzn.VLWRrlDfhNYip0qWW.','undefined','undefined','1111-12-13',0,'1648203975.png','',0,'2022-03-25 11:26:15','2022-03-25 11:26:15'),(5,'User','Test','test@gmail.com','$2y$10$GoToRK0vwU.b2bi6XbvfdOFonQRktt75rKVdezJ7UqRMZCNH8pUhS','undefined','undefined','1983-12-15',0,'1649399732.png','',0,'2022-04-08 08:35:32','2022-04-08 08:35:32'),(6,'One','Test','testone@gmail.com','$2y$10$CQlJpZNnNoUX0bgkkjtluO8OJ93EqAQIzXws0wlNi13eMic4XP1ku','undefined','undefined','2022-01-01',0,'1650360929.png','',0,'2022-05-06 11:35:29','2022-05-17 17:58:04'),(7,'Goulard','Daniel','d.contact@gmail.com','$2y$10$jSHYqZ1n7Yxug/nCI3Z.NuApMlcgQ/RCd4ptx5/X380MGCsCYlbQa','undefined','undefined','1983-12-15',1,NULL,NULL,0,'2022-05-20 16:59:59','2022-05-20 16:59:59'),(8,'Goulard','Daniel','dg.contact@gmail.com','$2y$10$E2tF4RucqHlqadbb0XjXO.rxaJdn4zNT9Mas2jgiMGuhy6dxXQAC2','undefined','undefined','1983-12-15',1,NULL,NULL,0,'2022-05-20 17:04:49','2022-05-20 17:04:49'),(9,'Goulard','Daniel','tact@gmail.com','$2y$10$XxHk.1OuJZve3MpgW.luPuS20rE7geMVT/vbK.UsL2X03GCvwJucW','undefined','undefined','1983-12-15',1,'1653124450.png',NULL,0,'2022-05-21 11:14:10','2022-05-21 11:14:10'),(10,'Goulard','Daniel','ntact@gmail.com','$2y$10$QrSHndjD/MHOC6XXbqYtDecreDTEbN.N8ssAtRbxGpcVCpP8w8JYK','undefined','undefined','1983-12-15',1,'1653604853.png',NULL,0,'2022-05-27 00:40:53','2022-05-27 00:40:53');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'kercode_network'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-07 21:13:23
