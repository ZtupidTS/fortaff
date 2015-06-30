-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2012 at 11:56 AM
-- Server version: 5.1.36-community-log
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eleclerc`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_id_user` int(11) DEFAULT '0',
  `com_comments` longtext CHARACTER SET latin1 NOT NULL,
  `com_id_section` int(11) NOT NULL,
  PRIMARY KEY (`com_id`),
  KEY `index2` (`com_id_section`),
  KEY `com_id_section` (`com_id_section`),
  KEY `sec_id` (`com_id_section`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`com_id`, `com_id_user`, `com_comments`, `com_id_section`) VALUES
(13, 0, 'xcvvxvxvxvxvxzvc', 11),
(14, 0, 'sdgdggdbgdhdhtdahgd', 15);

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `conf_id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_tipo` varchar(45) CHARACTER SET latin1 NOT NULL,
  `conf_description` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `conf_value` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`conf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`conf_id`, `conf_tipo`, `conf_description`, `conf_value`) VALUES
(1, 'JFrame', 'setIconImage', './images/logo12.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `sec_id` int(11) NOT NULL AUTO_INCREMENT,
  `sec_description` varchar(45) NOT NULL,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`sec_id`, `sec_description`) VALUES
(1, 'Mercearia'),
(2, 'Bebidas'),
(3, 'Dph'),
(4, 'Peixaria'),
(5, 'Charcutaria'),
(6, 'Talho'),
(7, 'Padaria/Pastelaria'),
(8, 'Caixas'),
(9, 'Administrativos'),
(10, 'Chefes'),
(11, 'Bazar Ligeiro'),
(12, 'Bazar Pesado'),
(13, 'Cremaria'),
(14, 'Frutas/Legumes'),
(15, ' Não Identifcado');

-- --------------------------------------------------------

--
-- Table structure for table `softversion`
--

CREATE TABLE IF NOT EXISTS `softversion` (
  `vers_id` int(11) NOT NULL AUTO_INCREMENT,
  `soft_num` varchar(3) NOT NULL,
  `soft_log` varchar(200) NOT NULL,
  PRIMARY KEY (`vers_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `softversion`
--

INSERT INTO `softversion` (`vers_id`, `soft_num`, `soft_log`) VALUES
(1, '1.0', 'Versão inicial com a submissão de comentários.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_login` varchar(45) NOT NULL,
  `usr_password` varchar(45) NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_login_UNIQUE` (`usr_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `sec_id` FOREIGN KEY (`com_id_section`) REFERENCES `section` (`sec_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
