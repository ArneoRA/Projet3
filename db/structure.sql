-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 23 Mai 2017 à 07:58
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blogjf`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `idcom` int(11) NOT NULL COMMENT 'Identifiant du commentaire',
  `pseudo` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Pseudo de la personne qui saisie le commentaire',
  `message` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Commentaire laissé',
  `dateCreat` date NOT NULL COMMENT 'Date de création du commentaire',
  `epID` int(11) NOT NULL COMMENT 'Identifiant de l''episode'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL COMMENT 'identifiant du chapitre',
  `titre` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Titre du chapitre (episode)',
  `contenu` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Contenu de l''episode',
  `dateCrea` date NOT NULL COMMENT 'Date de création de l''episode',
  `dateModif` date DEFAULT NULL COMMENT 'Date de modification de l''episode',
  `valided` int(1) NOT NULL COMMENT 'Si 1 validé, la modification et la suppression ne sont plus possible si 0 modif et suppr encore possible'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`idcom`);

--
-- Index pour la table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `idcom` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du commentaire', AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant du chapitre', AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
