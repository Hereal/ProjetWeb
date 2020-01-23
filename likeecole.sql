-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 23 jan. 2020 à 15:39
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `likeecole`
--

DROP TABLE IF EXISTS `likeecole`;
CREATE TABLE IF NOT EXISTS `likeecole` (
  `idEcole` varchar(10) NOT NULL,
  `adressIp` varchar(16) NOT NULL,
  `statutJaime` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `likeecole`
--

INSERT INTO `likeecole` (`idEcole`, `adressIp`, `statutJaime`) VALUES
('0870669E', '124', -1),
('0870669E', '253', 1),
('0870669E', '124', -1),
('0870669E', '253', 1),
('0870669E', '2453', 1),
('0870669E', '6542', 0),
('0870669E', '4444', -1),
('0870669E', '568', 1),
('0870669E', '2453', 1),
('0870669E', '6542', 0),
('0870669E', '4444', -1),
('0870669E', '568', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
