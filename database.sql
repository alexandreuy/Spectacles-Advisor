-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 30 mai 2021 à 14:19
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `spectacle`
--

DROP TABLE IF EXISTS `spectacle`;
CREATE TABLE IF NOT EXISTS `spectacle` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) NOT NULL DEFAULT '',
  `auteur` varchar(250) NOT NULL DEFAULT '',
  `lieu` varchar(64) NOT NULL DEFAULT '',
  `id_users` int(11) UNSIGNED NOT NULL,
  `statut` tinyint(4) NOT NULL DEFAULT '0',
  `lien` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_users` (`id_users`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `spectacle`
--

INSERT INTO `spectacle` (`id`, `titre`, `auteur`, `lieu`, `id_users`, `statut`, `lien`) VALUES
(6, 'Sans Tambour', 'Gad Elmaleh', 'Paris', 3, 1, 'https://www.ticketmaster.fr/fr/resultat?ipSearch=gad+elmaleh'),
(7, 'Paradis Latin', 'Kamel Ouali', 'Paris', 4, 1, 'https://www.ticketac.com/spectacles/paradis-latin.htm'),
(8, 'gsgsd', 'gdfsgsdf', 'gfdsgsd', 4, 0, 'gfdsgfds'),
(9, 'gsdgdfs', 'gfdsgsdf', 'zrazreaz', 4, 0, 'razrzea'),
(10, 'Papa je veux voir un spectacle', 'ton fils prÃ©fÃ©rÃ©', 'maison', 4, 0, 'gfdsgd');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL DEFAULT '',
  `pseudonym` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `administrateur` tinyint(4) NOT NULL DEFAULT '0',
  `expert` tinyint(4) NOT NULL DEFAULT '0',
  `contributeur` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `pseudonym`, `password`, `administrateur`, `expert`, `contributeur`) VALUES
(1, 'admin@admin.fr', 'admin', '$2y$10$WDLO5Wc.uhEyAYg6GVRUVOrx6YPzmaXtxIqM0rJolOm18ekOBq7tG', 1, 0, 0),
(2, 'filsaimeowenn@gmail.com', 'owennfilsaime', '$2y$10$oOV81kV2LfNEGjF5tYDxyuCDVUF4WkvRA.11yPwWjD/djCbYVUQ1i', 0, 1, 0),
(3, 'ltchounang@gmail.com', 'Loris Tchounang', '$2y$10$krfjV0odQtWLpSUB1wKp.ut4tJ6VJMnmyhK9lyJl47SEDmOcWQuJy', 0, 0, 1),
(4, 'faycal.hamdi@pro.fr', 'fhamdi', '$2y$10$lKHLIcoOBIPr8MLYMAyrYOCyJrYhQfySV8wzupeEsdH0CExFVJVou', 0, 0, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `spectacle`
--
ALTER TABLE `spectacle`
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`id_users`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
