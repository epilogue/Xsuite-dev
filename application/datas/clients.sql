-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 02 Février 2015 à 20:02
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
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom_client`, `numwp_client`, `adresse_client`, `id_industry`, `potentiel`) VALUES
(1, 'GIRBAU ROBOTICS                     ', 'I012770000', '.                                   ZI ECHANGEUR AIX NORD                                           ', '309', '0'),
(2, 'CDA                                 ', 'I005570000', ',                                   6 RUE DE L''ARTISANAT                ZI PLAISANCE                ', '310', '0'),
(3, 'DINATEC                             ', 'I046830000', '.                                   20 AV DE L''INDUSTRIE                ZI DU TRIOLET               ', '416', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
