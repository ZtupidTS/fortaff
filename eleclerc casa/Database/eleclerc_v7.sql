-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 27, 2012 at 10:09 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `menumain`
--

INSERT INTO `menumain` (`menu_id`, `menu_number`, `menu_description`) VALUES
(1, 10, 'Ficheiro'),
(2, 11, 'Sugestão'),
(3, 20, 'Quebras'),
(4, 21, 'Importar Quebras'),
(5, 30, 'Administração'),
(6, 31, 'Utilizadores');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `quebras`
--

INSERT INTO `quebras` (`que_id`, `que_fam_id`, `que_tq_id`, `que_quantity`, `que_valor`, `que_date`) VALUES
(74, 541520, 10, '2.000', '1.980', '2012-07-23'),
(75, 541, 10, '2.000', '1.980', '2012-07-23'),
(76, 542523, 10, '5.000', '9.710', '2012-07-23'),
(77, 542524, 10, '2.000', '3.800', '2012-07-23'),
(78, 542528, 10, '3.000', '2.300', '2012-07-23'),
(79, 542529, 10, '2.000', '3.120', '2012-07-23'),
(80, 542530, 10, '36.066', '70.380', '2012-07-23'),
(81, 542, 10, '48.066', '89.330', '2012-07-23'),
(82, 54, 10, '50.066', '91.310', '2012-07-23'),
(83, 5, 10, '50.066', '91.310', '2012-07-23');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `softversion`
--

INSERT INTO `softversion` (`vers_id`, `vers_num`, `vers_log`) VALUES
(1, '1.0', 'Versão inicial com a submissão de comentários.'),
(2, '1.1', 'Mail implementado na parte da submissão de sugestão'),
(3, '1.2', 'Resolvi o problema de poder trabalhar em casa'),
(4, '1.3', 'Importação das quebras finalizadas com rollback implementado, menu sugestão no menu principal, personalização do menu');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_quebras`
--

CREATE TABLE IF NOT EXISTS `tipo_quebras` (
  `tq_id` int(11) NOT NULL AUTO_INCREMENT,
  `tq_description` varchar(45) NOT NULL,
  PRIMARY KEY (`tq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tipo_quebras`
--

INSERT INTO `tipo_quebras` (`tq_id`, `tq_description`) VALUES
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `userauth`
--

INSERT INTO `userauth` (`usa_id`, `usa_usr_id`, `usa_menu_id`) VALUES
(46, 1, 1),
(47, 1, 2),
(48, 1, 3),
(49, 1, 4),
(50, 1, 5),
(51, 1, 6),
(37, 2, 1),
(38, 2, 2);

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
(2, 'anónimo', '300182', 15, 0);

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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
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
  ADD CONSTRAINT `userauth_ibfk_2` FOREIGN KEY (`usa_menu_id`) REFERENCES `menumain` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userauth_ibfk_1` FOREIGN KEY (`usa_usr_id`) REFERENCES `users` (`usr_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `usr_section` FOREIGN KEY (`usr_section`) REFERENCES `section` (`sec_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
