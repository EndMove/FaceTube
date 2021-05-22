-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 21 mai 2021 à 15:58
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
  ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chaine`
--

INSERT INTO `chaine` (`id_chaine`, `fk_compte`, `nom`, `est_publique`, `evaluation`, `date_derniere_video`, `est_bloquee`) VALUES
(1, 1, 'NORMAN FAIT DES VIDÉOS', 1, 0, '2021-05-09 17:56:52', 0),
(2, 1, 'Amixem', 1, 0, '2021-05-09 18:03:45', 0),
(3, 1, 'Ma chaîne privée', 0, 0, '2021-05-09 18:06:09', 0),
(4, 3, 'Je n\'ai qu\'une chaine moi :C', 1, 0, '2021-05-09 18:16:33', 0),
(5, 2, 'Chaine principale', 1, 0, '2021-05-10 09:16:39', 0),
(6, 2, 'Chaine publique', 1, 0, '2021-05-10 09:15:02', 0),
(7, 2, 'Chaine privée', 0, 0, '2021-05-10 09:15:14', 0);

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
  ) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `fk_compte`, `fk_video`, `commentaire`, `date_publication`) VALUES
(1, 1, 7, 'Je commente ma propre vidéo :D', '2021-05-09 18:06:45'),
(2, 1, 7, 'Ouiiiii', '2021-05-09 18:07:01'),
(3, 1, 6, 'Normannnnn :o', '2021-05-09 18:07:24'),
(4, 1, 1, 'OH MON DIEU NORMAN !!!!!!!', '2021-05-09 18:08:19'),
(5, 1, 10, 'Je décline toute responsabilité', '2021-05-09 18:08:39'),
(6, 1, 9, 'He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were. He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.', '2021-05-09 18:09:53'),
(7, 1, 9, 'Je suis un autre commentaire :o', '2021-05-09 18:10:04'),
(8, 1, 9, 'He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.', '2021-05-09 18:10:14'),
(9, 1, 9, 'He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.', '2021-05-09 18:10:19'),
(10, 1, 9, 'He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.', '2021-05-09 18:10:21'),
(11, 1, 9, 'He determined to drop his litigation with the monastry, and relinguish his claims to the wood-cuting and fishery rihgts at once. He was the more ready to do this becuase the rights had becom much less valuable, and he had indeed the vaguest idea where the wood and river in quedtion were.', '2021-05-09 18:10:24'),
(12, 1, 9, 'Non', '2021-05-09 18:10:28'),
(13, 1, 9, 'Je dis oui', '2021-05-09 18:10:33'),
(14, 1, 9, 'Je dis non', '2021-05-09 18:10:39'),
(15, 1, 9, 'Il y  a beaucoup de commentaire par ici', '2021-05-09 18:10:51'),
(16, 2, 9, 'Tu arretes maintenant ok', '2021-05-09 18:11:45'),
(17, 2, 9, 'je suis le plus fort', '2021-05-09 18:12:02'),
(18, 2, 7, 'Je suis un super administrateur hahah', '2021-05-09 18:12:19'),
(19, 3, 7, 'héhéh', '2021-05-09 18:13:06'),
(20, 2, 13, 'Une super vidéo non ?', '2021-05-09 18:27:40'),
(21, 1, 13, 'en effet', '2021-05-09 18:28:05');

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
  `est_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_compte`)
  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id_compte`, `nom`, `prenom`, `login`, `couriel`, `mot_de_passe`, `est_bloque`, `est_admin`) VALUES
(1, 'Florquin', 'Coralie', 'gashila', 'cocogash381@gmail.com', 'e1fb9caa40b98659b7729ea856a5bb8f', 0, 0),
(2, 'Nihart', 'Jérémi', 'endmove', 'superjeremi1302@gmail.com', 'e1fb9caa40b98659b7729ea856a5bb8f', 0, 1),
(3, 'Dumont', 'Michel', 'titouan', 'jeremi.pro2002@gmail.com', 'e1fb9caa40b98659b7729ea856a5bb8f', 0, 0),
(4, 'nom 1', 'prénom 1', 'user01', 'user01@endmove.eu', 'e1fb9caa40b98659b7729ea856a5bb8f', 0, 0),
(5, 'nom 2', 'prénom 2', 'user02', 'user02@endmove.eu', 'e1fb9caa40b98659b7729ea856a5bb8f', 0, 0),
(6, 'nom 3', 'prénom 3', 'user03', 'user03@endmove.eu', 'e1fb9caa40b98659b7729ea856a5bb8f', 0, 0),
(7, 'nom 4', 'prénom 4', 'user04', 'user04@endmove.eu', 'e1fb9caa40b98659b7729ea856a5bb8f', 0, 0),
(8, 'nom 5', 'prénom 5', 'user05', 'user05@endmove.eu', 'e1fb9caa40b98659b7729ea856a5bb8f', 0, 0),
(9, 'nom 6', 'prénom 6', 'user06', 'user06@endmove.eu', 'e1fb9caa40b98659b7729ea856a5bb8f', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

DROP TABLE IF EXISTS `demande`;
CREATE TABLE IF NOT EXISTS `demande` (
  `id_compte_demandeur` int(10) UNSIGNED NOT NULL,
  `id_compte_destinataire` int(10) UNSIGNED NOT NULL,
  `est_acceptee` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_compte_demandeur`,`id_compte_destinataire`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `demande`
--

INSERT INTO `demande` (`id_compte_demandeur`, `id_compte_destinataire`, `est_acceptee`) VALUES
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(2, 1, 1),
(2, 3, 1),
(2, 4, 1),
(2, 5, 1),
(2, 9, 0),
(3, 1, 1),
(3, 5, 1),
(4, 3, 1),
(4, 5, 1),
(8, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `evaluer`
--

DROP TABLE IF EXISTS `evaluer`;
CREATE TABLE IF NOT EXISTS `evaluer` (
  `id_compte` int(10) UNSIGNED NOT NULL,
  `id_video` int(10) UNSIGNED NOT NULL,
  `evaluation` int(11) NOT NULL,
  PRIMARY KEY (`id_compte`,`id_video`),
  KEY `id_video` (`id_video`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `evaluer`
--

INSERT INTO `evaluer` (`id_compte`, `id_video`, `evaluation`) VALUES
(1, 3, 3),
(1, 5, 5),
(1, 6, 1),
(1, 7, 2),
(1, 13, 5),
(2, 5, 3),
(2, 6, 2),
(2, 7, 5),
(2, 8, 3),
(2, 9, 5),
(2, 13, 4);

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
  ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id_video`, `fk_chaine`, `intitule`, `description`, `html_fragment`, `duree`, `url_apercu`, `date_ajout`, `est_bloquee`) VALUES
(1, 1, 'LE MAROC (VLOG COUP DE COEUR) (Norman)', 'Lorsqu\'il était encore possible de voyager, nous avons eu la chance de découvrir Fès, Essaouira, Casablanca, le désert d\'Agafay et Marrakech dans un road trip inoubliable au Maroc !', '&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/cp_jBHiTeZw&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:32:16', 'ak0tTc20iHNH2claQ77nb2jKBgagE3f7s90dbU6S3j8fl.jpg', '2021-05-09 17:46:55', 0),
(2, 1, 'NORMAN - CODE DE LA ROUTE (suite et fin)', '10 ans après je REPASSE mon code de la route, et résultat... à la fin de la vidéo !', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/AdAb_ED6mCQ&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:07:29', 'qc0M9sa9bcaU2AfcXcz74iaQfT6p3bId8aa90z9882a00.jpg', '2021-05-09 17:50:51', 0),
(3, 1, 'SI 2020 ÉTAIT UN HUMAIN... (NORMAN)', 'Cette vidéo est sponsorisée par NordVPN les pti bro !\r\nProfitez de mon code promo &quot;Tartiflette&quot; lors de votre achat en cliquant ici : https://nordvpn.com/tartiflette', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/1mEBDZ4ZXnc&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:08:52', '8A4vGX6HU6b54L8qN7cc98y4bbBdsfw6p78af4K6e8aae.jpg', '2021-05-09 17:51:55', 0),
(4, 1, 'NORMAN - LES LIVRES (produits non essentiels)', 'J\'ai appris à lire en CP et pourtant j\'ai toujours du mal...\r\n\r\nMerci à Martha (@marthagambet sur insta), ainsi qu\'à Antoine Barillot, Alexandre Guiraud et Lou !', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/dBX_mLT5f3c&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:05:53', 'd1jcR9G449jeLcef535Ocf9fv4HCDV79Ag709K11Uk7UM.jpg', '2021-05-09 17:52:57', 0),
(5, 1, 'NORMAN - LA CUISINE TROMPE L\'OEIL (avec Morgan VS)', 'Avec Morgan VS on a testé des plats qui ont le goût d\'autres plats...\r\n\r\nMerci au monstre sacré Morgan VS ! Suivez-le ! Sa chaîne: https://www.youtube.com/channel/UCXwu...', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/q4IKXSGxweU&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:17:00', 'PrMc2cgyGeP0c32621p4a355FMeaybE51t16WHZbf3P57.jpg', '2021-05-09 17:53:59', 0),
(6, 1, 'NORMAN - ÊTRE PARENTS', 'Un peu comme la suite de ma vidéo &quot;avoir un bébé&quot; mais 1 an et demi plus tard !', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/7JTb2vf1OQQ&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:05:33', 'eL53175LS17doHenXrad087ii6a3a708aefPv2h23eRst.jpg', '2021-05-09 17:55:06', 0),
(7, 1, 'NORMAN - LES SÉRIES (Netflix, Prime Video...)', 'J\'ai bingé beaucoup de séries ces derniers mois: petit bilan !\r\n\r\nMon INSTA: @NORMANTHAVAUD\r\nCelui de Martha: @MARTHA_GAMBET\r\n\r\nÉcrit avec Kader Aoun', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/wa-E3WlQcSE&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:12:06', 'z24f9Pbwk31arb4s8MX1BG8aSw2Vlb91e9fcUOc0c74QG.jpg', '2021-05-09 17:56:52', 0),
(8, 2, 'J\'AI ACHETÉ UN BATEAU ! (on navigue dans l’Atlantique avec)', 'J\'ai acheté un bateau on navigue dans l’Atlantique !\r\nMontage : Florent Bodenez', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/1E9pDc0CeSY&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:21:13', '2kSf491ap4a7r2H40Db9BD4s6cOcJ7dKgPXZ2P5StqwSM.jpg', '2021-05-09 18:02:12', 0),
(9, 2, 'Mais pourquoi ils font ça à leurs enfants ? (Les pires pranks de parents)', 'Des parents prank leurs enfants, y\'en a vous voulez les tuer ou c\'est comment ??\r\nMa boutique SPACEFOX.shop ! : https://www.spacefox.shop/', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/fTuuVSB0Mmw&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:15:02', 'Hcdzef6fbCm03Rlwef99Jf9cbaa27x2a1fl333B5e3c9H.jpg', '2021-05-09 18:03:45', 0),
(10, 3, 'Five Kids The Colors Song + More Children\'s Songs and Videos', 'A new compilation video, including one of our most recent learn colors songs, &quot;The Colors Song&quot;.', '&lt;iframe width=&quot;1024&quot; height=&quot;576&quot; src=&quot;https://www.youtube.com/embed/0F8EcogA2K4&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:33:47', '2CVahFqfVUl1r12bibaaVc07z8Vc2dRNld49a9qapbYQG.jpg', '2021-05-09 18:06:08', 0),
(11, 4, 'Je suis l\'unique vidéo :/', 'Je suis Titouan, un petit homme dépressif', '&lt;iframe src=&quot;https://www.facebook.com/plugins/video.php?height=476&amp;href=https%3A%2F%2Fwww.facebook.com%2FYaQueLaVeriteQuiCompteOff%2Fvideos%2F763497954575185%2F&amp;show_text=false&amp;width=380&quot; width=&quot;380&quot; height=&quot;476&quot; style=&quot;border:none;overflow:hidden&quot; scrolling=&quot;no&quot; frameborder=&quot;0&quot; allowfullscreen=&quot;true&quot; allow=&quot;autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share&quot; allowFullScreen=&quot;true&quot;&gt;&lt;/iframe&gt;', '00:07:41', '36A7we6613vGcY2JncS3e25xHL6eq6FO1P439pdef26uP.jpg', '2021-05-09 18:16:33', 0),
(12, 5, 'Ne pas cliquer, iframe D buggé', 'Une vidéo random', '&lt;iframe style=&quot;width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden&quot; frameborder=&quot;0&quot; type=&quot;text/html&quot; src=&quot;https://www.dailymotion.com/embed/video/x815qse?autoplay=1&quot; width=&quot;100%&quot; height=&quot;100%&quot; allowfullscreen allow=&quot;autoplay&quot;&gt; &lt;/iframe&gt;', '00:01:50', 'f37pt37BQlQJOeK2zUq58fwCcc8If7ab2wfMfK7b9pVfe.jpg', '2021-05-09 18:20:23', 0),
(13, 5, 'NEW Super Mario Bloopers 4', 'marioooooooooo', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/WTuC8vg3m_w&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:03:14', 'iduW7bL4bUbcce0B4fog53ablgo6gE0wTe88heyqMfc87.jpg', '2021-05-09 18:24:19', 0),
(14, 5, 'Resident Evil 8 VILLAGE Let\'s Play - Épisode 1 (Gameplay FR)', 'Gameplay 1 du let\'s play sur Resident Evil Village. RE8 prend place directement après les événements de RE7, on y retrouve donc Ethan qui va malheureusement une nouvelle fois vivre l\'enfer, cette fois-ci dans un village peuplé de monstres, dans le but de retrouver sa fille.', '&lt;iframe width=&quot;923&quot; height=&quot;519&quot; src=&quot;https://www.youtube.com/embed/Alyz0JVYeNs&quot; title=&quot;YouTube video player&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture&quot; allowfullscreen&gt;&lt;/iframe&gt;', '00:58:46', 'S163l8y6dcN6hs15Wytfbf4fb3r99q444Gg614OJe4c34.jpg', '2021-05-10 09:14:21', 0);

-- --------------------------------------------------------

--
-- Structure de la table `voir`
--

DROP TABLE IF EXISTS `voir`;
CREATE TABLE IF NOT EXISTS `voir` (
  `id_compte` int(10) UNSIGNED NOT NULL,
  `id_video` int(10) UNSIGNED NOT NULL,
  `date_vue` datetime NOT NULL,
  PRIMARY KEY (`id_compte`,`id_video`,`date_vue`),
  KEY `id_video` (`id_video`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `voir`
--

INSERT INTO `voir` (`id_compte`, `id_video`, `date_vue`) VALUES
(1, 1, '2021-05-09 17:47:07'),
(1, 1, '2021-05-09 17:47:49'),
(1, 1, '2021-05-09 18:08:03'),
(1, 1, '2021-05-09 18:08:19'),
(1, 3, '2021-05-09 18:07:51'),
(1, 3, '2021-05-09 18:07:54'),
(1, 5, '2021-05-09 18:07:37'),
(1, 5, '2021-05-09 18:07:42'),
(2, 5, '2021-05-09 18:26:45'),
(2, 5, '2021-05-09 18:26:48'),
(1, 6, '2021-05-09 18:07:10'),
(1, 6, '2021-05-09 18:07:24'),
(1, 6, '2021-05-09 18:07:28'),
(2, 6, '2021-05-09 18:26:38'),
(2, 6, '2021-05-09 18:26:42'),
(1, 7, '2021-05-09 18:06:29'),
(1, 7, '2021-05-09 18:06:31'),
(1, 7, '2021-05-09 18:06:32'),
(1, 7, '2021-05-09 18:06:34'),
(1, 7, '2021-05-09 18:06:35'),
(1, 7, '2021-05-09 18:06:45'),
(1, 7, '2021-05-09 18:06:52'),
(1, 7, '2021-05-09 18:07:01'),
(2, 7, '2021-05-09 18:12:07'),
(2, 7, '2021-05-09 18:12:19'),
(2, 7, '2021-05-09 18:26:31'),
(2, 7, '2021-05-09 18:26:34'),
(3, 7, '2021-05-09 18:13:02'),
(3, 7, '2021-05-09 18:13:06'),
(2, 8, '2021-05-09 18:26:52'),
(2, 8, '2021-05-09 18:26:55'),
(1, 9, '2021-05-09 18:08:53'),
(1, 9, '2021-05-09 18:09:53'),
(1, 9, '2021-05-09 18:10:04'),
(1, 9, '2021-05-09 18:10:14'),
(1, 9, '2021-05-09 18:10:19'),
(1, 9, '2021-05-09 18:10:21'),
(1, 9, '2021-05-09 18:10:24'),
(1, 9, '2021-05-09 18:10:28'),
(1, 9, '2021-05-09 18:10:33'),
(1, 9, '2021-05-09 18:10:39'),
(1, 9, '2021-05-09 18:10:51'),
(2, 9, '2021-05-09 18:11:35'),
(2, 9, '2021-05-09 18:11:45'),
(2, 9, '2021-05-09 18:12:02'),
(2, 9, '2021-05-09 18:27:03'),
(2, 9, '2021-05-09 18:27:06'),
(2, 9, '2021-05-10 09:20:47'),
(2, 9, '2021-05-10 09:21:12'),
(2, 9, '2021-05-10 09:21:31'),
(2, 9, '2021-05-10 09:25:29'),
(2, 9, '2021-05-10 09:25:47'),
(1, 10, '2021-05-09 18:08:27'),
(1, 10, '2021-05-09 18:08:39'),
(1, 10, '2021-05-09 18:08:42'),
(3, 11, '2021-05-09 18:16:38'),
(2, 12, '2021-05-09 18:20:37'),
(2, 12, '2021-05-09 18:21:20'),
(2, 12, '2021-05-09 18:21:32'),
(2, 12, '2021-05-09 18:21:36'),
(2, 12, '2021-05-09 18:22:17'),
(1, 13, '2021-05-09 18:26:13'),
(1, 13, '2021-05-09 18:26:15'),
(1, 13, '2021-05-09 18:26:17'),
(1, 13, '2021-05-09 18:26:21'),
(1, 13, '2021-05-09 18:27:57'),
(1, 13, '2021-05-09 18:28:05'),
(1, 13, '2021-05-09 18:28:17'),
(2, 13, '2021-05-09 18:27:32'),
(2, 13, '2021-05-09 18:27:40'),
(2, 13, '2021-05-09 18:27:45'),
(2, 14, '2021-05-10 09:14:34'),
(2, 14, '2021-05-10 09:19:59'),
(2, 14, '2021-05-10 09:20:08'),
(2, 14, '2021-05-10 09:20:17'),
(2, 14, '2021-05-10 09:20:22'),
(2, 14, '2021-05-10 09:21:37'),
(2, 14, '2021-05-10 09:21:40'),
(2, 14, '2021-05-10 09:25:05'),
(2, 14, '2021-05-20 09:35:54'),
(2, 14, '2021-05-20 09:36:06'),
(2, 14, '2021-05-20 09:55:06');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chaine`
--
ALTER TABLE `chaine`
  ADD CONSTRAINT `chaine_ibfk_1` FOREIGN KEY (`fk_compte`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`fk_compte`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE,
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`fk_video`) REFERENCES `video` (`id_video`) ON DELETE CASCADE;

--
-- Contraintes pour la table `demande`
--
ALTER TABLE `demande`
  ADD CONSTRAINT `demande_ibfk_1` FOREIGN KEY (`id_compte_demandeur`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE;

--
-- Contraintes pour la table `evaluer`
--
ALTER TABLE `evaluer`
  ADD CONSTRAINT `evaluer_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE,
  ADD CONSTRAINT `evaluer_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `video` (`id_video`) ON DELETE CASCADE;

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`fk_chaine`) REFERENCES `chaine` (`id_chaine`) ON DELETE CASCADE;

--
-- Contraintes pour la table `voir`
--
ALTER TABLE `voir`
  ADD CONSTRAINT `voir_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE,
  ADD CONSTRAINT `voir_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `video` (`id_video`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
