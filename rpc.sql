-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Lun 28 Avril 2014 à 20:10
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
-- Structure de la table `AC`
--

CREATE TABLE `AC` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IN` tinyint(1) NOT NULL,
  `MR` tinyint(1) NOT NULL,
  `PL` tinyint(1) NOT NULL,
  `proba` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `AC`
--

INSERT INTO `AC` (`ID`, `IN`, `MR`, `PL`, `proba`) VALUES
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
-- Structure de la table `AL`
--

CREATE TABLE `AL` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `proba` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `AL`
--

INSERT INTO `AL` (`ID`, `proba`) VALUES
(1, 0.8);

-- --------------------------------------------------------

--
-- Structure de la table `DR`
--

CREATE TABLE `DR` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `proba` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `DR`
--

INSERT INTO `DR` (`ID`, `proba`) VALUES
(1, 0.6);

-- --------------------------------------------------------

--
-- Structure de la table `IN`
--

CREATE TABLE `IN` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AL` tinyint(1) NOT NULL,
  `DR` tinyint(1) NOT NULL,
  `proba` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `IN`
--

INSERT INTO `IN` (`ID`, `AL`, `DR`, `proba`) VALUES
(1, 1, 1, 0.8),
(2, 1, 0, 0.7),
(3, 0, 1, 0.4),
(4, 0, 0, 0.2);

-- --------------------------------------------------------

--
-- Structure de la table `MR`
--

CREATE TABLE `MR` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `proba` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `MR`
--

INSERT INTO `MR` (`ID`, `proba`) VALUES
(1, 0.3);

-- --------------------------------------------------------

--
-- Structure de la table `Parente`
--

CREATE TABLE `Parente` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `fils` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Parente`
--

INSERT INTO `Parente` (`ID`, `parent`, `fils`) VALUES
(1, 1, 3),
(2, 2, 3),
(3, 3, 4),
(4, 5, 4),
(5, 6, 4);

-- --------------------------------------------------------

--
-- Structure de la table `PL`
--

CREATE TABLE `PL` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `proba` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `PL`
--

INSERT INTO `PL` (`ID`, `proba`) VALUES
(1, 0.6);

-- --------------------------------------------------------

--
-- Structure de la table `Probabilites`
--

CREATE TABLE `Probabilites` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` tinytext NOT NULL,
  `valeur` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `Probabilites`
--

INSERT INTO `Probabilites` (`ID`, `nom`, `valeur`) VALUES
(1, 'AL', 0.8),
(2, 'DR', 0.6),
(3, 'IN | AL DR', 0),
(4, 'IN | -AL DR', 0),
(5, 'IN | AL -DR', 0),
(6, 'IN | -AL -DR', 0),
(7, 'MR', 0.3),
(8, 'PL', 0.6),
(9, 'AC | IN MR PL', 0),
(10, 'AC | IN MR -PL', 0),
(11, 'AC | IN -MR PL', 0),
(12, 'AC | IN -MR -PL', 0),
(13, 'AC | -IN MR PL', 0),
(14, 'AC | -IN MR -PL', 0),
(15, 'AC | -IN -MR PL', 0),
(16, 'AC | -IN -MR -PL', 0);

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
