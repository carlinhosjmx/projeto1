# ************************************************************
# Sequel Pro SQL dump
# Versão 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.23)
# Base de Dados: assinaturas
# Tempo de Geração: 2015-11-11 21:38:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump da tabela assinaturas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `assinaturas`;

CREATE TABLE `assinaturas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `vencimento` timestamp NULL DEFAULT NULL,
  `data_assinatura` timestamp NULL DEFAULT NULL,
  `valor` double(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `referencia` varchar(50) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `cancelamento` int(11) DEFAULT NULL,
  `expirou` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `assinaturas` WRITE;
/*!40000 ALTER TABLE `assinaturas` DISABLE KEYS */;

INSERT INTO `assinaturas` (`id`, `user`, `vencimento`, `data_assinatura`, `valor`, `status`, `referencia`, `cpf`, `codigo`, `cancelamento`, `expirou`)
VALUES
	(11,2,'2015-11-10 21:57:24','2015-11-10 21:57:24',59.90,1,'SITE582c6015546fb5a3fd600ce1423d3f3b','020292922990','3D9710500C0C947004E2DF9A2BECABE4',1,NULL);

/*!40000 ALTER TABLE `assinaturas` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
