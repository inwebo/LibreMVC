-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 26 Mars 2015 à 11:05
-- Version du serveur: 5.5.41
-- Version de PHP: 5.4.39-0+deb7u1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `UsersRoles`
--

-- --------------------------------------------------------

--
-- Structure de la table `Permissions`
--

CREATE TABLE IF NOT EXISTS `Permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf16_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_bin AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `Roles`
--

CREATE TABLE IF NOT EXISTS `Roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text COLLATE utf16_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `role_perm`
--

CREATE TABLE IF NOT EXISTS `role_perm` (
  `id_role` int(11) NOT NULL,
  `id_perm` int(11) NOT NULL,
  KEY `id_role` (`id_role`),
  KEY `id_perm` (`id_perm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(16) COLLATE utf16_bin NOT NULL,
  `mail` varchar(32) COLLATE utf16_bin NOT NULL,
  `password` text COLLATE utf16_bin NOT NULL,
  `passPhrase` text COLLATE utf16_bin NOT NULL,
  `publicKey` text COLLATE utf16_bin NOT NULL,
  `privateKey` text COLLATE utf16_bin NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  KEY `id_user` (`id_user`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_bin;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `role_perm`
--
ALTER TABLE `role_perm`
  ADD CONSTRAINT `role_perm_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `Roles` (`id`),
  ADD CONSTRAINT `role_perm_ibfk_2` FOREIGN KEY (`id_perm`) REFERENCES `Permissions` (`id`);

--
-- Contraintes pour la table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `Roles` (`id`);

--
-- Contraintes pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `Roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
