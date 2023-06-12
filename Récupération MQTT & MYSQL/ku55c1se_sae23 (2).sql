-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 12 juin 2023 à 11:58
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
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `administration`
--

INSERT INTO `administration` (`user`, `password`) VALUES
('Sebastien', '35f2f4e7a2df5acc08e0efd181059294937d188542e923ad34a6c1802acbeaeb');

-- --------------------------------------------------------

--
-- Structure de la table `batiment`
--

CREATE TABLE `batiment` (
  `id_batiment` int(1) NOT NULL,
  `nom_bat` varchar(20) NOT NULL,
  `login_gest` varchar(50) NOT NULL,
  `mdp_gest` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `batiment`
--

INSERT INTO `batiment` (`id_batiment`, `nom_bat`, `login_gest`, `mdp_gest`) VALUES
(2, 'B', 'Pierre', 'fd9c6c387debc9fe80435f5cb089aad87967b38bcffdad1e566a36271cf3cfec'),
(3, 'C', 'Sylvio', 'c74b8f6bc5406352d6b75d700e6a83c494b1614f81838e66f074af562204f73b'),
(4, 'D', 'toto', '31f7a65e315586ac198bd798b6629ce4903d0899476d5741a9f32e2e521b6a66'),
(5, 'E', 'Gael', '03f490b86897eb55de59ef1cd372693af667112e582f9058bca38218bf103043'),
(22, 'A', 'Ange', '1c8445f04b1abf82bf0d4062bc9cf522cfa5b23c07840511585849b269b9024c'),
(23, 'F', 'Gaspard', '82b8a05cf226f9d0b9c7454cef56c2f7a99f9a4ec8ef7e6e6f26e3a896d14d21');

-- --------------------------------------------------------

--
-- Structure de la table `capteur`
--

CREATE TABLE `capteur` (
  `id_capteur` int(16) NOT NULL,
  `nom_capteur` varchar(25) NOT NULL,
  `type_capteur` varchar(20) NOT NULL,
  `Salle` varchar(4) NOT NULL,
  `id_batiment` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `capteur`
--

INSERT INTO `capteur` (`id_capteur`, `nom_capteur`, `type_capteur`, `Salle`, `id_batiment`) VALUES
(827, 'B110temperature', 'temperature', 'B110', 2),
(828, 'B110tvoc', 'tvoc', 'B110', 2),
(830, 'B110humidity', 'humidity', 'B110', 2),
(831, 'B110activity', 'activity', 'B110', 2),
(832, 'B110co2', 'co2', 'B110', 2),
(833, 'B111temperature', 'temperature', 'B111', 2),
(834, 'B111humidity', 'humidity', 'B111', 2),
(835, 'B111activity', 'activity', 'B111', 2),
(917, 'B112temperature', 'temperature', 'B112', 2),
(918, 'B112humidity', 'humidity', 'B112', 2),
(919, 'B112activity', 'activity', 'B112', 2),
(920, 'B112co2', 'co2', 'B112', 2),
(921, 'B112tvoc', 'tvoc', 'B112', 2),
(922, 'B112illumination', 'illumination', 'B112', 2),
(923, 'B112infrared', 'infrared', 'B112', 2),
(924, 'B112infrared_and_visible', 'infrared_and_visible', 'B112', 2),
(925, 'B112pressure', 'pressure', 'B112', 2),
(926, 'E101temperature', 'temperature', 'E101', 5),
(927, 'C101temperature', 'temperature', 'C101', 3),
(928, 'E106temperature', 'temperature', 'E106', 5),
(929, 'E102illumination', 'illumination', 'E102', 5),
(930, 'B103humidity', 'humidity', 'B103', 2),
(931, 'E003activity', 'activity', 'E003', 5),
(932, 'E003temperature', 'temperature', 'E003', 5),
(933, 'B201temperature', 'temperature', 'B201', 2);

-- --------------------------------------------------------

--
-- Structure de la table `mesure`
--

CREATE TABLE `mesure` (
  `id_mesure` int(10) NOT NULL,
  `date_mesure` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valeur_mesure` varchar(10) NOT NULL,
  `nom_capteur` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mesure`
--

INSERT INTO `mesure` (`id_mesure`, `date_mesure`, `valeur_mesure`, `nom_capteur`) VALUES
(1092, '2023-06-11 15:50:48', '26.3', 'B110temperature'),
(1093, '2023-06-11 15:50:48', '55', 'B110humidity'),
(1094, '2023-06-11 15:50:48', '0', 'B110activity'),
(1095, '2023-06-11 15:50:48', '427', 'B110co2'),
(1096, '2023-06-11 15:50:48', '235', 'B110tvoc'),
(1098, '2023-06-11 15:51:04', '26.3', 'B110temperature'),
(1099, '2023-06-11 15:51:04', '55', 'B110humidity'),
(1100, '2023-06-11 15:51:04', '0', 'B110activity'),
(1101, '2023-06-11 15:51:04', '427', 'B110co2'),
(1102, '2023-06-11 15:51:04', '235', 'B110tvoc'),
(1104, '2023-06-11 15:51:06', '26.3', 'B110temperature'),
(1105, '2023-06-11 15:51:06', '55', 'B110humidity'),
(1106, '2023-06-11 15:51:06', '0', 'B110activity'),
(1107, '2023-06-11 15:51:06', '427', 'B110co2'),
(1108, '2023-06-11 15:51:06', '235', 'B110tvoc'),
(1110, '2023-06-11 15:53:40', '26.3', 'B110temperature'),
(1111, '2023-06-11 15:53:40', '55', 'B110humidity'),
(1112, '2023-06-11 15:53:40', '0', 'B110activity'),
(1113, '2023-06-11 15:53:40', '427', 'B110co2'),
(1114, '2023-06-11 15:53:40', '235', 'B110tvoc'),
(1116, '2023-06-11 15:54:16', '26.3', 'B110temperature'),
(1117, '2023-06-11 15:54:16', '55', 'B110humidity'),
(1118, '2023-06-11 15:54:16', '0', 'B110activity'),
(1119, '2023-06-11 15:54:16', '427', 'B110co2'),
(1120, '2023-06-11 15:54:16', '235', 'B110tvoc'),
(1136, '2023-06-11 15:55:28', '26.3', 'B110temperature'),
(1137, '2023-06-11 15:55:28', '55', 'B110humidity'),
(1138, '2023-06-11 15:55:28', '0', 'B110activity'),
(1139, '2023-06-11 15:55:28', '427', 'B110co2'),
(1140, '2023-06-11 15:55:28', '235', 'B110tvoc'),
(1156, '2023-06-11 15:58:10', '26.3', 'B110temperature'),
(1157, '2023-06-11 15:58:10', '55', 'B110humidity'),
(1158, '2023-06-11 15:58:11', '0', 'B110activity'),
(1159, '2023-06-11 15:58:11', '427', 'B110co2'),
(1160, '2023-06-11 15:58:11', '235', 'B110tvoc'),
(1176, '2023-06-11 16:03:40', '26', 'B110temperature'),
(1177, '2023-06-11 16:03:40', '5', 'B110humidity'),
(1178, '2023-06-11 16:03:40', '2', 'B110activity'),
(1179, '2023-06-11 16:03:40', '464', 'B110co2'),
(1180, '2023-06-11 16:03:40', '238', 'B110tvoc'),
(1196, '2023-06-11 16:05:03', '25.6', 'B111temperature'),
(1197, '2023-06-11 16:05:03', '57.5', 'B111humidity'),
(1198, '2023-06-11 16:05:03', '0', 'B111activity'),
(1207, '2023-06-11 16:05:05', '25.6', 'B111temperature'),
(1208, '2023-06-11 16:05:05', '57.5', 'B111humidity'),
(1209, '2023-06-11 16:05:05', '0', 'B111activity'),
(1218, '2023-06-11 16:05:07', '25.6', 'B111temperature'),
(1219, '2023-06-11 16:05:07', '57.5', 'B111humidity'),
(1220, '2023-06-11 16:05:07', '0', 'B111activity'),
(1229, '2023-06-11 16:05:27', '25.6', 'B111temperature'),
(1230, '2023-06-11 16:05:27', '57.5', 'B111humidity'),
(1231, '2023-06-11 16:05:27', '0', 'B111activity'),
(1338, '2023-06-11 16:13:20', '25.6', 'B111temperature'),
(1339, '2023-06-11 16:13:20', '57.5', 'B111humidity'),
(1340, '2023-06-11 16:13:20', '0', 'B111activity'),
(1349, '2023-06-11 16:13:21', '25.6', 'B111temperature'),
(1350, '2023-06-11 16:13:21', '57.5', 'B111humidity'),
(1351, '2023-06-11 16:13:21', '0', 'B111activity'),
(1474, '2023-06-11 16:14:03', '25.6', 'B111temperature'),
(1475, '2023-06-11 16:14:03', '57.5', 'B111humidity'),
(1476, '2023-06-11 16:14:03', '0', 'B111activity'),
(1485, '2023-06-11 16:14:04', '25.6', 'B111temperature'),
(1486, '2023-06-11 16:14:04', '57.5', 'B111humidity'),
(1487, '2023-06-11 16:14:04', '0', 'B111activity'),
(1599, '2023-06-11 16:15:07', '25.6', 'B111temperature'),
(1600, '2023-06-11 16:15:07', '57.5', 'B111humidity'),
(1601, '2023-06-11 16:15:07', '0', 'B111activity'),
(1610, '2023-06-11 16:15:08', '25.6', 'B111temperature'),
(1611, '2023-06-11 16:15:08', '57.5', 'B111humidity'),
(1612, '2023-06-11 16:15:08', '0', 'B111activity'),
(1706, '2023-06-11 16:25:39', '25.6', 'B111temperature'),
(1707, '2023-06-11 16:25:39', '57.5', 'B111humidity'),
(1708, '2023-06-11 16:25:39', '0', 'B111activity'),
(1735, '2023-06-11 16:25:40', '25.6', 'B112temperature'),
(1736, '2023-06-11 16:25:40', '57.5', 'B112humidity'),
(1737, '2023-06-11 16:25:40', '0', 'B112activity'),
(1738, '2023-06-11 16:25:40', '413', 'B112co2'),
(1739, '2023-06-11 16:25:40', '1897', 'B112tvoc'),
(1740, '2023-06-11 16:25:40', '4', 'B112illumination'),
(1741, '2023-06-11 16:25:41', '1', 'B112infrared'),
(1743, '2023-06-11 16:25:41', '990', 'B112pressure'),
(1744, '2023-06-11 16:28:29', '25.6', 'B111temperature'),
(1745, '2023-06-11 16:28:29', '57.5', 'B111humidity'),
(1746, '2023-06-11 16:28:29', '0', 'B111activity'),
(1763, '2023-06-12 07:40:02', '23.8', 'E003temperature'),
(1765, '2023-06-12 07:41:02', '23.8', 'E003temperature'),
(1767, '2023-06-12 07:41:04', '23.8', 'E003temperature'),
(1769, '2023-06-12 07:41:16', '23.8', 'E003temperature'),
(1771, '2023-06-12 07:41:46', '23.8', 'E003temperature'),
(1773, '2023-06-12 07:41:48', '23.8', 'E003temperature'),
(1775, '2023-06-12 07:42:03', '23.8', 'E003temperature'),
(1777, '2023-06-12 07:42:36', '23.8', 'E003temperature'),
(1779, '2023-06-12 07:42:38', '23.8', 'E003temperature'),
(1781, '2023-06-12 07:43:12', '23.8', 'E003temperature'),
(1783, '2023-06-12 07:43:15', '23.8', 'E003temperature'),
(1785, '2023-06-12 07:43:16', '23.8', 'E003temperature'),
(1787, '2023-06-12 07:43:29', '23.8', 'E003temperature'),
(1789, '2023-06-12 07:43:30', '23.8', 'E003temperature'),
(1791, '2023-06-12 07:44:35', '23.8', 'E003temperature'),
(1793, '2023-06-12 07:46:03', '23.8', 'E003temperature'),
(1795, '2023-06-12 07:46:05', '23.8', 'E003temperature'),
(1797, '2023-06-12 07:46:19', '23.8', 'E003temperature'),
(1806, '2023-06-12 07:59:24', '25.4', 'B201temperature'),
(1808, '2023-06-12 08:01:27', '25.4', 'B201temperature'),
(1810, '2023-06-12 08:05:42', '25.4', 'B201temperature'),
(1811, '2023-06-12 08:06:43', '25.4', 'B201temperature'),
(1812, '2023-06-12 08:06:52', '25.4', 'B201temperature'),
(1813, '2023-06-12 08:07:23', '25.4', 'B201temperature'),
(1814, '2023-06-12 08:24:25', '25.4', 'B201temperature'),
(1815, '2023-06-12 08:24:32', '25.4', 'B201temperature'),
(1816, '2023-06-12 08:24:34', '25.4', 'B201temperature'),
(1817, '2023-06-12 08:25:16', '25.4', 'B201temperature'),
(1818, '2023-06-12 08:25:44', '25.4', 'B201temperature'),
(1819, '2023-06-12 08:26:25', '25.4', 'B201temperature'),
(1820, '2023-06-12 08:26:27', '25.4', 'B201temperature'),
(1821, '2023-06-12 08:26:42', '25.4', 'B201temperature'),
(1822, '2023-06-12 08:26:48', '25.4', 'B201temperature'),
(1823, '2023-06-12 08:27:20', '25.4', 'B201temperature'),
(1824, '2023-06-12 08:27:42', '25.4', 'B201temperature'),
(1825, '2023-06-12 08:41:50', '25.4', 'B201temperature'),
(1826, '2023-06-12 09:46:14', '25.4', 'B201temperature'),
(1827, '2023-06-12 09:48:11', '24.7', 'B112temperature'),
(1828, '2023-06-12 09:48:11', '61.5', 'B112humidity'),
(1829, '2023-06-12 09:48:11', '0', 'B112activity'),
(1830, '2023-06-12 09:48:11', '583', 'B112co2'),
(1831, '2023-06-12 09:48:11', '2228', 'B112tvoc'),
(1832, '2023-06-12 09:48:11', '54', 'B112illumination'),
(1833, '2023-06-12 09:48:12', '19', 'B112infrared'),
(1835, '2023-06-12 09:55:10', '26.2', 'E106temperature'),
(1836, '2023-06-12 09:57:28', '26.1', 'B111temperature'),
(1837, '2023-06-12 09:57:28', '64.5', 'B111humidity'),
(1838, '2023-06-12 09:57:28', '32', 'B111activity');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administration`
--
ALTER TABLE `administration`
  ADD UNIQUE KEY `user` (`user`);

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
  ADD UNIQUE KEY `nom_capteur` (`nom_capteur`),
  ADD KEY `id_batiment` (`id_batiment`);

--
-- Index pour la table `mesure`
--
ALTER TABLE `mesure`
  ADD PRIMARY KEY (`id_mesure`),
  ADD KEY `nom_capteur` (`nom_capteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `batiment`
--
ALTER TABLE `batiment`
  MODIFY `id_batiment` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `capteur`
--
ALTER TABLE `capteur`
  MODIFY `id_capteur` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=934;

--
-- AUTO_INCREMENT pour la table `mesure`
--
ALTER TABLE `mesure`
  MODIFY `id_mesure` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1839;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `capteur`
--
ALTER TABLE `capteur`
  ADD CONSTRAINT `capteur_ibfk_1` FOREIGN KEY (`id_batiment`) REFERENCES `batiment` (`id_batiment`);

--
-- Contraintes pour la table `mesure`
--
ALTER TABLE `mesure`
  ADD CONSTRAINT `mesure_ibfk_1` FOREIGN KEY (`nom_capteur`) REFERENCES `capteur` (`nom_capteur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
