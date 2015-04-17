-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 17 Avril 2015 à 12:01
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `csi_projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `Categorie_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Categorie_Nom` varchar(500) NOT NULL,
  PRIMARY KEY (`Categorie_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `Client_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Client_Nom` varchar(200) NOT NULL,
  `Client_Prenom` varchar(200) NOT NULL,
  `Client_Numvoie` int(11) NOT NULL,
  `Client_Rue` varchar(200) NOT NULL,
  `Client_Cp` int(11) NOT NULL,
  `Client_Ville` varchar(200) NOT NULL,
  `Client_Dernierpanier` int(11) NOT NULL,
  `Client_Admin` tinyint(1) NOT NULL,
  `Client_Codename` varchar(200) NOT NULL,
  `Client_mdp` varchar(50) NOT NULL,
  `Compte_Id` int(11) NOT NULL,
  PRIMARY KEY (`Client_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONS POUR LA TABLE `client`:
--   `Compte_Id`
--       `compte` -> `Compte_Id`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `Commande_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Commande_date` date NOT NULL,
  `Comande_recuperee` tinyint(1) NOT NULL,
  `HeureRecuperation_id` int(11) NOT NULL,
  `Panier_Id` int(11) NOT NULL,
  PRIMARY KEY (`Commande_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONS POUR LA TABLE `commande`:
--   `HeureRecuperation_id`
--       `heurerecuperation` -> `HeureRecuperation_id`
--   `Panier_Id`
--       `panier` -> `Panier_Id`
--

-- --------------------------------------------------------

--
-- Structure de la table `compose`
--

CREATE TABLE IF NOT EXISTS `compose` (
  `Produit_Id` int(11) NOT NULL,
  `Panier_Id` int(11) NOT NULL,
  `Quantite` int(11) NOT NULL,
  PRIMARY KEY (`Produit_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `compose`:
--   `Panier_Id`
--       `panier` -> `Panier_Id`
--   `Produit_Id`
--       `produit` -> `Produit_Id`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
  `Compte_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Compte_Codename` varchar(200) NOT NULL,
  `Compte_mdp` varchar(50) NOT NULL,
  PRIMARY KEY (`Compte_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `heurerecuperation`
--

CREATE TABLE IF NOT EXISTS `heurerecuperation` (
  `HeureRecuperation_id` int(11) NOT NULL AUTO_INCREMENT,
  `HeureRecuperation_Deb` date NOT NULL,
  `HeureRecuperation_Fin` date NOT NULL,
  PRIMARY KEY (`HeureRecuperation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE IF NOT EXISTS `historique` (
  `Historique_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Historique_Deb` date NOT NULL,
  `Historique_Fin` date NOT NULL,
  `Historique_Nbvente` int(11) NOT NULL,
  `Historique_Ca` double NOT NULL,
  PRIMARY KEY (`Historique_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `obtenir_promotion`
--

CREATE TABLE IF NOT EXISTS `obtenir_promotion` (
  `Promotion_Id` int(11) NOT NULL,
  `Produit_Id` int(11) NOT NULL,
  `Date_Debut` date NOT NULL,
  `Date_Fin` date NOT NULL,
  PRIMARY KEY (`Promotion_Id`,`Produit_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `obtenir_promotion`:
--   `Produit_Id`
--       `produit` -> `Produit_Id`
--   `Promotion_Id`
--       `promotion` -> `Promotion_Id`
--

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE IF NOT EXISTS `panier` (
  `Panier_Id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `DateDebutRed` date NOT NULL,
  `DateFinRed` date NOT NULL,
  `Reduction_Id` int(11) NOT NULL,
  PRIMARY KEY (`Panier_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONS POUR LA TABLE `panier`:
--   `Reduction_Id`
--       `reduction` -> `Reduction_id`
--   `client_id`
--       `client` -> `Client_Id`
--

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `Produit_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Produit_Nom` varchar(500) NOT NULL,
  `Produit_Img_Url` varchar(500) NOT NULL,
  `Produit_Prix` double NOT NULL,
  `Categorie_Id` int(11) NOT NULL,
  PRIMARY KEY (`Produit_Id`),
  UNIQUE KEY `Produit_Nom` (`Produit_Nom`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- RELATIONS POUR LA TABLE `produit`:
--   `Categorie_Id`
--       `categorie` -> `Categorie_Id`
--

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE IF NOT EXISTS `promotion` (
  `Promotion_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Promotion_montant` double NOT NULL,
  PRIMARY KEY (`Promotion_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `reduction`
--

CREATE TABLE IF NOT EXISTS `reduction` (
  `Reduction_id` int(11) NOT NULL AUTO_INCREMENT,
  `Reduction_montant` double NOT NULL,
  `Reduction_qtereduction` int(11) NOT NULL,
  PRIMARY KEY (`Reduction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
