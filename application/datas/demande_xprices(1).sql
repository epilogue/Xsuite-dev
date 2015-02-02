-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 02 Février 2015 à 20:00
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
-- Contenu de la table `demande_xprices`
--

INSERT INTO `demande_xprices` (`id_demande_xprice`, `num_workplace_demande_xprice`, `tracking_number_demande_xprice`, `commentaire_demande_xprice`, `date_demande_xprice`, `justificatif_demande_xprice`, `justificatif2_demande_xprice`, `justificatif3_demande_xprice`, `justificatif4_demande_xprice`, `id_user`, `id_validation`, `numwp_client`) VALUES
(1, '0090687063', 'SP-FR-QHT00001', 'Bêta tests\r\nTest sur cette référence qui ne sera pas commandé chez GIRBAU (remplacé par une autre référence)', '2015-01-27', '14/an', 'FESTO', '45', '2', 11, NULL, 'I012770000'),
(2, '0090687965', 'SP-FR-QKT00002', 'Marché CDA actuel:\r\nMGPM/MGPL\r\nAC\r\nAS\r\nTU\r\n\r\nEn spécial:\r\nLEY32\r\n\r\nGlobalisation marché Raccords', '2015-01-30', '1000 KQ / mois', 'Airtac', 'Environ 50%', '2', 88, NULL, 'I005570000'),
(3, '0090688241', 'SP-FR-QET00003', 'nouveau marche en prevision chez dinatec\r\nMachines de tests de batteries \r\nbatterie ok > regeneration sinon tri\r\n1 proto actuellement en metalwork\r\naventics et festo consultés egalement\r\n1 machine pour fevrier / mars\r\n7 machines en commande pour avril\r\nla dde d xprice se base sur un previsionnel annuel estime environ 30 machines \r\nNous avons actuelement 3 variantes concernnat l''ilot de distribution\r\nsoit ilot SS5Y5-QET065 din 15 15 a cabler soit SS5Y31-QET062 sub D, soit en ethercat SS5Y31-QET063\r\nconcernant les capteurs marche annuel d environ 500 capteurs actuellement en Balluf à un prix inferieur à 7 euros principalement sur 2 references standard rainure en T et en C nous pouvons repondre sur le standard rainure en C\r\ncette affaire va surement evoluer vers une RFS avec platine TA + ilot (en fonction du choix) pour la phase de pre serie, serie\r\nje dois faire l''offre ce jour merci d avance', '2015-02-02', '1 ENSEMBLE', 'METALWORK', '2%', '1', 43, NULL, 'I046830000');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
