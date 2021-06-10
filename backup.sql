DROP TABLE IF EXISTS `hebergement`;
CREATE TABLE `hebergement` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `nbpersonnes` int(20) unsigned NOT NULL,
  `nb_sallebain` int(11) NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `prix` int(20) unsigned NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hebergement` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `image`;
CREATE TABLE `image` (
  `id_image` int(20) unsigned NOT NULL,
  `id_heberg` int(20) unsigned NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id_image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
LOCK TABLES `image` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `indispo`;
CREATE TABLE `indispo` (
  `id_date` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_heberg` int(20) unsigned NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
LOCK TABLES `indispo` WRITE;
UNLOCK TABLES;