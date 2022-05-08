-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 09 mai 2022 à 00:51
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_etudiant`
--

-- --------------------------------------------------------

--
-- Structure de la table `absences`
--

CREATE TABLE `absences` (
  `id` int(11) NOT NULL,
  `nomMatiere` varchar(20) NOT NULL,
  `cin_Etudiant` varchar(8) CHARACTER SET latin1 NOT NULL,
  `justification` tinyint(1) NOT NULL,
  `dateAbsence` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `absences`
--

INSERT INTO `absences` (`id`, `nomMatiere`, `cin_Etudiant`, `justification`, `dateAbsence`) VALUES
(1, 'SGBD', '09858025', 0, '2022-04-25'),
(2, 'SGBD', '09858025', 0, '2022-05-16'),
(3, 'TECHWEB', '09858025', 0, '2022-04-18'),
(57, 'SGBD', '01111111', 0, '2022-05-09'),
(58, 'SGBD', '09858025', 0, '2022-05-09'),
(59, 'SGBD', '01111111', 0, '2022-05-09'),
(60, 'SGBD', '09858025', 1, '2022-05-10'),
(67, 'SGBD', '01111111', 0, '2022-06-20'),
(68, 'SGBD', '09858025', 0, '2022-06-21'),
(69, 'SGBD', '01111111', 0, '2022-07-25'),
(70, 'SGBD', '09858025', 0, '2022-07-26'),
(71, 'TECHWEB', '01111111', 0, '2022-04-25'),
(72, 'TECHWEB', '09858025', 0, '2022-04-27'),
(73, 'SGBD', '01111111', 0, '2022-04-26'),
(74, 'SGBD', '01111111', 0, '2022-04-27');

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`id`, `name`) VALUES
(3, 'INFO2-A'),
(16, 'INFO1-C'),
(17, 'INFO2-B');

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(40) NOT NULL,
  `login` varchar(40) NOT NULL,
  `pass` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `enseignant`
--

INSERT INTO `enseignant` (`id`, `date`, `nom`, `prenom`, `login`, `pass`) VALUES
(1, '2022-03-12 15:58:08', 'Saad', 'Walid', 'walid.saadd@gmail.com', '25f9e794323b453885f5181f1b624d0b'),
(2, '2022-04-28 01:15:56', 'iheb', 'laribi', 'iheb', '61fca7d67f6e4120643b876a9bc50127'),
(4, '2022-04-28 08:09:43', 'dali', 'dali', 'dali', 'f5c506bc8d1ae760a201b1a7069101e7'),
(5, '2022-04-28 23:09:56', 'aaaa', 'aaaa', 'aaaa', '74b87337454200d4d33f80c4663dc5e5'),
(6, '2022-04-30 00:58:27', 'bbbb', 'bbbb', 'bbbb', '65ba841e01d6db7733e90a5b7f9e6f80');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `cin` varchar(8) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `cpassword` varchar(40) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `adresse` text NOT NULL,
  `Classe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`cin`, `email`, `password`, `cpassword`, `nom`, `prenom`, `adresse`, `Classe`) VALUES
('01111111', 'fff@gmail.com', '25d55ad283aa400af464c76d713c07ad', '25d55ad283aa400af464c76d713c07ad', 'ghffg', 'uhyrrhry', '     kelibia', 3),
('09858025', 'iheb@gmail.com', '25d55ad283aa400af464c76d713c07ad', '25d55ad283aa400af464c76d713c07ad', 'iheb', 'laribi', '                    nabeul               ', 16);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cin_Etudiant` (`cin_Etudiant`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`cin`),
  ADD KEY `Classe` (`Classe`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_ibfk_1` FOREIGN KEY (`cin_Etudiant`) REFERENCES `etudiant` (`cin`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`Classe`) REFERENCES `classe` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
