-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 15, 2012 at 10:06 AM
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
  KEY `sec_id` (`com_id_section`),
  KEY `com_id_user` (`com_id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`com_id`, `com_id_user`, `com_comments`, `com_id_section`) VALUES
(17, 1, 'test', 9);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`conf_id`, `conf_tipo`, `conf_description`, `conf_value`) VALUES
(1, 'JFrame', 'setIconImage', './images/logo12.jpg'),
(2, 'Email', 'smtpserver', 'auth.ptasp.com'),
(3, 'Email', 'port', '25'),
(4, 'Email', 'user', 'ep108651w@fafedis.pt'),
(5, 'Email', 'password', 'leclerc'),
(6, 'Email', 'auth', 'true'),
(7, 'Email', 'from', 'ep108651w@fafedis.pt'),
(8, 'Email', 'to', 'ricain59@gmail.com'),
(11, 'Email', 'charset', 'ISO-8859-1'),
(12, 'Email', 'imagesug', 'http://dl.dropbox.com/u/24467236/logo01.gif');

-- --------------------------------------------------------

--
-- Table structure for table `family`
--

CREATE TABLE IF NOT EXISTS `family` (
  `fam_id` int(11) NOT NULL,
  `fam_description` varchar(80) NOT NULL,
  PRIMARY KEY (`fam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `family`
--

INSERT INTO `family` (`fam_id`, `fam_description`) VALUES
(0, 'Loja'),
(1, 'PGC'),
(4, 'BAZAR'),
(5, 'PRODUTOSFRESCOS'),
(6, 'TEXTIL/CALCADO'),
(11, 'MERCEARIA'),
(12, 'BEBIDAS'),
(13, 'D.P.H'),
(41, 'BAZAR LIGEIRO PERMANENTE'),
(42, 'BAZAR LIGEIRO SASONAL'),
(43, 'BAZAR PESADO'),
(44, 'CULTURAL'),
(51, 'TALHO'),
(52, 'AVES'),
(53, 'CHARCUTARIA'),
(54, 'CREMARIA'),
(55, 'CONGELADOS'),
(56, 'FRUTASELEGUMES'),
(57, 'PADARIAPASTELARIA'),
(58, 'PEIXARIA'),
(61, 'TEXTILPERMANENTE'),
(62, 'TEXTILSAZONAL'),
(63, 'PUERICULTURA'),
(64, 'CALCADO'),
(111, 'MERCEARIASALGADA'),
(112, 'MERCEARIADOCE'),
(121, 'BEBIDASNAOALCOOLICAS'),
(122, 'BEBIDASALCOOLICAS'),
(123, 'VASILHAME'),
(124, 'CONJNATAL'),
(131, 'DROGARIA'),
(132, 'PERFUMARIA'),
(133, 'HIGIENE'),
(134, 'PARAFARMACIA'),
(411, 'BRICOLAGE'),
(412, 'AUTO/CYCLO'),
(413, 'MENAGE'),
(414, 'ANIMAIS'),
(421, 'BAGAGENS/SACOSDESPORTO'),
(422, 'ARLIVRE/CAMPISMO'),
(423, 'DESPORTO/CYCLOS'),
(424, 'BRINQUEDOS'),
(425, 'PAPELARIA'),
(426, 'JARDIM'),
(431, 'GRANDEDOMESTICO'),
(432, 'PEQUENOSDOMESTICOS'),
(433, 'S.A.V.'),
(434, 'FOTO/CINE/SOM'),
(441, 'LIVROS'),
(442, 'MUSICACDS'),
(443, 'FILMESDVD/VIDEO'),
(444, 'INFORMATICA'),
(445, 'BILHETEIRA'),
(511, 'TALHOL.S.'),
(512, 'TALHOATENDIMENTO'),
(521, 'AVESL.S.'),
(522, 'AVESATENDIMENTO'),
(531, 'CHARCUTARIAL.S.'),
(532, 'CHARCUTARIAATENDIMENTO'),
(541, 'QUEIJARIAATENDIMENTO'),
(542, 'CREMARIAL.S.'),
(551, 'CONGELADOSDOCE'),
(552, 'CONGELADOSSALGADOS'),
(561, 'FRUTAS'),
(562, 'LEGUMES'),
(563, 'LEGUMESEMBALADOS/SOPAS'),
(564, 'SUMOSFRESCOS'),
(565, 'LEGUMESSECOSECORTIDOS'),
(566, 'FRUTOSSECOS'),
(567, 'FLORESEPLANTAS'),
(569, 'CONSIMIVEISEEMBALFRUTAS.LEG.'),
(571, 'PADARIAATENDIMENTO'),
(572, 'PADARIAL.S.'),
(573, 'CROISSANTARIAATENDIMENTO'),
(574, 'CROISSANTARIAL.S'),
(575, 'PASTELARIAATENDIMENTO'),
(576, 'PASTELARIAL.S.'),
(581, 'PEIXARIAFRESCA'),
(582, 'PEIXARIACONGELADA'),
(583, 'BACALHAU'),
(611, 'BEBE0/24MESES'),
(612, 'CRIANÇA2/8ANOS'),
(613, 'JUNIOR8/16ANOS'),
(614, 'SENHORA'),
(615, 'HOMEM'),
(616, 'TEXTILLAR'),
(617, 'RETROSARIA'),
(621, 'BEBE0/24MESES'),
(622, 'CRIANÇA2/8ANOS'),
(623, 'JUNIOR6-16ANOS'),
(624, 'SENHORA'),
(625, 'HOMEM'),
(626, 'RETROSARIA/ACESSORIOSDEMODA'),
(631, 'PUERICULTURA'),
(641, 'CALCADO'),
(111100, 'ARROZ'),
(111102, 'VINAGRES'),
(111104, 'OLEO'),
(111106, 'AZEITE'),
(111108, 'LEGUMESSECOS'),
(111110, 'LEGUMESENLATADOS'),
(111112, 'LEGUMESEMVINAGREEOLEO'),
(111114, 'CONDIMENTOSEMOLHOS'),
(111116, 'SAL'),
(111118, 'ESPECIARIAS'),
(111120, 'MASSAS'),
(111122, 'SOPASECALDOS'),
(111124, 'FARINHAS'),
(111126, 'PURES/FECULAS'),
(111128, 'CONSERVASDEPEIXE'),
(111130, 'CONSERVASDECARNE'),
(111132, 'COZINHADOS'),
(112140, 'ACUCAR'),
(112142, 'CAFES'),
(112144, 'CHAS'),
(112146, 'ALIMENTOSPARABEBE'),
(112148, 'LEITE'),
(112150, 'ACHOCOLATADO'),
(112152, 'CEREAIS'),
(112154, 'DIETETICO'),
(112156, 'TOSTAS'),
(112158, 'PAOEAFINS'),
(112160, 'PASTELARIAINDUSTRIAL'),
(112162, 'BOLACHAS'),
(112164, 'SOBREMESAS'),
(112166, 'CHOCOLATES'),
(112168, 'AMENDOAS'),
(112170, 'CONFEITARIA'),
(112172, 'DOCES'),
(112174, 'FRUTASEMCALDA'),
(112176, 'FRUTOSSECOSECRISTALIZADOS'),
(112178, 'APERITIVOS'),
(121200, 'REFRIGERANTESC/GAS'),
(121205, 'REFRIGERANTESS/GAS'),
(121210, 'SUMOSENECTARES'),
(121220, 'AGUAS'),
(122230, 'CERVEJAECIDRA'),
(122235, 'VINHOS'),
(122240, 'CHAMPANHEEESPUMANTES'),
(122245, 'APERITIVO'),
(122250, 'DIGESTIVOS,LICORESEAGUARDAN'),
(123299, 'VASILHAME'),
(124201, 'CONJNATAL'),
(131300, 'LAVAGEM'),
(132310, 'PERFUMARIA'),
(133320, 'HIGIENE'),
(134330, 'PARAFARMACIA'),
(411400, 'FERRAMENTAS'),
(411401, 'QUINQUILHARIA'),
(411402, 'HIDRAULICA/AQUECIMENTO'),
(411403, 'ELECTRICIDADE'),
(411404, 'MADEIRAEDERIVADOS'),
(411405, 'CONSTRUCAO'),
(411406, 'PINTURA/FITAS/COLAS/VEDANTES'),
(411407, 'REVESTIMENTOSP/CHAOEPAREDES'),
(412410, 'CYCLO/MOTORIZADAS'),
(412411, 'AUTO'),
(413414, 'UTENSILIOSPARACOZINHAR'),
(413415, 'ACESSORIOSEUTENSILIOSDECOZ'),
(413416, 'ACESSORIOSDEMESA'),
(413417, 'ACESSORIOSDEMENAGE'),
(413418, 'ACESSORIOSDEGARRAFEIRA'),
(413419, 'TALHERES'),
(413420, 'PLASTICODEMENAGE'),
(413421, 'RECIPIENTES/CONSERVACAO'),
(413422, 'EMBALAGENS'),
(413423, 'RECIPIENTESDEVIDRO'),
(413424, 'LOICA'),
(413425, 'PRESENTES'),
(413426, 'DESCARTAVEISEARTIGOSP/FESTA'),
(413427, 'LIMPEZA'),
(413428, 'ACESSORIOSP/ROUPA'),
(413429, 'ARTIGOSP/CASADEBANHO'),
(413430, 'MOBILIARIO'),
(414433, 'ALIMENTACAO'),
(414434, 'ACESSORIOSP/ANIMAIS'),
(421440, 'SACOSDESPORTO'),
(421441, 'BAGAGENS'),
(422444, 'MOBILIARIO'),
(422445, 'JOGOSDEJARDIM'),
(422446, 'MATERIALCAMPISMO'),
(422447, 'PISCINASEACESSORIOS'),
(422448, 'REBOQUEEACESSORIOS'),
(423451, 'BICICLETAS'),
(423452, 'DESPORTO/PESCA/CACA'),
(424455, 'JOGOS/ACESS.DEVERAOECARNAV'),
(424456, 'BRINQUEDOSSECHEPLEURSPERM.'),
(424457, 'BRINQUEDOSDENATAL'),
(425460, 'CORRESPONDENCIA'),
(425461, 'ECRITURE'),
(425462, 'DESENHO'),
(425463, 'ADESIVOS'),
(425464, 'ACESSORIOS'),
(425465, 'PAPEL'),
(425466, 'ARQUIVOS'),
(425467, 'MOCHILAS'),
(425468, 'MOLDURASEALBUNSFOTOS'),
(425469, 'PAPELFANTASIA'),
(426472, 'FERRAMENTAS'),
(426473, 'REGA'),
(426474, 'VEDACOES/PROTECCOES'),
(426475, 'VASOSEACESSORIOS'),
(426476, 'SEMENTES/VEGETAIS/PLANTAS'),
(426477, 'PRODUTOSFITOSANITARIOS'),
(426478, 'TERRAEDERIVADOS'),
(426479, 'ELEMENTOSDEDECORACAOEXTERIO'),
(431700, 'MAQUINALAVARROUPA'),
(431701, 'MAQUINASECARAROUPA'),
(431702, 'MAQUINALAVARLOICA'),
(431703, 'FRIGORIFICOS'),
(431704, 'CONGELADORES'),
(431705, 'FOGOES'),
(431706, 'ENCASTRAVEIS'),
(431707, 'EXAUSTORES'),
(431708, 'AQUECIMENTO/ARCONDICIONADO'),
(432720, 'PEQU.DOMESTICOCOZINHA'),
(432721, 'PEQU.DOMESTICOHIG.BELEZA'),
(432722, 'PEQU.DOMESTICOCASA'),
(432723, 'VENTOINHAS/AQUEC./DESUMIFI'),
(432724, 'ACESSORIOSPEQU.DOMESTICO'),
(433730, 'ENTREGAS'),
(433731, 'REPARACOES'),
(433732, 'ALUGUER'),
(434740, 'FOTO/OPTICA'),
(434741, 'TELEVISAO/VIDEO'),
(434742, 'HIFI/PEQUENOSOM'),
(434743, 'SUPORTESMAGNETICOS'),
(434744, 'TELECOMUNICAOES'),
(434745, 'ACESSORIOSTV-HIFI/ANTENAS/AR'),
(434746, 'EQUIPAMENTOESCRITORIO'),
(434747, 'INSTRUMENTOSMUSICAIS'),
(441750, 'LIVROSDEBOLSO'),
(441751, 'LIVROSBANDADESENHADA'),
(441752, 'LIVROSLITERATURA'),
(441753, 'LIVROSTECNICOS'),
(441754, 'HISTORIA'),
(441755, 'DICTIONARIOSEENCICLOPEDIAS'),
(441756, 'LIVROSAPOIOESCOLAR'),
(441757, 'LIVROSINFANTIS/JUVENIS'),
(441758, 'FERIADOLIVRO'),
(441759, 'POSTERS/POSTAIS'),
(442762, 'CD'),
(442763, 'CASSETESGRAVADAS'),
(442764, 'DVDMUSICA'),
(443767, 'FILMES/DVD'),
(443768, 'FILMESVIDEO'),
(444770, 'INFORMATICAMATERIAL'),
(444771, 'COMUNICACOES/NUMERIQUE'),
(444772, 'SOFTWARES'),
(444773, 'INFORMATICAACESSORIOS/CONSUMI'),
(444774, 'LIVROSINFORMATICA'),
(444775, 'JOGOSECONSOLASVIDEO'),
(445790, 'BILHETEIRA'),
(511500, 'TALHOL.S.'),
(511501, 'CONSUMIVEIS/EMBALAGENSTALHOL'),
(512503, 'TALHOATENDIMENTO'),
(512504, 'CONSUMIVEIS/EMBALAGENSTALHOA'),
(521506, 'AVESL.S.'),
(521507, 'CONSUMIVEISEMBALAGENSLSAVES'),
(522509, 'AVESATENDIMENTO'),
(522510, 'CONSUMIVEIS/EMBAL.ATEND.AVES'),
(531512, 'CHARCUTARIAL.S.'),
(531513, 'CONSUMIVEIS/EMBALAG.CHARC.LS'),
(532515, 'CHARCUTARIAATENDIMENTO'),
(532516, 'CHARCUTARIAEMBALADAP/L.S.'),
(532517, 'CHURRASCARIA'),
(532518, 'CONSUMIVEIS/EMBALAG.CHARCUT.'),
(541520, 'QUEIJARIAATENDIMENTO'),
(541521, 'CONSUMIVEIS/EMBALAG.QUEIJARIA'),
(542523, 'LEITE'),
(542524, 'IOGURTES'),
(542525, 'SOBREMESAS'),
(542526, 'MANTEIGAS'),
(542527, 'MARGARINAS'),
(542528, 'NATASECHANTILLY'),
(542529, 'SUMOSFRESCOS'),
(542530, 'QUEIJARIA'),
(542531, 'OVOS'),
(551533, 'GELADOS'),
(551534, 'SOBREMESAS'),
(551535, 'FRUTAS/POLPA/SUMOSCONGELADOS'),
(552537, 'PEIXEEMARISCOS'),
(552538, 'CARNECONGELADA'),
(552539, 'BATATASELEGUMESCONGELADOS'),
(552540, 'PREPARACOESCOZINHADAS'),
(552541, 'MASSAS/PAOCONGELADOS'),
(552542, 'SACOSP/CONGELADOS'),
(552543, 'CONSUMIVEISEEMBALAGENSCONG.'),
(561544, 'FRUTAS'),
(561545, 'FRUTOSEXOTICOS'),
(561546, 'FRUTOSEMBALADOS'),
(562548, 'LEGUMES'),
(562549, 'LEGUMESEMBALADOS'),
(563551, 'LEGUMESCOZIDOS/SOPAS'),
(564553, 'SUMOSFRESCOS'),
(565555, 'LEGUMESSECOSECORTIDOS'),
(566557, 'FRUTOSSECOS'),
(567559, 'FLORES'),
(567560, 'PLANTAS'),
(569561, 'CONSIMIVEISEEMBAL.FRUTAS.LE'),
(571563, 'PADARIAATENDIMENTO'),
(571564, 'CONSUMIVEISEEMBAL.PAD.ATEND'),
(572566, 'PADARIAL.S.'),
(572567, 'CONSUMIVEISEEMBAL.PAD.L.S.'),
(573569, 'CROISSANTARIAATENDIMENTO'),
(573570, 'CONSUMIVEISCROISSANT.ATEND.'),
(574572, 'CROISSANTARIAL.S.'),
(574573, 'CONSUMIVEISCROISSANT.L.S.'),
(575575, 'PASTELARIADOCE'),
(575576, 'PASTELARIASALGADA'),
(575577, 'CONSUMIVEISPASTELARIAATEND.'),
(576575, 'PASTELARIA'),
(576579, 'PASTELARIADOCE'),
(576580, 'PASTELARIASALGADA'),
(576581, 'PASTELARIAINDUSTRIAL'),
(576582, 'CONSUMIVEISPASTELARIAL.S.'),
(581584, 'PEIXARIAFRESCAATENDIMENTO'),
(581585, 'PEIXARIAL.S'),
(581586, 'CONSUMIVEISPEIXARIAFRESCA'),
(582588, 'PEIXARIACONGELADA'),
(582589, 'CONSUMIVEISPEXARIACONGEL.'),
(583591, 'BACALHAUL.S.'),
(583592, 'BACALHAUATENDIMENTO'),
(583593, 'CONSUMIVEISBACALHAU'),
(611600, 'BEBE0/24MESES'),
(612601, 'CRIANÇA2/8ANOS'),
(613602, 'JUNIOR8/16ANOS'),
(614603, 'SENHORA'),
(615604, 'HOMEM'),
(616605, 'TEXTILLAR'),
(617606, 'RETROSARIA'),
(621610, 'BEBE0/24MESESMENINO'),
(621611, 'BEBE0/24MESESMENINA'),
(622612, 'CRIANÇA2/8ANOSMENINO'),
(622613, 'CRIANÇA2/8ANOSMENINA'),
(623614, 'JUNIOR6-16ANOSRAPAZ'),
(623615, 'JUNIOR6-16ANOSRAPARIGA'),
(624616, 'SENHORA'),
(625617, 'HOMEM'),
(626618, 'RETROSARIA/ACESSORIOSDEMODA'),
(631620, 'PUERICULTURA'),
(641630, 'CALCADO');

-- --------------------------------------------------------

--
-- Table structure for table `menumain`
--

CREATE TABLE IF NOT EXISTS `menumain` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_number` int(11) NOT NULL,
  `menu_description` varchar(45) NOT NULL,
  PRIMARY KEY (`menu_id`),
  UNIQUE KEY `menu_num_UNIQUE` (`menu_number`),
  UNIQUE KEY `menu_description_UNIQUE` (`menu_description`),
  KEY `menu_num` (`menu_number`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `menumain`
--

INSERT INTO `menumain` (`menu_id`, `menu_number`, `menu_description`) VALUES
(1, 10, 'Ficheiro'),
(2, 11, 'Sugestão'),
(3, 20, 'Quebras'),
(4, 21, 'Importar Quebras'),
(5, 30, 'Administração'),
(6, 31, 'Utilizadores'),
(7, 12, 'Ver Sugestão'),
(8, 22, 'Ver Quebras'),
(9, 40, 'Resultados'),
(10, 41, 'Importar Vendas'),
(11, 42, 'Ver Vendas');

-- --------------------------------------------------------

--
-- Table structure for table `quebras`
--

CREATE TABLE IF NOT EXISTS `quebras` (
  `que_id` int(11) NOT NULL AUTO_INCREMENT,
  `que_fam_id` int(11) NOT NULL,
  `que_tq_id` int(11) NOT NULL,
  `que_quantity` decimal(12,3) NOT NULL,
  `que_valor` decimal(12,3) NOT NULL,
  `que_date` date NOT NULL,
  PRIMARY KEY (`que_id`),
  KEY `que_fam_id` (`que_fam_id`,`que_tq_id`),
  KEY `que_tq_id` (`que_tq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=309 ;

--
-- Dumping data for table `quebras`
--

INSERT INTO `quebras` (`que_id`, `que_fam_id`, `que_tq_id`, `que_quantity`, `que_valor`, `que_date`) VALUES
(105, 112140, 4, '2.000', '2.450', '2012-08-02'),
(106, 112166, 4, '2.000', '2.300', '2012-08-02'),
(107, 112, 4, '4.000', '4.760', '2012-08-02'),
(108, 11, 4, '4.000', '4.760', '2012-08-02'),
(109, 121200, 4, '1.000', '0.740', '2012-08-02'),
(110, 121205, 4, '1.000', '1.060', '2012-08-02'),
(111, 121220, 4, '2.000', '0.720', '2012-08-02'),
(112, 121, 4, '4.000', '2.520', '2012-08-02'),
(113, 12, 4, '4.000', '2.520', '2012-08-02'),
(114, 131300, 4, '3.000', '11.760', '2012-08-02'),
(115, 131, 4, '3.000', '11.760', '2012-08-02'),
(116, 132310, 4, '20.000', '125.910', '2012-08-02'),
(117, 132, 4, '20.000', '125.910', '2012-08-02'),
(118, 133320, 4, '1.000', '2.820', '2012-08-02'),
(119, 133, 4, '1.000', '2.820', '2012-08-02'),
(120, 134330, 4, '1.000', '2.460', '2012-08-02'),
(121, 134, 4, '1.000', '2.460', '2012-08-02'),
(122, 13, 4, '25.000', '142.950', '2012-08-02'),
(123, 1, 4, '33.000', '150.240', '2012-08-02'),
(124, 411400, 4, '2.000', '8.580', '2012-08-02'),
(125, 411401, 4, '4.000', '15.560', '2012-08-02'),
(126, 411403, 4, '4.000', '3.010', '2012-08-02'),
(127, 411406, 4, '5.000', '16.260', '2012-08-02'),
(128, 411, 4, '15.000', '43.420', '2012-08-02'),
(129, 412411, 4, '3.000', '6.230', '2012-08-02'),
(130, 412, 4, '3.000', '6.230', '2012-08-02'),
(131, 413421, 4, '1.000', '1.420', '2012-08-02'),
(132, 413427, 4, '1.000', '0.360', '2012-08-02'),
(133, 413, 4, '2.000', '1.790', '2012-08-02'),
(134, 41, 4, '20.000', '51.450', '2012-08-02'),
(135, 423452, 4, '2.000', '7.800', '2012-08-02'),
(136, 423, 4, '2.000', '7.800', '2012-08-02'),
(137, 424456, 4, '1.000', '0.350', '2012-08-02'),
(138, 424457, 4, '3.000', '9.190', '2012-08-02'),
(139, 424, 4, '4.000', '9.540', '2012-08-02'),
(140, 425461, 4, '1.000', '0.230', '2012-08-02'),
(141, 425464, 4, '3.000', '0.820', '2012-08-02'),
(142, 425, 4, '4.000', '1.050', '2012-08-02'),
(143, 426473, 4, '1.000', '1.700', '2012-08-02'),
(144, 426, 4, '1.000', '1.700', '2012-08-02'),
(145, 42, 4, '11.000', '20.100', '2012-08-02'),
(146, 444775, 4, '1.000', '15.640', '2012-08-02'),
(147, 444, 4, '1.000', '15.640', '2012-08-02'),
(148, 44, 4, '1.000', '15.640', '2012-08-02'),
(149, 4, 4, '32.000', '87.200', '2012-08-02'),
(150, 614603, 4, '1.000', '4.130', '2012-08-02'),
(151, 614, 4, '1.000', '4.130', '2012-08-02'),
(152, 61, 4, '1.000', '4.130', '2012-08-02'),
(153, 626618, 4, '2.000', '11.250', '2012-08-02'),
(154, 626, 4, '2.000', '11.250', '2012-08-02'),
(155, 62, 4, '2.000', '11.250', '2012-08-02'),
(156, 6, 4, '3.000', '15.380', '2012-08-02'),
(157, 542523, 10, '12.000', '5.900', '2012-08-03'),
(158, 542524, 10, '24.000', '26.820', '2012-08-03'),
(159, 542525, 10, '2.000', '0.960', '2012-08-03'),
(160, 542526, 10, '4.000', '6.920', '2012-08-03'),
(161, 542528, 10, '125.000', '126.440', '2012-08-03'),
(162, 542530, 10, '36.496', '65.120', '2012-08-03'),
(163, 542531, 10, '3.000', '3.000', '2012-08-03'),
(164, 542, 10, '206.496', '235.170', '2012-08-03'),
(165, 54, 10, '206.496', '235.170', '2012-08-03'),
(166, 5, 10, '206.496', '235.170', '2012-08-03'),
(187, 614603, 4, '1.000', '1.910', '2012-08-08'),
(188, 614603, 10, '1.000', '0.420', '2012-08-08'),
(189, 614, 4, '1.000', '1.910', '2012-08-08'),
(190, 614, 10, '1.000', '0.420', '2012-08-08'),
(191, 61, 4, '1.000', '1.910', '2012-08-08'),
(192, 61, 10, '1.000', '0.420', '2012-08-08'),
(193, 624616, 5, '9.000', '58.420', '2012-08-08'),
(194, 624, 5, '9.000', '58.420', '2012-08-08'),
(195, 625617, 5, '1.000', '11.450', '2012-08-08'),
(196, 625617, 10, '1.000', '4.530', '2012-08-08'),
(197, 625, 5, '1.000', '11.450', '2012-08-08'),
(198, 625, 10, '1.000', '4.530', '2012-08-08'),
(199, 62, 5, '11.000', '78.340', '2012-08-08'),
(200, 62, 10, '1.000', '4.530', '2012-08-08'),
(201, 631620, 5, '1.000', '1.560', '2012-08-08'),
(202, 631620, 10, '1.000', '8.660', '2012-08-08'),
(203, 631, 5, '1.000', '1.560', '2012-08-08'),
(204, 631, 10, '1.000', '8.660', '2012-08-08'),
(205, 63, 5, '1.000', '1.560', '2012-08-08'),
(206, 63, 10, '1.000', '8.660', '2012-08-08'),
(207, 641630, 5, '7.000', '41.890', '2012-08-08'),
(208, 641630, 10, '6.000', '53.100', '2012-08-08'),
(209, 641, 5, '7.000', '41.890', '2012-08-08'),
(210, 641, 10, '6.000', '53.100', '2012-08-08'),
(211, 64, 5, '7.000', '41.890', '2012-08-08'),
(212, 64, 10, '6.000', '53.100', '2012-08-08'),
(213, 6, 4, '1.000', '1.910', '2012-08-08'),
(214, 6, 5, '19.000', '121.790', '2012-08-08'),
(215, 6, 10, '9.000', '66.720', '2012-08-08'),
(216, 434744, 9, '18.000', '360.000', '2012-08-09'),
(217, 434, 9, '18.000', '360.000', '2012-08-09'),
(218, 43, 9, '18.000', '360.000', '2012-08-09'),
(219, 4, 9, '18.000', '360.000', '2012-08-09'),
(220, 111116, 10, '4.000', '4.680', '2012-08-10'),
(221, 111, 10, '4.000', '4.680', '2012-08-10'),
(222, 11, 10, '4.000', '4.680', '2012-08-10'),
(223, 1, 10, '4.000', '4.680', '2012-08-10'),
(224, 541520, 10, '5.000', '4.120', '2012-08-10'),
(225, 541, 10, '5.000', '4.120', '2012-08-10'),
(226, 542523, 10, '38.000', '30.470', '2012-08-10'),
(227, 542524, 10, '53.000', '80.340', '2012-08-10'),
(228, 542525, 10, '27.000', '20.300', '2012-08-10'),
(229, 542526, 10, '1.000', '1.270', '2012-08-10'),
(230, 542528, 10, '42.000', '60.600', '2012-08-10'),
(231, 542529, 10, '1.000', '1.200', '2012-08-10'),
(232, 542530, 10, '54.959', '78.950', '2012-08-10'),
(233, 542531, 10, '3.000', '3.140', '2012-08-10'),
(234, 542, 10, '219.959', '276.300', '2012-08-10'),
(235, 54, 10, '224.959', '280.420', '2012-08-10'),
(236, 551533, 10, '35.000', '119.080', '2012-08-10'),
(237, 551, 10, '35.000', '119.080', '2012-08-10'),
(238, 552541, 10, '4.000', '3.550', '2012-08-10'),
(239, 552, 10, '4.000', '3.550', '2012-08-10'),
(240, 55, 10, '39.000', '122.630', '2012-08-10'),
(241, 561544, 10, '101.350', '58.420', '2012-08-10'),
(242, 561545, 10, '128.891', '82.100', '2012-08-10'),
(243, 561546, 10, '3.000', '4.050', '2012-08-10'),
(244, 561, 10, '233.241', '144.580', '2012-08-10'),
(245, 562548, 10, '79.250', '54.580', '2012-08-10'),
(246, 562549, 10, '57.000', '63.900', '2012-08-10'),
(247, 562, 10, '136.250', '118.480', '2012-08-10'),
(248, 567560, 10, '12.000', '10.560', '2012-08-10'),
(249, 567, 10, '12.000', '10.560', '2012-08-10'),
(250, 56, 10, '381.491', '273.630', '2012-08-10'),
(251, 581584, 10, '20.930', '80.530', '2012-08-10'),
(252, 581, 10, '20.930', '80.530', '2012-08-10'),
(253, 58, 10, '20.930', '80.530', '2012-08-10'),
(254, 5, 10, '666.380', '757.220', '2012-08-10'),
(255, 511500, 10, '54.654', '206.470', '2012-08-12'),
(256, 511, 10, '54.654', '206.470', '2012-08-12'),
(257, 51, 10, '54.654', '206.470', '2012-08-12'),
(258, 521506, 10, '47.426', '129.850', '2012-08-12'),
(259, 521, 5, '47.426', '129.850', '2012-08-12'),
(260, 52, 10, '47.426', '129.850', '2012-08-12'),
(261, 531512, 10, '102.000', '150.990', '2012-08-12'),
(262, 531, 10, '102.000', '150.990', '2012-08-12'),
(263, 532515, 10, '0.367', '2.930', '2012-08-12'),
(264, 532517, 10, '12.959', '23.450', '2012-08-12'),
(265, 532, 10, '13.326', '26.390', '2012-08-12'),
(266, 53, 10, '115.326', '177.380', '2012-08-12'),
(267, 541520, 10, '16.082', '68.180', '2012-08-12'),
(268, 541, 10, '16.082', '68.180', '2012-08-12'),
(269, 54, 10, '16.082', '68.180', '2012-08-12'),
(270, 5, 10, '233.488', '581.900', '2012-08-12'),
(271, 111100, 5, '3.000', '2.070', '2012-08-13'),
(272, 111120, 5, '7.607', '2.320', '2012-08-13'),
(273, 111, 5, '10.607', '4.390', '2012-08-13'),
(274, 112140, 5, '2.000', '1.840', '2012-08-13'),
(275, 112146, 5, '1.000', '2.050', '2012-08-13'),
(276, 112150, 5, '1.000', '1.060', '2012-08-13'),
(277, 112156, 5, '5.000', '4.320', '2012-08-13'),
(278, 112160, 5, '3.000', '3.090', '2012-08-13'),
(279, 112164, 5, '3.000', '5.110', '2012-08-13'),
(280, 112166, 5, '1.000', '0.480', '2012-08-13'),
(281, 112170, 5, '7.000', '12.620', '2012-08-13'),
(282, 112172, 5, '1.000', '0.450', '2012-08-13'),
(283, 112178, 5, '5.000', '2.040', '2012-08-13'),
(284, 112, 5, '29.000', '33.100', '2012-08-13'),
(285, 11, 5, '39.607', '37.490', '2012-08-13'),
(286, 131300, 5, '1.000', '17.040', '2012-08-13'),
(287, 131, 5, '1.000', '17.040', '2012-08-13'),
(288, 132310, 5, '5.000', '14.220', '2012-08-13'),
(289, 132, 5, '5.000', '14.220', '2012-08-13'),
(290, 133320, 5, '2.000', '2.820', '2012-08-13'),
(291, 133, 5, '2.000', '2.820', '2012-08-13'),
(292, 13, 5, '8.000', '34.090', '2012-08-13'),
(293, 1, 5, '47.607', '71.580', '2012-08-13'),
(294, 411406, 10, '1.000', '2.860', '2012-08-13'),
(295, 411, 10, '1.000', '2.860', '2012-08-13'),
(296, 413427, 10, '1.000', '1.960', '2012-08-13'),
(297, 413, 10, '1.000', '1.960', '2012-08-13'),
(298, 41, 10, '2.000', '4.830', '2012-08-13'),
(299, 4, 10, '2.000', '4.830', '2012-08-13'),
(300, 542524, 5, '30.000', '52.900', '2012-08-13'),
(301, 542525, 5, '8.000', '6.430', '2012-08-13'),
(302, 542527, 5, '50.000', '113.050', '2012-08-13'),
(303, 542, 5, '88.000', '172.390', '2012-08-13'),
(304, 54, 5, '88.000', '172.390', '2012-08-13'),
(305, 572566, 5, '16.000', '6.820', '2012-08-13'),
(306, 572, 5, '16.000', '6.820', '2012-08-13'),
(307, 57, 5, '16.000', '6.820', '2012-08-13'),
(308, 5, 5, '104.000', '179.220', '2012-08-13');

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
  `vers_num` varchar(3) NOT NULL,
  `vers_log` varchar(200) NOT NULL,
  PRIMARY KEY (`vers_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `softversion`
--

INSERT INTO `softversion` (`vers_id`, `vers_num`, `vers_log`) VALUES
(1, '1.0', 'Versão inicial com a submissão de comentários.'),
(2, '1.1', 'Mail implementado na parte da submissão de sugestão'),
(3, '1.2', 'Resolvi o problema de poder trabalhar em casa'),
(4, '1.3', 'Importação das quebras finalizadas com rollback implementado, menu sugestão no menu principal, personalização do menu'),
(5, '1.4', 'Permissão de utilizadores a 100%'),
(6, '1.5', 'criação de user ok'),
(7, '1.6', 'ver sugestão'),
(8, '1.7', 'Visualizar quebras feito'),
(9, '1.8', 'Inserção vendas feito.');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_quebras`
--

CREATE TABLE IF NOT EXISTS `tipo_quebras` (
  `tq_id` int(11) NOT NULL,
  `tq_description` varchar(45) NOT NULL,
  PRIMARY KEY (`tq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipo_quebras`
--

INSERT INTO `tipo_quebras` (`tq_id`, `tq_description`) VALUES
(0, 'Todo Tipo'),
(1, 'Partido Transporte'),
(2, 'Fora Validade'),
(3, 'Retorno Fornecedor'),
(4, 'Roubo Constatado'),
(5, 'Donativos Coop Fafe'),
(6, 'Donativos JD Montelongo'),
(7, 'Demarco Promo'),
(8, 'Revenda a outra loja'),
(9, 'Requisição Interna'),
(10, 'Sinistro'),
(11, 'Donativos Lar de Revelhe'),
(12, 'Outros Donativos'),
(13, 'Diversos Saidas'),
(14, 'Transferido Inter Secção');

-- --------------------------------------------------------

--
-- Table structure for table `userauth`
--

CREATE TABLE IF NOT EXISTS `userauth` (
  `usa_id` int(11) NOT NULL AUTO_INCREMENT,
  `usa_usr_id` int(11) NOT NULL,
  `usa_menu_id` int(11) NOT NULL,
  PRIMARY KEY (`usa_id`),
  KEY `usa_usr_id` (`usa_usr_id`,`usa_menu_id`),
  KEY `usa_menu_id` (`usa_menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `userauth`
--

INSERT INTO `userauth` (`usa_id`, `usa_usr_id`, `usa_menu_id`) VALUES
(86, 1, 1),
(87, 1, 2),
(89, 1, 3),
(90, 1, 4),
(92, 1, 5),
(93, 1, 6),
(88, 1, 7),
(91, 1, 8),
(94, 1, 9),
(95, 1, 10),
(96, 1, 11),
(37, 2, 1),
(38, 2, 2),
(74, 3, 1),
(75, 3, 2),
(76, 3, 3),
(77, 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_login` varchar(45) NOT NULL,
  `usr_password` varchar(45) NOT NULL,
  `usr_section` int(11) NOT NULL,
  `usr_enable` int(11) NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_login_UNIQUE` (`usr_login`),
  KEY `usr_section` (`usr_section`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usr_id`, `usr_login`, `usr_password`, `usr_section`, `usr_enable`) VALUES
(1, 'ricardo', '300182', 9, 1),
(2, 'anónimo', '300182', 15, 1),
(3, 'chefes', 'fafedis', 15, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_authorization_menu`
--
CREATE TABLE IF NOT EXISTS `user_authorization_menu` (
`usa_id` int(11)
,`usa_usr_id` int(11)
,`usa_menu_id` int(11)
,`menu_id` int(11)
,`menu_number` int(11)
,`menu_description` varchar(45)
,`usr_id` int(11)
,`usr_login` varchar(45)
,`usr_password` varchar(45)
,`usr_section` int(11)
,`usr_enable` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `user_section`
--
CREATE TABLE IF NOT EXISTS `user_section` (
`usr_id` int(11)
,`usr_login` varchar(45)
,`usr_section` int(11)
,`sec_description` varchar(45)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `user_section_comment`
--
CREATE TABLE IF NOT EXISTS `user_section_comment` (
`com_id` int(11)
,`com_id_user` int(11)
,`com_comments` longtext
,`com_id_section` int(11)
,`usr_id` int(11)
,`usr_login` varchar(45)
,`usr_password` varchar(45)
,`usr_section` int(11)
,`usr_enable` int(11)
,`sec_id` int(11)
,`sec_description` varchar(45)
);
-- --------------------------------------------------------

--
-- Table structure for table `vendas`
--

CREATE TABLE IF NOT EXISTS `vendas` (
  `ve_id` int(11) NOT NULL AUTO_INCREMENT,
  `ve_fam_id` int(11) NOT NULL,
  `ve_valor` decimal(12,3) NOT NULL,
  `ve_date` date NOT NULL,
  PRIMARY KEY (`ve_id`),
  KEY `ve_fam_id` (`ve_fam_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=275 ;

--
-- Dumping data for table `vendas`
--

INSERT INTO `vendas` (`ve_id`, `ve_fam_id`, `ve_valor`, `ve_date`) VALUES
(1, 111100, '517.140', '2012-08-14'),
(2, 111102, '43.290', '2012-08-14'),
(3, 111104, '248.870', '2012-08-14'),
(4, 111106, '1761.520', '2012-08-14'),
(5, 111108, '68.260', '2012-08-14'),
(6, 111110, '236.730', '2012-08-14'),
(7, 111112, '40.150', '2012-08-14'),
(8, 111114, '331.400', '2012-08-14'),
(9, 111116, '41.150', '2012-08-14'),
(10, 111118, '129.230', '2012-08-14'),
(11, 111120, '255.540', '2012-08-14'),
(12, 111122, '103.900', '2012-08-14'),
(13, 111124, '47.090', '2012-08-14'),
(14, 111126, '20.280', '2012-08-14'),
(15, 111128, '380.530', '2012-08-14'),
(16, 111130, '129.880', '2012-08-14'),
(17, 111132, '51.580', '2012-08-14'),
(18, 111, '4406.540', '2012-08-14'),
(19, 112140, '195.230', '2012-08-14'),
(20, 112142, '1301.040', '2012-08-14'),
(21, 112144, '81.270', '2012-08-14'),
(22, 112146, '586.050', '2012-08-14'),
(23, 112148, '12.670', '2012-08-14'),
(24, 112150, '74.110', '2012-08-14'),
(25, 112152, '402.720', '2012-08-14'),
(26, 112154, '16.500', '2012-08-14'),
(27, 112156, '73.520', '2012-08-14'),
(28, 112158, '257.620', '2012-08-14'),
(29, 112160, '678.620', '2012-08-14'),
(30, 112162, '863.080', '2012-08-14'),
(31, 112164, '130.000', '2012-08-14'),
(32, 112166, '353.660', '2012-08-14'),
(33, 112168, '1.980', '2012-08-14'),
(34, 112170, '399.810', '2012-08-14'),
(35, 112172, '289.160', '2012-08-14'),
(36, 112174, '26.370', '2012-08-14'),
(37, 112176, '3.250', '2012-08-14'),
(38, 112178, '519.780', '2012-08-14'),
(39, 112, '6266.440', '2012-08-14'),
(40, 11, '10672.980', '2012-08-14'),
(41, 121200, '814.440', '2012-08-14'),
(42, 121205, '524.010', '2012-08-14'),
(43, 121210, '272.670', '2012-08-14'),
(44, 121220, '501.080', '2012-08-14'),
(45, 121, '2112.200', '2012-08-14'),
(46, 122230, '1298.250', '2012-08-14'),
(47, 122235, '4055.750', '2012-08-14'),
(48, 122240, '443.980', '2012-08-14'),
(49, 122245, '3131.100', '2012-08-14'),
(50, 122250, '1782.610', '2012-08-14'),
(51, 122, '10711.690', '2012-08-14'),
(52, 124201, '60.880', '2012-08-14'),
(53, 124, '60.880', '2012-08-14'),
(54, 12, '12884.770', '2012-08-14'),
(55, 131300, '1561.280', '2012-08-14'),
(56, 131, '1561.280', '2012-08-14'),
(57, 132310, '2252.480', '2012-08-14'),
(58, 132, '2252.480', '2012-08-14'),
(59, 133320, '1405.360', '2012-08-14'),
(60, 133, '1405.360', '2012-08-14'),
(61, 134330, '141.140', '2012-08-14'),
(62, 134, '141.140', '2012-08-14'),
(63, 13, '5360.260', '2012-08-14'),
(64, 1, '28918.010', '2012-08-14'),
(65, 411400, '421.910', '2012-08-14'),
(66, 411401, '134.000', '2012-08-14'),
(67, 411402, '27.100', '2012-08-14'),
(68, 411403, '319.560', '2012-08-14'),
(69, 411406, '183.200', '2012-08-14'),
(70, 411, '1085.770', '2012-08-14'),
(71, 412410, '11.960', '2012-08-14'),
(72, 412411, '518.010', '2012-08-14'),
(73, 412, '529.970', '2012-08-14'),
(74, 413414, '251.270', '2012-08-14'),
(75, 413415, '40.510', '2012-08-14'),
(76, 413416, '41.760', '2012-08-14'),
(77, 413417, '29.450', '2012-08-14'),
(78, 413419, '75.730', '2012-08-14'),
(79, 413420, '36.260', '2012-08-14'),
(80, 413421, '48.700', '2012-08-14'),
(81, 413422, '101.480', '2012-08-14'),
(82, 413423, '212.650', '2012-08-14'),
(83, 413424, '136.990', '2012-08-14'),
(84, 413425, '81.210', '2012-08-14'),
(85, 413426, '122.860', '2012-08-14'),
(86, 413427, '78.960', '2012-08-14'),
(87, 413428, '101.660', '2012-08-14'),
(88, 413429, '69.090', '2012-08-14'),
(89, 413430, '339.000', '2012-08-14'),
(90, 413, '1767.580', '2012-08-14'),
(91, 414433, '797.290', '2012-08-14'),
(92, 414434, '143.190', '2012-08-14'),
(93, 414, '940.480', '2012-08-14'),
(94, 41, '4323.800', '2012-08-14'),
(95, 421441, '19.900', '2012-08-14'),
(96, 421, '19.900', '2012-08-14'),
(97, 422444, '138.160', '2012-08-14'),
(98, 422446, '169.830', '2012-08-14'),
(99, 422447, '71.700', '2012-08-14'),
(100, 422, '379.690', '2012-08-14'),
(101, 423451, '89.000', '2012-08-14'),
(102, 423452, '37.550', '2012-08-14'),
(103, 423, '126.550', '2012-08-14'),
(104, 424455, '27.520', '2012-08-14'),
(105, 424456, '85.770', '2012-08-14'),
(106, 424457, '160.660', '2012-08-14'),
(107, 424, '273.950', '2012-08-14'),
(108, 425460, '6.790', '2012-08-14'),
(109, 425461, '26.010', '2012-08-14'),
(110, 425462, '4.260', '2012-08-14'),
(111, 425463, '0.990', '2012-08-14'),
(112, 425464, '14.510', '2012-08-14'),
(113, 425465, '43.990', '2012-08-14'),
(114, 425466, '23.170', '2012-08-14'),
(115, 425467, '44.840', '2012-08-14'),
(116, 425468, '3.040', '2012-08-14'),
(117, 425469, '0.900', '2012-08-14'),
(118, 425, '168.500', '2012-08-14'),
(119, 426472, '19.000', '2012-08-14'),
(120, 426473, '55.790', '2012-08-14'),
(121, 426474, '7.400', '2012-08-14'),
(122, 426476, '14.890', '2012-08-14'),
(123, 426477, '2.790', '2012-08-14'),
(124, 426478, '21.210', '2012-08-14'),
(125, 426479, '83.900', '2012-08-14'),
(126, 426, '204.980', '2012-08-14'),
(127, 42, '1173.570', '2012-08-14'),
(128, 431701, '199.000', '2012-08-14'),
(129, 431, '199.000', '2012-08-14'),
(130, 432720, '1053.540', '2012-08-14'),
(131, 432721, '70.600', '2012-08-14'),
(132, 432722, '49.880', '2012-08-14'),
(133, 432724, '18.630', '2012-08-14'),
(134, 432, '1192.650', '2012-08-14'),
(135, 434740, '212.910', '2012-08-14'),
(136, 434741, '1684.000', '2012-08-14'),
(137, 434742, '54.980', '2012-08-14'),
(138, 434743, '4.990', '2012-08-14'),
(139, 434745, '441.070', '2012-08-14'),
(140, 434, '2397.950', '2012-08-14'),
(141, 43, '3789.600', '2012-08-14'),
(142, 441750, '11.900', '2012-08-14'),
(143, 441751, '5.900', '2012-08-14'),
(144, 441752, '51.550', '2012-08-14'),
(145, 441753, '42.000', '2012-08-14'),
(146, 441755, '17.900', '2012-08-14'),
(147, 441756, '5.500', '2012-08-14'),
(148, 441757, '2.990', '2012-08-14'),
(149, 441758, '26.500', '2012-08-14'),
(150, 441, '164.240', '2012-08-14'),
(151, 442762, '118.560', '2012-08-14'),
(152, 442, '118.560', '2012-08-14'),
(153, 443767, '16.980', '2012-08-14'),
(154, 443, '16.980', '2012-08-14'),
(155, 444770, '163.780', '2012-08-14'),
(156, 444773, '203.100', '2012-08-14'),
(157, 444775, '506.860', '2012-08-14'),
(158, 444, '873.740', '2012-08-14'),
(159, 44, '1173.520', '2012-08-14'),
(160, 4, '10460.490', '2012-08-14'),
(161, 511500, '966.210', '2012-08-14'),
(162, 511, '966.210', '2012-08-14'),
(163, 512503, '1618.040', '2012-08-14'),
(164, 512, '1618.040', '2012-08-14'),
(165, 51, '2584.250', '2012-08-14'),
(166, 521506, '885.370', '2012-08-14'),
(167, 521, '885.370', '2012-08-14'),
(168, 522509, '245.220', '2012-08-14'),
(169, 522, '245.220', '2012-08-14'),
(170, 52, '1130.590', '2012-08-14'),
(171, 531512, '1090.900', '2012-08-14'),
(172, 531, '1090.900', '2012-08-14'),
(173, 532515, '1951.060', '2012-08-14'),
(174, 532517, '117.480', '2012-08-14'),
(175, 532, '2068.540', '2012-08-14'),
(176, 53, '3159.440', '2012-08-14'),
(177, 541520, '644.580', '2012-08-14'),
(178, 541, '644.580', '2012-08-14'),
(179, 542523, '1229.800', '2012-08-14'),
(180, 542524, '1203.260', '2012-08-14'),
(181, 542525, '263.960', '2012-08-14'),
(182, 542526, '116.360', '2012-08-14'),
(183, 542527, '184.490', '2012-08-14'),
(184, 542528, '84.530', '2012-08-14'),
(185, 542529, '38.400', '2012-08-14'),
(186, 542530, '918.460', '2012-08-14'),
(187, 542531, '215.380', '2012-08-14'),
(188, 542, '4254.640', '2012-08-14'),
(189, 54, '4899.220', '2012-08-14'),
(190, 551533, '294.320', '2012-08-14'),
(191, 551534, '17.220', '2012-08-14'),
(192, 551535, '9.470', '2012-08-14'),
(193, 551, '321.010', '2012-08-14'),
(194, 552537, '340.160', '2012-08-14'),
(195, 552538, '117.620', '2012-08-14'),
(196, 552539, '443.340', '2012-08-14'),
(197, 552540, '646.370', '2012-08-14'),
(198, 552541, '3.690', '2012-08-14'),
(199, 552542, '13.890', '2012-08-14'),
(200, 552, '1565.070', '2012-08-14'),
(201, 55, '1886.080', '2012-08-14'),
(202, 561544, '624.080', '2012-08-14'),
(203, 561545, '105.750', '2012-08-14'),
(204, 561546, '4.580', '2012-08-14'),
(205, 561, '734.410', '2012-08-14'),
(206, 562548, '545.200', '2012-08-14'),
(207, 562549, '92.590', '2012-08-14'),
(208, 562, '637.790', '2012-08-14'),
(209, 565555, '47.860', '2012-08-14'),
(210, 565, '47.860', '2012-08-14'),
(211, 566557, '130.590', '2012-08-14'),
(212, 566, '130.590', '2012-08-14'),
(213, 567560, '2.580', '2012-08-14'),
(214, 567, '2.580', '2012-08-14'),
(215, 56, '1553.230', '2012-08-14'),
(216, 571563, '182.490', '2012-08-14'),
(217, 571, '182.490', '2012-08-14'),
(218, 572566, '546.710', '2012-08-14'),
(219, 572, '546.710', '2012-08-14'),
(220, 574572, '22.990', '2012-08-14'),
(221, 574, '22.990', '2012-08-14'),
(222, 575575, '77.740', '2012-08-14'),
(223, 575576, '7.700', '2012-08-14'),
(224, 575, '85.440', '2012-08-14'),
(225, 576579, '1004.150', '2012-08-14'),
(226, 576581, '17.430', '2012-08-14'),
(227, 576, '1021.580', '2012-08-14'),
(228, 57, '1859.210', '2012-08-14'),
(229, 581584, '727.570', '2012-08-14'),
(230, 581, '727.570', '2012-08-14'),
(231, 582588, '623.200', '2012-08-14'),
(232, 582, '623.200', '2012-08-14'),
(233, 583591, '37.810', '2012-08-14'),
(234, 583592, '643.720', '2012-08-14'),
(235, 583, '681.530', '2012-08-14'),
(236, 58, '2032.300', '2012-08-14'),
(237, 5, '19104.320', '2012-08-14'),
(238, 611600, '39.340', '2012-08-14'),
(239, 611, '39.340', '2012-08-14'),
(240, 612601, '109.960', '2012-08-14'),
(241, 612, '109.960', '2012-08-14'),
(242, 613602, '23.700', '2012-08-14'),
(243, 613, '23.700', '2012-08-14'),
(244, 614603, '127.250', '2012-08-14'),
(245, 614, '127.250', '2012-08-14'),
(246, 615604, '69.770', '2012-08-14'),
(247, 615, '69.770', '2012-08-14'),
(248, 616605, '338.930', '2012-08-14'),
(249, 616, '338.930', '2012-08-14'),
(250, 61, '708.950', '2012-08-14'),
(251, 621610, '53.820', '2012-08-14'),
(252, 621611, '34.200', '2012-08-14'),
(253, 621, '88.020', '2012-08-14'),
(254, 622612, '244.180', '2012-08-14'),
(255, 622613, '146.270', '2012-08-14'),
(256, 622, '390.450', '2012-08-14'),
(257, 623614, '49.680', '2012-08-14'),
(258, 623615, '100.350', '2012-08-14'),
(259, 623, '150.030', '2012-08-14'),
(260, 624616, '210.190', '2012-08-14'),
(261, 624, '210.190', '2012-08-14'),
(262, 625617, '59.120', '2012-08-14'),
(263, 625, '59.120', '2012-08-14'),
(264, 626618, '86.400', '2012-08-14'),
(265, 626, '86.400', '2012-08-14'),
(266, 62, '984.210', '2012-08-14'),
(267, 631620, '279.480', '2012-08-14'),
(268, 631, '279.480', '2012-08-14'),
(269, 63, '279.480', '2012-08-14'),
(270, 641630, '590.040', '2012-08-14'),
(271, 641, '590.040', '2012-08-14'),
(272, 64, '590.040', '2012-08-14'),
(273, 6, '2562.680', '2012-08-14'),
(274, 1, '61700.380', '2012-08-14');

-- --------------------------------------------------------

--
-- Structure for view `user_authorization_menu`
--
DROP TABLE IF EXISTS `user_authorization_menu`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_authorization_menu` AS select `ua`.`usa_id` AS `usa_id`,`ua`.`usa_usr_id` AS `usa_usr_id`,`ua`.`usa_menu_id` AS `usa_menu_id`,`mm`.`menu_id` AS `menu_id`,`mm`.`menu_number` AS `menu_number`,`mm`.`menu_description` AS `menu_description`,`us`.`usr_id` AS `usr_id`,`us`.`usr_login` AS `usr_login`,`us`.`usr_password` AS `usr_password`,`us`.`usr_section` AS `usr_section`,`us`.`usr_enable` AS `usr_enable` from ((`userauth` `ua` join `menumain` `mm`) join `users` `us`) where ((`ua`.`usa_menu_id` = `mm`.`menu_id`) and (`us`.`usr_id` = `ua`.`usa_usr_id`)) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `user_section`
--
DROP TABLE IF EXISTS `user_section`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_section` AS select `us`.`usr_id` AS `usr_id`,`us`.`usr_login` AS `usr_login`,`us`.`usr_section` AS `usr_section`,`sec`.`sec_description` AS `sec_description` from (`users` `us` join `section` `sec`) where (`us`.`usr_section` = `sec`.`sec_id`) WITH CASCADED CHECK OPTION;

-- --------------------------------------------------------

--
-- Structure for view `user_section_comment`
--
DROP TABLE IF EXISTS `user_section_comment`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_section_comment` AS select `comment`.`com_id` AS `com_id`,`comment`.`com_id_user` AS `com_id_user`,`comment`.`com_comments` AS `com_comments`,`comment`.`com_id_section` AS `com_id_section`,`users`.`usr_id` AS `usr_id`,`users`.`usr_login` AS `usr_login`,`users`.`usr_password` AS `usr_password`,`users`.`usr_section` AS `usr_section`,`users`.`usr_enable` AS `usr_enable`,`section`.`sec_id` AS `sec_id`,`section`.`sec_description` AS `sec_description` from ((`comment` join `users`) join `section`) where ((`comment`.`com_id_user` = `users`.`usr_id`) and (`comment`.`com_id_section` = `section`.`sec_id`)) WITH CASCADED CHECK OPTION;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`com_id_user`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sec_id` FOREIGN KEY (`com_id_section`) REFERENCES `section` (`sec_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quebras`
--
ALTER TABLE `quebras`
  ADD CONSTRAINT `quebras_ibfk_1` FOREIGN KEY (`que_fam_id`) REFERENCES `family` (`fam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quebras_ibfk_2` FOREIGN KEY (`que_tq_id`) REFERENCES `tipo_quebras` (`tq_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userauth`
--
ALTER TABLE `userauth`
  ADD CONSTRAINT `userauth_ibfk_1` FOREIGN KEY (`usa_usr_id`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userauth_ibfk_2` FOREIGN KEY (`usa_menu_id`) REFERENCES `menumain` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `usr_section` FOREIGN KEY (`usr_section`) REFERENCES `section` (`sec_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`ve_fam_id`) REFERENCES `family` (`fam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
