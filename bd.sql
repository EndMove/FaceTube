-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 12 avr. 2021 à 20:58
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
-- Base de données : `in20b1154`
--
CREATE DATABASE IF NOT EXISTS `in20b1154` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `in20b1154`;

-- --------------------------------------------------------

--
-- Structure de la table `chaine`
--

DROP TABLE IF EXISTS `chaine`;
CREATE TABLE IF NOT EXISTS `chaine` (
  `id_chaine` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_compte` int(10) UNSIGNED NOT NULL,
  `nom` varchar(155) NOT NULL DEFAULT 'no name',
  `est_publique` tinyint(1) NOT NULL DEFAULT '1',
  `evaluation` int(11) NOT NULL,
  `date_derniere_video` datetime DEFAULT NULL,
  `est_bloquee` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_chaine`),
  KEY `fk_compte` (`fk_compte`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `chaine`
--

INSERT INTO `chaine` (`id_chaine`, `fk_compte`, `nom`, `est_publique`, `evaluation`, `date_derniere_video`, `est_bloquee`) VALUES
(1, 5, 'Ma première chaine', 1, 0, '2021-04-12 22:51:02', 0),
(2, 5, 'Ma deuxième chaine', 1, 0, '2021-04-12 22:51:43', 0),
(3, 6, 'une chaine privée', 0, 0, '2021-04-12 22:53:04', 0),
(4, 6, 'une chaine publique', 1, 0, '2021-04-12 22:53:42', 0);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_compte` int(10) UNSIGNED NOT NULL,
  `fk_video` int(10) UNSIGNED NOT NULL,
  `commentaire` text,
  `date_publication` datetime NOT NULL,
  PRIMARY KEY (`id_commentaire`),
  KEY `fk_compte` (`fk_compte`),
  KEY `fk_video` (`fk_video`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `id_compte` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `prenom` varchar(45) NOT NULL,
  `login` varchar(35) NOT NULL,
  `couriel` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `est_bloque` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_compte`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id_compte`, `nom`, `prenom`, `login`, `couriel`, `mot_de_passe`, `est_bloque`) VALUES
(5, 'Nihart', 'Jérémi', 'endmove', 'superjeremi1302@gmail.com', 'e1fb9caa40b98659b7729ea856a5bb8f', 0),
(6, 'Florquin', 'Coralie', 'gashila', 'florquin43@gmail.com', 'e1fb9caa40b98659b7729ea856a5bb8f', 0);

-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

DROP TABLE IF EXISTS `demande`;
CREATE TABLE IF NOT EXISTS `demande` (
  `id_compte_demandeur` int(11) NOT NULL,
  `id_compte_destinataire` int(11) NOT NULL,
  `est_acceptee` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_compte_demandeur`,`id_compte_destinataire`),
  KEY `id_compte_destinataire` (`id_compte_destinataire`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `demande`
--

INSERT INTO `demande` (`id_compte_demandeur`, `id_compte_destinataire`, `est_acceptee`) VALUES
(5, 6, 1),
(9, 5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `evaluer`
--

DROP TABLE IF EXISTS `evaluer`;
CREATE TABLE IF NOT EXISTS `evaluer` (
  `id_compte` int(10) UNSIGNED NOT NULL,
  `id_video` int(10) UNSIGNED NOT NULL,
  `evaluation` enum('like','unlike') NOT NULL,
  PRIMARY KEY (`id_compte`,`id_video`),
  KEY `id_video` (`id_video`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `evaluer`
--

INSERT INTO `evaluer` (`id_compte`, `id_video`, `evaluation`) VALUES
(1, 1, 'like'),
(2, 1, 'unlike'),
(3, 1, 'like'),
(4, 1, 'like'),
(5, 1, 'like'),
(6, 1, 'like'),
(7, 1, 'like'),
(8, 1, 'like'),
(9, 1, 'unlike'),
(10, 1, 'unlike'),
(11, 1, 'unlike');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id_video` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_chaine` int(10) UNSIGNED NOT NULL,
  `intitule` varchar(155) NOT NULL DEFAULT 'no title',
  `description` text,
  `html_fragment` text,
  `duree` time NOT NULL DEFAULT '00:00:00',
  `url_apercu` varchar(255) DEFAULT NULL,
  `date_ajout` datetime NOT NULL,
  `est_bloquee` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_video`),
  KEY `fk_chaine` (`fk_chaine`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id_video`, `fk_chaine`, `intitule`, `description`, `html_fragment`, `duree`, `url_apercu`, `date_ajout`, `est_bloquee`) VALUES
(1, 1, 'une titre', 'une description', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/btDyQlFQCew&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '09:16:51', 'FL4fbaN6fH0N05P620u6ajcbANaf3dtcf025H862d8CwV.jpg', '2021-04-12 22:49:48', 0),
(2, 1, 'une titre 02', 'une description toujours buggé', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/btDyQlFQCew&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '09:16:51', 'LA46bed4GJ53lacv471226ab42cB0dvc43d2e49u2947c.jpg', '2021-04-12 22:50:07', 0),
(3, 1, 'une titre 03', 'The next generation of our icon library + toolkit is coming with more icons, more styles, more services, and more awesome. Pre-order now to get access to our alpha and future releases!', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/btDyQlFQCew&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '09:16:51', 'aX3ldpE3b318c64j787i32Ys72eT2v1821Rc7Ad2u7uaR.png', '2021-04-12 22:50:33', 0),
(4, 1, 'une titre 04', 'The next generation of our icon library + toolkit is coming with more icons, more styles, more services, and more awesome. Pre-order now to get access to our alpha and future releases!', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/btDyQlFQCew&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '09:16:51', '4ubAqeLKA70nbzxCecqogD020axCd7223GYIZa23m0ybH.jpg', '2021-04-12 22:50:44', 0),
(5, 1, 'une titre 05', 'The next generation of our icon library + toolkit is coming with more icons, more styles, more services, and more awesome. Pre-order now to get access to our alpha and future releases!', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/btDyQlFQCew&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '09:16:51', 'N8b898hdcBs9089Nf89bla8mh4c1b8fcSEa950r9kHKmM.jpg', '2021-04-12 22:50:55', 0),
(6, 1, 'une titre 06', 'The next generation of our icon library + toolkit is coming with more icons, more styles, more services, and more awesome. Pre-order now to get access to our alpha and future releases!', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/btDyQlFQCew&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '09:16:51', 'S6865lX161WrYC0I9i1YdwfUf13ThOda8eG68NuCHGDa3.jpg', '2021-04-12 22:51:02', 0),
(7, 2, 'Je recommande le produit sauf aux amateurs de basses.', ',ncndkfneknfcked', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/btDyQlFQCew&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '04:06:56', 'Ld7dGZ366Ga2hfy3ed0sX8kd9f7B5bcBd3PaeIWn61yx1.png', '2021-04-12 22:51:43', 0),
(8, 3, 'une vidéo', 'une description', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/-4P0sZpSeRI&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '04:49:04', 'v93e3ujY1bn25Esned1TH8ayQ484D03yqb4da28DU827M.jpg', '2021-04-12 22:53:04', 0),
(9, 4, 'une vidéo publique', 'une descriptionune descriptionune descriptionune descriptionune descriptionune descriptionune descriptionune descriptionune descriptionune descriptionune descriptionune descriptionune description', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/-4P0sZpSeRI&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '04:49:04', '298qbTE502U8H7xBfbqT7d6d8f3e1DbB448212150ffZc.jpg', '2021-04-12 22:53:42', 0);

-- --------------------------------------------------------

--
-- Structure de la table `voir`
--

DROP TABLE IF EXISTS `voir`;
CREATE TABLE IF NOT EXISTS `voir` (
  `id_compte` int(10) UNSIGNED NOT NULL,
  `id_video` int(10) UNSIGNED NOT NULL,
  `date_vue` datetime NOT NULL,
  PRIMARY KEY (`id_compte`,`id_video`),
  KEY `id_video` (`id_video`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
