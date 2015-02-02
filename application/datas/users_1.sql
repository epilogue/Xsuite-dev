-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mar 27 Janvier 2015 à 16:37
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
  `id_fonction` int(11) DEFAULT NULL,
  `id_zone` int(11) DEFAULT NULL,
  `id_holon` int(11) DEFAULT NULL,
  `niveau` varchar(25) NOT NULL DEFAULT 'niveau0',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=164 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id_user`, `nom_user`, `prenom_user`, `tel_user`, `email_user`, `password_user`, `numwp_user`, `id_fonction`, `id_zone`, `id_holon`, `niveau`) VALUES
(4, 'BAUER', 'Alexandre', 674087817, 'abauer@smc-france.fr', 'alex4288', 'IP14', 5, 1, 25, 'niveau5'),
(6, 'BERINGUE', 'Nicolas', 629599274, 'nberingue@smc-france.fr', 'smc00501', 'IB17', 26, 4, 5, 'niveau3'),
(9, 'BOQUILLARD', 'Alain', 689742252, 'aboquillard@smc-france.fr', 'smc00671', 'IS10', 2, 3, 7, 'niveau1'),
(11, 'BRETON', 'Gilles', 686499840, 'gbreton@smc-france.fr', 'smc00276', 'IB06', 1, 4, 7, 'niveau1'),
(12, 'BRIANTAIS', 'Laurent', 618731947, 'lbriantais@smc-france.fr', 'smc00590', 'ID23', 6, 6, 15, 'niveau0'),
(13, 'BRIATTE', 'Bruno', 614438218, 'bbriatte@smc-france.fr', 'smc00608', 'IP13', 27, 1, 25, 'niveau3'),
(15, 'BRULE', 'Damien', 686263497, 'dbrule@smc-france.fr', 'smc00644', 'IN01', 2, 0, 19, 'niveau1'),
(16, 'BUCCHI', 'Stephane', 685572409, 'sbucchi@smc-france.fr', 'smc00534', 'IS05', 28, 1, 25, 'niveau3'),
(17, 'BURON', 'Nicolas', 685572397, 'nburon@smc-france.fr', 'smc2009', 'IW02', 3, 6, 9, 'niveau1bis'),
(18, 'CALMELS', 'Christophe', 686265161, 'ccalmels@smc-france.fr', 'smc00356', 'IC13', 2, 3, 11, 'niveau1'),
(20, 'CHANTELOUP', 'Willy', 685572412, 'wchanteloup@smc-france.fr', 'ferrari', 'ID01', 1, 6, 16, 'niveau1'),
(23, 'CHOUX', 'Damien', 686267296, 'dchoux@smc-france.fr', 'smc00684', 'IS11', 2, 4, 5, 'niveau1'),
(24, 'CLERIN', 'Remi', 686265169, 'rclerin@smc-france.fr', 'smc00651', 'IS01', 2, 0, 5, 'niveau1'),
(25, 'COUDAN', 'Jean-Christophe', 686265166, 'jcoudan@smc-france.fr', 'smc00066', 'IS02', 2, 3, 6, 'niveau1'),
(26, 'COULOMBEL', 'Mickael', 618542839, 'mcoulombel@smc-france.fr', 'smc00683', 'IN09', 2, 2, 19, 'niveau1'),
(27, 'COURTOIS', 'Karine', 0, 'kcourtois@smc-france.fr', 'smc00201', 'IM22', 0, 0, 25, 'niveau0'),
(28, 'COURTOIS', 'Julien', 685572392, 'jcourtois@smc-france.fr', 'jc101182', 'IS07', 6, 4, 12, 'niveau0'),
(31, 'D''ANGELO', 'Thierry', 0, 'tdangelo@smc-france.fr', 'smc00094', 'Support te', 15, 0, 25, 'niveau0'),
(33, 'DAVID', 'Gaetan', 620088752, 'gdavid@smc-france.fr', 'smc00511', 'ID18', 2, 6, 8, 'niveau1'),
(34, 'DAZIN', 'Patrice', 686265151, 'pdazin@smc-france.fr', 'smc00253', 'ID04', 1, 6, 8, 'niveau1'),
(35, 'DELAUGE', 'Francois', 686263495, 'fdelauge@smc-france.fr', 'smc00012', 'IB01', 13, 0, 25, 'niveau5'),
(37, 'DELOBEL', 'Christophe', 627532444, 'cdelobel@smc-france.fr', 'cdelo74', 'IS12', 2, 3, 11, 'niveau1'),
(39, 'DEPRETZ', 'Fabien', 615691497, 'fdepretz@smc-france.fr', 'smc00581', 'IA25', 2, 2, 19, 'niveau1'),
(42, 'DRANCOURT', 'Frederic', 627292038, 'fdrancourt@smc-france.fr', 'smc00689', 'IN10', 1, 5, 23, 'niveau1'),
(43, 'DUCREUX', 'Stephane', 624391549, 'sducreux@smc-france.fr', 'morrison', 'IC21', 2, 3, 6, 'niveau1'),
(45, 'DUROURE', 'Francis', 686287225, 'fduroure@smc-france.fr', 'smc00076', 'IC02', 11, 3, 30, 'niveau0'),
(46, 'DUVERNET', 'Jean-Denis', 630074496, 'jduvernet@smc-france.fr', 'smc00410', 'IB10', 1, 4, 7, 'niveau1'),
(47, 'FOREST', 'Gaetan', 674891834, 'gforest@smc-france.fr', 'smc00365', 'ID09', 2, 6, 8, 'niveau1'),
(51, 'FRIOCOURT', 'Anthony', 618849713, 'afriocourt@smc-france.fr', 'smc00645', 'ID13', 2, 0, 9, 'niveau1'),
(53, 'GARCIA BALLESTER', 'Nicolas', 671223833, 'ngarciaballester@smc-france.fr', 'smc00495', 'IC17', 2, 3, 6, 'niveau1'),
(56, 'GERMAIN', 'Bruno', 618849709, 'bgermain@smc-france.fr', 'smc2012', 'IW01', 2, 0, 9, 'niveau1'),
(59, 'GOUCHET', 'Pierrick', 686287226, 'pgouchet@smc-france.fr', 'smc00544', 'ID21', 2, 6, 8, 'niveau1'),
(61, 'GRELOT', 'Christelle', 0, 'cgrelot@smc-france.fr', 'smc00458', 'IM18', 0, 0, 25, 'niveau0'),
(62, 'GRIOTIER', 'Cyril', 627292251, 'cyril.griotier@smc-france.fr', 'cgmd0705', 'IX02', 2, 3, 29, 'niveau1'),
(63, 'GRUAT', 'Frederic', 629599277, 'fgruat@smc-france.fr', 'smc00500', 'ID14', 6, 6, 15, 'niveau0'),
(64, 'HATTERER', 'Nicolas', 660960288, 'nhatterer@smc-france.fr', 'smc00665', 'IS03', 2, 3, 11, 'niveau1'),
(65, 'HAUPTMANN', 'Mickael', 610873501, 'mhauptmann@smc-france.fr', 'smc00549', 'IB24', 2, 4, 5, 'niveau1'),
(67, 'HUBY', 'Magalie', 695148871, 'mhuby@smc-france.fr', 'plop01', '', 0, 1, 25, 'niveau6'),
(70, 'JOURDAIN', 'Emmanuel', 685542966, 'ejourdain@smc-france.fr', 'thomas01', '', 32, 0, 25, 'niveau4'),
(71, 'JOURET', 'Gilles', 671223835, 'gjouret@smc-france.fr', 'MATHISLO', 'IF06', 3, 7, 10, 'niveau1bis'),
(72, 'LADANT', 'Sophie', 676723522, 'sladant@smc-france.fr', 'smc00332', 'IB07', 2, 4, 11, 'niveau1'),
(73, 'LAFARGE', 'Bruno', 621583468, 'blafarge@smc-france.fr', 'Mat14109', 'IW05', 2, 6, 9, 'niveau1'),
(74, 'LAFAY', 'Martial', 674891909, 'mlafay@smc-france.fr', 'FRL4F4', 'IC27', 3, 3, 11, 'niveau1bis'),
(75, 'LAMBARD', 'Rodrigue', 629599279, 'rlambard@smc-france.fr', 'smc00652', 'IN05', 2, 0, 20, 'niveau1'),
(77, 'LANG', 'Frederic', 608417023, 'flang@smc-france.fr', 'smc00132', 'IE02', 3, 5, 18, 'niveau1bis'),
(78, 'LANIEL', 'Christophe', 674892010, 'claniel@smc-france.fr', 'smc00363', 'IC16', 2, 3, 29, 'niveau1'),
(79, 'LE CAM', 'Brice', 622371990, 'blecam@smc-france.fr', 'smc00591', 'ID24', 2, 6, 9, 'niveau1'),
(80, 'LECLERCQ', 'Pierre', 674976442, 'pleclercq@smc-france.fr', 'smc00280', 'IE07', 1, 5, 23, 'niveau1'),
(81, 'LECOUSTRE', 'Benoit', 676723529, 'blecoustre@smc-france.fr', 'smc00635', 'IE25', 2, 2, 18, 'niveau1'),
(82, 'LEDERMANN', 'Jonathan', 674892077, 'jledermann@smc-france.fr', 'lithium2', 'IA31', 3, 2, 19, 'niveau1bis'),
(83, 'LEFRERE', 'Emmanuel', 608416676, 'elefrere@smc-france.fr', 'smc00455', 'IS06', 1, 7, 16, 'niveau1'),
(84, 'LEGEARD', 'Arnaud', 686265141, 'alegeard@smc-france.fr', 'smc00648', 'IP17', 29, 0, 25, 'niveau3'),
(85, 'LEMACON', 'Max', 685572395, 'mlemacon@smc-france.fr', 'smc00389', 'IE11', 6, 5, 22, 'niveau1'),
(87, 'LEMOINE', 'Cedric', 686265140, 'clemoine@smc-france.fr', 'smc00628', 'IP15', 30, 1, 25, 'niveau3'),
(88, 'LETELLIER', 'Steevy', 671175549, 'sletellier@smc-france.fr', 'smc00293', 'IA04', 2, 7, 10, 'niveau1'),
(89, 'LOGET', 'Emmanuelle', 686287224, 'eloget@smc-france.fr', 'smc00609', '', 31, 0, 25, 'niveau0'),
(91, 'MACZENKO', 'Cedric', 686263496, 'cmaczenko@smc-france.fr', 'ARMAGEDO', 'IE04', 1, 5, 23, 'niveau1'),
(92, 'MANSAU', 'Philippe', 671223837, 'pmansau@smc-france.fr', 'smc00470', 'IE12', 3, 5, 20, 'niveau1bis'),
(93, 'MARAVAL', 'Benoit', 630074486, 'bmaraval@smc-france.fr', 'smc00598', 'IF21', 6, 7, 15, 'niveau0'),
(95, 'MEZANGE', 'Dominique', 686265149, '6ezange@smc-france.fr', 'MGBMK4', 'ID19', 10, 6, 4, 'niveau2'),
(96, 'MICHARD', 'Stephane', 685572408, 'smichard@smc-france.fr', 'smc00193', 'ID03', 2, 6, 16, 'niveau1'),
(97, 'MOAL', 'Thierry', 625554903, 'tmoal@smc-france.fr', 'SMC00068', 'IS10', 2, 3, 7, 'niveau1'),
(98, 'MOSCONE', 'Franco', 685572391, 'fmoscone@smc-france.fr', 'smc00570', 'IA21', 2, 2, 19, 'niveau1'),
(99, 'MOURA', 'Patrick', 686265172, 'pmoura@smc-france.fr', 'smc00553', 'IC25', 2, 3, 11, 'niveau1'),
(100, 'MULLER', 'Emmanuel', 618735812, 'emuller@smc-france.fr', 'smc00491', 'IC31', 2, 3, 7, 'niveau1'),
(101, 'OCAL', 'Aydovan', 622371992, 'aocal@smc-france.fr', 'smc00639', 'IF26', 2, 3, 6, 'niveau1'),
(102, 'ORJOLLET', 'Claude', 0, 'corjollet@smc-france.fr', 'corjolle', 'Engineerin', 8, 0, 0, 'niveau0'),
(103, 'ORNY', 'Marc-Olivier', 686265154, 'moorny@smc-france.fr', 'smc00382', 'Engineerin', 24, 0, 0, 'niveau0'),
(104, 'PAGNI', 'Sophie', 0, 'spagni@smc-france.fr', 'smc00461', 'IM14', 2, 0, 25, 'niveau1'),
(105, 'PEETERS', 'Christophe', 686265173, 'cpeeters@smc-france.fr', 'smc00254', 'IB05', 6, 3, 12, 'niveau1'),
(107, 'PERRAUD', 'Vincent', 674892009, 'vperraud@smc-france.fr', '000000', 'Engineerin', 14, 0, 0, 'niveau1'),
(111, 'PLOTON', 'Laurent', 686265175, 'lploton@smc-france.fr', 'smc00559', 'IF17', 10, 3, 3, 'niveau2'),
(112, 'POTARD', 'Yannick', 608416326, 'ypotard@smc-france.fr', 'smc00614', 'IF23', 2, 7, 10, 'niveau1'),
(113, 'POUPLIER', 'Patrice', 618735011, 'ppouplier@smc-france.fr', '928GT90', 'IE13', 2, 5, 20, 'niveau1'),
(115, 'RAYMOND', 'Denis', 608416946, 'draymond@smc-france.fr', 'smc00187', 'ID02', 2, 6, 17, 'niveau1'),
(116, 'RIBEIRO', 'Olinda', 0, 'oribeiro@smc-france.fr', 'smc00422', 'IM16', 2, 0, 25, 'niveau1'),
(119, 'RITA', 'Massimo', 608416053, 'mrita@smc-france.fr', 'smc00403', 'IM03', 0, 0, 25, 'niveau0'),
(122, 'ROLLET', 'Didier', 686265167, 'drollet@smc-france.fr', 'did5962*', 'IE05', 2, 5, 23, 'niveau1'),
(123, 'RONCHI', 'Paolo', 0, 'pronchi@smc-france.fr', 'smc00120', '', 0, 0, 0, 'niveau0'),
(124, 'ROYAL', 'Vincent', 680941373, 'vroyal@smc-france.fr', 'smc00620', 'IE28', 10, 2, 2, 'niveau2'),
(125, 'SALAMI', 'Bruno', 685572396, 'bsalami@smc-france.fr', 'smc00179', 'IA23', 2, 2, 2, 'niveau1'),
(126, 'SONVICO', 'Jacques', 685572414, 'jsonvico@smc-france.fr', 'smc00423', 'IB12', 2, 4, 7, 'niveau1'),
(127, 'TAOURI', 'Youness', 0, 'ytaouri@smc-france.fr', 'ytaouri1', 'IS13', 2, 3, 6, 'niveau1'),
(128, 'TERAGNOLI', 'Bruno', 674977872, 'bteragnoli@smc-france.fr', 'smc00668', 'IS08', 6, 3, 12, 'niveau0'),
(129, 'THOUIN', 'Nicolas', 0, 'nthouin@smc-france.fr', 'smc00348', 'Product Ma', 23, 0, 25, 'niveau4'),
(130, 'TONNELIER', 'Sophie', 0, 'stonnelier@smc-france.fr', 'smc00311', '', 0, 0, 0, 'niveau0'),
(131, 'TOUCHARD', 'Dominique', 627532450, 'dtouchard@smc-france.fr', 'smc00685', 'IW06', 2, 6, 8, 'niveau1'),
(132, 'VAILLANT', 'Frederic', 674892211, 'fvaillant@smc-france.fr', 'smc00649', 'IN02', 0, 0, 0, 'niveau0'),
(133, 'VANDEMEULEBROUCKE', 'Nicolas', 0, 'nvandemeulebroucke@smc-france.', 'smc2012', 'Engineerin', 9, 0, 0, 'niveau0'),
(134, 'VERET', 'Nicolas', 686265145, 'nveret@smc-france.fr', 'smc00662', 'IN07', 2, 0, 5, 'niveau1'),
(136, 'ZABKA', 'Patrick', 618735233, 'pzabka@smc-france.fr', 'alcrolle', 'ID22', 2, 6, 8, 'niveau1'),
(138, 'SOETAERT', 'David', 646292367, 'dsoetaert@smc-france.fr', 'dso2112', 'IN11', 6, 22, 5, 'niveau0'),
(139, 'EGEA', 'jordy', 617551944, 'jegea@smc-france.fr', 'smc00901', 'IS14', 6, 3, 12, 'niveau0'),
(140, 'LAINE', 'mickael', 617553292, 'mlaine@smc-france.fr', 'smc00902', 'IN12', 1, 2, 20, 'niveau0'),
(142, 'GOUBELLE', 'jerome', 617553456, 'jgoubelle@smc-france.fr', 'smc00708', 'IN14', 1, 5, 18, 'niveau0'),
(143, 'KESLER', 'jean-marie', 617553496, 'jmkesler@smc-france.fr', 'smc00707', 'IS15', 1, 3, 5, 'niveau0'),
(144, 'FERRIERES', 'pascal', 0, 'pferrieres@smc-france.fr', 'smc00709', NULL, NULL, NULL, NULL, 'niveau0'),
(145, 'MONTACLAIR', 'luc', 0, 'lmontaclair@smc-france.fr', 'smc00710', 'IP20', NULL, NULL, NULL, 'niveau0'),
(146, 'CHATOUT', 'bertrand', 625572625, 'bchatout@smc-france.fr', 'smc00711', 'IP19', 2, 5, 23, 'niveau0'),
(147, 'MATTA', 'richard', 0, 'rmatta@smc-france.fr', 'smc00712', NULL, NULL, NULL, NULL, 'niveau0'),
(148, 'DELSAUX', 'axel', 164761025, 'adelsaux@smc-france.fr', 'smc904', NULL, NULL, NULL, NULL, 'niveau0'),
(149, 'CARON', 'julien', 0, 'jcaron@smc-france.fr', 'smc00905', NULL, NULL, NULL, NULL, 'niveau0'),
(150, 'RAKOTOARIMANANA', 'nadia', 617553456, 'nrakoto@smc-france.fr', 'smc00906', 'IW07', 1, 6, 9, 'niveau0'),
(151, 'LEVY', 'herve', 646723400, 'hlevy@smc-france.fr', 'smc00907', 'IS16', 1, 3, 6, 'niveau0'),
(152, 'STROHL', 'matthieu', 164761185, 'mstrohl@smc-france.fr', 'smc00908', NULL, NULL, NULL, NULL, 'niveau0'),
(153, 'MAINOT', 'sebastien', 676723520, 'smainot@smc-france.fr', 'smc00719', 'IN16', 1, 2, 20, 'niveau0'),
(154, 'AZE', 'sebastien', 629599279, 'saze@smc-france.fr', 'smc00720', 'IN15', 1, 2, 20, 'niveau0'),
(155, 'BOREL', 'Olivier', 618542839, 'oborel@smc-france.fr', 'smc00726', 'IN18', 2, 2, 19, 'niveau0'),
(156, 'MARGOT', 'Remi', 627314335, 'rmargot@smc-france.fr', 'smc00735', 'IW09', 2, 4, 9, 'niveau0'),
(157, 'BRIOIS', 'David', 617553300, 'dbriois@smc-france.fr', 'smc00733', 'IN19', 2, 2, 20, 'niveau0'),
(158, 'FROMONT', 'Vincent', 615691502, 'vfromont@smc-france.fr', 'smc00727', 'IP22', 6, NULL, NULL, 'niveau0'),
(159, 'SCHALLER-SCHWARTZ', 'jean-marie', 616556153, 'jschaller-schwartz@smc-france.fr', 'smc00732', 'IS17', 1, 3, 5, 'niveau0'),
(161, 'MIRANDA', 'Stephane', 616556767, 'smiranda@smc-france.fr', 'smc00724', 'IN17', 1, 2, 18, 'niveau0'),
(163, 'LAROZE', 'vincent', NULL, 'vlaroze@smc-france.fr', 'smc00725', NULL, NULL, NULL, NULL, 'niveau0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
