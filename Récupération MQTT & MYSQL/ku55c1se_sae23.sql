-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 27 mai 2023 à 13:32
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
  `user` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
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
  `id_batiment` int(11) NOT NULL,
  `nom_bat` varchar(50) NOT NULL,
  `login_gest` varchar(50) NOT NULL,
  `mdp_gest` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `batiment`
--

INSERT INTO `batiment` (`id_batiment`, `nom_bat`, `login_gest`, `mdp_gest`) VALUES
(6, 'Batiment en Bois', 'gze', 'fregtr'),
(7, 'Batiment sur un Nuage', 'dzq', 'fr'),
(8, 'dzqd', 'grdg', 'erfesfes');

-- --------------------------------------------------------

--
-- Structure de la table `capteur`
--

CREATE TABLE `capteur` (
  `id_capteur` varchar(16) NOT NULL,
  `nom_capteur` varchar(9) NOT NULL,
  `type_capteur` varchar(20) NOT NULL,
  `Salle` int (3) NOT NULL,
  `id_batiment` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `capteur`
--

INSERT INTO `capteur` (`id_capteur`, `nom_capteur`, `type_capteur`, `id_batiment`) VALUES
(35, 'AH AAIUHDFZIUAHD', 'oxygene', 6),
(39, 'rgreg', 'lux', 6);

-- --------------------------------------------------------

--
-- Structure de la table `mesure`
--

CREATE TABLE `mesure` (
  `id_mesure` int(11) NOT NULL,
  `id_capteur` int(11) NOT NULL,
  `date_mesure` date NOT NULL,
  `horaires` date NOT NULL,
  `valeur_mesure` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mesure`
--

INSERT INTO `mesure` (`id_mesure`, `id_capteur`, `date_mesure`, `horaires`, `valeur_mesure`) VALUES
(3, 39, '2023-05-16', '2023-05-13', 'uh');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `batiment`
--
ALTER TABLE `batiment`
  ADD PRIMARY KEY (`id_batiment`);

--
-- Index pour la table `capteur`
--
ALTER TABLE `capteur`
  ADD PRIMARY KEY (`id_capteur`),
  ADD KEY `id_batiment` (`id_batiment`);

--
-- Index pour la table `mesure`
--
ALTER TABLE `mesure`
  ADD PRIMARY KEY (`id_mesure`),
  ADD KEY `id_capteur` (`id_capteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `batiment`
--
ALTER TABLE `batiment`
  MODIFY `id_batiment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `capteur`
--
ALTER TABLE `capteur`
  MODIFY `id_capteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `mesure`
--
ALTER TABLE `mesure`
  MODIFY `id_mesure` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `capteur`
--
ALTER TABLE `capteur`
  ADD CONSTRAINT `capteur_ibfk_1` FOREIGN KEY (`id_batiment`) REFERENCES `batiment` (`ID_Batiment`);

--
-- Contraintes pour la table `mesure`
--
ALTER TABLE `mesure`
  ADD CONSTRAINT `mesure_ibfk_1` FOREIGN KEY (`ID_Capteur`) REFERENCES `capteur` (`id_capteur`),
  ADD CONSTRAINT `mesure_ibfk_2` FOREIGN KEY (`id_capteur`) REFERENCES `capteur` (`id_capteur`);
COMMIT;

-- insert data into the capteur table 

INSERT INTO capteur (ID_capteur, Nom_capt, Type_capt, Salle, ID_Batiment)
VALUES
    ('24e124128c012259', 'AM107-7', 'CO2', 'B001', '2'),
    ('24e124128c011778', 'AM107-6', 'Humidité', 'B203', '2'),
    ('24e124128c016509', 'AM107-29', 'CO2', 'E006', '5'),
    ('24e124128c016122', 'AM107-32', 'Humidité', 'E102', '5');
    
--insert data into the table batiment

INSERT INTO batiment (ID_bat, Nom_bat, Login_Gest, MDP_Gest)
VALUES
    ('1', 'A', 'Ange', 'Ange'),
    ('2', 'B', 'Pierre', 'Pierre'),
    ('3', 'C', 'Sylvio', 'Sylvio'),
    ('4', 'D', 'Gaspard', 'Gaspard'),
    ('5', '5', 'Gael', 'Gael');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
