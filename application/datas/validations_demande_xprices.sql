-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 02 Février 2015 à 20:01
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

--
-- Contenu de la table `validations_demande_xprices`
--

INSERT INTO `validations_demande_xprices` (`id`, `validations_demande_xprices_id`, `id_demande_xprice`, `id_user`, `nom_validation`, `date_validation`, `etat_validation`, `commentaire`) VALUES
(1, NULL, 1, 11, 'creation', '2015-01-28 15:11:51', 'creation', 'Bêta tests\r\nTest sur cette référence qui ne sera pas commandé chez GIRBAU (remplacé par une autre référence)'),
(2, 1, 1, 111, 'cdr', '2015-01-28 18:50:37', 'validee', 'ok'),
(8, NULL, 1, 129, 'fobfr', '2015-01-29 16:37:24', 'validée', NULL),
(9, NULL, 1, 70, 'supply', '2015-01-29 16:39:34', 'validée', NULL),
(12, NULL, 1, 4, 'dbd', '2015-01-29 17:53:05', 'enAttente', 'Tu me confirmes que c''est bien une demande de test, qui n''a pas objet à aboutir?'),
(17, NULL, 2, 88, 'creation', '2015-01-30 11:18:45', 'creation', 'Marché CDA actuel:\r\nMGPM/MGPL\r\nAC\r\nAS\r\nTU\r\n\r\nEn spécial:\r\nLEY32\r\n\r\nGlobalisation marché Raccords'),
(20, 12, 1, 11, 'reponse', '2015-01-30 11:34:45', 'enAttente', 'Oui'),
(21, 20, 1, 4, 'dbd', '2015-01-30 12:29:04', 'validee', 'Ok pour appliquer ce prix en tant que test.'),
(22, 17, 2, 95, 'cdr', '2015-01-30 12:29:37', 'validee', 'OK pour moi'),
(23, NULL, 2, 129, 'fobfr', '2015-01-30 14:44:16', 'validée', NULL),
(24, NULL, 2, 129, 'fobfr', '2015-01-30 14:49:19', 'validée', NULL),
(25, NULL, 2, 70, 'supply', '2015-01-30 14:54:21', 'validée', 'Total marge'),
(26, NULL, 3, 43, 'creation', '2015-02-02 10:03:53', 'creation', 'nouveau marche en prevision chez dinatec\r\nMachines de tests de batteries \r\nbatterie ok > regeneration sinon tri\r\n1 proto actuellement en metalwork\r\naventics et festo consultés egalement\r\n1 machine pour fevrier / mars\r\n7 machines en commande pour avril\r\nla dde d xprice se base sur un previsionnel annuel estime environ 30 machines \r\nNous avons actuelement 3 variantes concernnat l''ilot de distribution\r\nsoit ilot SS5Y5-QET065 din 15 15 a cabler soit SS5Y31-QET062 sub D, soit en ethercat SS5Y31-QET063\r\nconcernant les capteurs marche annuel d environ 500 capteurs actuellement en Balluf à un prix inferieur à 7 euros principalement sur 2 references standard rainure en T et en C nous pouvons repondre sur le standard rainure en C\r\ncette affaire va surement evoluer vers une RFS avec platine TA + ilot (en fonction du choix) pour la phase de pre serie, serie\r\nje dois faire l''offre ce jour merci d avance'),
(27, 26, 3, 111, 'cdr', '2015-02-02 10:42:22', 'validee', 'ok, prise de PDM'),
(28, NULL, 3, 70, 'fobfr', '2015-02-02 16:04:36', 'validée', NULL),
(29, NULL, 3, 70, 'supply', '2015-02-02 16:06:30', 'validée', 'OK'),
(30, 29, 3, 4, 'dbd', '2015-02-02 16:23:09', 'validee', 'Ok, avec la démarche: Attaque du faible');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
