-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 14 Mai 2014 à 14:15
-- Version du serveur :  5.6.16
-- Version de PHP :  5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gr`
--

-- --------------------------------------------------------

--
-- Structure de la table `grep`
--

CREATE TABLE IF NOT EXISTS `grep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_name` varchar(100) NOT NULL,
  `cl_morada` varchar(100) NOT NULL,
  `cl_codpostal` varchar(7) NOT NULL,
  `cl_telefone` int(9) NOT NULL,
  `art_type` varchar(50) NOT NULL,
  `art_marca` varchar(30) NOT NULL,
  `art_modelo` varchar(30) NOT NULL,
  `art_numserie` varchar(50) NOT NULL,
  `art_acessor` varchar(100) DEFAULT NULL,
  `art_estetic` varchar(100) DEFAULT NULL,
  `art_garantie` tinyint(1) NOT NULL,
  `art_orcamento` tinyint(1) NOT NULL,
  `art_dategar` date DEFAULT NULL,
  `art_valorcamento` decimal(6,2) DEFAULT NULL,
  `id_reparador` int(11) DEFAULT NULL,
  `date_in` datetime NOT NULL,
  `date_torep` datetime DEFAULT NULL,
  `date_tocliente` datetime DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `cl_localidade` varchar(30) NOT NULL,
  `art_numtalao` varchar(30) DEFAULT NULL,
  `art_valor` decimal(7,2) DEFAULT NULL,
  `art_ean` int(13) DEFAULT NULL,
  `gr_enable` tinyint(1) NOT NULL,
  `date_sms` datetime DEFAULT NULL,
  `status_sms` int(1) NOT NULL,
  `sms_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reparador` (`id_reparador`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Structure de la table `modifgr`
--

CREATE TABLE IF NOT EXISTS `modifgr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gr_id` int(11) NOT NULL,
  `us_id` int(11) NOT NULL,
  `modif_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_text` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gr_id` (`gr_id`,`us_id`),
  KEY `us_id` (`us_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Structure de la table `modifrep`
--

CREATE TABLE IF NOT EXISTS `modifrep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_id` int(11) DEFAULT NULL,
  `us_id` int(11) DEFAULT NULL,
  `modif_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_text` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `rep_id` (`rep_id`,`us_id`),
  KEY `us_id` (`us_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Structure de la table `reparador`
--

CREATE TABLE IF NOT EXISTS `reparador` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_name` varchar(50) NOT NULL,
  `rep_email` varchar(100) DEFAULT NULL,
  `rep_morada` varchar(200) DEFAULT NULL,
  `rep_telefone1` int(9) DEFAULT '0',
  `rep_nome1` varchar(30) DEFAULT NULL,
  `rep_telefone2` int(9) DEFAULT NULL,
  `rep_nome2` varchar(30) DEFAULT NULL,
  `rep_enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`rep_id`),
  KEY `id` (`rep_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `us_id` int(11) NOT NULL AUTO_INCREMENT,
  `us_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `us_password` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `us_enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`us_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`us_id`, `us_name`, `us_password`, `us_enable`) VALUES
(1, 'Jorge', NULL, 1),
(2, 'José', NULL, 1),
(3, 'Artur', NULL, 1),
(4, 'Fabio', NULL, 1),
(5, 'Catia', NULL, 1),
(6, 'Luis', NULL, 1),
(7, 'André', NULL, 1),
(8, 'Andreia', NULL, 1),
(9, 'admin', 'ame59100', 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `grep`
--
ALTER TABLE `grep`
  ADD CONSTRAINT `grep_ibfk_1` FOREIGN KEY (`id_reparador`) REFERENCES `reparador` (`rep_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grep_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`us_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `modifgr`
--
ALTER TABLE `modifgr`
  ADD CONSTRAINT `modifgr_ibfk_1` FOREIGN KEY (`gr_id`) REFERENCES `grep` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `modifgr_ibfk_2` FOREIGN KEY (`us_id`) REFERENCES `users` (`us_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `modifrep`
--
ALTER TABLE `modifrep`
  ADD CONSTRAINT `modifrep_ibfk_1` FOREIGN KEY (`rep_id`) REFERENCES `reparador` (`rep_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `modifrep_ibfk_2` FOREIGN KEY (`us_id`) REFERENCES `users` (`us_id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
ALTER TABLE `grep` AUTO_INCREMENT = 1
ALTER TABLE `modifgr` AUTO_INCREMENT = 1
ALTER TABLE `modifrep` AUTO_INCREMENT = 1
ALTER TABLE `reparador` AUTO_INCREMENT = 1

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
