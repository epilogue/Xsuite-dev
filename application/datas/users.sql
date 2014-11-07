-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mer 16 Juillet 2014 à 17:17
-- Version du serveur: 5.5.37
-- Version de PHP: 5.3.10-1ubuntu3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `xsuite-dev`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom_user` varchar(80) NOT NULL,
  `prenom_user` varchar(80) NOT NULL,
  `tel_user` int(10) DEFAULT NULL,
  `email_user` varchar(80) NOT NULL,
  `password_user` varchar(10) NOT NULL,
  `numwp_user` varchar(10) DEFAULT NULL,
  `id_fonction` int(5) DEFAULT NULL,
  `id_zone` int(5) DEFAULT NULL,
  `id_holon` int(5) DEFAULT NULL,
  `niveau` varchar(25) NOT NULL DEFAULT 'niveau0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=137 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `nom_user`, `prenom_user`, `tel_user`, `email_user`, `password_user`, `numwp_user`, `id_fonction`, `id_zone`, `id_holon`, `niveau`) VALUES
(3, 'ARGENTINO', 'Tony', 6, 'targentino@smc-france.fr', 'smc00643', 'IN01', 0, 5, 2, 'niveau0'),
(4, 'BAUER', 'Alexandre', 6, 'abauer@smc-france.fr', 'alex4288', 'IP14', 5, 1, 1, 'niveau0'),
(5, 'BELKACEM', 'Karim', 6, 'kbelkacem@smc-france.fr', 'smc00446', '', 0, 0, 0, 'niveau0'),
(6, 'BERINGUE', 'Nicolas', 6, 'nberingue@smc-france.fr', 'smc00501', 'IS01', 3, 4, 3, 'niveau0'),
(7, 'BLONDELLE', 'Mickael', 6, 'mblondelle@smc-france.fr', '19041393', 'Engineerin', 9, 0, 0, 'niveau0'),
(8, 'BODENAN', 'Virginie', 0, 'vbodenan@smc-france.fr', 'smc00270', '', 0, 0, 0, 'niveau0'),
(9, 'BOQUILLARD', 'Alain', 6, 'aboquillard@smc-france.fr', 'smc00671', 'IS06', 1, 3, 3, 'niveau0'),
(10, 'BOULOUD', 'Martial', 0, 'mbouloud@smc-france.fr', 'smc00425', '', 0, 0, 0, 'niveau0'),
(11, 'BRETON', 'Gilles', 6, 'gbreton@smc-france.fr', 'smc00276', 'IB06', 1, 4, 3, 'niveau0'),
(12, 'BRIANTAIS', 'Laurent', 6, 'lbriantais@smc-france.fr', 'smc00590', 'IW05', 6, 6, 4, 'niveau0'),
(13, 'BRIATTE', 'Bruno', 6, 'bbriatte@smc-france.fr', 'smc00608', '', 16, 1, 1, 'niveau0'),
(14, 'BRUGEROLLE', 'Guillaume', 0, 'gbrugerolle@smc-france.fr', 'dec2011', 'Engineerin', 8, 0, 0, 'niveau0'),
(15, 'BRULE', 'Damien', 6, 'dbrule@smc-france.fr', 'smc00644', 'IN04', 0, 0, 0, 'niveau0'),
(16, 'BUCCHI', 'St', 6, 'sbucchi@smc-france.fr', 'smc00534', '', 17, 1, 1, 'niveau0'),
(17, 'BURON', 'Nicolas', 6, 'nburon@smc-france.fr', 'smc2009', 'IW02', 2, 6, 4, 'niveau0'),
(18, 'CALMELS', 'Christophe', 6, 'ccalmels@smc-france.fr', 'smc00356', 'IS03', 2, 3, 3, 'niveau0'),
(19, 'CHAMIELEC', 'H', 0, 'hchamielec@smc-france.fr', 'smc00319', '', 0, 0, 0, 'niveau0'),
(20, 'CHANTELOUP', 'Willy', 6, 'wchanteloup@smc-france.fr', 'ferrari', 'IW02', 3, 6, 4, 'niveau0'),
(21, 'CHEVALIER', 'Olivier', 6, 'ochevalier@smc-France.fr', 'smc00350', '', 0, 0, 0, 'niveau0'),
(22, 'CHHUN', 'Philippe', 0, 'pchhun@smc-france.fr', 'smc00556', '', 0, 0, 0, 'niveau0'),
(23, 'CHOUX', 'Damien', 6, 'dchoux@smc-france.fr', 'smc00684', 'IS01', 2, 4, 3, 'niveau0'),
(24, 'CLERIN', 'R', 6, 'rclerin@smc-france.fr', 'smc00651', 'IS01', 0, 0, 0, 'niveau0'),
(25, 'COUDAN', 'Jean-Christophe', 6, 'jcoudan@smc-france.fr', 'smc00066', 'IS04', 2, 3, 3, 'niveau0'),
(26, 'COULOMBEL', 'Micka', 6, 'mcoulombel@smc-france.fr', 'smc00683', 'IN02', 2, 2, 2, 'niveau0'),
(27, 'COURTOIS', 'Karine', 0, 'kcourtois@smc-france.fr', 'smc00201', '', 0, 0, 0, 'niveau0'),
(28, 'COURTOIS', 'Julien', 6, 'jcourtois@smc-france.fr', 'jc101182', 'IS05', 6, 4, 3, 'niveau0'),
(29, 'CRETON', 'Benoit', 0, 'bcreton@smc-france.fr', 'smc00631', '', 0, 0, 0, 'niveau0'),
(30, 'D''ANGELO', 'S', 6, 'sdangelo@smc-france.fr', 'smc00578', 'IN01', 2, 2, 2, 'niveau0'),
(31, 'D''ANGELO', 'Thierry', 0, 'tdangelo@smc-france.fr', 'smc00094', 'Support te', 15, 0, 0, 'niveau0'),
(32, 'DAMIEN', 'Eddy', 6, 'edamien@smc-france.fr', 'smc00600', 'IS07', 11, 4, 3, 'niveau0'),
(33, 'DAVID', 'Ga', 6, 'gdavid@smc-france.fr', 'smc00511', 'IW01', 2, 6, 4, 'niveau0'),
(34, 'DAZIN', 'Patrice', 6, 'pdazin@smc-france.fr', 'smc00253', 'IW02', 2, 6, 4, 'niveau0'),
(35, 'DELAUGE', 'Fran', 6, 'fdelauge@smc-france.fr', 'smc00012', '', 10, 0, 0, 'niveau0'),
(36, 'DELHAUME', 'Patrick', 0, 'pdelhaume@smc-france.fr', 'smc00256', '', 0, 0, 0, 'niveau0'),
(37, 'DELOBEL', 'Christophe', 6, 'cdelobel@smc-france.fr', 'cdelo74', 'IS03', 2, 3, 3, 'niveau0'),
(38, 'DELPLUQUE', 'J', 0, 'jdelpluque@smc-france.fr', 'smc00522', '', 0, 0, 0, 'niveau0'),
(39, 'DEPRETZ', 'Fabien', 6, 'fdepretz@smc-france.fr', 'smc00581', 'IN02', 4, 2, 2, 'niveau0'),
(40, 'DEROCHE', 'Yann', 6, 'yderoche@smc-france.fr', 'smc00663', '', 1, 0, 0, 'niveau0'),
(41, 'DERONNE', 'Marion', 0, 'mderonne@smc-france.fr', 'smc00637', '', 0, 0, 0, 'niveau0'),
(42, 'DRANCOURT', 'Fr', 6, 'fdrancourt@smc-france.fr', 'smc00689', '', 1, 5, 2, 'niveau0'),
(43, 'DUCREUX', 'St', 6, 'sducreux@smc-france.fr', 'morrison', 'IS04', 2, 3, 3, 'niveau0'),
(44, 'DUPRE', 'G', 0, 'gdupre@smc-france.fr', 'smc00272', '', 0, 0, 0, 'niveau0'),
(45, 'DUROURE', 'Francis', 6, 'fduroure@smc-france.fr', 'smc00076', 'IS07', 11, 3, 3, 'niveau0'),
(46, 'DUVERNET', 'Jean-Denis', 6, 'jduvernet@smc-france.fr', 'smc00410', 'IS06', 1, 4, 3, 'niveau0'),
(47, 'FOREST', 'Ga', 6, 'gforest@smc-france.fr', 'smc00365', 'IW01', 2, 6, 1, 'niveau0'),
(48, 'FORNAGE', 'Fr', 0, 'ffornage@smc-france.fr', 'smc00630', '', 0, 0, 0, 'niveau0'),
(49, 'FOUQUET', 'Val', 0, 'vfouquet@smc-france.fr', 'smc00618', '', 0, 0, 0, 'niveau0'),
(50, 'FRANCOIS', 'V', 0, 'vfrancois@smc-france.fr', 'smc00407', '', 0, 0, 0, 'niveau0'),
(51, 'FRIOCOURT', 'Anthony', 6, 'afriocourt@smc-france.fr', 'smc00645', 'IW03', 0, 0, 0, 'niveau0'),
(52, 'GAIARIN', 'Laurence', 6, 'lgaiarin@smc-france.fr', 'smc00616', '', 0, 0, 0, 'niveau0'),
(53, 'GARCIA BALLESTER', 'Nicolas', 6, 'ngarciaballester@smc-france.fr', 'smc00495', 'IS04', 3, 3, 3, 'niveau0'),
(54, 'GAUTAUX', 'Fabien', 6, 'fgautaux@smc-france.fr', 'smc00664', 'IS01', 4, 4, 3, 'niveau0'),
(55, 'GAUTHIER', 'Fabien', 6, 'fgauthier@smc-france.fr', 'smc00515', '', 0, 0, 0, 'niveau0'),
(56, 'GERMAIN', 'Bruno', 6, 'bgermain@smc-france.fr', 'smc2012', 'IW03', 0, 0, 0, 'niveau0'),
(57, 'GOEMAN', 'Matthieu', 6, 'mgoeman@smc-france.fr', 'smc00505', 'Engineerin', 9, 0, 0, 'niveau0'),
(58, 'GOTTI', 'Marie-Laure', 0, 'mgotti@smc-france.fr', 'smc00441', '', 0, 0, 0, 'niveau0'),
(59, 'GOUCHET', 'Pierrick', 6, 'pgouchet@smc-france.fr', 'smc00544', 'IW01', 4, 6, 4, 'niveau0'),
(60, 'GOUIN', 'Sophie', 0, 'sgouin@smc-france.fr', 'smc00207', '', 0, 0, 0, 'niveau0'),
(61, 'GRELOT', 'Christelle', 0, 'cgrelot@smc-france.fr', 'smc00458', '', 0, 0, 0, 'niveau0'),
(62, 'GRIOTIER', 'Cyril', 6, 'cyril.griotier@smc-france.fr', 'cgmd0705', 'IX01', 2, 3, 3, 'niveau0'),
(63, 'GRUAT', 'Fr', 6, 'fgruat@smc-france.fr', 'smc00500', 'IW05', 6, 6, 4, 'niveau0'),
(64, 'HATTERER', 'Nicolas', 6, 'nhatterer@smc-france.fr', 'smc00665', '', 4, 3, 3, 'niveau0'),
(65, 'HAUPTMANN', 'Micka', 6, 'mhauptmann@smc-france.fr', 'smc00549', 'IS01', 2, 4, 3, 'niveau0'),
(66, 'HIENNE', 'Eric', 6, 'ehienne@smc-france.fr', 'smc00279', 'Direction', 7, 0, 0, 'niveau0'),
(67, 'HUBY', 'Magalie', 0, 'mhuby@smc-france.fr', 'smc00687', '', 0, 1, 1, 'niveau1'),
(68, 'JAMET', 'Pascal', 0, 'pjamet@smc-france.fr', 'mallauri', 'Support te', 18, 0, 0, 'niveau0'),
(69, 'JOLY', 'Christophe', 0, 'cjoly@smc-france.fr', 'smc00119', 'Engineerin', 8, 0, 0, 'niveau0'),
(70, 'JOURDAIN', 'Emmanuel', 6, 'ejourdain@smc-france.fr', 'thomas01', '', 0, 0, 0, 'niveau0'),
(71, 'JOURET', 'Gilles', 6, 'gjouret@smc-france.fr', 'MATHISLO', 'IW06', 3, 7, 4, 'niveau0'),
(72, 'LADANT', 'Sophie', 6, 'sladant@smc-france.fr', 'smc00332', 'IS02', 2, 4, 3, 'niveau0'),
(73, 'LAFARGE', 'Bruno', 6, 'blafarge@smc-france.fr', 'Mat14109', 'IW02', 2, 6, 4, 'niveau0'),
(74, 'LAFAY', 'Martial', 6, 'mlafay@smc-france.fr', 'FRL4F4', 'IS03', 3, 3, 3, 'niveau0'),
(75, 'LAMBARD', 'Rodrigue', 6, 'rlambard@smc-france.fr', 'smc00652', 'IN03', 0, 0, 0, 'niveau0'),
(76, 'LAMETAIRIE', 'Patricia', 0, 'plametairie@smc-france.fr', 'smc00030', '', 0, 0, 0, 'niveau0'),
(77, 'LANG', 'Fr', 6, 'flang@smc-france.fr', 'smc00132', 'IN07', 2, 5, 2, 'niveau0'),
(78, 'LANIEL', 'Christophe', 6, 'claniel@smc-france.fr', 'smc00363', 'IX01', 21, 3, 3, 'niveau0'),
(79, 'LE CAM', 'Brice', 6, 'blecam@smc-france.fr', 'smc00591', 'IW03', 2, 6, 4, 'niveau0'),
(80, 'LECLERCQ', 'Pierre', 6, 'pleclercq@smc-france.fr', 'smc00280', 'IN06', 1, 5, 2, 'niveau0'),
(81, 'LECOUSTRE', 'Beno', 6, 'blecoustre@smc-france.fr', 'smc00635', 'IN01', 0, 2, 2, 'niveau0'),
(82, 'LEDERMANN', 'Jonathan', 6, 'jledermann@smc-france.fr', 'lithium2', 'IN04', 2, 2, 2, 'niveau0'),
(83, 'LEFRERE', 'Emmanuel', 6, 'elefrere@smc-france.fr', 'smc00455', 'IW04', 1, 7, 4, 'niveau0'),
(84, 'LEGEARD', 'Arnaud', 6, 'alegeard@smc-france.fr', 'smc00648', '', 20, 0, 0, 'niveau0'),
(85, 'LEMACON', 'Max', 6, 'mlemacon@smc-france.fr', 'smc00389', 'IN05', 6, 5, 2, 'niveau0'),
(86, 'LEMAINI', 'JESSY', 6, 'jlemaini@smc-france.fr', 'smc00646', 'IN02', 0, 0, 0, 'niveau0'),
(87, 'LEMOINE', 'C', 6, 'clemoine@smc-france.fr', 'smc00628', '', 22, 1, 1, 'niveau0'),
(88, 'LETELLIER', 'Steevy', 6, 'sletellier@smc-france.fr', 'smc00293', 'IW04', 2, 7, 4, 'niveau0'),
(89, 'LOGET', 'Emmanuelle', 6, 'eloget@smc-france.fr', 'smc00609', '', 0, 0, 0, 'niveau0'),
(90, 'LONGIN', 'Patrick', 0, 'plongin@smc-france.fr', 'Xyon14c', 'Engineerin', 8, 0, 0, 'niveau0'),
(91, 'MACZENKO', 'C', 6, 'cmaczenko@smc-france.fr', 'ARMAGEDO', 'IN02', 3, 5, 2, 'niveau0'),
(92, 'MANSAU', 'Philippe', 6, 'pmansau@smc-france.fr', 'smc00470', 'IN03', 2, 5, 2, 'niveau0'),
(93, 'MARAVAL', 'Beno', 6, 'bmaraval@smc-france.fr', 'smc00598', 'IW05', 6, 7, 4, 'niveau0'),
(94, 'MARCHOIS', 'Bruno', 0, 'bmarchois@smc-france.fr', 'smc00247', '', 0, 0, 0, 'niveau0'),
(95, 'MEZANGE', 'Dominique', 6, '6ezange@smc-france.fr', 'MGBMK4', 'IW00', 10, 6, 4, 'niveau0'),
(96, 'MICHARD', 'St', 6, 'smichard@smc-france.fr', 'smc00193', 'IW01', 3, 6, 4, 'niveau0'),
(97, 'MOAL', 'Thierry', 6, 'tmoal@smc-france.fr', 'SMC00068', 'IS06', 1, 3, 3, 'niveau0'),
(98, 'MOSCONE', 'Franco', 6, 'fmoscone@smc-france.fr', 'smc00570', 'IN02', 2, 2, 2, 'niveau0'),
(99, 'MOURA', 'Patrick', 6, 'pmoura@smc-france.fr', 'smc00553', 'IS03', 2, 3, 3, 'niveau0'),
(100, 'MULLER', 'Emmanuel', 6, 'emuller@smc-france.fr', 'smc00491', 'IS06', 1, 3, 3, 'niveau0'),
(101, 'OCAL', 'Aydovan', 6, 'aocal@smc-france.fr', 'smc00639', 'IS04', 2, 3, 3, 'niveau0'),
(102, 'ORJOLLET', 'Claude', 0, 'corjollet@smc-france.fr', 'corjolle', 'Engineerin', 8, 0, 0, 'niveau0'),
(103, 'ORNY', 'Marc-Olivier', 6, 'moorny@smc-france.fr', 'smc00382', 'Engineerin', 24, 0, 0, 'niveau0'),
(104, 'PAGNI', 'Sophie', 0, 'spagni@smc-france.fr', 'smc00461', '', 0, 0, 0, 'niveau0'),
(105, 'PEETERS', 'Christophe', 6, 'cpeeters@smc-france.fr', 'smc00254', 'IS05', 6, 3, 3, 'niveau0'),
(106, 'PELLETIER', 'Damien', 6, 'dpelletier@smc-France.fr', 'smc00420', '', 12, 0, 0, 'niveau0'),
(107, 'PERRAUD', 'Vincent', 6, 'vperraud@smc-france.fr', '000000', 'Engineerin', 14, 0, 0, 'niveau1'),
(108, 'PEYROUSE', 'Laurent', 0, 'lpeyrouse@smc-france.fr', 'smc00197', '', 0, 0, 0, 'niveau0'),
(109, 'PHAM', 'Ba Th', 6, 'bpham@smc-france.fr', 'smc00494', '', 22, 1, 1, 'niveau0'),
(110, 'PINTO', 'Philippe', 6, 'ppinto@smc-france.fr', 'smc00104', 'IP06', 25, 1, 1, 'niveau0'),
(111, 'PLOTON', 'Laurent', 6, 'lploton@smc-france.fr', 'smc00559', 'IS00', 10, 3, 3, 'niveau0'),
(112, 'POTARD', 'Yannick', 6, 'ypotard@smc-france.fr', 'smc00614', 'IW04', 2, 7, 4, 'niveau0'),
(113, 'POUPLIER', 'Patrice', 6, 'ppouplier@smc-france.fr', '928GT90', 'IN03', 2, 5, 2, 'niveau0'),
(114, 'PUCCINELLI', 'Ludovic', 0, 'lpuccinelli@smc-france.fr', 'smc2000', 'Engineerin', 8, 0, 0, 'niveau0'),
(115, 'RAYMOND', 'Denis', 6, 'draymond@smc-france.fr', 'smc00187', 'IW07', 11, 6, 4, 'niveau0'),
(116, 'RIBEIRO', 'Olinda', 0, 'oribeiro@smc-france.fr', 'smc00422', '', 0, 0, 0, 'niveau0'),
(117, 'RICHET', 'Fabienne', 6, 'frichet@smc-france.fr', 'smc00454', 'IN05', 6, 5, 2, 'niveau0'),
(118, 'RIETZ', 'Vanessa', 0, 'vrietz@smc-france.fr', 'smc00642', '', 0, 0, 0, 'niveau0'),
(119, 'RITA', 'Massimo', 6, 'mrita@smc-france.fr', 'smc00403', '', 0, 0, 0, 'niveau0'),
(120, 'ROBARDELLE', 'Sylvain', 0, 'srobardelle@smc-france.fr', 'smc00028', '', 0, 0, 0, 'niveau0'),
(121, 'ROLDEZ', 'J', 6, 'jroldez@smc-france.fr', 'smc00666', 'IW04', 2, 7, 4, 'niveau0'),
(122, 'ROLLET', 'Didier', 6, 'drollet@smc-france.fr', 'did5962*', 'IN02', 2, 5, 2, 'niveau0'),
(123, 'RONCHI', 'Paolo', 0, 'pronchi@smc-france.fr', 'smc00120', '', 0, 0, 0, 'niveau0'),
(124, 'ROYAL', 'Vincent', 6, 'vroyal@smc-france.fr', 'smc00620', 'IN00', 10, 2, 2, 'niveau0'),
(125, 'SALAMI', 'Bruno', 6, 'bsalami@smc-france.fr', 'smc00179', 'IN07', 11, 2, 2, 'niveau0'),
(126, 'SONVICO', 'Jacques', 6, 'jsonvico@smc-france.fr', 'smc00423', 'IS06', 1, 4, 3, 'niveau0'),
(127, 'TAOURI', 'Youness', 0, 'ytaouri@smc-france.fr', 'ytaouri1', 'IS04', 2, 3, 3, 'niveau0'),
(128, 'TERAGNOLI', 'Bruno', 6, 'bteragnoli@smc-france.fr', 'smc00668', 'IS05', 6, 3, 3, 'niveau0'),
(129, 'THOUIN', 'Nicolas', 0, 'nthouin@smc-france.fr', 'smc00348', 'Product Ma', 23, 0, 0, 'niveau0'),
(130, 'TONNELIER', 'Sophie', 0, 'stonnelier@smc-france.fr', 'smc00311', '', 0, 0, 0, 'niveau0'),
(131, 'TOUCHARD', 'Dominique', 6, 'dtouchard@smc-france.fr', 'smc00685', 'IW01', 2, 6, 4, 'niveau0'),
(132, 'VAILLANT', 'Fr', 6, 'fvaillant@smc-france.fr', 'smc00649', 'IN02', 0, 0, 0, 'niveau0'),
(133, 'VANDEMEULEBROUCKE', 'Nicolas', 0, 'nvandemeulebroucke@smc-france.', 'smc2012', 'Engineerin', 9, 0, 0, 'niveau0'),
(134, 'VERET', 'Nicolas', 6, 'nveret@smc-france.fr', 'smc00662', '', 2, 0, 0, 'niveau0'),
(135, 'VRANCIC', 'Isabelle', 0, 'ivrancic@smc-france.fr', 'smc00388', '', 0, 0, 0, 'niveau0'),
(136, 'ZABKA', 'Patrick', 6, 'pzabka@smc-france.fr', 'alcrolle', 'IW03', 3, 6, 4, 'niveau0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
