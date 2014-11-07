-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mer 06 Août 2014 à 09:09
-- Version du serveur: 5.5.38
-- Version de PHP: 5.3.10-1ubuntu3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `CVXCDTA`
--
DROP DATABASE `CVXCDTA`;
CREATE DATABASE `CVXCDTA` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `CVXCDTA`;

-- --------------------------------------------------------

--
-- Structure de la table `OCUSMA`
--

DROP TABLE IF EXISTS `OCUSMA`;
CREATE TABLE IF NOT EXISTS `OCUSMA` (
  `OKCUNO` varchar(10) NOT NULL,
  `OKCUNM` varchar(80) NOT NULL,
  `OKCUCL` varchar(3) NOT NULL,
  `OKACGR` varchar(4) NOT NULL,
  `OKCFC7` varchar(80) NOT NULL,
  `OKCUA1` varchar(80) NOT NULL,
  `OKCUA2` varchar(80) NOT NULL,
  `OKCUA3` varchar(80) NOT NULL,
  `OKCUA4` varchar(80) NOT NULL,
  `OKPHNO` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `OCUSMA`
--

INSERT INTO `OCUSMA` (`OKCUNO`, `OKCUNM`, `OKCUCL`, `OKACGR`, `OKCFC7`, `OKCUA1`, `OKCUA2`, `OKCUA3`, `OKCUA4`, `OKPHNO`) VALUES
('I01277', 'GIRBAU ROBOTICS     ', 'CA3', 'IS06', '0', '.     ', 'ZI ECHANGEUR AIX NORD', '    ', '73100 AIX LES BAINS', '04 79 34 80 80');

-- --------------------------------------------------------

--
-- Structure de la table `OOLINE`
--

DROP TABLE IF EXISTS `OOLINE`;
CREATE TABLE IF NOT EXISTS `OOLINE` (
  `OBORNO` varchar(15) NOT NULL,
  `OBCUNO` varchar(10) NOT NULL,
  `OBITNO` varchar(15) NOT NULL,
  `OBITDS` varchar(15) NOT NULL,
  `OBORQT` varchar(15) NOT NULL,
  `OBLNA2` varchar(15) NOT NULL,
  `OBLNAM` varchar(15) NOT NULL,
  `OBNEPR` varchar(15) NOT NULL,
  `OBSAPR` varchar(10) NOT NULL,
  `OBELNO` date NOT NULL,
  `OBRGDT` date NOT NULL,
  `OBLMDT` date NOT NULL,
  `OBSMCD` varchar(4) NOT NULL,
  `OBDIVI` varchar(3) NOT NULL DEFAULT 'FR0',
  `OBCONO` int(3) NOT NULL DEFAULT '100'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `OOLINE`
--

INSERT INTO `OOLINE` (`OBORNO`, `OBCUNO`, `OBITNO`, `OBITDS`, `OBORQT`, `OBLNA2`, `OBLNAM`, `OBNEPR`, `OBSAPR`, `OBELNO`, `OBRGDT`, `OBLMDT`, `OBSMCD`, `OBDIVI`, `OBCONO`) VALUES
('0090636993', 'I01277', '00028125', 'TU0425R-100  ', '20.000000', '212.40', '212.40', '10.620000', '42.480000', '2014-06-12', '2014-06-10', '2014-06-10', 'IB06', 'FR0', 100),
('0090636993', 'I01277', '00028169', 'TU0604BU-100', '20.000000', '465.80', '465.80', '23.290000', '93.170000', '2014-06-12', '2014-06-10', '2014-06-10', 'IB06', 'FR0', 100),
('0090636993', 'I01277', '00028285', 'TU0805R-100', '5.000000', '209.05', '209.05', '41.810000', '167.260000', '2014-06-12', '2014-06-10', '2014-06-10', 'IB06', 'FR0', 100);
--
-- Base de données: `MVXCDTA`
--
DROP DATABASE `MVXCDTA`;
CREATE DATABASE `MVXCDTA` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `MVXCDTA`;

-- --------------------------------------------------------

--
-- Structure de la table `MCHEAD`
--

DROP TABLE IF EXISTS `MCHEAD`;
CREATE TABLE IF NOT EXISTS `MCHEAD` (
  `KOPCTP` int(11) NOT NULL,
  `KOPCDT` varchar(15) NOT NULL,
  `KOCSU3` varchar(30) NOT NULL,
  `KOITNO` varchar(8) NOT NULL,
  KEY `KOITNO` (`KOITNO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `MCHEAD`
--

INSERT INTO `MCHEAD` (`KOPCTP`, `KOPCDT`, `KOCSU3`, `KOITNO`) VALUES
(3, '20140322', '11.00000', '00028125'),
(3, '20130629', '11.050000', '00028125'),
(3, '20130324', '11.63000', '00028125'),
(3, '20121222', '11.640000', '00028125'),
(3, '20140322', '24.06000', '00028169'),
(3, '20130629', '24.18', '00028169'),
(3, '20130624', '24.18000', '00028169'),
(3, '20130622', '24.180000', '00028169'),
(3, '20130624', '43.49000', '00028285'),
(3, '20130622', '43.49000', '00028285'),
(3, '20140322', '43.27000', '00028285'),
(3, '20130629', '43.49000', '00028285');

-- --------------------------------------------------------

--
-- Structure de la table `OCUSMA`
--

DROP TABLE IF EXISTS `OCUSMA`;
CREATE TABLE IF NOT EXISTS `OCUSMA` (
  `OKCUNO` varchar(10) NOT NULL,
  `OKCUNM` varchar(80) NOT NULL,
  `OKCUCL` varchar(3) NOT NULL,
  `OKACGR` varchar(4) NOT NULL,
  `OKCFC7` varchar(80) NOT NULL,
  `OKCUA1` varchar(80) NOT NULL,
  `OKCUA2` varchar(80) NOT NULL,
  `OKCUA3` varchar(80) NOT NULL,
  `OKCUA4` varchar(80) NOT NULL,
  `OKPHNO` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `OCUSMA`
--

INSERT INTO `OCUSMA` (`OKCUNO`, `OKCUNM`, `OKCUCL`, `OKACGR`, `OKCFC7`, `OKCUA1`, `OKCUA2`, `OKCUA3`, `OKCUA4`, `OKPHNO`) VALUES
('I01277', 'GIRBAU ROBOTICS     ', 'CA3', 'IS06', '0', '.     ', 'ZI ECHANGEUR AIX NORD', '    ', '73100 AIX LES BAINS', '04 79 34 80 80');
--
-- Base de données: `xsuite-dev`
--
DROP DATABASE `xsuite-dev`;
CREATE DATABASE `xsuite-dev` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `xsuite-dev`;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `reference_article` varchar(80) NOT NULL,
  `code_article` varchar(8) NOT NULL,
  `description_article` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id_article`, `reference_article`, `code_article`, `description_article`) VALUES
(1, 'TU0425R-100  ', '28125', NULL),
(2, 'TU0604BU-100', '28169', NULL),
(3, 'TU0805R-100', '28285', NULL),
(4, 'TU0425R-100 ', '00028125', NULL),
(5, 'TU0604BU-100', '00028169', NULL),
(6, 'TU0805R-100', '00028285', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(80) NOT NULL,
  `numwp_client` varchar(15) NOT NULL,
  `adresse_client` varchar(100) NOT NULL,
  `id_industry` varchar(30) NOT NULL,
  PRIMARY KEY (`id_client`),
  KEY `id_industry` (`id_industry`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom_client`, `numwp_client`, `adresse_client`, `id_industry`) VALUES
(1, 'GIRBAU ROBOTICS     ', 'I01277', '.     ZI ECHANGEUR AIX NORD    73100 AIX LES BAINS', 'CA3');

-- --------------------------------------------------------

--
-- Structure de la table `demande_article_xprices`
--

DROP TABLE IF EXISTS `demande_article_xprices`;
CREATE TABLE IF NOT EXISTS `demande_article_xprices` (
  `id_demande_article` int(11) NOT NULL AUTO_INCREMENT,
  `prixwplace_demande_article` decimal(10,4) NOT NULL,
  `prix_demande_article` float NOT NULL,
  `quantite_demande_article` int(11) NOT NULL,
  `remise_demande_article` float DEFAULT NULL,
  `date_demande_xprice` date NOT NULL,
  `prix_accorde_demande_article` float DEFAULT NULL,
  `remise_accorde_demande_article` float DEFAULT NULL,
  `prix_fob_demande_article` varchar(20) DEFAULT NULL,
  `prix_cif_demande_article` varchar(20) DEFAULT NULL,
  `marge_demande_article` float DEFAULT NULL,
  `tracking_number_demande_xprice` varchar(50) NOT NULL,
  `code_article` varchar(15) NOT NULL,
  `reference_article` varchar(80) NOT NULL,
  `num_workplace_demande_xprice` varchar(35) NOT NULL,
  PRIMARY KEY (`id_demande_article`),
  KEY `tracking_number_demande_xprice` (`tracking_number_demande_xprice`),
  KEY `code_article` (`code_article`,`reference_article`),
  KEY `num_workplace_demande_xprice` (`num_workplace_demande_xprice`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `demande_article_xprices`
--

INSERT INTO `demande_article_xprices` (`id_demande_article`, `prixwplace_demande_article`, `prix_demande_article`, `quantite_demande_article`, `remise_demande_article`, `date_demande_xprice`, `prix_accorde_demande_article`, `remise_accorde_demande_article`, `prix_fob_demande_article`, `prix_cif_demande_article`, `marge_demande_article`, `tracking_number_demande_xprice`, `code_article`, `reference_article`, `num_workplace_demande_xprice`) VALUES
(1, 10.6200, 42.48, 20, 25, '2014-06-10', NULL, NULL, '11.00000', '11.00000', NULL, 'SP-FR-QAS00001', '00028125', 'TU0425R-100 ', '0090636993'),
(2, 23.2900, 93.17, 20, 25, '2014-06-10', NULL, NULL, '24.06000', '24.06000', NULL, 'SP-FR-QAS00001', '00028169', 'TU0604BU-100', '0090636993'),
(3, 41.8100, 167.26, 5, 25, '2014-06-10', NULL, NULL, '43.49000', '43.49000', NULL, 'SP-FR-QAS00001', '00028285', 'TU0805R-100', '0090636993');

-- --------------------------------------------------------

--
-- Structure de la table `demande_xprices`
--

DROP TABLE IF EXISTS `demande_xprices`;
CREATE TABLE IF NOT EXISTS `demande_xprices` (
  `id_demande_xprice` int(11) NOT NULL AUTO_INCREMENT,
  `num_workplace_demande_xprice` varchar(35) NOT NULL,
  `tracking_number_demande_xprice` varchar(50) NOT NULL,
  `commentaire_demande_xprice` text,
  `date_demande_xprice` date NOT NULL,
  `justificatif_demande_xprice` varchar(80) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_validation` int(11) DEFAULT NULL,
  `numwp_client` varchar(15) NOT NULL,
  PRIMARY KEY (`id_demande_xprice`),
  KEY `id_demande_article` (`id_user`,`id_validation`),
  KEY `numwp_client` (`numwp_client`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `demande_xprices`
--

INSERT INTO `demande_xprices` (`id_demande_xprice`, `num_workplace_demande_xprice`, `tracking_number_demande_xprice`, `commentaire_demande_xprice`, `date_demande_xprice`, `justificatif_demande_xprice`, `id_user`, `id_validation`, `numwp_client`) VALUES
(1, '0090636993', 'SP-FR-QAS00001', 'dydydyrdufrkiufikgfyuf', '2014-06-10', 'plop2', 11, NULL, 'I01277');

-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

DROP TABLE IF EXISTS `fonctions`;
CREATE TABLE IF NOT EXISTS `fonctions` (
  `id_fonction` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fonction` varchar(30) NOT NULL,
  `description_fonction` text NOT NULL,
  PRIMARY KEY (`id_fonction`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Contenu de la table `fonctions`
--

INSERT INTO `fonctions` (`id_fonction`, `nom_fonction`, `description_fonction`) VALUES
(1, 'KAM', 'bla bla'),
(2, 'ITC', 'bla bla bli'),
(3, 'ITC Leader', 'plop'),
(4, 'ATC', 'attaché technico commercial'),
(5, 'DBD', 'directeur business developpement'),
(6, 'DD', 'Développeur Distribution'),
(7, 'DM', 'Developpement manager'),
(8, 'TE', 'Technicien d études'),
(9, 'IP', 'Ingénieur projet'),
(10, 'CDR', 'chef de region'),
(11, 'NBD', 'new business developpement'),
(12, 'PDG', 'president directeur general'),
(13, 'Dirco', 'directeur commercial'),
(14, 'leader Engeneering', 'responsable engeneering'),
(15, 'Leader  technique', 'group leader support technique'),
(16, 'FIM ', 'Food Industry Manager'),
(17, 'EEPM', 'Energy,Environement and process Manager'),
(18, 'AT', 'assitant technique'),
(19, 'DM', 'developpement Manager'),
(20, 'CDM', 'chef de marché'),
(21, 'DE', 'développeur export'),
(22, 'CIM', 'car industry manager'),
(23, 'PM', 'product management'),
(24, 'RPM', 'responsable product management'),
(25, 'LSIM', 'life et science Industry Manager');

-- --------------------------------------------------------

--
-- Structure de la table `holons`
--

DROP TABLE IF EXISTS `holons`;
CREATE TABLE IF NOT EXISTS `holons` (
  `id_holon` int(11) NOT NULL AUTO_INCREMENT,
  `nom_holon` varchar(15) NOT NULL,
  `description_holon` text NOT NULL,
  PRIMARY KEY (`id_holon`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `holons`
--

INSERT INTO `holons` (`id_holon`, `nom_holon`, `description_holon`) VALUES
(1, 'IP00', 'holon de la zone QA'),
(2, 'IN00', 'holon de la zone QC et QF'),
(3, 'IS00', 'holon de la zone QE et QH'),
(4, 'IW00', 'holon de la zone QI et QK');

-- --------------------------------------------------------

--
-- Structure de la table `industry`
--

DROP TABLE IF EXISTS `industry`;
CREATE TABLE IF NOT EXISTS `industry` (
  `id_industry` int(11) NOT NULL AUTO_INCREMENT,
  `nom_industry` varchar(80) NOT NULL,
  `code_smc_industry` varchar(15) NOT NULL,
  `code_movex_industry` varchar(30) NOT NULL,
  `description_industry` tinytext NOT NULL,
  PRIMARY KEY (`id_industry`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- Contenu de la table `industry`
--

INSERT INTO `industry` (`id_industry`, `nom_industry`, `code_smc_industry`, `code_movex_industry`, `description_industry`) VALUES
(1, 'Car Projects', 'CP', 'CAZ', 'AUTRES'),
(2, 'Car Projects', 'CP', 'CA1', 'FABRIQUANT DE VOITURE'),
(3, 'Car Projects', 'CP', 'CA2', 'FABRIQUANT DE CARROSSERIE'),
(4, 'Car Projects', 'CP', 'CBZ', 'AUTRES MACHINES DE PRESSES ET FILIERES'),
(5, 'Car Projects', 'CP', 'CB1', 'PRESSES'),
(6, 'Car Projects', 'CP', 'CCZ', 'AUTRES MACHINES DE SOUDAGE'),
(7, 'Car Projects', 'CP', 'CC1', 'MACHINE DE SOUDAGE PAR POINT'),
(8, 'Car Projects', 'CP', 'CC2', 'MACHINE DE SOUDAGE A L''ARC'),
(9, 'Car Projects', 'CP', 'CDZ', 'AUTRE MACHINE DE GALVANISATION'),
(10, 'Car Projects', 'CP', 'CD1', 'MACHINE AUTOMATIQUE DE GALVANISATION'),
(11, 'Car Projects', 'CP', 'CE1', 'MACHINE POUR COMPOSANT ELECTRONIQUE'),
(12, 'Car Projects', 'CP', 'CE2', 'MACHINE D''USINAGE?'),
(13, 'Car Projects', 'CP', 'CE3', 'MACHINE D''ASSEMBLAGE AUTOMATIQUE'),
(14, 'Car Projects', 'CP', 'CE4', 'MACHINE DE MOULAGE RESINE'),
(15, 'Car Projects', 'CP', 'CE5', 'CONVOYEUR, MACHINE DE TRANSFERT'),
(16, 'Car Projects', 'CP', 'CE6', 'ROBOTS'),
(17, 'Car Projects', 'CP', 'CE7', 'MACHINE DE MOULAGE'),
(18, 'Car Projects', 'CP', 'CE8', 'MACHINE DE FABRICATION DE PILE A COMBUSTIBLE (POUR VOITURE)'),
(19, 'Car Projects', 'CP', 'CFZ', 'AUTRES'),
(20, 'Car Projects', 'CP', 'CGZ', 'AUTRES COMPOSANTS MOTEUR'),
(21, 'Car Projects', 'CP', 'CG1', 'PISTONS'),
(22, 'Car Projects', 'CP', 'CHZ', 'AUTRES COMPOSANTS LIES AU MOTEUR'),
(23, 'Car Projects', 'CP', 'CH1', 'TUYAUX D''ECHAPPEMENT ET SILENCIEUX'),
(24, 'Car Projects', 'CP', 'CH2', 'EQUIPEMENT D''INJECTION DE CARBURANT POUR MOTEUR DIESEL'),
(25, 'Car Projects', 'CP', 'CH3', 'RADIATEURS'),
(26, 'Car Projects', 'CP', 'CIZ', 'AUTRE COMPOSANT ELECTRIQUE POUR MOTEUR'),
(27, 'Car Projects', 'CP', 'CI1', 'DEMARREURS'),
(28, 'Car Projects', 'CP', 'CI2', 'COMPOSANTS ELECTRONIQUES ET CAPTEURS'),
(29, 'Car Projects', 'CP', 'CI3', 'GENERATEUR DE CHARGE (ALTERNATEUR)vvvvvvvvv '),
(30, 'Car Projects', 'CP', 'CI4', 'BOUGIES D''ALLUMAGE'),
(31, 'Car Projects', 'CP', 'CI5', 'EQUIPEMENT ELECTRONIQUE LIE AU FREINAGE'),
(32, 'Car Projects', 'CP', 'CJZ', 'AUTRE COMPOSANT ELECTRIQUE ET INSTRUMENTS'),
(33, 'Car Projects', 'CP', 'CJ1', 'PROJECTEUR, PHARES'),
(34, 'Car Projects', 'CP', 'CJ2', 'ESSUIE GLACE, MOTEURS'),
(35, 'Car Projects', 'CP', 'CJ3', 'COMPTEUR DE VITESSE'),
(36, 'Car Projects', 'CP', 'CJ4', 'BOUTON ELECTRIQUE, COMMUTATEUR'),
(37, 'Car Projects', 'CP', 'CJ5', 'FAISCEAU DE CABLES'),
(38, 'Car Projects', 'CP', 'CKZ', 'AUTRE COMPOSANT DE TRANSMISSION'),
(39, 'Car Projects', 'CP', 'CK1', 'TRANSMISSION'),
(40, 'Car Projects', 'CP', 'CLZ', 'AUTRE COMPOSANT DE DIRECTION'),
(41, 'Car Projects', 'CP', 'CL1', 'DIRECTION ASSISTEE'),
(42, 'Car Projects', 'CP', 'CMZ', 'AUTRES COMPOSANT DE SUSPENSION'),
(43, 'Car Projects', 'CP', 'CM1', 'AMORTISSEURS'),
(44, 'Car Projects', 'CP', 'CNZ', 'AUTRES COMPOSANT DE FREIN'),
(45, 'Car Projects', 'CP', 'CN1', 'DISQUE, EQUIPEMENT DE FREINAGE'),
(46, 'Car Projects', 'CP', 'CO1', 'ROUES'),
(47, 'Car Projects', 'CP', 'CP1', 'PNEUS'),
(48, 'Car Projects', 'CP', 'CQZ', 'AUTRES ACCESSOIRES DE CARROSSERIES'),
(49, 'Car Projects', 'CP', 'CQ1', 'TABLEAU DE BORDS ET PANEAUX'),
(50, 'Car Projects', 'CP', 'CQ2', 'POIGNEES DE PORTES ET SERRURES'),
(51, 'Car Projects', 'CP', 'CQ3', 'RESERVOIRS D''ESSENCE'),
(52, 'Car Projects', 'CP', 'CQ4', 'AIRBAG ET ACCESSOIRES'),
(53, 'Car Projects', 'CP', 'CQ5', 'PILES A COMBUSTIBLE POUR VEHICULE ELECTRIQUE'),
(54, 'Car Projects', 'CP', 'CQ6', 'BATTERIE RECHARGEABLE UNIQUEMENT POUR LES VEHICULES ELECTRIQUES'),
(55, 'Car Projects', 'CP', 'CQ7', 'CLIMATISATION AUTOMOBILE'),
(56, 'Car Projects', 'CP', 'CRZ', 'AUTRES ACCESSOIRES DE CARROSSERIES'),
(57, 'Car Projects', 'CP', 'CSA', 'MACHINE DE FABRICATION DE PNEUS'),
(58, 'Car Projects', 'CP', 'CSB', 'MACHINE DE FABRICATION DE PILE A COMBUSTIBLE POUR VEHICULE ELECTRIQUE'),
(59, 'Car Projects', 'CP', 'CSC', 'MACHINE DE FABRICATION DE BATTERIE RECHARGEABLE UNIQUEMENT POUR LES VEHICULES ELECTRIQUES'),
(60, 'Car Projects', 'CP', 'CSD', 'FABRIQUANT DE MACHINE POUR ACCESSOIRE DE CARROSSERIE'),
(61, 'Car Projects', 'CP', 'CSZ', 'FOURNISSEUR DE MATERIEL, AUTRE'),
(62, 'Car Projects', 'CP', 'CS1', 'MACHINE DE FABRICATION DE COMPOSANT MOTEUR'),
(63, 'Car Projects', 'CP', 'CS2', 'MACHINE DE FABRICATION DE COMPOSANT LIE AU MOTEUR'),
(64, 'Car Projects', 'CP', 'CS3', 'MACHINE DE FABRICATION DE COMPOSANT DE MOTEUR ELECTRIQUE'),
(65, 'Car Projects', 'CP', 'CS4', 'MACHINE DE FABRICATION DE COMPOSANT ELECTRIQUE ET DE MESURE'),
(66, 'Car Projects', 'CP', 'CS5', 'MACHINE DE FABRICATION DE COMPOSANT DE TRANSMISSION'),
(67, 'Car Projects', 'CP', 'CS6', 'MACHINE DE FABRICATION DE COMPOSANT DE DIRECTION'),
(68, 'Car Projects', 'CP', 'CS7', 'MACHINE DE FABRICATION DE COMPOSANT DE SUSPENSION'),
(69, 'Car Projects', 'CP', 'CS8', 'MACHINE DE FABRICATION DE COMPOSANT DE FREIN'),
(70, 'Car Projects', 'CP', 'CS9', 'MACHINE DE FABRICATION DE ROUES'),
(71, 'Car Projects', 'CP', 'CTZ', 'AUTRES'),
(72, 'Car Projects', 'CP', 'CT1', 'FABRIQUANT DE BATTERIE SECONDAIRE'),
(73, 'Car Projects', 'CP', 'CT2', 'FABRIQUANT D''USINE DE BATTERIE SECONDAIRE'),
(74, 'Car Projects', 'CP', 'CT3', 'FABRIQUANT DE MOTEUR'),
(75, 'Car Projects', 'CP', 'CT4', 'FABRIQUANT D''USINE DE MOTEUR'),
(76, 'Car Projects', 'CP', 'CA3', 'inconnu');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
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
(67, 'HUBY', 'Magalie', 0, 'mhuby@smc-france.fr', 'smc00687', '', 0, 1, 1, 'niveau2'),
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

-- --------------------------------------------------------

--
-- Structure de la table `validations_xprice`
--

DROP TABLE IF EXISTS `validations_xprice`;
CREATE TABLE IF NOT EXISTS `validations_xprice` (
  `id_validation` int(11) NOT NULL AUTO_INCREMENT,
  `date_validation` date NOT NULL,
  `etat_validation` varchar(15) NOT NULL,
  `commentaire_validation` text,
  `id_user` int(11) NOT NULL,
  `id_demande_xprice` int(11) NOT NULL,
  PRIMARY KEY (`id_validation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `zones`
--

DROP TABLE IF EXISTS `zones`;
CREATE TABLE IF NOT EXISTS `zones` (
  `id_zone` int(11) NOT NULL AUTO_INCREMENT,
  `nom_zone` varchar(15) NOT NULL,
  `description_zone` text NOT NULL,
  `id_holon` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_zone`),
  KEY `id_holon` (`id_holon`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `zones`
--

INSERT INTO `zones` (`id_zone`, `nom_zone`, `description_zone`, `id_holon`) VALUES
(1, 'QA', 'siege', 1),
(2, 'QC', 'zone je sais pas', 2),
(3, 'QE', 'région est', 3),
(4, 'QH', 'zone est', 3),
(5, 'QF', 'zone je sais pas ', 2),
(6, 'QI', 'je sais pas ', 4),
(7, 'QK', 'je sais pas ', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
