-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 08 Juin 2017 à 16:25
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db684093681`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `idcom` int(11) NOT NULL COMMENT 'Identifiant du commentaire',
  `message` text NOT NULL COMMENT 'Commentaire laissé',
  `dateCreat` datetime NOT NULL COMMENT 'Date de création du commentaire',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `niveau` int(11) NOT NULL DEFAULT '0',
  `epID` int(11) NOT NULL COMMENT 'Identifiant de l''episode',
  `user_id` int(11) DEFAULT NULL,
  `pseudo` varchar(30) NOT NULL,
  `spam` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `episodes`
--

CREATE TABLE `episodes` (
  `id` int(11) NOT NULL COMMENT 'identifiant du chapitre',
  `titre` varchar(50) NOT NULL COMMENT 'Titre du chapitre (episode)',
  `contenu` text NOT NULL COMMENT 'Contenu de l''episode',
  `dateCrea` datetime NOT NULL COMMENT 'Date de création de l''episode',
  `dateModif` datetime DEFAULT NULL COMMENT 'Date de modification de l''episode',
  `valided` int(1) NOT NULL DEFAULT '0' COMMENT 'Si 1 validé, la modification et la suppression ne sont plus possible si 0 modif et suppr encore possible'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(88) NOT NULL,
  `user_salt` varchar(23) NOT NULL,
  `user_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `idcom` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du commentaire', AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant du chapitre', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
