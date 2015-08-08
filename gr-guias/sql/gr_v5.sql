-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 13 Mai 2014 à 22:23
-- Version du serveur: 5.5.35
-- Version de PHP: 5.4.4-14+deb7u9

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
  `art_valorcamento` decimal(6,2) DEFAULT NULL,
  `id_reparador` int(11) DEFAULT NULL,
  `date_in` date NOT NULL,
  `date_torep` date DEFAULT NULL,
  `date_tocliente` date DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `cl_localidade` varchar(30) NOT NULL,
  `art_numtalao` varchar(30) DEFAULT NULL,
  `art_valor` decimal(7,2) DEFAULT NULL,
  `art_ean` int(13) DEFAULT NULL,
  `gr_enable` tinyint(1) NOT NULL,
  `date_sms` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_reparador` (`id_reparador`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Contenu de la table `grep`
--

INSERT INTO `grep` (`id`, `cl_name`, `cl_morada`, `cl_codpostal`, `cl_telefone`, `art_type`, `art_marca`, `art_modelo`, `art_numserie`, `art_acessor`, `art_estetic`, `art_garantie`, `art_orcamento`, `art_dategar`, `art_valorcamento`, `id_reparador`, `date_in`, `date_torep`, `date_tocliente`, `id_user`, `cl_localidade`, `art_numtalao`, `art_valor`, `art_ean`, `gr_enable`, `date_sms`) VALUES
(5, 'c', 'c', '4624', 127, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL, 1, NULL),
(6, 'c', 'c', '4624', 127, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL, 1, NULL),
(7, 'c', 'c', '4624', 242542445, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL, 1, NULL),
(8, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL, 1, NULL),
(9, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL, 1, NULL),
(10, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL, 1, NULL),
(11, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL, 1, NULL),
(12, 'c', 'c', '4624', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL, 1, NULL),
(13, 'c', 'c', '4802178', 111111111, 'das', 'dsa', 'das', 'das', NULL, NULL, 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', NULL, NULL, NULL, 1, NULL),
(14, 'c', 'c', '4802178', 111111111, 'das', 'dsa', 'das', 'das', 'cdsssssssssssskdcnc, acessórios, não, dadadfa', 'sdfsdjfhf sdjhfsf sjoh fsfohsf sfshf s', 1, 0, '0000-00-00', NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', 'sdfsdfsdfdsfs', 189.00, NULL, 1, NULL),
(15, 'c', 'c', '4802178', 111111111, 'das', 'dsa', 'das', 'das', 'cdsssssssssssskdcnc, acessórios, não, dadadfa', 'sdfsdjfhf sdjhfsf sjoh fsfohsf sfshf s', 1, 0, '0000-00-00', NULL, NULL, '0000-00-00', NULL, NULL, 5, 'c', 'sdfsdfsdfdsfs', 189.10, NULL, 1, NULL),
(16, 'dsadsa dsadsada', 'dsadas dsa dasd asd ad asdasd nº12', '1234140', 112222222, 'xzccx', 'csdcc', 'zczx', 'cxz', 'czxc  cz cc ksadc lsadfs fl', 'sa lkd kfsh fslfh sflsjf hsjkflsd ', 0, 0, NULL, NULL, NULL, '0000-00-00', NULL, NULL, 3, 'dsada', '1', 1.01, NULL, 1, NULL),
(17, 'dasd', 'das', '4820000', 111111111, 'dasdada', 'dasd', 'dasdsad', 'dasdsad', 'dasd', 'das', 1, 0, '0000-00-00', NULL, NULL, '0000-00-00', NULL, NULL, 3, 'dsa', 'das', 18.01, 2147483647, 1, NULL),
(18, 'dasd', 'das', '4820000', 111111111, 'dasdada', 'dasd', 'dasdsad', 'dasdsad', 'dasd', 'das', 1, 0, '2014-01-14', NULL, NULL, '0000-00-00', NULL, NULL, 3, 'dsa', 'das', 18.01, 2147483647, 1, NULL),
(19, 'dasd', 'das', '4820000', 111111111, 'dasdada', 'dasd', 'dasdsad', 'dasdsad', 'dasd', 'das', 1, 0, '2014-01-14', NULL, NULL, '2014-05-06', NULL, NULL, 3, 'dsa', 'das', 18.01, 2147483647, 1, NULL),
(20, 'fsd', 'fsd', '4802178', 111111111, 'fsd', 'fsd', 'fsd', 'fsd', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-06', NULL, NULL, 3, 'fsd', NULL, NULL, NULL, 1, NULL),
(21, 'fsd', 'fsd', '4820178', 111111111, 'fsd', 'dfs', 'fs', 'fsd', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-06', NULL, NULL, 5, 'fsd', '00/00/00 0 000A 00X00', NULL, NULL, 1, NULL),
(22, 'fdsfsfskldfs fsdfks jfsklfj slfks fsljkfh skfj hsjkfhs fjkhf sfjh ffksjdf sfkjs fsfksd fhskjf sfjksf', ' jklhf sjkdfh sfks fhsfjks hfjks fhsjkfs hfjksdh fjksdfh skjfhs fkslfhsfk shfjs fskjfsh fsjkfh sdkfj', '4820178', 123456546, 'fsdfsdfsfsdfsdfsdfsd sfsfsdfsf sf sdfsfsfsfsffsdfs', 'asdfsdfsfsfsdfsdfsdfsdfsdfffsf', 'fsfsfsdfs fsfsdfsdfsdfsdfsdfsd', 'sdfsd fsfsdfsda f sdafsdfsadfsadfsdafsadfsdfsdfsda', 'fjklhf sjkfh sfjksh fsjhs fjkshf sjkfhsfjk shfs jkfhjksda fhskljf shfjkl sdhafkjlsdah fsdfdsasfsf sf', 'sdlfksf slfksf jhsfljshf ksjfh sfkjh fsjkfh sfkjsh fskfjhs fkjsh fskjfhs fjks fhsfjkhsf sjkfh sflksj', 1, 0, '2014-01-01', NULL, NULL, '2014-05-06', NULL, NULL, 1, 'fsfsdfsfsafjsk fshkjs fhsjkf s', '5454651641654', 100.01, 2147483647, 1, NULL),
(23, 'Ricardo Silva', 'rua de fafe nº1364', '4820178', 253509162, 'leclerc', 'leclerc', 'amleclerc', '12346541651', 'não trouxe nada', 'nada a assinalar', 1, 0, '2014-01-01', NULL, NULL, '2014-05-06', NULL, NULL, 3, 'fafe', 'df1sdaf65sf1s65', 110.00, 2147483647, 1, NULL),
(24, 'ricardo Silva', 'rua de fafe', '4820178', 132549646, 'leclerc', 'fafe', 'modmeom', '1351561', 'nada', 'não trouxe nada', 1, 0, '2014-02-02', NULL, NULL, '2014-05-07', NULL, NULL, 7, 'fafe', 'svsdfvdfvd', 149.99, 2147483647, 1, NULL),
(25, 'test', 'test', '4800000', 121132123, '123132', '123132', '1231321', '1231231', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'atas', NULL, NULL, NULL, 1, NULL),
(26, 'test', 'test', '4800000', 121132123, '123132', '123132', '1231321', '1231231', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'atas', NULL, NULL, NULL, 1, NULL),
(27, 'test', 'test', '4800000', 121132123, '123132', '123132', '1231321', '1231231', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'atas', NULL, NULL, NULL, 1, NULL),
(28, 'test', 'test', '4800000', 121132123, '123132', '123132', '1231321', '1231231', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'atas', NULL, NULL, NULL, 1, NULL),
(29, 'test', 'test', '4800000', 121132123, '123132', '123132', '1231321', '1231231', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'atas', NULL, NULL, NULL, 1, NULL),
(30, 'test', 'test', '4800000', 121132123, '123132', '123132', '1231321', '1231231', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'atas', NULL, NULL, NULL, 1, NULL),
(31, 'jorge vieira', 'rua das cascas e das putas', '4820178', 123456789, 'tv lcd', 'samsung', 's23333', 'fsfsffsad', 'não tem', 'nada a assinalar', 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 1, 'fafe', 'hsfsklshdfos', 199.99, 2147483647, 1, NULL),
(32, 'jorge vieir', 'adsa', '4820178', 123131561, ' tv lcd', 'samsung', 'samsung', 'ddafdfsa', 'não tem', 'nada', 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 1, 'fafe', '00/00/00 0 000A 00X00', 199.99, 2147483647, 1, NULL),
(33, 'FSDF', 'FS', '1', 111111111, 'DSA', 'DSADA', 'DSA', 'DAS', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 3, 'FSD', NULL, NULL, NULL, 1, NULL),
(34, 'FSDF', 'FS', '1', 111111111, 'DSA', 'DSADA', 'DSA', 'DAS', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 3, 'FSD', NULL, NULL, NULL, 1, NULL),
(35, 'fsdaf', 'fsdaf', '4820178', 111111111, 'adadasdas', 'dadadad', 'dasdasdasda', 'dasdas', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'fsdafs', '', NULL, NULL, 1, NULL),
(36, 'fsdaf', 'fsdaf', '4820178', 111111111, 'adadasdas', 'dadadad', 'dasdasdasda', 'dasdas', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'fsdafs', '', NULL, NULL, 1, NULL),
(37, 'rweter', 'tetetet', '4820178', 111111111, 'dasdadada', 'dasdad', 'dadada', 'dasda', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'eterte', '', NULL, NULL, 1, NULL),
(38, 'dffsdfsd', 'fsdfsdfs', '4820178', 111111111, 'fsdfsdaf', 'fsdfsdf', 'sfsdfsdf', 'fsdfsd', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'fsd', '', NULL, NULL, 1, NULL),
(39, 'fsda', 'fsad', '4820178', 111111111, 'fsdafsd', 'fsdfsdf', 'fdsfsadfsf', 'ssfsdfsdf', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'fsad', '', NULL, NULL, 1, NULL),
(40, 'fsda', 'fsad', '4820178', 962411111, 'fsdafsd', 'fsdfsdf', 'fdsfsadfsf', 'ssfsdfsdf', NULL, NULL, 0, 0, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'fsad', '', NULL, NULL, 1, NULL),
(41, 'sdfsdfsdfdsd', 'fsdfsadfs', '4820178', 111111341, 'sfsdfsdf', 'fsdfsdfs', 'fsdfsf', 'fsdfsd', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'fsdfsdafdsa', '', NULL, NULL, 1, NULL),
(42, 'sadasd', 'ddadada', '4820178', 111111112, 'dasdd', 'dsadsadd', 'asdasda', 'dad', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 3, 'sdasdadasd', '', NULL, NULL, 1, NULL),
(43, 'dasdasd', 'dasdasdas', '4820178', 123123156, 'dasdasdada', 'dadadadda', 'dasdadada', 'dadadadad', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-07', NULL, NULL, 5, 'dasdadasd', '', NULL, NULL, 1, NULL),
(44, 'dasdasd', 'dasdasdas', '4820178', 123123156, 'dasdasdada', 'dadadadda', 'dasdadada', 'dadadadad', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-08', NULL, NULL, 5, 'dasdadasd', '', NULL, NULL, 1, NULL),
(45, 'dasdasd', 'dasdasdas', '4820178', 123123156, 'dasdasdada', 'dadadadda', 'dasdadada', 'dadadadad', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-08', NULL, NULL, 5, 'dasdadasd', '', NULL, NULL, 1, NULL),
(46, 'dasdasd', 'dasdasdas', '4820178', 123123156, 'dasdasdada', 'dadadadda', 'dasdadada', 'dadadadad', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-08', NULL, NULL, 5, 'dasdadasd', '', NULL, NULL, 1, NULL),
(47, 'sdasd', 'dasdadad', '4820178', 123456579, 'FSDFSDF', 'FSDF', 'SFSFSFF', 'SDFS', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-08', NULL, NULL, 5, 'adad', '', NULL, NULL, 1, NULL),
(48, 'José luis', 'lordelo', '4820178', 915165165, 'informatica', 'leclerc', 'dasdada', 'fafdafffs', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-08', NULL, NULL, 4, 'lordelo', '', NULL, NULL, 1, NULL),
(49, 'GFHFGHFH', 'HHDDGDD', '4820178', 121212122, 'JGJGJGJJ', 'JHJHJ', 'JGHJGJ', 'JGJGJG', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-08', NULL, NULL, 3, 'HHDHDHDHDH', '00/00/00 0 000A 00X00', NULL, NULL, 1, NULL),
(50, 'fsdff', 'sfsfsf', '4820178', 111111111, 'fsd', 'fsda', 'fsd', 'fsd', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-08', '2014-05-08', NULL, 5, 'sfsfsdf', '', NULL, NULL, 1, NULL),
(51, 'sdfsfsdf', 'sffsfsfsf', '4820178', 111111111, 'gdfdg', 'daffsfs', 'gdfgdfgdg', 'gdfgdf', NULL, NULL, 0, 1, NULL, NULL, NULL, '2014-05-08', NULL, NULL, 4, 'sfsfsfs', '', NULL, NULL, 1, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Contenu de la table `modifgr`
--

INSERT INTO `modifgr` (`id`, `gr_id`, `us_id`, `modif_date`, `modif_text`) VALUES
(3, 29, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(4, 30, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(5, 31, 1, '2014-05-07 00:00:00', 'Criação da guia'),
(6, 32, 1, '2014-05-07 00:00:00', 'Criação da guia'),
(7, 33, 3, '2014-05-07 00:00:00', 'Criação da guia'),
(8, 34, 3, '2014-05-07 00:00:00', 'Criação da guia'),
(9, 35, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(10, 36, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(11, 37, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(12, 38, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(13, 39, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(14, 40, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(15, 41, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(16, 42, 3, '2014-05-07 00:00:00', 'Criação da guia'),
(17, 40, 5, '2014-05-07 00:00:00', 'Imprimiu de novo a guia'),
(18, 42, 5, '2014-05-07 00:00:00', 'Imprimiu de novo a guia'),
(19, 41, 3, '2014-05-07 00:00:00', 'Imprimiu de novo a guia'),
(20, 39, 3, '2014-05-07 00:00:00', 'Imprimiu de novo a guia'),
(21, 40, 3, '2014-05-07 11:05:00', 'Alterou o contacto'),
(22, 40, 3, '2014-05-07 11:05:00', 'Alterou o contacto'),
(23, 10, 7, '2014-05-07 11:05:00', 'Alterou o contacto'),
(24, 40, 7, '0000-00-00 00:00:00', 'Alterou o contacto'),
(25, 40, 7, '2014-05-07 11:05:20', 'Alterou o contacto'),
(26, 40, 7, '2014-05-07 11:05:40', 'Alterou o contacto'),
(27, 40, 7, '2014-05-07 11:05:00', 'Alterou o contacto'),
(28, 40, 7, '2014-05-07 11:05:26', 'Alterou o contacto'),
(29, 40, 7, '2014-05-07 23:05:00', 'Alterou o contacto'),
(30, 40, 7, '2014-05-07 23:05:00', 'Alterou o contacto'),
(31, 40, 7, '2014-05-07 23:54:00', 'Alterou o contacto'),
(32, 43, 5, '2014-05-07 00:00:00', 'Criação da guia'),
(33, 44, 5, '2014-05-08 00:00:00', 'Criação da guia'),
(34, 45, 5, '2014-05-08 00:00:00', 'Criação da guia'),
(35, 46, 5, '2014-05-08 00:01:00', 'Criação da guia'),
(36, 46, 5, '2014-05-08 00:02:00', 'Imprimiu de novo a guia'),
(37, 46, 5, '2014-05-08 00:02:00', 'Alterou o contacto'),
(38, 41, 3, '2014-05-08 08:55:00', 'Alterou o contacto'),
(39, 47, 5, '2014-05-08 10:35:00', 'Criação da guia'),
(40, 48, 4, '2014-05-08 10:48:00', 'Criação da guia'),
(41, 7, 3, '2014-05-08 11:35:00', 'Alterou o contacto'),
(42, 49, 3, '2014-05-08 11:39:00', 'Criação da guia'),
(43, 49, 5, '2014-05-08 15:17:00', 'Guia enviada ao reparador'),
(44, 50, 5, '2014-05-08 15:18:00', 'Criação da guia'),
(45, 50, 5, '2014-05-08 15:19:00', 'Imprimiu de novo a guia'),
(46, 50, 5, '2014-05-08 15:19:00', 'Guia enviada por mail ao reparador'),
(47, 50, 5, '2014-05-08 15:34:39', 'Artigo Levantado pelo reparador'),
(48, 51, 4, '2014-05-08 15:42:04', 'Criação da guia');

-- --------------------------------------------------------

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

--
-- Contenu de la table `modifrep`
--

INSERT INTO `modifrep` (`id`, `rep_id`, `us_id`, `modif_date`, `modif_text`) VALUES
(2, 1, 3, '2014-05-08 09:07:00', 'Criação do reparador'),
(3, 2, 3, '2014-05-08 09:08:00', 'Criação do reparador'),
(4, 3, 3, '2014-05-08 09:10:00', 'Criação do reparador'),
(5, 1, 1, '2014-05-08 10:34:00', 'Alterou o reparador');

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

--
-- Contenu de la table `reparador`
--

INSERT INTO `reparador` (`rep_id`, `rep_name`, `rep_email`, `rep_morada`, `rep_telefone1`, `rep_nome1`, `rep_telefone2`, `rep_nome2`, `rep_enable`) VALUES
(1, 'adfsadf dsf s', 'informatica@fafedis.pt', 'modif', 123456789, 'change1', 987654321, 'change2', 1),
(2, 'sassasas', NULL, NULL, 0, NULL, 222222222, 'nome 2', 1),
(3, 'dsadda', NULL, NULL, 222222222, NULL, NULL, NULL, 1);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
