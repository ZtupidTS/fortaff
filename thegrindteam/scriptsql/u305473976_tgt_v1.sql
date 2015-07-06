-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Jeu 07 Novembre 2013 à 18:22
-- Version du serveur: 5.5.32
-- Version de PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `u305473976_tgt`
--
CREATE DATABASE IF NOT EXISTS `u305473976_tgt` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `u305473976_tgt`;

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

--
-- Contenu de la table `tgt_posthands`
--

INSERT INTO `tgt_posthands` (`id`, `id_users`, `title`, `hand`, `thinkingprocess`, `image1`, `image2`, `date`, `enable`) VALUES
(51, 1, 'fd', 'Poker Stars No-Limit Hold''em, $0.10 BB (6 handed) - Poker Stars Converter Tool from http://www.flopturnriver.com/<br>\n<br>\nHero (Button) ($17.79)<br>\nSB ($13.68)<br>\nBB ($13.53)<br>\nUTG ($6.40)<br>\nMP ($6.52)<br>\nCO ($8.57)<br>\n<br>\n<b>Preflop</b>: Hero is Button with K<img src="images/diamond.gif">, K<img src="images/spade.gif"><br>\n<font color=#666666><i>2 folds</i></font>, <font color=#CC3333>CO raises $0.30</font>, <font color=#CC3333>Hero raises $1</font>, <font color=#666666><i>2 folds</i></font>, CO calls $0.70<br>\n<br>\n<b>Flop</b>: ($2.15) A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif">, A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif">, 6<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\nCO checks, Hero checks<br>\n<br>\n<b>Turn</b>: ($2.15) 10<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\nCO checks, <font color=#CC3333>Hero bets $1</font>, <font color=#CC3333>CO raises $2.30</font>, Hero calls $1.30<br>\n<br>\n<b>River</b>: ($6.75) 2<img src="images/heart.gif"> <font color=#009B00>(2 players)</font><br>\n<font color=#CC3333>CO bets $4</font>, <font color=#666666><i>Hero folds</i></font><br>\n<br>\n<b>Total pot:</b> $6.75<br>\n<br>\nResults below: <font color=#FFFFFF><br>\nCO didn''t show</font><br>', 'fd', 'fd', '', '2013-11-07 13:33:47', 1),
(52, 1, 'dwe', 'Poker Stars No-Limit Hold''em, $0.10 BB (6 handed) - Poker Stars Converter Tool from http://www.flopturnriver.com/<br>\n<br>\nHero (Button) ($17.79)<br>\nSB ($13.68)<br>\nBB ($13.53)<br>\nUTG ($6.40)<br>\nMP ($6.52)<br>\nCO ($8.57)<br>\n<br>\n<b>Preflop</b>: Hero is Button with K<img src="http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif">, K<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"><br>\n<font color=#666666><i>2 folds</i></font>, <font color=#CC3333>CO raises $0.30</font>, <font color=#CC3333>Hero raises $1</font>, <font color=#666666><i>2 folds</i></font>, CO calls $0.70<br>\n<br>\n<b>Flop</b>: ($2.15) A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif">, A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif">, 6<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\nCO checks, Hero checks<br>\n<br>\n<b>Turn</b>: ($2.15) 10<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\nCO checks, <font color=#CC3333>Hero bets $1</font>, <font color=#CC3333>CO raises $2.30</font>, Hero calls $1.30<br>\n<br>\n<b>River</b>: ($6.75) 2<img src="http://www.flopturnriver.com/pokerforum/images/smilies/heart.gif"> <font color=#009B00>(2 players)</font><br>\n<font color=#CC3333>CO bets $4</font>, <font color=#666666><i>Hero folds</i></font><br>\n<br>\n<b>Total pot:</b> $6.75<br>\n<br>\nResults below: <font color=#FFFFFF><br>\nCO didn''t show</font><br>', 'de', 'de', '', '2013-11-07 13:39:21', 1),
(53, 1, 'editer', 'Poker Stars No-Limit Hold''em, $0.10 BB (6 handed) - Poker Stars Converter Tool from http://www.flopturnriver.com/<br>\n<br>\nHero (Button) ($17.79)<br>\nSB ($13.68)<br>\nBB ($13.53)<br>\nUTG ($6.40)<br>\nMP ($6.52)<br>\nCO ($8.57)<br>\n<br>\n<b>Preflop</b>: Hero is Button with K<img src="http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif">, K<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"><br>\n<font color=#666666><i>2 folds</i></font>, <font color=#CC3333>CO raises $0.30</font>, <font color=#CC3333>Hero raises $1</font>, <font color=#666666><i>2 folds</i></font>, CO calls $0.70<br>\n<br>\n<b>Flop</b>: ($2.15) A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif">, A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif">, 6<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\nCO checks, Hero checks<br>\n<br>\n<b>Turn</b>: ($2.15) 10<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\nCO checks, <font color=#CC3333>Hero bets $1</font>, <font color=#CC3333>CO raises $2.30</font>, Hero calls $1.30<br>\n<br>\n<b>River</b>: ($6.75) 2<img src="http://www.flopturnriver.com/pokerforum/images/smilies/heart.gif"> <font color=#009B00>(2 players)</font><br>\n<font color=#CC3333>CO bets $4</font>, <font color=#666666><i>Hero folds</i></font><br>\n<br>\n<b>Total pot:</b> $6.75<br>\n<br>\nResults below:  <br>\nCO didn''t show</font><br>', 'editer', 'editer', '', '2013-11-07 17:19:48', 1),
(54, 1, 'das', 'das', 'das', 'das', '', '2013-11-07 13:55:13', 1),
(55, 2, 'KK au co', 'Poker Stars No-Limit Hold''em, $0.10 BB (6 handed) - Poker Stars Converter Tool from http://www.flopturnriver.com/<br>\r\n<br>\r\nHero (Button) ($17.79)<br>\r\nSB ($13.68)<br>\r\nBB ($13.53)<br>\r\nUTG ($6.40)<br>\r\nMP ($6.52)<br>\r\nCO ($8.57)<br>\r\n<br>\r\n<b>Preflop</b>: Hero is Button with K<img src="http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif">, K<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"><br>\r\n<font color=#666666><i>2 folds</i></font>, <font color=#CC3333>CO raises $0.30</font>, <font color=#CC3333>Hero raises $1</font>, <font color=#666666><i>2 folds</i></font>, CO calls $0.70<br>\r\n<br>\r\n<b>Flop</b>: ($2.15) A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif">, A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif">, 6<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\r\nCO checks, Hero checks<br>\r\n<br>\r\n<b>Turn</b>: ($2.15) 10<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\r\nCO checks, <font color=#CC3333>Hero bets $1</font>, <font color=#CC3333>CO raises $2.30</font>, Hero calls $1.30<br>\r\n<br>\r\n<b>River</b>: ($6.75) 2<img src="http://www.flopturnriver.com/pokerforum/images/smilies/heart.gif"> <font color=#009B00>(2 players)</font><br>\r\n<font color=#CC3333>CO bets $4</font>, <font color=#666666><i>Hero folds</i></font><br>\r\n<br>\r\n<b>Total pot:</b> $6.75<br>\r\n<br>\r\nResults below:  <br>\r\nCO didn''t show</font><br>', 'test', '', '', '2013-11-07 15:02:20', 1),
(56, 2, 'KK au co', 'Poker Stars No-Limit Hold''em, $0.10 BB (6 handed) - Poker Stars Converter Tool from http://www.flopturnriver.com/<br>\r\n<br>\r\nHero (Button) ($17.79)<br>\r\nSB ($13.68)<br>\r\nBB ($13.53)<br>\r\nUTG ($6.40)<br>\r\nMP ($6.52)<br>\r\nCO ($8.57)<br>\r\n<br>\r\n<b>Preflop</b>: Hero is Button with K<img src="http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif">, K<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"><br>\r\n<font color=#666666><i>2 folds</i></font>, <font color=#CC3333>CO raises $0.30</font>, <font color=#CC3333>Hero raises $1</font>, <font color=#666666><i>2 folds</i></font>, CO calls $0.70<br>\r\n<br>\r\n<b>Flop</b>: ($2.15) A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/diamond.gif">, A<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif">, 6<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\r\nCO checks, Hero checks<br>\r\n<br>\r\n<b>Turn</b>: ($2.15) 10<img src="http://www.flopturnriver.com/pokerforum/images/smilies/spade.gif"> <font color=#009B00>(2 players)</font><br>\r\nCO checks, <font color=#CC3333>Hero bets $1</font>, <font color=#CC3333>CO raises $2.30</font>, Hero calls $1.30<br>\r\n<br>\r\n<b>River</b>: ($6.75) 2<img src="http://www.flopturnriver.com/pokerforum/images/smilies/heart.gif"> <font color=#009B00>(2 players)</font><br>\r\n<font color=#CC3333>CO bets $4</font>, <font color=#666666><i>Hero folds</i></font><br>\r\n<br>\r\n<b>Total pot:</b> $6.75<br>\r\n<br>\r\nResults below:  <br>\r\nCO didn''t show</font><br>', 'test', '', '', '2013-11-07 15:02:26', 1),
(57, 1, 'sdcdsc', 'csdcdsc', 'fsd', 'fsd', '', '2013-11-07 15:25:08', 1),
(58, 1, 'fds', 'fsd', 'fsd', 'fsd', '', '2013-11-07 15:25:40', 1);

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
