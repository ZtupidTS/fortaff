-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 06 Mai 2014 à 20:46
-- Version du serveur: 5.5.35
-- Version de PHP: 5.4.4-14+deb7u8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `gr`
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
  `art_valorcamento` tinyint(6) DEFAULT NULL,
  `id_reparador` int(11) DEFAULT NULL,
  `date_in` date NOT NULL,
  `date_torep` date DEFAULT NULL,
  `date_inrep` date DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `cl_localidade` varchar(30) NOT NULL,
  `art_numtalao` varchar(30) DEFAULT NULL,
  `art_valor` decimal(7,2) DEFAULT NULL,
  `art_ean` int(13) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reparador` (`id_reparador`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `grep`
--

INSERT INTO `grep` (`id`, `cl_name`, `cl_morada`, `cl_codpostal`, `cl_telefone`, `art_type`, `art_marca`, `art_modelo`, `art_numserie`, `art_acessor`, `art_estetic`, `art_garantie`, `art_orcamento`, `art_dategar`, `art_valorcamento`, `id_reparador`, `date_in`, `date_torep`, `date_inrep`, `id_user`, `cl_localidade`, `art_numtalao`, `art_valor`, `art_ean`) VALUES
(5, 'c', 'c', '4624', 127, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL),
(6, 'c', 'c', '4624', 127, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL),
(7, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL),
(8, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL),
(9, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL),
(10, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL),
(11, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL),
(12, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL),
(13, 'c', 'c', '4802178', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL),
(14, 'c', 'c', '4802178', 111111111, 'das', 'dsa', 'das', 'das', 'cdsssssssssssskdcnc, acessórios, não, dadadfa', 'sdfsdjfhf sdjhfsf sjoh fsfohsf sfshf s', 1, 0, '0000-00-00', NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', 'sdfsdfsdfdsfs', 189.00, NULL),
(15, 'c', 'c', '4802178', 111111111, 'das', 'dsa', 'das', 'das', 'cdsssssssssssskdcnc, acessórios, não, dadadfa', 'sdfsdjfhf sdjhfsf sjoh fsfohsf sfshf s', 1, 0, '0000-00-00', NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', 'sdfsdfsdfdsfs', 189.10, NULL),
(16, 'dsadsa dsadsada', 'dsadas dsa dasd asd ad asdasd nº12', '1234140', 112222222, 'xzccx', 'csdcc', 'zczx', 'cxz', 'czxc  cz cc ksadc lsadfs fl', 'sa lkd kfsh fslfh sflsjf hsjkflsd ', 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 3, 'dsada', '1', 1.01, NULL),
(17, 'dasd', 'das', '4820000', 111111111, 'dasdada', 'dasd', 'dasdsad', 'dasdsad', 'dasd', 'das', 1, 0, '0000-00-00', NULL, NULL, '0000-00-00', NULL, NULL, 3, 'dsa', 'das', 18.01, 2147483647),
(18, 'dasd', 'das', '4820000', 111111111, 'dasdada', 'dasd', 'dasdsad', 'dasdsad', 'dasd', 'das', 1, 0, '2014-01-14', NULL, NULL, '0000-00-00', NULL, NULL, 3, 'dsa', 'das', 18.01, 2147483647),
(19, 'dasd', 'das', '4820000', 111111111, 'dasdada', 'dasd', 'dasdsad', 'dasdsad', 'dasd', 'das', 1, 0, '2014-01-14', NULL, NULL, '2014-05-06', NULL, NULL, 3, 'dsa', 'das', 18.01, 2147483647),
(20, 'fsd', 'fsd', '4802178', 111111111, 'fsd', 'fsd', 'fsd', 'fsd', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-06', NULL, NULL, 3, 'fsd', NULL, NULL, NULL),
(21, 'fsd', 'fsd', '4820178', 111111111, 'fsd', 'dfs', 'fs', 'fsd', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-06', NULL, NULL, 5, 'fsd', '00/00/00 0 000A 00X00', NULL, NULL),
(22, 'fdsfsfskldfs fsdfks jfsklfj slfks fsljkfh skfj hsjkfhs fjkhf sfjh ffksjdf sfkjs fsfksd fhskjf sfjksf', ' jklhf sjkdfh sfks fhsfjks hfjks fhsjkfs hfjksdh fjksdfh skjfhs fkslfhsfk shfjs fskjfsh fsjkfh sdkfj', '4820178', 123456546, 'fsdfsdfsfsdfsdfsdfsd sfsfsdfsf sf sdfsfsfsfsffsdfs', 'asdfsdfsfsfsdfsdfsdfsdfsdfffsf', 'fsfsfsdfs fsfsdfsdfsdfsdfsdfsd', 'sdfsd fsfsdfsda f sdafsdfsadfsadfsdafsadfsdfsdfsda', 'fjklhf sjkfh sfjksh fsjhs fjkshf sjkfhsfjk shfs jkfhjksda fhskljf shfjkl sdhafkjlsdah fsdfdsasfsf sf', 'sdlfksf slfksf jhsfljshf ksjfh sfkjh fsjkfh sfkjsh fskfjhs fkjsh fskjfhs fjks fhsfjkhsf sjkfh sflksj', 1, 0, '2014-01-01', NULL, NULL, '2014-05-06', NULL, NULL, 1, 'fsfsdfsfsafjsk fshkjs fhsjkf s', '5454651641654', 100.01, 2147483647),
(23, 'Ricardo Silva', 'rua de fafe nº1364', '4820178', 253509162, 'leclerc', 'leclerc', 'amleclerc', '12346541651', 'não trouxe nada', 'nada a assinalar', 1, 0, '2014-01-01', NULL, NULL, '2014-05-06', NULL, NULL, 3, 'fafe', 'df1sdaf65sf1s65', 110.00, 2147483647),
(24, 'ricardo Silva', 'rua de fafe', '4820178', 132549646, 'leclerc', 'fafe', 'modmeom', '1351561', 'nada', 'não trouxe nada', 1, 0, '2014-02-02', NULL, NULL, '2014-05-06', NULL, NULL, 7, 'fafe', 'svsdfvdfvd', 149.99, 2147483647);

-- --------------------------------------------------------

--
-- Structure de la table `reparador`
--

CREATE TABLE IF NOT EXISTS `reparador` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_name` varchar(50) NOT NULL,
  `rep_email` varchar(100) NOT NULL,
  `rep_morada` varchar(200) NOT NULL,
  `rep_codpostal` tinyint(7) NOT NULL,
  `rep_telefone` tinyint(9) NOT NULL,
  PRIMARY KEY (`rep_id`),
  KEY `id` (`rep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
