-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: loja_online
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `carrinho`
--

DROP TABLE IF EXISTS `carrinho`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT 1,
  `data_adicionado` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `carrinho_ibfk_1` (`id_usuario`),
  KEY `fk_produto_carrinho` (`id_produto`),
  CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carrinho_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_produto_carrinho` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrinho`
--

LOCK TABLES `carrinho` WRITE;
/*!40000 ALTER TABLE `carrinho` DISABLE KEYS */;
INSERT INTO `carrinho` VALUES (15,1,56,18,'2025-05-31 03:01:19'),(16,1,56,18,'2025-05-31 03:01:21'),(17,1,56,18,'2025-05-31 03:01:21'),(18,1,56,18,'2025-05-31 03:01:24'),(19,1,56,18,'2025-05-31 03:01:24'),(20,1,56,18,'2025-05-31 03:01:25'),(21,1,56,18,'2025-05-31 03:01:25'),(22,1,56,18,'2025-05-31 03:01:25'),(23,1,28,3,'2025-05-31 03:15:21'),(24,1,28,17,'2025-05-31 03:26:52');
/*!40000 ALTER TABLE `carrinho` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (5,'sapato'),(6,'saia'),(7,'beleza'),(8,'Vestido'),(9,'BOLSA');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `depoimentos`
--

DROP TABLE IF EXISTS `depoimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `depoimentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `depoimento` text DEFAULT NULL,
  `data_depoimento` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `depoimentos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `depoimentos`
--

LOCK TABLES `depoimentos` WRITE;
/*!40000 ALTER TABLE `depoimentos` DISABLE KEYS */;
INSERT INTO `depoimentos` VALUES (3,8,'essa  sati foi muito bom gostei tanto de fazer as minhas compras foi bem recebida','2025-04-13 10:11:41'),(5,1,'gostei de fazer parte desse sati  comprei coisas e me trataram muito bem','2025-04-13 10:13:50'),(6,2,'foi muito satisfatorio  amei bastante  a forma que fui recebida','2025-04-13 11:38:10');
/*!40000 ALTER TABLE `depoimentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itens_pedido`
--

DROP TABLE IF EXISTS `itens_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco_unitario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_idcarri` (`id_produto`),
  CONSTRAINT `id_idcarri` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_pedido`
--

LOCK TABLES `itens_pedido` WRITE;
/*!40000 ALTER TABLE `itens_pedido` DISABLE KEYS */;
INSERT INTO `itens_pedido` VALUES (5,3,42,1,3.00),(6,4,43,11,1.00),(7,4,43,14,1.00);
/*!40000 ALTER TABLE `itens_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itens_venda`
--

DROP TABLE IF EXISTS `itens_venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itens_venda` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_venda` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_item`),
  KEY `fk_produto_venda` (`id_produto`),
  KEY `fk_produto_vendaas` (`id_venda`),
  CONSTRAINT `fk_produto_venda` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_produto_vendaas` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id_venda`) ON DELETE CASCADE,
  CONSTRAINT `itens_venda_ibfk_1` FOREIGN KEY (`id_venda`) REFERENCES `vendas` (`id_venda`),
  CONSTRAINT `itens_venda_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itens_venda`
--

LOCK TABLES `itens_venda` WRITE;
/*!40000 ALTER TABLE `itens_venda` DISABLE KEYS */;
/*!40000 ALTER TABLE `itens_venda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marcas`
--

DROP TABLE IF EXISTS `marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `logo` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

LOCK TABLES `marcas` WRITE;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` VALUES (5,'OPPO','Patrocinador','683274b4eae2d.png','2025-05-25 01:39:00'),(7,'coca','patrocin','683275664335b.png','2025-05-25 01:41:58'),(8,'tr','sdf','683275b8a278a.png','2025-05-25 01:43:20'),(9,'rt','zu','683275d2e8a52.png','2025-05-25 01:43:46'),(10,'4567','fgh','683275ed918c4.png','2025-05-25 01:44:13'),(11,'45','dfg','6832763247b0e.png','2025-05-25 01:45:22');
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `nome_cliente` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `localidade` varchar(50) DEFAULT NULL,
  `pagamento` varchar(50) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `data_pedido` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pendente',
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,2,4710.00,'Esmael Adriano adriano','940923748','Angola-Luanda','Luanda','transferencia','zzzzzz','2025-05-24 11:06:45','pendente'),(2,1,10.00,'ameliajustino Justino','921015416','ssss','Benguela','mobile','ggg','2025-05-29 17:38:42','entregue'),(3,2,3.00,'A','943787590','ESTALAGEM','Benguela','transferencia','','2025-05-30 00:02:38','entregue'),(4,1,25.00,'ameliajustino Justino','943787590','ssss','Benguela','mobile','jjjjjjjjjjj','2025-05-30 15:36:56','entregue');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `destaque` tinyint(1) DEFAULT 0,
  `data_adicao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_produto_categoria` (`categoria_id`),
  CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (28,'lllll','oooo',2500.00,5,'6831cd680b0e8.jpg',1,'2025-05-24 13:45:12'),(30,'BOTA DE  NAPA ALTO','Cor: Preto \r\n Marca:ZARA',10.00,5,'6831db644c014.jpg',0,'2025-05-24 14:44:52'),(36,'BOLSA','COR: LARANJA \r\nMARCA : JANEL',11.00,9,'68320d6c24677.jpg',0,'2025-05-24 18:18:20'),(39,'SAPATO ALTO ELEGANTE','COR:ROSA MARCA:MARIA LICE',5.00,5,'6832537be3636.jpg',0,'2025-05-24 23:17:15'),(40,'PASTA','COR:LARANJA MARCA:CHARNEL',7.00,9,'68325477dc4d7.jpg',0,'2025-05-24 23:21:27'),(41,'GLOSSE','COR: LILAS E ROSA MARCA: NAKED',7.00,7,'6832577a98088.jpg',0,'2025-05-24 23:34:18'),(42,'MALETA DE PINCEL','COR:PRETO MARCA:MAC',3.00,7,'683259abc5b3d.jpg',0,'2025-05-24 23:43:39'),(43,'DELINHADORE','COR:PRETO MARCA:MAC',1.00,7,'68325a3b28896.jpg',0,'2025-05-24 23:46:03'),(44,'BATOM','COR : ROSA MARCA: MAC',2.00,7,'68325af48445c.jpg',0,'2025-05-24 23:49:08'),(48,'VESTIDO','COR :PRETO MARCA:MARIA LICE',6.00,8,'6838e288a7dd3.jpeg',0,'2025-05-29 22:41:12'),(49,'VESTIDO','COR: ROSA MARCA: MEYDE',6.00,8,'6838e3800aff8.jpeg',0,'2025-05-29 22:45:20'),(50,'VESTIDO','COR: LARANJA  MARCA :AL',5.00,8,'6838e3eb5a03f.jpeg',0,'2025-05-29 22:47:07'),(51,'VESTIDO','COR:ROSA MARCA: ZARA',5.00,8,'6838e46964e31.jpeg',0,'2025-05-29 22:49:13'),(52,'VESTIDO','COR: AZUL MARCA: MARIA LICE',5.00,8,'6838e66403e30.jpeg',0,'2025-05-29 22:57:40'),(53,'VESTIDO','COR:VERMELHO MARCA: MARIA LICE',4.00,8,'6838e6c77aa99.jpeg',0,'2025-05-29 22:59:19'),(55,'VESTIDO','COR: BRANCA MARCA: MARIA LICE',7.00,8,'6838e769c4257.jpeg',0,'2025-05-29 23:02:01'),(56,'VESTIDO','COR: CASTAMHO MARCA: MARIA LICE',8.00,8,'6838e7a98cfe7.jpeg',0,'2025-05-29 23:03:05'),(57,'VESTIDO','COR: BANCA E PRETO MARCA : MARIA LICE',8.00,8,'6838e7f212f3a.jpeg',0,'2025-05-29 23:04:18'),(58,'VESTIDO','COR: VERDE MARCA A: ZARA',8.00,8,'6838e827141fb.jpeg',0,'2025-05-29 23:05:11'),(59,'VESTIDO','COR: PRETO MARGA : DEL',4.00,8,'6838e892cbf19.jpeg',0,'2025-05-29 23:06:58'),(60,'VESTIDO','COR: ROSA E BRANCA MARCA:',4.00,8,'6838e913ab910.jpeg',0,'2025-05-29 23:09:07'),(61,'VESTIDO','COR: CASTANHO MARCA:ZARA',9.00,8,'6838e99a3ae63.jpeg',0,'2025-05-29 23:11:22'),(62,'VESTIDO','COR: PRETO MARCA: ZARA',9.00,8,'6838e9ea2308b.jpeg',0,'2025-05-29 23:12:42'),(63,'VESTIDO','COR: VERMELHO MARCA: ZARA',10.00,8,'6838ea39a0cf2.jpeg',0,'2025-05-29 23:14:01'),(64,'BOLSA','COR: PRETO MARCA: ZARA',6.00,9,'6838eb35276a6.jpg',0,'2025-05-29 23:18:13'),(65,'BOLSA','COR: ROSA MARCA: ZARA',6.00,9,'6838eb8b7834a.jpg',0,'2025-05-29 23:19:39'),(66,'BOLSA','COR: CASTANHO MARCA ZARA',7.00,9,'6838ebba0b1f6.jpg',0,'2025-05-29 23:20:26'),(67,'BOLSA','COR: LARANJA MARCA : ZARA',7.00,9,'6838ec15e8cbb.jpg',0,'2025-05-29 23:21:57'),(68,'BOLSA','COR:  PRETO MARCA : ZARA',12.00,9,'6838ec8ebad6c.jpg',0,'2025-05-29 23:23:58'),(69,'Beleza','COR : 1 MARCA :MAC',5.00,7,'6838ed498215c.jpg',0,'2025-05-29 23:27:05'),(70,'VESTIDO','COR: CASTANHO MARCA: MARIA LICE',12.00,8,'6838edf4e5614.jpeg',0,'2025-05-29 23:29:56'),(91,'BOLSA','COR: LARANJA MARCA:  DEL',7.00,9,'6839b43b95b78.jpg',0,'2025-05-30 13:35:55'),(92,'BOLSA','COR: VERDE MARCA: ZARA',4.00,9,'6839b4afd38f0.jpg',0,'2025-05-30 13:37:51'),(93,'BOLSA','COR: SINZA MARCA: ZARA',12.00,9,'6839b50a91c11.jpg',0,'2025-05-30 13:39:22'),(94,'BOLSA','COR: SINZA MARCA: ADIDAS',12.00,9,'6839b5923f86c.jpg',0,'2025-05-30 13:41:38'),(95,'BOLSA','COR: DORADA MARCA : ZARA',6.00,9,'6839b611d3e1d.jpg',0,'2025-05-30 13:43:45'),(96,'BOLSA','COR: AMARELO MARCA: ZARA',9.00,9,'6839b9e4931bb.jpg',0,'2025-05-30 14:00:04'),(97,'BOLSA','COR: PRETO MARCA: ZARA',3.00,9,'6839ba5f23772.jpg',0,'2025-05-30 14:02:07'),(105,'ssssss','ssssssssssss',222.00,7,'683a68b981ad6.jpg',0,'2025-05-31 02:26:01'),(106,'ddddddddd','ddddddd',234.00,7,'683a68e45db45.jpg',0,'2025-05-31 02:26:44');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos_baner`
--

DROP TABLE IF EXISTS `produtos_baner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produtos_baner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `data_adicao` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `produtos_baner_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos_baner`
--

LOCK TABLES `produtos_baner` WRITE;
/*!40000 ALTER TABLE `produtos_baner` DISABLE KEYS */;
INSERT INTO `produtos_baner` VALUES (1,'VESTIDOS EGANTE','sss',3.00,6,'68389fa724086.jpeg','2025-05-29 17:55:51'),(2,'VESTIDOS EGANTE','aaaaaaaaa',3.00,9,'6838a231302eb.jfif','2025-05-29 18:06:41'),(3,'VESTIDOS EGANTE','',3.00,7,'6838e2f40f88c.jpeg','2025-05-29 22:43:00'),(4,'VESTIDOS EGANTE','rt',3.00,7,'68399b5088646.jpg','2025-05-30 11:49:36'),(5,'VESTIDOS EGANTE','rt',3.00,7,'68399cda9a2a7.jpg','2025-05-30 11:56:10'),(6,'VESTIDOS EGANTE','45TZ',3.00,6,'6839c031758e1.jpeg','2025-05-30 14:26:57'),(7,'VESTIDOS EGANTE','RTZ',3.00,7,'6839c08f032ea.jpg','2025-05-30 14:28:31'),(8,'VESTIDOS EGANTE','',3.00,8,'6839e7b3ef02c.jpeg','2025-05-30 17:15:31'),(9,'WWWWWWWWWWWWWWWWWWWWW','AAAAAAAAAAAAAAAAAAAAAA',2025.00,9,'683a264ccb5b7.png','2025-05-30 21:42:36');
/*!40000 ALTER TABLE `produtos_baner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('cliente','admin') NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Esmael Adriano','esma@gmail.com','$2y$10$b/wFLskftp9D48bwwTlAfunlesB03.Pg3lSjA4qqtHldyCO/KBohW','admin','2025-04-13 07:58:03'),(2,'ALice','admin@gmail.com','$2y$10$tqvyz5uR8FW9KqSmt1TTW.ywFdYbO143jLR7E3bS9dlrAN7L7yi9q','cliente','2025-04-13 10:15:16'),(7,'aaa','admain@gmail.com','$2y$10$XdY/AbeHbEP58rlnKRXZLusF4tPWwrG/HiXXdciVTQ4h8vyO7E6aO','cliente','2025-04-13 22:53:27'),(8,'Amelia justino','meli@gmail.com','$2y$10$gKEr0zQjJHTN3aP3HWezjORFvpHmS6H1Ogu16ib4R6GVO1w/Y2L9a','cliente','2025-05-24 13:47:56'),(9,'leonoraleo','Leopoldinaleonora@gmail.com','$2y$10$BlQlG7agZsHd..Mgxs.98ereEZI2W1HRobiWpyOi.H9jHoC.IdFCu','cliente','2025-05-30 17:19:19'),(10,'mariaa','maria@gmail.com','$2y$10$CkPSYYKme87wllyNEUfSX.gYaH2sb4o.GWKRZCwG35ayQXGHhEOKK','cliente','2025-05-30 17:26:19'),(11,'janeth','a@f','$2y$10$qozkFx9H5LQHHt1j7vXl7.EQcGUoppA.2tABZ.C7iOLwMj9rRLR5.','cliente','2025-05-30 17:27:21');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendas`
--

DROP TABLE IF EXISTS `vendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(255) NOT NULL,
  `data_venda` datetime DEFAULT current_timestamp(),
  `tipo_pagamento` varchar(50) NOT NULL,
  `vendido_por` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_venda`),
  KEY `vendido_por` (`vendido_por`),
  CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`vendido_por`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendas`
--

LOCK TABLES `vendas` WRITE;
/*!40000 ALTER TABLE `vendas` DISABLE KEYS */;
INSERT INTO `vendas` VALUES (46,'Esmael Adriano','2025-05-31 01:25:32','Cartão',1),(47,'Amelia justino','2025-05-31 01:26:51','Transferência',1),(48,'janeth','2025-05-31 01:30:21','Transferência',1);
/*!40000 ALTER TABLE `vendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendas_itens`
--

DROP TABLE IF EXISTS `vendas_itens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendas_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venda_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unitario` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `venda_id` (`venda_id`),
  KEY `produto_id` (`produto_id`),
  CONSTRAINT `vendas_itens_ibfk_1` FOREIGN KEY (`venda_id`) REFERENCES `vendas` (`id_venda`) ON DELETE CASCADE,
  CONSTRAINT `vendas_itens_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendas_itens`
--

LOCK TABLES `vendas_itens` WRITE;
/*!40000 ALTER TABLE `vendas_itens` DISABLE KEYS */;
INSERT INTO `vendas_itens` VALUES (12,46,30,34,10.00),(13,47,42,2,3.00),(14,47,48,2,6.00),(15,47,36,2,11.00),(16,47,51,2,5.00),(17,48,40,2,7.00),(18,48,43,2,1.00),(19,48,93,22,12.00),(20,48,28,2,2500.00),(21,48,28,3444,2500.00),(22,48,28,2,2500.00);
/*!40000 ALTER TABLE `vendas_itens` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-31  4:32:45
