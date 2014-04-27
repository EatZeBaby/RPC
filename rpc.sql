-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Dim 27 Avril 2014 à 13:16
-- Version du serveur :  5.5.34
-- Version de PHP :  5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `rpc`
--

-- --------------------------------------------------------

--
-- Structure de la table `Parente`
--

CREATE TABLE `Parente` (
  `ID` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `fils` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Proba(AC|MR,PL)`
--

CREATE TABLE `Proba(AC|MR,PL)` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IN` tinyint(1) NOT NULL,
  `MR` tinyint(1) NOT NULL,
  `PL` tinyint(1) NOT NULL,
  `ac` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `Proba(AC|MR,PL)`
--

INSERT INTO `Proba(AC|MR,PL)` (`ID`, `IN`, `MR`, `PL`, `ac`) VALUES
(1, 1, 1, 1, 0.99),
(2, 1, 1, 0, 0.9),
(3, 1, 0, 1, 0.7),
(4, 1, 0, 0, 0.6),
(5, 0, 1, 1, 0.5),
(6, 0, 1, 0, 0.2),
(7, 0, 1, 0, 0.2),
(8, 0, 0, 0, 0.1);

-- --------------------------------------------------------

--
-- Structure de la table `Proba(IN|AL,DR)`
--

CREATE TABLE `Proba(IN|AL,DR)` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AL` tinyint(1) NOT NULL,
  `DR` tinyint(1) NOT NULL,
  `INF` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Proba(IN|AL,DR)`
--

INSERT INTO `Proba(IN|AL,DR)` (`ID`, `AL`, `DR`, `INF`) VALUES
(1, 1, 1, 0.8),
(2, 1, 0, 0.7),
(3, 0, 1, 0.4),
(4, 0, 0, 0.2);

-- --------------------------------------------------------

--
-- Structure de la table `Variable`
--

CREATE TABLE `Variable` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` tinytext NOT NULL,
  `slug` varchar(2) NOT NULL,
  `observe` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `Variable`
--

INSERT INTO `Variable` (`ID`, `nom`, `slug`, `observe`) VALUES
(1, 'alcool', 'AL', 0),
(2, 'drogue', 'DR', 0),
(3, 'infarctus', 'IN', 0),
(4, 'accident', 'AC', 0),
(5, 'mauvaise condition de route', 'MR', 0),
(6, 'pluie', 'PL', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
