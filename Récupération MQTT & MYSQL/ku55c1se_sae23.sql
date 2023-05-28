-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generated on: Sat, 27 May 2023 at 13:32
-- Server version: 5.7.33-cll-lve
-- PHP version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ku55c1se_sae23`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration`
--
CREATE TABLE `administration` (
  `user` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administration`
--
INSERT INTO `administration` (`user`, `password`) VALUES
('Sebastien', 'Patoche');

-- --------------------------------------------------------

--
-- Table structure for table `batiment`
--
CREATE TABLE `batiment` (
  `id_batiment` int(1) NOT NULL,
  `nom_bat` varchar(1) NOT NULL,
  `login_gest` varchar(50) NOT NULL,
  `mdp_gest` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `capteur`
--
CREATE TABLE `capteur` (
  `id_capteur` varchar(16) NOT NULL,
  `nom_capteur` varchar(9) NOT NULL,
  `type_capteur` varchar(20) NOT NULL,
  `Salle` varchar(4) NOT NULL,
  `id_batiment` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mesure`
--
CREATE TABLE `mesure` (
  `id_mesure` int(10) NOT NULL,
  `date_mesure` varchar(20) NOT NULL,
  `valeur_mesure` varchar(10) NOT NULL,
  `id_capteur` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- insert data into the table batiment
--
INSERT INTO batiment (id_batiment, nom_bat, login_gest, mdp_gest)
VALUES
    ('1', 'A', 'Ange', 'Ange'),
    ('2', 'B', 'Pierre', 'Pierre'),
    ('3', 'C', 'Sylvio', 'Sylvio'),
    ('4', 'D', 'Gaspard', 'Gaspard'),
    ('5', 'E', 'Gael', 'Gael');

--
-- insert data into the capteur table 
--
INSERT INTO capteur (id_capteur, nom_capteur, type_capteur, Salle, id_batiment)
VALUES
    ('24e124128c012259', 'AM107-7', 'CO2', 'B001', '2'),
    ('24e124128c011778', 'AM107-6', 'Humidity', 'B203', '2'),
    ('24e124128c016509', 'AM107-29', 'CO2

', 'E006', '5'),
    ('24e124128c016122', 'AM107-32', 'Humidity', 'E102', '5');
    


--
-- Indexes for table `batiment`
--
ALTER TABLE `batiment`
  ADD PRIMARY KEY (`id_batiment`);

--
-- Indexes for table `capteur`
--
ALTER TABLE `capteur`
  ADD PRIMARY KEY (`id_capteur`),
  ADD KEY `id_batiment` (`id_batiment`);

--
-- Indexes for table `mesure`
--
ALTER TABLE `mesure`
  ADD PRIMARY KEY (`id_mesure`),
  ADD KEY `id_capteur` (`id_capteur`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batiment`
--
ALTER TABLE `batiment`
  MODIFY `id_batiment` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mesure`
--
ALTER TABLE `mesure`
  MODIFY `id_mesure` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for table `capteur`
--
ALTER TABLE `capteur`
  ADD CONSTRAINT `capteur_ibfk_1` FOREIGN KEY (`id_batiment`) REFERENCES `batiment` (`id_batiment`);

--
-- Constraints for table `mesure`
--
ALTER TABLE `mesure`
  ADD CONSTRAINT `mesure_ibfk_1` FOREIGN KEY (`id_capteur`) REFERENCES `capteur` (`id_capteur`),
  ADD CONSTRAINT `mesure_ibfk_2` FOREIGN KEY (`id_capteur`) REFERENCES `capteur` (`id_capteur`);
COMMIT;




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
