-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2015 at 05:18 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `drive`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `Categorie_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Categorie_Nom` varchar(500) NOT NULL,
  PRIMARY KEY (`Categorie_Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`Categorie_Id`, `Categorie_Nom`) VALUES
(1, 'Alimentaire'),
(2, 'Beauté'),
(3, 'Bricolage'),
(4, 'Electroménager'),
(5, 'Maison'),
(6, 'Vêtement');

-- --------------------------------------------------------

--
-- Table structure for table `client`
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

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `Commande_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Commande_date` date NOT NULL,
  `Comande_recuperee` tinyint(1) NOT NULL,
  `HeureRecuperation_id` int(11) NOT NULL,
  `Panier_Id` int(11) NOT NULL,
  PRIMARY KEY (`Commande_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `compose`
--

CREATE TABLE IF NOT EXISTS `compose` (
  `Produit_Id` int(11) NOT NULL,
  `Panier_Id` int(11) NOT NULL,
  `Quantite` int(11) NOT NULL,
  PRIMARY KEY (`Produit_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
  `Compte_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Compte_Codename` varchar(200) NOT NULL,
  `Compte_mdp` varchar(50) NOT NULL,
  PRIMARY KEY (`Compte_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `heurerecuperation`
--

CREATE TABLE IF NOT EXISTS `heurerecuperation` (
  `HeureRecuperation_id` int(11) NOT NULL AUTO_INCREMENT,
  `HeureRecuperation_Deb` date NOT NULL,
  `HeureRecuperation_Fin` date NOT NULL,
  PRIMARY KEY (`HeureRecuperation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `historique`
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
-- Table structure for table `obtenir_promotion`
--

CREATE TABLE IF NOT EXISTS `obtenir_promotion` (
  `Promotion_Id` int(11) NOT NULL,
  `Produit_Id` int(11) NOT NULL,
  `Date_Debut` date NOT NULL,
  `Date_Fin` date NOT NULL,
  PRIMARY KEY (`Promotion_Id`,`Produit_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

CREATE TABLE IF NOT EXISTS `panier` (
  `Panier_Id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `DateDebutRed` date NOT NULL,
  `DateFinRed` date NOT NULL,
  `Reduction_Id` int(11) NOT NULL,
  PRIMARY KEY (`Panier_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `Produit_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Produit_Nom` varchar(500) NOT NULL,
  `Produit_Img_Url` varchar(500) NOT NULL,
  `Produit_Prix` double NOT NULL,
  `Categorie_Id` int(11) NOT NULL,
  PRIMARY KEY (`Produit_Id`),
  UNIQUE KEY `Produit_Nom` (`Produit_Nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`Produit_Id`, `Produit_Nom`, `Produit_Img_Url`, `Produit_Prix`, `Categorie_Id`) VALUES
(9, 'fromage', 'images/alimentaire/fromage.jpg', 4.35, 1),
(8, 'eau', 'images/alimentaire/eau.jpg', 1.3, 1),
(7, 'croissant', 'images/alimentaire/croissant.jpg', 0.86, 1),
(6, 'cookies', 'images/alimentaire/cookies.jpg', 2.15, 1),
(5, 'champignons', 'images/alimentaire/champignons.jpg', 2.5, 1),
(4, 'cereales', 'images/alimentaire/cereales.jpg', 1.2, 1),
(3, 'bébé chat', 'images/alimentaire/bebe_chat.jpg', 3.5, 1),
(2, 'banane', 'images/alimentaire/banane.jpg', 0.95, 1),
(1, 'baguette', 'images/alimentaire/baguette.jpg', 0.87, 1),
(10, 'gateau', 'images/alimentaire/gateau.jpg', 5.6, 1),
(11, 'hamburger', 'images/alimentaire/hamburger.jpg', 2.55, 1),
(12, 'jus de pomme', 'images/alimentaire/jus_de_pomme.jpg', 1.1, 1),
(13, 'lait', 'images/alimentaire/lait.jpg', 1.5, 1),
(14, 'pasteque', 'images/alimentaire/pasteque.jpg', 1.4, 1),
(15, 'pâtes', 'images/alimentaire/pates.jpg', 0.9, 1),
(16, 'poisson', 'images/alimentaire/poisson.jpg', 2.25, 1),
(17, 'saucisson', 'images/alimentaire/saucisson.jpg', 1.85, 1),
(19, 'viande', 'images/alimentaire/viande.jpg', 4.35, 1),
(23, 'rouge à lèvre', 'images/beaute/rouge_a_levre.jpg', 15.99, 2),
(22, 'maquillage', 'images/beaute/maquillage.jpg', 32, 2),
(21, 'fond de teint', 'images/beaute/fond_de_teint.jpg', 24.1, 2),
(20, 'crème', 'images/beaute/creme.jpg', 14.21, 2),
(24, 'gel douche', 'images/beaute/gel_douche.jpg', 3.25, 2),
(25, 'mousse à raser', 'images/beaute/mousse_a_raser.jpg', 11, 2),
(26, 'parfum femme', 'images/beaute/parfum_femme.jpg', 58.95, 2),
(27, 'parfum homme', 'images/beaute/parfum_homme.jpg', 49.9, 2),
(28, 'rasoir', 'images/beaute/rasoir.jpg', 5.6, 2),
(29, 'shampoing', 'images/beaute/shampoing.jpg', 4.69, 2),
(30, 'tondeuse', 'images/beaute/tondeuse.jpg', 32.54, 2),
(31, 'casque de chantier', 'images/bricolage/casque_de_chantier.jpg', 7.99, 3),
(32, 'ciment', 'images/bricolage/ciment.jpg', 19.9, 3),
(33, 'clé anglaise', 'images/bricolage/cle_anglaise.jpg', 8.69, 3),
(34, 'clous', 'images/bricolage/clous.jpg', 11.5, 3),
(35, 'fer à souder', 'images/bricolage/fer_a_souder.jpg', 15.28, 3),
(36, 'marteau', 'images/bricolage/marteau.jpg', 7.6, 3),
(37, 'pelle', 'images/bricolage/pelle.jpg', 17.4, 3),
(38, 'perceuse', 'images/bricolage/perceuse.jpg', 38.99, 3),
(39, 'pince', 'images/bricolage/pince.jpg', 9.89, 3),
(40, 'planches', 'images/bricolage/planches.jpg', 18.95, 3),
(41, 'aspirateur', 'images/electromenager/aspirateur.jpg', 273.23, 4),
(42, 'chaine hifi', 'images/electromenager/chaine_hifi.jpg', 159.63, 4),
(43, 'lave vaisselle', 'images/electromenager/lave_vaisselle.jpg', 699.99, 4),
(44, 'lecteur DVD', 'images/electromenager/lecteur_dvd.jpg', 99.5, 4),
(45, 'machine à laver', 'images/electromenager/machine_a_laver.jpg', 449, 4),
(46, 'ordinateur', 'images/electromenager/ordinateur_fixe.jpg', 859.99, 4),
(47, 'ordinateur portable', 'images/electromenager/ordinateur_portable.jpg', 735, 4),
(48, 'smartphone', 'images/electromenager/smartphone.jpg', 549.99, 4),
(49, 'télévision écran plat', 'images/electromenager/tele.jpg', 372.35, 4),
(50, 'téléphone fixe', 'images/electromenager/telephone_fixe.jpg', 48.5, 4),
(51, 'téléphone indestructible', 'images/electromenager/telephone_indestructible.jpg', 1, 4),
(52, 'canape', 'images/maison/canape.jpg', 499.99, 5),
(53, 'chaise', 'images/maison/chaise.jpg', 69, 5),
(54, 'commode', 'images/maison/commode.jpg', 179.2, 5),
(55, 'lampe', 'images/maison/lampe.jpg', 29.99, 5),
(56, 'lit', 'images/maison/lit.jpg', 345, 5),
(57, 'meuble_tele', 'images/maison/meuble_tele.jpg', 124.35, 5),
(58, 'miroir', 'images/maison/miroir.jpg', 42, 5),
(59, 'plante_verte', 'images/maison/plante_verte.jpg', 25.99, 5),
(60, 'table à manger', 'images/maison/table_a_manger.jpg', 215.69, 5),
(61, 'table basse', 'images/maison/table_basse.jpg', 115.99, 5),
(62, 'tableau', 'images/maison/tableau.jpg', 56.34, 5),
(63, 'tapis', 'images/maison/tapis.jpg', 246.75, 5),
(64, 'ballerine', 'images/vetement/ballerine.jpg', 14.99, 6),
(65, 'basket homme', 'images/vetement/basket_homme.jpg', 65.99, 6),
(66, 'chapeau', 'images/vetement/chapeau.jpg', 1, 6),
(67, 'costume homme', 'images/vetement/costume_homme.jpg', 350.99, 6),
(70, 'jean homme', 'images/vetement/jean_homme.jpg', 69.99, 6),
(69, 'jean femme', 'images/vetement/jean_femme.jpg', 45.99, 6),
(68, 'jean', 'images/vetement/jean.jpg', 59.6, 6),
(71, 'lunettes', 'images/vetement/lunettes.jpg', 35, 6),
(72, 'lunettes de soleil', 'images/vetement/lunettes_de_soleil.jpg', 35, 6),
(73, 'pantalon femme', 'images/vetement/pantalon_femme.jpg', 29.99, 6),
(74, 'pantalon homme', 'images/vetement/pantalon_homme.jpg', 49.99, 6),
(75, 'pull femme', 'images/vetement/pull_femme.jpg', 19.99, 6),
(76, 'pull homme', 'images/vetement/pull_homme.jpg', 26.99, 6),
(77, 'tshirt homme', 'images/vetement/tshirt_homme.jpg', 15.99, 6),
(78, 'tshirt femme', 'images/vetement/tshirt_femme.jpg', 9.99, 6);

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE IF NOT EXISTS `promotion` (
  `Promotion_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Promotion_montant` double NOT NULL,
  PRIMARY KEY (`Promotion_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reduction`
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
