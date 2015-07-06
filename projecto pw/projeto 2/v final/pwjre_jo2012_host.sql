-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2012 at 01:05 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pwjre_jo2012`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `associar_atl_prova`
--
CREATE TABLE IF NOT EXISTS `associar_atl_prova` (
`cod_equipa` int(11)
,`cod_prova` int(11)
,`cod_modalidade` int(11)
,`nome_modalidade` varchar(30)
,`sexo` varchar(1)
,`cod_delegacao` varchar(2)
,`cod_elemento_equipa` int(11)
,`estado_valido` varchar(1)
,`nome` varchar(30)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `associar_el_delegacao`
--
CREATE TABLE IF NOT EXISTS `associar_el_delegacao` (
`cod_delegacao` varchar(2)
,`nome` varchar(30)
,`cod_elemento_equipa` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `associar_eq_prova`
--
CREATE TABLE IF NOT EXISTS `associar_eq_prova` (
`cod_equipa` int(11)
,`cod_prova` int(11)
,`cod_modalidade` int(11)
,`nome_modalidade` varchar(30)
,`sexo` varchar(1)
,`cod_delegacao` varchar(2)
);
-- --------------------------------------------------------

--
-- Table structure for table `atleta`
--

CREATE TABLE IF NOT EXISTS `atleta` (
  `cod_elemento_equipa` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  `altura` int(11) NOT NULL,
  `grupo_sanguineo` varchar(3) NOT NULL,
  `old_peso` int(11) DEFAULT NULL,
  `old_altura` int(11) DEFAULT NULL,
  `old_grupo_sanguineo` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`cod_elemento_equipa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `atleta`
--

INSERT INTO `atleta` (`cod_elemento_equipa`, `peso`, `altura`, `grupo_sanguineo`, `old_peso`, `old_altura`, `old_grupo_sanguineo`) VALUES
(85, 80, 180, 'A+', NULL, NULL, NULL),
(88, 94, 193, 'A+', NULL, NULL, NULL),
(91, 70, 174, 'A+', NULL, NULL, NULL),
(92, 70, 178, 'A+', NULL, NULL, NULL),
(93, 60, 160, 'A+', NULL, NULL, NULL),
(94, 65, 165, 'B+', NULL, NULL, NULL),
(95, 77, 173, 'B+', NULL, NULL, NULL),
(96, 67, 167, 'B+', NULL, NULL, NULL),
(97, 65, 170, 'B-', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `atl_acrescentado_a_prova`
--
CREATE TABLE IF NOT EXISTS `atl_acrescentado_a_prova` (
`cod_elemento_equipa` int(11)
,`cod_equipa` int(11)
,`cod_prova` int(11)
,`cod_modalidade` int(11)
,`nome_modalidade` varchar(30)
,`sexo` varchar(1)
,`cod_delegacao` varchar(2)
,`nome` varchar(30)
);
-- --------------------------------------------------------

--
-- Table structure for table `auxiliar`
--

CREATE TABLE IF NOT EXISTS `auxiliar` (
  `cod_elemento_equipa` int(11) NOT NULL,
  `funcao` varchar(30) NOT NULL,
  `habilit_literarias` varchar(30) DEFAULT NULL,
  `old_funcao` varchar(30) DEFAULT NULL,
  `old_habilit` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cod_elemento_equipa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auxiliar`
--

INSERT INTO `auxiliar` (`cod_elemento_equipa`, `funcao`, `habilit_literarias`, `old_funcao`, `old_habilit`) VALUES
(87, 'Doctor', '12ªano', NULL, NULL),
(89, 'Doctor', 'Licenciado', NULL, NULL),
(98, 'Massagista', 'Licenciado', NULL, NULL),
(99, 'Massagista', 'Licenciado', NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `classificacao_atleta`
--
CREATE TABLE IF NOT EXISTS `classificacao_atleta` (
`cod_elemento_equipa` int(11)
,`cod_prova` int(11)
,`sexo` varchar(1)
,`cod_delegacao` varchar(2)
,`classificacao` int(11)
,`nome_pais` varchar(30)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `classificacao_equipa`
--
CREATE TABLE IF NOT EXISTS `classificacao_equipa` (
`cod_equipa` int(11)
,`cod_prova` int(11)
,`sexo` varchar(1)
,`cod_delegacao` varchar(2)
,`classificacao` int(11)
,`nome_pais` varchar(30)
);
-- --------------------------------------------------------

--
-- Table structure for table `classificacao_evento`
--

CREATE TABLE IF NOT EXISTS `classificacao_evento` (
  `cod_classificacao_evento` int(11) NOT NULL AUTO_INCREMENT,
  `cod_evento` int(11) NOT NULL,
  `classificacao` int(11) NOT NULL,
  `id_vis` int(11) NOT NULL,
  PRIMARY KEY (`cod_classificacao_evento`),
  KEY `cod_evento` (`cod_evento`),
  KEY `id_vis` (`id_vis`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `classificacao_evento`
--

INSERT INTO `classificacao_evento` (`cod_classificacao_evento`, `cod_evento`, `classificacao`, `id_vis`) VALUES
(1, 1, 5, 5),
(4, 8, 3, 5);

-- --------------------------------------------------------

--
-- Stand-in structure for view `classificacao_media_evento`
--
CREATE TABLE IF NOT EXISTS `classificacao_media_evento` (
`cod_evento` int(11)
,`classif_media` decimal(36,4)
,`votos` bigint(21)
);
-- --------------------------------------------------------

--
-- Table structure for table `classificacao_prova`
--

CREATE TABLE IF NOT EXISTS `classificacao_prova` (
  `id_class_prova` int(11) NOT NULL AUTO_INCREMENT,
  `cod_prova` int(11) NOT NULL,
  `cod_do_classificado` int(11) NOT NULL,
  `classificacao` int(11) DEFAULT NULL,
  `estado_valido_prova` varchar(1) NOT NULL,
  `estado_valido_classificado` varchar(1) NOT NULL,
  PRIMARY KEY (`id_class_prova`),
  KEY `cod_prova` (`cod_prova`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `classificacao_prova`
--

INSERT INTO `classificacao_prova` (`id_class_prova`, `cod_prova`, `cod_do_classificado`, `classificacao`, `estado_valido_prova`, `estado_valido_classificado`) VALUES
(1, 16, 61, NULL, 'V', 'X'),
(8, 19, 69, NULL, 'V', 'X'),
(9, 19, 69, NULL, 'V', 'X'),
(10, 19, 69, 2, 'V', 'V'),
(11, 21, 64, NULL, 'V', 'X'),
(12, 20, 61, NULL, 'V', 'X'),
(15, 13, 91, NULL, 'V', 'X'),
(16, 21, 73, NULL, 'V', 'X'),
(17, 13, 91, NULL, 'V', 'X'),
(18, 13, 92, NULL, 'V', 'X'),
(19, 13, 92, 1, 'V', 'V'),
(20, 13, 91, 2, 'V', 'V'),
(21, 21, 73, NULL, 'V', 'X'),
(22, 21, 73, 2, 'V', 'V'),
(23, 13, 89, NULL, 'V', 'X'),
(24, 13, 88, NULL, 'V', 'X'),
(25, 13, 88, NULL, 'V', 'X'),
(26, 13, 87, NULL, 'V', 'X'),
(27, 23, 74, NULL, 'V', 'X'),
(28, 23, 75, 3, 'V', 'V'),
(29, 24, 63, NULL, 'V', 'X'),
(30, 13, 87, NULL, 'V', 'X'),
(31, 13, 89, NULL, 'V', 'X'),
(32, 22, 89, NULL, 'V', 'X'),
(33, 25, 85, NULL, 'V', 'X'),
(34, 25, 85, NULL, 'V', 'X'),
(35, 25, 85, NULL, 'V', 'X'),
(36, 25, 85, NULL, 'V', 'X'),
(37, 22, 89, NULL, 'V', 'X'),
(38, 26, 97, 3, 'V', 'V');

-- --------------------------------------------------------

--
-- Stand-in structure for view `co_re_evento`
--
CREATE TABLE IF NOT EXISTS `co_re_evento` (
`id_vis` int(11)
,`cod_evento` int(11)
,`data` date
,`hora_inicio` time
,`duracao` time
,`re_ou_com` varchar(8)
,`lat` decimal(17,15)
,`lng` decimal(17,15)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `co_re_prova`
--
CREATE TABLE IF NOT EXISTS `co_re_prova` (
`id_vis` int(11)
,`cod_prova` int(11)
,`data` date
,`hora_inicio` time
,`duracao` time
,`nome_modalidade` varchar(30)
,`re_ou_com` varchar(8)
,`lat` decimal(17,15)
,`lng` decimal(17,15)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `dados_atletas`
--
CREATE TABLE IF NOT EXISTS `dados_atletas` (
`cod_equipa` int(11)
,`cod_elemento_equipa` int(11)
,`nome` varchar(30)
,`data_nasc` date
,`sexo` varchar(2)
,`peso` int(11)
,`altura` int(11)
,`grupo_sanguineo` varchar(3)
,`cod_delegacao` varchar(2)
,`nome_pais` varchar(30)
,`estado_valido` varchar(1)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `dados_auxiliares`
--
CREATE TABLE IF NOT EXISTS `dados_auxiliares` (
`cod_equipa` int(11)
,`cod_elemento_equipa` int(11)
,`nome` varchar(30)
,`data_nasc` date
,`sexo` varchar(2)
,`funcao` varchar(30)
,`habilit_literarias` varchar(30)
,`cod_delegacao` varchar(2)
,`nome_pais` varchar(30)
,`estado_valido` varchar(1)
);
-- --------------------------------------------------------

--
-- Table structure for table `delegacao`
--

CREATE TABLE IF NOT EXISTS `delegacao` (
  `id_delegacao` int(11) NOT NULL AUTO_INCREMENT,
  `cod_delegacao` varchar(2) NOT NULL,
  `nome_pais` varchar(30) NOT NULL,
  `nome_responsavel` varchar(30) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `estado_valido` varchar(1) NOT NULL,
  `ultimo_acesso` date DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id_delegacao`),
  KEY `nome_pais` (`nome_pais`),
  KEY `login` (`login`),
  KEY `cod_delegacao` (`cod_delegacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `delegacao`
--

INSERT INTO `delegacao` (`id_delegacao`, `cod_delegacao`, `nome_pais`, `nome_responsavel`, `login`, `password`, `estado_valido`, `ultimo_acesso`, `email`) VALUES
(1, 'af', 'Afeganistão', 'jamel', 'jam', 'jam', 'X', NULL, 'jamel@gmail.com'),
(2, 'co', 'comite_organizacao', 'jre', 'jre', 'jre123456', 'V', '2012-01-15', 'ricain@iol.pt'),
(3, 'es', 'Espanha', 'Juan', 'Juan_de_espanha', 'as', 'X', NULL, 'juan@hotmail.com'),
(4, 'fr', 'França', 'Dominic', 'dom2', 'dom', 'V', '2011-12-03', 'dom@msn.com'),
(5, 'pt', 'Portugal', 'Alfredo', 'alf', 'alf', 'V', '2011-12-05', 'alf@sapo.pt'),
(6, 'za', 'África do Sul', 'Samuel', 'sam', 'samuel', 'V', '2011-11-24', 'sam@gmail.com'),
(7, 'es', 'Espanha', 'Juan', 'Juan_de_espanha', 'as', 'X', NULL, 'juan@hotmail.com'),
(8, 'es', 'Espanha', 'Juan', 'Juan_de_espanha', 'as', 'X', NULL, 'juan@hotmail.com'),
(9, 'es', 'Espanha', 'Juan', 'Juan_de_espanha', 'as', 'X', NULL, 'juan@hotmail.com'),
(10, 'af', 'Afeganistão', 'Hamed', 'hamed', '0dcfc9aa81', 'V', NULL, 'hamed@gmail.com'),
(11, 'al', 'Albânia', 'Philip''s', 'philip''s', 'phil', 'X', NULL, 'phil@msn.com'),
(12, 'de', 'Alemanha', 'Half', 'half', 'half', 'V', NULL, 'half@hotmail.com'),
(13, 'us', 'Estados Unidos', 'O´neal', 'oneal2', '0cb250d760', 'V', '2011-12-01', 'ricain59@gmail.com'),
(14, 'cv', 'Cabo Verde', 'Joaquim D''Almeida', 'ja', '5bd22ea425', 'X', NULL, 'ja@gmail.com');

-- --------------------------------------------------------

--
-- Stand-in structure for view `elemento_delegacao`
--
CREATE TABLE IF NOT EXISTS `elemento_delegacao` (
`cod_equipa` int(11)
,`cod_delegacao` varchar(2)
,`cod_elemento_equipa` int(11)
);
-- --------------------------------------------------------

--
-- Table structure for table `elemento_equipa`
--

CREATE TABLE IF NOT EXISTS `elemento_equipa` (
  `cod_elemento_equipa` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `data_nasc` date NOT NULL,
  `sexo` varchar(2) NOT NULL,
  `old_nome` varchar(30) DEFAULT NULL,
  `old_data_nasc` date DEFAULT NULL,
  `old_sexo` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`cod_elemento_equipa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `elemento_equipa`
--

INSERT INTO `elemento_equipa` (`cod_elemento_equipa`, `nome`, `data_nasc`, `sexo`, `old_nome`, `old_data_nasc`, `old_sexo`) VALUES
(85, 'daniel', '1980-08-06', 'M', NULL, NULL, NULL),
(87, 'João', '1970-07-10', 'M', NULL, NULL, NULL),
(88, 'Pedro', '1976-10-10', 'M', NULL, NULL, NULL),
(89, 'Simão', '1980-08-10', 'M', NULL, NULL, NULL),
(91, 'Pierre', '1990-09-08', 'M', NULL, NULL, NULL),
(92, 'Jean', '1986-10-10', 'M', NULL, NULL, NULL),
(93, 'Sylvie', '1980-10-10', 'F', NULL, NULL, NULL),
(94, 'Daniela', '1980-10-10', 'F', NULL, NULL, NULL),
(95, 'Michael', '1980-10-19', 'M', NULL, NULL, NULL),
(96, 'Richards', '1980-10-10', 'M', NULL, NULL, NULL),
(97, 'Marion Jones', '1981-10-10', 'F', NULL, NULL, NULL),
(98, 'Ricardo', '1981-12-11', 'M', NULL, NULL, NULL),
(99, 'Richard', '1981-12-11', 'M', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `elemento_in_equipa`
--

CREATE TABLE IF NOT EXISTS `elemento_in_equipa` (
  `id_elemento_in_equipa` int(11) NOT NULL AUTO_INCREMENT,
  `cod_equipa` int(11) NOT NULL,
  `cod_elemento_equipa` int(11) NOT NULL,
  `estado_valido` varchar(1) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_elemento_in_equipa`),
  KEY `cod_equipa` (`cod_equipa`),
  KEY `cod_elemento_equipa` (`cod_elemento_equipa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `elemento_in_equipa`
--

INSERT INTO `elemento_in_equipa` (`id_elemento_in_equipa`, `cod_equipa`, `cod_elemento_equipa`, `estado_valido`) VALUES
(39, 60, 85, 'V'),
(41, 61, 85, 'V'),
(44, 60, 87, 'V'),
(45, 61, 87, 'V'),
(46, 60, 88, 'X'),
(47, 60, 89, 'V'),
(49, 70, 91, 'V'),
(50, 70, 92, 'X'),
(51, 71, 93, 'V'),
(52, 70, 92, 'X'),
(53, 70, 92, 'V'),
(54, 68, 94, 'V'),
(55, 76, 85, 'V'),
(56, 63, 85, 'V'),
(57, 77, 95, 'X'),
(58, 77, 96, 'V'),
(59, 78, 97, 'V'),
(60, 79, 97, 'V'),
(61, 63, 87, 'V'),
(62, 63, 89, 'V'),
(63, 63, 98, 'V'),
(64, 71, 99, 'V'),
(65, 70, 99, 'V'),
(66, 72, 99, 'V'),
(67, 64, 87, 'X');

-- --------------------------------------------------------

--
-- Table structure for table `equipa`
--

CREATE TABLE IF NOT EXISTS `equipa` (
  `cod_equipa` int(11) NOT NULL AUTO_INCREMENT,
  `cod_modalidade` int(11) NOT NULL,
  `cod_delegacao` varchar(2) NOT NULL,
  `estado_valido` varchar(1) NOT NULL,
  `ref_cod_modalidade` int(11) DEFAULT NULL,
  `sexo` varchar(1) NOT NULL,
  PRIMARY KEY (`cod_equipa`),
  KEY `cod_delegacao` (`cod_delegacao`),
  KEY `cod_modalidade` (`cod_modalidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `equipa`
--

INSERT INTO `equipa` (`cod_equipa`, `cod_modalidade`, `cod_delegacao`, `estado_valido`, `ref_cod_modalidade`, `sexo`) VALUES
(60, 19, 'pt', 'V', NULL, 'M'),
(61, 2, 'pt', 'V', NULL, 'M'),
(63, 12, 'pt', 'V', NULL, 'M'),
(64, 5, 'pt', 'V', NULL, 'M'),
(68, 11, 'pt', 'V', NULL, 'F'),
(69, 12, 'pt', 'V', NULL, 'F'),
(70, 11, 'fr', 'V', NULL, 'M'),
(71, 19, 'fr', 'V', NULL, 'F'),
(72, 19, 'fr', 'V', NULL, 'M'),
(73, 5, 'fr', 'V', NULL, 'M'),
(74, 25, 'pt', 'X', NULL, 'M'),
(75, 25, 'fr', 'V', NULL, 'M'),
(76, 27, 'pt', 'V', NULL, 'M'),
(77, 19, 'us', 'V', NULL, 'M'),
(78, 19, 'us', 'V', NULL, 'F'),
(79, 11, 'us', 'V', NULL, 'F');

-- --------------------------------------------------------

--
-- Stand-in structure for view `equipa_with_delegacao`
--
CREATE TABLE IF NOT EXISTS `equipa_with_delegacao` (
`cod_equipa` int(11)
,`nome_modalidade` varchar(30)
,`nome_pais` varchar(30)
,`estado_valido` varchar(1)
,`cod_delegacao` varchar(2)
,`cod_modalidade` int(11)
,`sexo` varchar(1)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `eq_acrescentado_a_prova`
--
CREATE TABLE IF NOT EXISTS `eq_acrescentado_a_prova` (
`cod_equipa` int(11)
,`cod_prova` int(11)
,`cod_modalidade` int(11)
,`nome_modalidade` varchar(30)
,`sexo` varchar(1)
,`cod_delegacao` varchar(2)
);
-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `cod_evento` int(11) NOT NULL AUTO_INCREMENT,
  `designacao` varchar(30) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `data` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `duracao` time NOT NULL,
  `preco` decimal(8,2) NOT NULL,
  `lugares_total` int(11) NOT NULL,
  `lugares_reservados` int(11) DEFAULT NULL,
  `estado_valido` varchar(1) NOT NULL,
  `lat` decimal(17,15) DEFAULT NULL,
  `lng` decimal(17,15) DEFAULT NULL,
  PRIMARY KEY (`cod_evento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `evento`
--

INSERT INTO `evento` (`cod_evento`, `designacao`, `descricao`, `data`, `hora_inicio`, `duracao`, `preco`, `lugares_total`, `lugares_reservados`, `estado_valido`, `lat`, `lng`) VALUES
(1, 'Cerimonia', 'Abertura', '2012-07-27', '20:00:00', '02:30:00', 9.99, 1000, 500, 'V', 51.501904107618110, 0.131835937500000),
(2, 'Cerimonia', 'Encerramento', '2012-08-12', '20:00:00', '01:30:00', 9.99, 1000, 51, 'V', 51.501904107618110, 0.121835937500000),
(3, 'Cerimonia', 'Entrega de Medalhas 200M', '2012-08-02', '19:00:00', '01:00:00', 9.99, 1000, 150, 'V', 51.501904107618110, 0.111835937500000),
(7, 'Cerimonia', 'Fecho', '2012-08-18', '11:00:00', '02:00:00', 12.00, 20000, 0, 'V', 51.501904107618110, 0.101835937500000),
(8, 'Cerimonia', 'Bandeira', '2012-01-12', '12:00:00', '02:00:00', 0.00, 200, 0, 'V', 51.501904107618110, 0.108359375000000),
(9, 'Espetaculo', 'Palhaço', '2012-08-02', '14:00:00', '01:00:00', 0.00, 15000, 0, 'V', 51.501904107618110, 0.101835937500000),
(10, 'Espetaculo', 'Pombas', '2012-08-02', '15:00:00', '00:25:00', 0.00, 15000, 0, 'V', 51.501904107618110, 0.101835937500000);

-- --------------------------------------------------------

--
-- Table structure for table `grupo_sanguineo`
--

CREATE TABLE IF NOT EXISTS `grupo_sanguineo` (
  `grupo_sanguineo` varchar(3) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupo_sanguineo`
--

INSERT INTO `grupo_sanguineo` (`grupo_sanguineo`) VALUES
('A+'),
('A-'),
('AB+'),
('B+'),
('B-'),
('O+'),
('O-');

-- --------------------------------------------------------

--
-- Table structure for table `informacao_diversas`
--

CREATE TABLE IF NOT EXISTS `informacao_diversas` (
  `id` varchar(30) NOT NULL,
  `informacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `informacao_diversas`
--

INSERT INTO `informacao_diversas` (`id`, `informacao`) VALUES
('A', 'Acrescentou'),
('C', 'Coletiva'),
('CO', 'Comentário'),
('D', 'Eliminou'),
('EV', 'evento'),
('I', 'Individual'),
('M', 'Alterou'),
('PR', 'prova'),
('RE', 'Reclamação'),
('SU', 'Sugestão'),
('V', 'Valido'),
('X', 'Elim_logica');

-- --------------------------------------------------------

--
-- Stand-in structure for view `lugares_vazios_evento`
--
CREATE TABLE IF NOT EXISTS `lugares_vazios_evento` (
`cod_evento` int(11)
,`lugar_vazios` bigint(12)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `lugares_vazios_prova`
--
CREATE TABLE IF NOT EXISTS `lugares_vazios_prova` (
`cod_prova` int(11)
,`lugar_vazios` bigint(12)
);
-- --------------------------------------------------------

--
-- Table structure for table `modalidade`
--

CREATE TABLE IF NOT EXISTS `modalidade` (
  `cod_modalidade` int(11) NOT NULL AUTO_INCREMENT,
  `nome_modalidade` varchar(30) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `estado_valido` varchar(1) NOT NULL,
  PRIMARY KEY (`cod_modalidade`),
  KEY `nome_modalidade` (`nome_modalidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `modalidade`
--

INSERT INTO `modalidade` (`cod_modalidade`, `nome_modalidade`, `tipo`, `estado_valido`) VALUES
(2, 'Basquetebol', 'C', 'V'),
(3, 'Boxe', 'I', 'V'),
(4, 'Ciclismo', 'I', 'V'),
(5, 'Esgrima', 'C', 'V'),
(9, 'Natacao', 'I', 'X'),
(10, 'Polo Aquático', 'I', 'X'),
(11, '200 metros', 'I', 'V'),
(12, 'Futebol', 'C', 'V'),
(18, 'Polo Aquático', 'C', 'V'),
(19, '100 metros', 'I', 'V'),
(20, '400 metros', 'I', 'V'),
(21, '800 metros', 'I', 'V'),
(22, '1500 metros', 'I', 'V'),
(23, '10 000 metros', 'I', 'V'),
(24, 'Salto em distancia', 'I', 'V'),
(25, '4 x 400 metros', 'C', 'V'),
(26, '4 x 100 metros', 'C', 'V'),
(27, 'Salto em altura', 'I', 'V'),
(28, 'Natação 100m livre', 'I', 'V'),
(29, 'Salto em cumprimento', 'I', 'V');

-- --------------------------------------------------------

--
-- Table structure for table `moeda`
--

CREATE TABLE IF NOT EXISTS `moeda` (
  `moeda` varchar(3) NOT NULL,
  KEY `moeda` (`moeda`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `moeda`
--

INSERT INTO `moeda` (`moeda`) VALUES
('AED'),
('AFA'),
('ALL'),
('ANG'),
('ARS'),
('AUD'),
('AWG'),
('BBD'),
('BDT'),
('BHD'),
('BIF'),
('BMD'),
('BND'),
('BOB'),
('BRL'),
('BSD'),
('BTN'),
('BWP'),
('BZD'),
('CAD'),
('CHF'),
('CLP'),
('CNY'),
('COP'),
('CRC'),
('CUP'),
('CVE'),
('CYP'),
('CZK'),
('DJF'),
('DKK'),
('DOP'),
('DZD'),
('EEK'),
('EGP'),
('ETB'),
('EUR'),
('FKP'),
('GBP'),
('GHC'),
('GIP'),
('GMD'),
('GNF'),
('GTQ'),
('GYD'),
('HKD'),
('HNL'),
('HRK'),
('HTG'),
('HUF'),
('IDR'),
('ILS'),
('INR'),
('IQD'),
('ISK'),
('JMD'),
('JOD'),
('JPY'),
('KES'),
('KHR'),
('KMF'),
('KPW'),
('KRW'),
('KWD'),
('KYD'),
('KZT'),
('LAK'),
('LBP'),
('LKR'),
('LRD'),
('LSL'),
('LTL'),
('LVL'),
('LYD'),
('MAD'),
('MDL'),
('MGF'),
('MKD'),
('MMK'),
('MNT'),
('MOP'),
('MRO'),
('MTL'),
('MUR'),
('MVR'),
('MWK'),
('MXN'),
('MYR'),
('MZM'),
('NAD'),
('NGN'),
('NIO'),
('NOK'),
('NPR'),
('NZD'),
('OMR'),
('PAB'),
('PEN'),
('PGK'),
('PHP'),
('PKR'),
('PLN'),
('PYG'),
('QAR'),
('ROL'),
('RUB'),
('SAR'),
('SBD'),
('SCR'),
('SDD'),
('SEK'),
('SGD'),
('SHP'),
('SIT'),
('SKK'),
('SLL'),
('SOS'),
('SRG'),
('STD'),
('SVC'),
('SYP'),
('SZL'),
('THB'),
('TND'),
('TOP'),
('TRL'),
('TRY'),
('TTD'),
('TWD'),
('TZS'),
('UAH'),
('UGX'),
('USD'),
('UYU'),
('VEB'),
('VND'),
('VUV'),
('WST'),
('XAF'),
('XAG'),
('XAU'),
('XCD'),
('XOF'),
('XPD'),
('XPF'),
('XPT'),
('YER'),
('YUM'),
('ZAR'),
('ZMK'),
('ZWD');

-- --------------------------------------------------------

--
-- Table structure for table `opiniao`
--

CREATE TABLE IF NOT EXISTS `opiniao` (
  `id_opiniao` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(2) NOT NULL,
  `email` varchar(60) NOT NULL,
  `conteudo` text NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id_opiniao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
  `nome_pais` varchar(30) NOT NULL,
  `prefix_pais` varchar(2) NOT NULL,
  PRIMARY KEY (`nome_pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pais`
--

INSERT INTO `pais` (`nome_pais`, `prefix_pais`) VALUES
('Afeganistão', 'af'),
('África do Sul', 'za'),
('Albânia', 'al'),
('Alemanha', 'de'),
('Andorra', 'ad'),
('Angola', 'ao'),
('Arábia Saudita', 'sa'),
('Argentina', 'ar'),
('Arménia', 'am'),
('Austrália', 'au'),
('Áustria', 'at'),
('Azerbaijão', 'az'),
('Bahamas', 'bs'),
('Bahrein', 'bh'),
('Bangladesh', 'bd'),
('Barbados', 'bb'),
('Bélgica', 'be'),
('Belize', 'bz'),
('Benim', 'bj'),
('Bermudas', 'bm'),
('Bolívia', 'bo'),
('Bósnia e Herzegovina', 'ba'),
('Botswana', 'bw'),
('Brasil', 'br'),
('Brunei', 'bn'),
('Bulgária', 'bg'),
('Burkina Faso', 'bf'),
('Burundi', 'bi'),
('Butão', 'bt'),
('Cabo Verde', 'cv'),
('Camarões', 'cm'),
('Camboja', 'kh'),
('Canada', 'ca'),
('Catar', 'qa'),
('Cazaquistão', 'kz'),
('Chade', 'td'),
('Chile', 'cl'),
('China', 'cn'),
('Chipre', 'cy'),
('Colômbia', 'cb'),
('comite_organizacao', 'co'),
('Congo', 'cd'),
('Coreia do Norte', 'kp'),
('Coreia do Sul', 'kr'),
('Costa do Marfim', 'ci'),
('Costa Rica', 'cr'),
('Croácia', 'hr'),
('Cuba', 'cu'),
('Dinamarca', 'dk'),
('Egito', 'eg'),
('El Salvador', 'sv'),
('Emirados Árabes Unidos', 'ae'),
('Equador', 'ec'),
('Eslováquia', 'sk'),
('Eslovênia', 'si'),
('Espanha', 'es'),
('Estados Unidos', 'us'),
('Estónia', 'ee'),
('Etiópia', 'et'),
('Fiji', 'fj'),
('Finlândia', 'fi'),
('França', 'fr'),
('Gana', 'gh'),
('Grécia', 'gr'),
('Guatemala', 'gt'),
('Guiné', 'gn'),
('Haiti', 'ht'),
('Holanda', 'nl'),
('Honduras', 'hn'),
('Hong Kong', 'hk'),
('Índia', 'in'),
('Indonésia', 'id'),
('Irão', 'ir'),
('Iraque', 'iq'),
('Irlanda', 'ie'),
('Islândia', 'is'),
('Israel', 'il'),
('Italia', 'it'),
('Jamaica', 'jm'),
('Japão', 'jp'),
('Kuwait', 'kw'),
('Laos', 'la'),
('Letónia ', 'lv'),
('Líbano', 'lb'),
('Liberia', 'lr'),
('Líbia', 'ly'),
('Liechtenstein', 'li'),
('Luxemburgo', 'lx'),
('Madagáscar', 'mg'),
('Malásia', 'my'),
('Malta', 'mt'),
('Marrocos', 'ma'),
('Mauritânia', 'mr'),
('México', 'mx'),
('Moçambique', 'mz'),
('Montenegro', 'me'),
('Namíbia', 'na'),
('Nepal', 'np'),
('Nicarágua', 'ni'),
('Nigéria', 'ng'),
('Noruega', 'no'),
('Nova Zelândia', 'nz'),
('Palestina', 'ps'),
('Panamá', 'pa'),
('Paquistão', 'pk'),
('Paraguai', 'py'),
('Peru', 'pe'),
('Polónia', 'pl'),
('Porto Rico', 'pr'),
('Portugal', 'pt'),
('Quénia', 'qn'),
('Reino Unido', 'uk'),
('República Checa', 'cz'),
('República Dominicana', 'do'),
('Roménia', 'ro'),
('Ruanda', 'rw'),
('Rússia', 'ru'),
('São Marino', 'sm'),
('São Tomé e Príncipe', 'st'),
('Senegal', 'sn'),
('Sérvia', 'rs'),
('Singapura', 'sg'),
('Síria', 'sy'),
('Somália', 'so'),
('Sri Lanka', 'lk'),
('Suazilândia', 'sz'),
('Sudão', 'sd'),
('Suécia', 'se'),
('Suíça', 'ch'),
('Timor-Leste', 'tl'),
('Trinidad e Tobago', 'tt'),
('Tunísia', 'tn'),
('Turquia', 'tr'),
('Ucrânia', 'ua'),
('Uganda', 'ug'),
('Uruguai', 'uy'),
('Venezuela', 've'),
('Vietname', 'vn'),
('Zâmbia', 'zm'),
('Zimbabwe', 'zw');

-- --------------------------------------------------------

--
-- Stand-in structure for view `pais_notin_delegacao`
--
CREATE TABLE IF NOT EXISTS `pais_notin_delegacao` (
`nome_pais` varchar(30)
,`prefix_pais` varchar(2)
);
-- --------------------------------------------------------

--
-- Table structure for table `prova`
--

CREATE TABLE IF NOT EXISTS `prova` (
  `cod_prova` int(11) NOT NULL AUTO_INCREMENT,
  `cod_modalidade` int(11) NOT NULL,
  `local` varchar(30) NOT NULL,
  `data` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `duracao` time NOT NULL,
  `nome_juiz` varchar(30) NOT NULL,
  `preco` decimal(8,2) NOT NULL,
  `lugares_total` int(11) NOT NULL,
  `lugares_reservados` int(11) NOT NULL,
  `estado_valido` varchar(1) NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `lat` decimal(17,15) DEFAULT NULL,
  `lng` decimal(17,15) DEFAULT NULL,
  PRIMARY KEY (`cod_prova`),
  KEY `cod_modalidade` (`cod_modalidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `prova`
--

INSERT INTO `prova` (`cod_prova`, `cod_modalidade`, `local`, `data`, `hora_inicio`, `duracao`, `nome_juiz`, `preco`, `lugares_total`, `lugares_reservados`, `estado_valido`, `sexo`, `lat`, `lng`) VALUES
(13, 11, 'Londres', '2012-07-28', '16:30:00', '01:00:00', 'Walter', 12.00, 10000, 5, 'V', 'M', 51.501904107618110, -0.108359375000000),
(16, 2, 'Londres', '2012-07-30', '16:00:00', '03:00:00', 'Richard', 10.00, 10000, 10000, 'V', 'F', 51.501904107618110, -0.983593750000000),
(18, 23, 'Londres', '2012-08-12', '14:25:00', '04:00:00', 'Filipe', 12.00, 12000, 0, 'V', 'F', 51.501904107618110, -0.101835937500000),
(19, 12, 'Londres', '2012-08-09', '15:00:00', '02:00:00', 'Richard', 12.00, 40000, 20000, 'V', 'F', 51.501904107618110, -0.111835937500000),
(20, 2, 'Londres', '2012-08-06', '17:00:00', '03:00:00', 'Simons', 15.00, 20000, 1, 'V', 'M', 51.501904107618110, -0.121835937500000),
(21, 5, 'Londres', '2012-08-06', '11:00:00', '02:00:00', 'Philips', 8.90, 5000, 0, 'V', 'M', 51.501904107618110, -0.131835937500000),
(22, 19, 'Londres', '2012-08-06', '14:00:00', '04:00:00', 'Simons', 14.90, 35000, 0, 'V', 'M', 51.501904107618110, -0.141835937500000),
(23, 25, 'Londres', '2012-08-02', '15:00:00', '03:00:00', 'Alfred', 9.90, 30000, 0, 'V', 'M', 51.501904107618110, -0.151835937500000),
(24, 12, 'Londres', '2012-08-05', '15:30:00', '02:00:00', 'Christian', 19.90, 55000, 0, 'V', 'M', 51.501904107618110, -0.158359375000000),
(25, 28, 'Londres', '2012-08-06', '10:30:00', '02:00:00', 'smith', 9.90, 10000, 0, 'V', 'M', 51.501904107618110, -0.161835937500000),
(26, 19, 'Londres', '2012-07-28', '17:35:00', '02:00:00', 'Walter', 14.90, 35000, 6, 'V', 'F', 51.501904107618110, -0.171835937500000);

-- --------------------------------------------------------

--
-- Table structure for table `reserva_compra`
--

CREATE TABLE IF NOT EXISTS `reserva_compra` (
  `idreserva_compra` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(2) CHARACTER SET utf8 NOT NULL,
  `id_vis` int(11) NOT NULL,
  `quant` int(11) NOT NULL,
  `cod_sessao` int(11) NOT NULL,
  `re_ou_com` varchar(8) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idreserva_compra`),
  KEY `id_vis` (`id_vis`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `reserva_compra`
--

INSERT INTO `reserva_compra` (`idreserva_compra`, `tipo`, `id_vis`, `quant`, `cod_sessao`, `re_ou_com`) VALUES
(8, 'PR', 5, 1, 13, 'reserva'),
(11, 'EV', 5, 1, 8, 'compra'),
(12, 'PR', 5, 2, 26, 'reserva');

-- --------------------------------------------------------

--
-- Stand-in structure for view `tipo_prova`
--
CREATE TABLE IF NOT EXISTS `tipo_prova` (
`cod_prova` int(11)
,`sexo` varchar(1)
,`cod_modalidade` int(11)
,`nome_modalidade` varchar(30)
,`tipo` varchar(1)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `total_elemento_equipa`
--
CREATE TABLE IF NOT EXISTS `total_elemento_equipa` (
`cod_equipa` int(11)
,`total` bigint(21)
);
-- --------------------------------------------------------

--
-- Table structure for table `visitante`
--

CREATE TABLE IF NOT EXISTS `visitante` (
  `id_visitante` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) CHARACTER SET utf8 NOT NULL,
  `apelido` varchar(30) CHARACTER SET utf8 NOT NULL,
  `nif` int(9) NOT NULL,
  `morada` varchar(250) CHARACTER SET utf8 NOT NULL,
  `telemovel` int(9) NOT NULL,
  `email` varchar(60) CHARACTER SET utf8 NOT NULL,
  `login` varchar(30) CHARACTER SET utf8 NOT NULL,
  `password` varchar(30) CHARACTER SET utf8 NOT NULL,
  `ult_acesso` date DEFAULT NULL,
  PRIMARY KEY (`id_visitante`),
  UNIQUE KEY `nif` (`nif`,`telemovel`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `visitante`
--

INSERT INTO `visitante` (`id_visitante`, `nome`, `apelido`, `nif`, `morada`, `telemovel`, `email`, `login`, `password`, `ult_acesso`) VALUES
(5, 'ricardo', 'silva', 233999850, 'rua 24 de junho', 962411301, 'ricain59@gmail.com', 'jre1', 'jre1', '2012-01-20');

-- --------------------------------------------------------

--
-- Structure for view `associar_atl_prova`
--
DROP TABLE IF EXISTS `associar_atl_prova`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `associar_atl_prova` AS select `eq`.`cod_equipa` AS `cod_equipa`,`pr`.`cod_prova` AS `cod_prova`,`eq`.`cod_modalidade` AS `cod_modalidade`,`mo`.`nome_modalidade` AS `nome_modalidade`,`eq`.`sexo` AS `sexo`,`eq`.`cod_delegacao` AS `cod_delegacao`,`el`.`cod_elemento_equipa` AS `cod_elemento_equipa`,`el`.`estado_valido` AS `estado_valido`,`ee`.`nome` AS `nome` from ((((`modalidade` `mo` join `equipa` `eq`) join `prova` `pr`) join `elemento_in_equipa` `el`) join `elemento_equipa` `ee`) where ((`eq`.`cod_modalidade` = `mo`.`cod_modalidade`) and (`mo`.`tipo` = 'I') and (`eq`.`estado_valido` = 'V') and (`pr`.`estado_valido` = 'V') and (`pr`.`cod_modalidade` = `eq`.`cod_modalidade`) and (convert(`pr`.`sexo` using utf8) = `eq`.`sexo`) and (`eq`.`cod_equipa` = `el`.`cod_equipa`) and (`el`.`estado_valido` = 'V') and (`ee`.`cod_elemento_equipa` = `el`.`cod_elemento_equipa`) and (not(`el`.`cod_elemento_equipa` in (select `cl`.`cod_do_classificado` from `classificacao_prova` `cl` where ((`cl`.`cod_prova` = `pr`.`cod_prova`) and (`cl`.`estado_valido_classificado` <> 'X')))))) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `associar_el_delegacao`
--
DROP TABLE IF EXISTS `associar_el_delegacao`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `associar_el_delegacao` AS select `de`.`cod_delegacao` AS `cod_delegacao`,`ee`.`nome` AS `nome`,`ee`.`cod_elemento_equipa` AS `cod_elemento_equipa` from (((`elemento_equipa` `ee` join `elemento_in_equipa` `el`) join `equipa` `eq`) join `delegacao` `de`) where ((`ee`.`cod_elemento_equipa` = `el`.`cod_elemento_equipa`) and (`el`.`estado_valido` = 'V') and (`el`.`cod_equipa` = `eq`.`cod_equipa`) and (`eq`.`cod_delegacao` = `de`.`cod_delegacao`)) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `associar_eq_prova`
--
DROP TABLE IF EXISTS `associar_eq_prova`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `associar_eq_prova` AS select `eq`.`cod_equipa` AS `cod_equipa`,`pr`.`cod_prova` AS `cod_prova`,`eq`.`cod_modalidade` AS `cod_modalidade`,`mo`.`nome_modalidade` AS `nome_modalidade`,`eq`.`sexo` AS `sexo`,`eq`.`cod_delegacao` AS `cod_delegacao` from ((`modalidade` `mo` join `equipa` `eq`) join `prova` `pr`) where ((`eq`.`cod_modalidade` = `mo`.`cod_modalidade`) and (`mo`.`tipo` = 'C') and (`eq`.`estado_valido` = 'V') and (`pr`.`estado_valido` = 'V') and (`pr`.`cod_modalidade` = `eq`.`cod_modalidade`) and (convert(`pr`.`sexo` using utf8) = `eq`.`sexo`) and (not(`eq`.`cod_equipa` in (select `cl`.`cod_do_classificado` from `classificacao_prova` `cl` where ((`cl`.`cod_prova` = `pr`.`cod_prova`) and (`cl`.`estado_valido_classificado` <> 'X')))))) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `atl_acrescentado_a_prova`
--
DROP TABLE IF EXISTS `atl_acrescentado_a_prova`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `atl_acrescentado_a_prova` AS select distinct `el`.`cod_elemento_equipa` AS `cod_elemento_equipa`,`eq`.`cod_equipa` AS `cod_equipa`,`pr`.`cod_prova` AS `cod_prova`,`pr`.`cod_modalidade` AS `cod_modalidade`,`mo`.`nome_modalidade` AS `nome_modalidade`,`pr`.`sexo` AS `sexo`,`eq`.`cod_delegacao` AS `cod_delegacao`,`ee`.`nome` AS `nome` from (((((`classificacao_prova` `cl` join `prova` `pr`) join `equipa` `eq`) join `modalidade` `mo`) join `elemento_in_equipa` `el`) join `elemento_equipa` `ee`) where ((`cl`.`cod_prova` = `pr`.`cod_prova`) and (`pr`.`cod_modalidade` = `mo`.`cod_modalidade`) and (`mo`.`tipo` = 'I') and (`eq`.`estado_valido` <> 'X') and (`eq`.`cod_equipa` = `el`.`cod_equipa`) and (`el`.`cod_elemento_equipa` <> 'X') and (`el`.`cod_elemento_equipa` = `ee`.`cod_elemento_equipa`) and `el`.`cod_elemento_equipa` in (select `cp`.`cod_do_classificado` from `classificacao_prova` `cp` where ((`cl`.`cod_do_classificado` = `cp`.`cod_do_classificado`) and (`cl`.`estado_valido_classificado` = 'V'))));

-- --------------------------------------------------------

--
-- Structure for view `classificacao_atleta`
--
DROP TABLE IF EXISTS `classificacao_atleta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `classificacao_atleta` AS select `at`.`cod_elemento_equipa` AS `cod_elemento_equipa`,`at`.`cod_prova` AS `cod_prova`,`at`.`sexo` AS `sexo`,`at`.`cod_delegacao` AS `cod_delegacao`,`cl`.`classificacao` AS `classificacao`,`de`.`nome_pais` AS `nome_pais` from ((`atl_acrescentado_a_prova` `at` join `classificacao_prova` `cl`) join `delegacao` `de`) where ((`at`.`cod_elemento_equipa` = `cl`.`cod_do_classificado`) and (`at`.`cod_prova` = `cl`.`cod_prova`) and (`cl`.`estado_valido_classificado` = 'V') and (`at`.`cod_delegacao` = `de`.`cod_delegacao`));

-- --------------------------------------------------------

--
-- Structure for view `classificacao_equipa`
--
DROP TABLE IF EXISTS `classificacao_equipa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `classificacao_equipa` AS select `eq`.`cod_equipa` AS `cod_equipa`,`eq`.`cod_prova` AS `cod_prova`,`eq`.`sexo` AS `sexo`,`eq`.`cod_delegacao` AS `cod_delegacao`,`cl`.`classificacao` AS `classificacao`,`de`.`nome_pais` AS `nome_pais` from ((`eq_acrescentado_a_prova` `eq` join `classificacao_prova` `cl`) join `delegacao` `de`) where ((`eq`.`cod_equipa` = `cl`.`cod_do_classificado`) and (`eq`.`cod_prova` = `cl`.`cod_prova`) and (`cl`.`estado_valido_classificado` = 'V') and (convert(`eq`.`cod_delegacao` using utf8) = `de`.`cod_delegacao`)) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `classificacao_media_evento`
--
DROP TABLE IF EXISTS `classificacao_media_evento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `classificacao_media_evento` AS select `ev`.`cod_evento` AS `cod_evento`,(sum(`cl`.`classificacao`) / count(0)) AS `classif_media`,count(0) AS `votos` from (`evento` `ev` join `classificacao_evento` `cl`) where (`ev`.`cod_evento` = `cl`.`cod_evento`) group by `ev`.`cod_evento`;

-- --------------------------------------------------------

--
-- Structure for view `co_re_evento`
--
DROP TABLE IF EXISTS `co_re_evento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `co_re_evento` AS select `rc`.`id_vis` AS `id_vis`,`ev`.`cod_evento` AS `cod_evento`,`ev`.`data` AS `data`,`ev`.`hora_inicio` AS `hora_inicio`,`ev`.`duracao` AS `duracao`,`rc`.`re_ou_com` AS `re_ou_com`,`ev`.`lat` AS `lat`,`ev`.`lng` AS `lng` from (`reserva_compra` `rc` join `evento` `ev`) where ((`rc`.`tipo` = 'EV') and (`rc`.`cod_sessao` = `ev`.`cod_evento`)) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `co_re_prova`
--
DROP TABLE IF EXISTS `co_re_prova`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `co_re_prova` AS select `rc`.`id_vis` AS `id_vis`,`pr`.`cod_prova` AS `cod_prova`,`pr`.`data` AS `data`,`pr`.`hora_inicio` AS `hora_inicio`,`pr`.`duracao` AS `duracao`,`mo`.`nome_modalidade` AS `nome_modalidade`,`rc`.`re_ou_com` AS `re_ou_com`,`pr`.`lat` AS `lat`,`pr`.`lng` AS `lng` from ((`reserva_compra` `rc` join `prova` `pr`) join `modalidade` `mo`) where ((`rc`.`tipo` = 'PR') and (`rc`.`cod_sessao` = `pr`.`cod_prova`) and (`pr`.`cod_modalidade` = `mo`.`cod_modalidade`)) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `dados_atletas`
--
DROP TABLE IF EXISTS `dados_atletas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `dados_atletas` AS select `eq`.`cod_equipa` AS `cod_equipa`,`el`.`cod_elemento_equipa` AS `cod_elemento_equipa`,`el`.`nome` AS `nome`,`el`.`data_nasc` AS `data_nasc`,`el`.`sexo` AS `sexo`,`at`.`peso` AS `peso`,`at`.`altura` AS `altura`,`at`.`grupo_sanguineo` AS `grupo_sanguineo`,`de`.`cod_delegacao` AS `cod_delegacao`,`de`.`nome_pais` AS `nome_pais`,`ei`.`estado_valido` AS `estado_valido` from ((((`elemento_equipa` `el` join `atleta` `at`) join `elemento_in_equipa` `ei`) join `delegacao` `de`) join `equipa` `eq`) where ((`el`.`cod_elemento_equipa` = `at`.`cod_elemento_equipa`) and (`ei`.`cod_elemento_equipa` = `el`.`cod_elemento_equipa`) and (`ei`.`cod_equipa` = `eq`.`cod_equipa`) and (`eq`.`cod_delegacao` = `de`.`cod_delegacao`)) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `dados_auxiliares`
--
DROP TABLE IF EXISTS `dados_auxiliares`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `dados_auxiliares` AS select `eq`.`cod_equipa` AS `cod_equipa`,`el`.`cod_elemento_equipa` AS `cod_elemento_equipa`,`el`.`nome` AS `nome`,`el`.`data_nasc` AS `data_nasc`,`el`.`sexo` AS `sexo`,`au`.`funcao` AS `funcao`,`au`.`habilit_literarias` AS `habilit_literarias`,`de`.`cod_delegacao` AS `cod_delegacao`,`de`.`nome_pais` AS `nome_pais`,`ei`.`estado_valido` AS `estado_valido` from ((((`elemento_equipa` `el` join `auxiliar` `au`) join `elemento_in_equipa` `ei`) join `equipa` `eq`) join `delegacao` `de`) where ((`el`.`cod_elemento_equipa` = `au`.`cod_elemento_equipa`) and (`ei`.`cod_elemento_equipa` = `el`.`cod_elemento_equipa`) and (`ei`.`cod_equipa` = `eq`.`cod_equipa`) and (`eq`.`cod_delegacao` = `de`.`cod_delegacao`)) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `elemento_delegacao`
--
DROP TABLE IF EXISTS `elemento_delegacao`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `elemento_delegacao` AS select `eq`.`cod_equipa` AS `cod_equipa`,`eq`.`cod_delegacao` AS `cod_delegacao`,`ei`.`cod_elemento_equipa` AS `cod_elemento_equipa` from (`elemento_in_equipa` `ei` join `equipa` `eq`) where (`eq`.`cod_equipa` = `ei`.`cod_equipa`) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `equipa_with_delegacao`
--
DROP TABLE IF EXISTS `equipa_with_delegacao`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `equipa_with_delegacao` AS select `eq`.`cod_equipa` AS `cod_equipa`,`mo`.`nome_modalidade` AS `nome_modalidade`,`de`.`nome_pais` AS `nome_pais`,`eq`.`estado_valido` AS `estado_valido`,`de`.`cod_delegacao` AS `cod_delegacao`,`mo`.`cod_modalidade` AS `cod_modalidade`,`eq`.`sexo` AS `sexo` from ((`equipa` `eq` join `modalidade` `mo`) join `delegacao` `de`) where ((`eq`.`cod_modalidade` = `mo`.`cod_modalidade`) and (`eq`.`cod_delegacao` = `de`.`cod_delegacao`) and (`de`.`estado_valido` <> 'X') and (`eq`.`estado_valido` <> 'X')) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `eq_acrescentado_a_prova`
--
DROP TABLE IF EXISTS `eq_acrescentado_a_prova`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `eq_acrescentado_a_prova` AS select `eq`.`cod_equipa` AS `cod_equipa`,`pr`.`cod_prova` AS `cod_prova`,`pr`.`cod_modalidade` AS `cod_modalidade`,`mo`.`nome_modalidade` AS `nome_modalidade`,`pr`.`sexo` AS `sexo`,`eq`.`cod_delegacao` AS `cod_delegacao` from (((`classificacao_prova` `cl` join `prova` `pr`) join `equipa` `eq`) join `modalidade` `mo`) where ((`cl`.`cod_prova` = `pr`.`cod_prova`) and (`pr`.`cod_modalidade` = `mo`.`cod_modalidade`) and (`mo`.`tipo` = 'C') and (`eq`.`estado_valido` <> 'X') and `eq`.`cod_equipa` in (select `cp`.`cod_do_classificado` from `classificacao_prova` `cp` where ((`cl`.`cod_do_classificado` = `cp`.`cod_do_classificado`) and (`cl`.`estado_valido_classificado` = 'V')))) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `lugares_vazios_evento`
--
DROP TABLE IF EXISTS `lugares_vazios_evento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `lugares_vazios_evento` AS select `evento`.`cod_evento` AS `cod_evento`,(`evento`.`lugares_total` - `evento`.`lugares_reservados`) AS `lugar_vazios` from `evento` WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `lugares_vazios_prova`
--
DROP TABLE IF EXISTS `lugares_vazios_prova`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `lugares_vazios_prova` AS select `prova`.`cod_prova` AS `cod_prova`,(`prova`.`lugares_total` - `prova`.`lugares_reservados`) AS `lugar_vazios` from `prova` WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `pais_notin_delegacao`
--
DROP TABLE IF EXISTS `pais_notin_delegacao`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `pais_notin_delegacao` AS select `pa`.`nome_pais` AS `nome_pais`,`pa`.`prefix_pais` AS `prefix_pais` from `pais` `pa` where (not(exists(select 1 from `delegacao` `de` where ((`de`.`nome_pais` = `pa`.`nome_pais`) and (`de`.`estado_valido` <> 'X'))))) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `tipo_prova`
--
DROP TABLE IF EXISTS `tipo_prova`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `tipo_prova` AS select `pr`.`cod_prova` AS `cod_prova`,`pr`.`sexo` AS `sexo`,`pr`.`cod_modalidade` AS `cod_modalidade`,`mo`.`nome_modalidade` AS `nome_modalidade`,`mo`.`tipo` AS `tipo` from (`prova` `pr` join `modalidade` `mo`) where ((`pr`.`cod_modalidade` = `mo`.`cod_modalidade`) and (`pr`.`estado_valido` = 'V')) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `total_elemento_equipa`
--
DROP TABLE IF EXISTS `total_elemento_equipa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pwjre_root`@`localhost` SQL SECURITY DEFINER VIEW `total_elemento_equipa` AS select `elemento_in_equipa`.`cod_equipa` AS `cod_equipa`,count(0) AS `total` from `elemento_in_equipa` where (`elemento_in_equipa`.`estado_valido` <> 'X') group by `elemento_in_equipa`.`cod_equipa`;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `atleta`
--
ALTER TABLE `atleta`
  ADD CONSTRAINT `atleta_ibfk_1` FOREIGN KEY (`cod_elemento_equipa`) REFERENCES `elemento_equipa` (`cod_elemento_equipa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auxiliar`
--
ALTER TABLE `auxiliar`
  ADD CONSTRAINT `auxiliar_ibfk_1` FOREIGN KEY (`cod_elemento_equipa`) REFERENCES `elemento_equipa` (`cod_elemento_equipa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classificacao_evento`
--
ALTER TABLE `classificacao_evento`
  ADD CONSTRAINT `classificacao_evento_ibfk_1` FOREIGN KEY (`cod_evento`) REFERENCES `evento` (`cod_evento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classificacao_evento_ibfk_2` FOREIGN KEY (`id_vis`) REFERENCES `visitante` (`id_visitante`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classificacao_prova`
--
ALTER TABLE `classificacao_prova`
  ADD CONSTRAINT `classificacao_prova_ibfk_1` FOREIGN KEY (`cod_prova`) REFERENCES `prova` (`cod_prova`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delegacao`
--
ALTER TABLE `delegacao`
  ADD CONSTRAINT `delegacao_ibfk_1` FOREIGN KEY (`nome_pais`) REFERENCES `pais` (`nome_pais`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `elemento_in_equipa`
--
ALTER TABLE `elemento_in_equipa`
  ADD CONSTRAINT `elemento_in_equipa_ibfk_1` FOREIGN KEY (`cod_equipa`) REFERENCES `equipa` (`cod_equipa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `elemento_in_equipa_ibfk_2` FOREIGN KEY (`cod_elemento_equipa`) REFERENCES `elemento_equipa` (`cod_elemento_equipa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `equipa`
--
ALTER TABLE `equipa`
  ADD CONSTRAINT `equipa_ibfk_1` FOREIGN KEY (`cod_modalidade`) REFERENCES `modalidade` (`cod_modalidade`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `equipa_ibfk_2` FOREIGN KEY (`cod_delegacao`) REFERENCES `delegacao` (`cod_delegacao`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prova`
--
ALTER TABLE `prova`
  ADD CONSTRAINT `prova_ibfk_1` FOREIGN KEY (`cod_modalidade`) REFERENCES `modalidade` (`cod_modalidade`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reserva_compra`
--
ALTER TABLE `reserva_compra`
  ADD CONSTRAINT `reserva_compra_ibfk_1` FOREIGN KEY (`id_vis`) REFERENCES `visitante` (`id_visitante`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
