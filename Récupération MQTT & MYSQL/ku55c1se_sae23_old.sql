-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 31 mai 2023 à 11:21
-- Version du serveur :  5.7.33-cll-lve
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ku55c1se_sae23`
--

-- --------------------------------------------------------

--
-- Structure de la table `administration`
--

CREATE TABLE `administration` (
  `user` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `administration`
--

INSERT INTO `administration` (`user`, `password`) VALUES
('Sebastien', 'Patoche');

-- --------------------------------------------------------

--
-- Structure de la table `batiment`
--

CREATE TABLE `batiment` (
  `id_batiment` int(1) NOT NULL,
  `nom_bat` varchar(20) NOT NULL,
  `login_gest` varchar(50) NOT NULL,
  `mdp_gest` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `batiment`
--

INSERT INTO `batiment` (`id_batiment`, `nom_bat`, `login_gest`, `mdp_gest`) VALUES
(1, 'A', 'Ange', 'Ange'),
(2, 'B', 'Pierre', 'Pierre'),
(3, 'C', 'Sylvio', 'Sylvio'),
(4, 'D', 'Gaspard', 'Gaspard'),
(5, 'E', 'Gael', 'Gael');

-- --------------------------------------------------------

--
-- Structure de la table `capteur`
--

CREATE TABLE `capteur` (
  `id_capteur` varchar(16) NOT NULL,
  `nom_capteur` varchar(9) NOT NULL,
  `type_capteur` varchar(20) NOT NULL,
  `Salle` varchar(4) NOT NULL,
  `id_batiment` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `capteur`
--

INSERT INTO `capteur` (`id_capteur`, `nom_capteur`, `type_capteur`, `Salle`, `id_batiment`) VALUES
('24e124128c011778', 'AM107-6', 'Humidity', 'B203', 2),
('24e124128c012259', 'AM107-7', 'CO2', 'B001', 2),
('24e124128c016122', 'AM107-32', 'Humidity', 'E102', 5),
('24e124128c016509', 'AM107-29', 'CO2\r\n\r\n', 'E006', 5);

-- --------------------------------------------------------

--
-- Structure de la table `mesure`
--

CREATE TABLE `mesure` (
  `id_mesure` int(10) NOT NULL,
  `date_mesure` varchar(20) NOT NULL,
  `valeur_mesure` varchar(10) NOT NULL,
  `id_capteur` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mesure`
--

INSERT INTO `mesure` (`id_mesure`, `date_mesure`, `valeur_mesure`, `id_capteur`) VALUES
(4, '29 May 12:54:30', '56.5', '24e124128c016122'),
(5, '29 May 12:54:38', '452', '24e124128c012259'),
(6, '29 May 13:00:05', '423', '24e124128c016509'),
(7, '29 May 13:01:06', '54.5', '24e124128c011778'),
(8, '29 May 13:04:30', '56.5', '24e124128c016122'),
(9, '29 May 13:10:04', '410', '24e124128c016509'),
(10, '29 May 13:11:07', '54.5', '24e124128c011778'),
(11, '29 May 13:14:29', '56.5', '24e124128c016122'),
(12, '29 May 13:20:05', '412', '24e124128c016509'),
(13, '29 May 13:21:06', '54.5', '24e124128c011778'),
(14, '29 May 13:24:32', '56.5', '24e124128c016122'),
(15, '29 May 13:30:05', '417', '24e124128c016509'),
(16, '29 May 13:31:06', '55', '24e124128c011778'),
(17, '29 May 13:34:30', '56.5', '24e124128c016122'),
(18, '29 May 13:40:04', '416', '24e124128c016509'),
(19, '29 May 13:41:07', '55', '24e124128c011778'),
(20, '29 May 13:44:30', '56', '24e124128c016122'),
(21, '29 May 13:50:04', '414', '24e124128c016509'),
(22, '29 May 13:51:06', '55', '24e124128c011778'),
(23, '29 May 13:54:29', '56', '24e124128c016122'),
(24, '29 May 13:54:38', '444', '24e124128c012259'),
(25, '29 May 14:00:05', '419', '24e124128c016509'),
(26, '29 May 14:01:06', '55', '24e124128c011778'),
(27, '29 May 14:04:30', '56', '24e124128c016122'),
(28, '29 May 14:10:04', '417', '24e124128c016509'),
(29, '29 May 14:11:07', '55.5', '24e124128c011778'),
(30, '29 May 14:14:29', '56', '24e124128c016122'),
(31, '29 May 14:14:39', '445', '24e124128c012259'),
(32, '29 May 14:20:04', '419', '24e124128c016509'),
(33, '29 May 14:21:06', '55.5', '24e124128c011778'),
(34, '29 May 14:24:32', '56', '24e124128c016122'),
(35, '29 May 14:30:04', '416', '24e124128c016509'),
(36, '29 May 14:31:06', '56', '24e124128c011778'),
(37, '29 May 14:34:31', '55.5', '24e124128c016122'),
(38, '29 May 16:20:05', '414', '24e124128c016509'),
(39, '29 May 16:21:06', '56', '24e124128c011778'),
(40, '29 May 16:24:29', '50', '24e124128c016122'),
(41, '29 May 16:30:04', '409', '24e124128c016509'),
(42, '29 May 16:31:07', '56', '24e124128c011778'),
(43, '29 May 18:24:30', '41', '24e124128c016122'),
(44, '29 May 18:24:39', '432', '24e124128c012259'),
(45, '29 May 18:30:04', '406', '24e124128c016509'),
(46, '29 May 18:31:20', '53', '24e124128c011778'),
(47, '29 May 18:34:29', '40.5', '24e124128c016122'),
(48, '29 May 18:40:05', '399', '24e124128c016509'),
(49, '29 May 18:41:20', '53', '24e124128c011778'),
(50, '29 May 18:50:04', '404', '24e124128c016509'),
(51, '29 May 18:51:20', '52.5', '24e124128c011778'),
(52, '29 May 18:54:32', '41', '24e124128c016122'),
(53, '29 May 18:54:39', '430', '24e124128c012259'),
(54, '31 May 10:30:03', '497', '24e124128c016509'),
(55, '31 May 10:31:20', '56', '24e124128c011778'),
(56, '31 May 10:34:29', '54.5', '24e124128c016122'),
(57, '31 May 10:34:38', '590', '24e124128c012259'),
(58, '31 May 10:40:03', '495', '24e124128c016509'),
(59, '31 May 10:41:20', '56', '24e124128c011778'),
(60, '31 May 10:50:03', '483', '24e124128c016509'),
(61, '31 May 10:51:20', '56.5', '24e124128c011778'),
(62, '31 May 10:54:29', '52.5', '24e124128c016122'),
(63, '31 May 10:54:38', '594', '24e124128c012259'),
(64, '31 May 11:00:04', '484', '24e124128c016509'),
(65, '31 May 11:01:20', '56.5', '24e124128c011778'),
(66, '31 May 11:04:29', '55', '24e124128c016122'),
(67, '31 May 11:10:03', '485', '24e124128c016509'),
(68, '31 May 11:11:20', '56.5', '24e124128c011778'),
(69, '31 May 11:14:30', '56.5', '24e124128c016122'),
(70, '31 May 11:14:39', '587', '24e124128c012259'),
(71, '31 May 11:20:03', '486', '24e124128c016509'),
(72, '31 May 11:21:20', '57', '24e124128c011778');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `batiment`
--
ALTER TABLE `batiment`
  ADD PRIMARY KEY (`id_batiment`),
  ADD UNIQUE KEY `nom_bat` (`nom_bat`);

--
-- Index pour la table `capteur`
--
ALTER TABLE `capteur`
  ADD PRIMARY KEY (`id_capteur`),
  ADD UNIQUE KEY `id_capteur` (`id_capteur`,`nom_capteur`),
  ADD KEY `id_batiment` (`id_batiment`);

--
-- Index pour la table `mesure`
--
ALTER TABLE `mesure`
  ADD PRIMARY KEY (`id_mesure`),
  ADD UNIQUE KEY `id_mesure` (`id_mesure`),
  ADD KEY `id_capteur` (`id_capteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `batiment`
--
ALTER TABLE `batiment`
  MODIFY `id_batiment` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `mesure`
--
ALTER TABLE `mesure`
  MODIFY `id_mesure` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `capteur`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
