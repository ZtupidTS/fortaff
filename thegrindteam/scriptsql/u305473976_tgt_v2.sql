-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Jeu 07 Novembre 2013 à 19:41
-- Version du serveur: 5.5.27
-- Version de PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `u305473976_tgt`
--

-- --------------------------------------------------------

--
-- Structure de la table `tgt_posthands`
--

CREATE TABLE IF NOT EXISTS `tgt_posthands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_users` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_bin NOT NULL,
  `hand` mediumtext COLLATE utf8_bin NOT NULL,
  `thinkingprocess` varchar(500) COLLATE utf8_bin NOT NULL,
  `image1` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `image2` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enable` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

--
-- Structure de la table `tgt_users`
--

CREATE TABLE IF NOT EXISTS `tgt_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(50) COLLATE utf8_bin NOT NULL,
  `enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Contenu de la table `tgt_users`
--

INSERT INTO `tgt_users` (`id`, `login`, `password`, `enable`) VALUES
(1, 'ricain', 'ricain2', 1),
(2, 'roup', 'roup2', 1),
(3, 'john', 'ricain', 1),
(5, 'squadl', 'thegrind', 1);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `view_all`
--
CREATE TABLE IF NOT EXISTS `view_all` (
`id` int(11)
,`id_users` int(11)
,`title` varchar(50)
,`hand` mediumtext
,`thinkingprocess` varchar(500)
,`image1` varchar(1000)
,`image2` varchar(1000)
,`date` timestamp
,`hands_enable` int(11)
,`login` varchar(50)
,`users_enable` tinyint(1)
);
-- --------------------------------------------------------

--
-- Structure de la vue `view_all`
--
DROP TABLE IF EXISTS `view_all`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_all` AS select `ph`.`id` AS `id`,`ph`.`id_users` AS `id_users`,`ph`.`title` AS `title`,`ph`.`hand` AS `hand`,`ph`.`thinkingprocess` AS `thinkingprocess`,`ph`.`image1` AS `image1`,`ph`.`image2` AS `image2`,`ph`.`date` AS `date`,`ph`.`enable` AS `hands_enable`,`us`.`login` AS `login`,`us`.`enable` AS `users_enable` from (`tgt_posthands` `ph` join `tgt_users` `us`) where (`ph`.`id_users` = `us`.`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
