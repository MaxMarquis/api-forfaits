-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  sam. 05 fév. 2022 à 20:51
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet-2-forfaits`
--

-- --------------------------------------------------------

--
-- Structure de la table `forfaits`
--

CREATE TABLE `forfaits` (
  `id` int(11) NOT NULL,
  `destination` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `villeDepart` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `coordonnees` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `nombreEtoiles` int(11) NOT NULL,
  `nombreChambres` int(11) NOT NULL,
  `caracteristiques` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `dateDepart` date NOT NULL,
  `dateRetour` date NOT NULL,
  `prix` int(11) NOT NULL,
  `rabais` int(11) NOT NULL,
  `vedette` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `forfaits`
--

INSERT INTO `forfaits` (`id`, `destination`, `villeDepart`, `nom`, `coordonnees`, `nombreEtoiles`, `nombreChambres`, `caracteristiques`, `dateDepart`, `dateRetour`, `prix`, `rabais`, `vedette`) VALUES
(1, 'Angleterre Modifié Sur Postman', 'Québec', 'Premier Hotel', '26 km de Aéroport de Heathrow - Londres', 6, 100, 'Face à la plage; Ascenseur; Miniclub', '2022-01-30', '2022-02-06', 1225, 200, 1),
(3, 'Écosse', 'Québec', 'Troisième Hotel', '42 km de Aéroport de Glasgow - Glasgow', 9, 500, 'Face à la plage; Ascenseur; Miniclub', '2022-02-20', '2022-03-06', 2500, 250, 1),
(4, 'France', 'Montréal', 'Quatrième Hotel', '16 km de Aéroport Paris‑Charles de Gaulle - Paris', 8, 197, 'Ascenseur; Miniclub', '2022-01-23', '2022-01-29', 1125, 125, 0),
(5, 'Irlande', 'Montréal', 'Cinquième Hotel', '95 km de Aéroport de Waterford - Killowen', 6, 234, 'Face à la plage; Ascenseur; Miniclub', '2022-01-29', '2022-02-06', 4231, 500, 1),
(6, 'Pays-Bas', 'Montréal', 'Sixième Hotel', '58 km de Aéroport d\'Eindhoven - Eindhoven', 9, 368, 'Face à la plage; Ascenseur; Miniclub', '2022-03-20', '2022-03-31', 3251, 450, 0),
(7, 'Cuba', 'Québec', 'Rancho Luna', 'Distance aéroport de Cienfuegos / hôtel : 20km', 6, 222, 'Piscine;Chaise longues;Centre de plongée', '2022-03-26', '2022-04-07', 525, 0, 0),
(8, 'Cuba Edit', 'Québec', 'Rancho Luna', 'Distance aéroport de Cienfuegos / hôtel : 20km', 6, 222, 'Piscine;Chaise longues;Centre de plongée', '2022-03-26', '2022-04-07', 525, 0, 0),
(9, 'Cuba', 'Québec', 'Rancho Luna', 'Distance aéroport de Cienfuegos / hôtel : 20km', 6, 222, 'Piscine;Chaise longues;Centre de plongée', '2022-03-26', '2022-04-07', 525, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `nombreAdulte` int(11) NOT NULL,
  `nombreEnfant` int(11) NOT NULL DEFAULT '0',
  `assurance` tinyint(1) NOT NULL DEFAULT '0',
  `fk_forfaits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `nombreAdulte`, `nombreEnfant`, `assurance`, `fk_forfaits`) VALUES
(1, 2, 0, 0, 7),
(2, 2, 2, 1, 4),
(3, 1, 1, 1, 3),
(4, 2, 3, 1, 9),
(5, 3, 0, 0, 7),
(6, 3, 0, 1, 8),
(7, 2, 2, 0, 6),
(8, 2, 2, 0, 6),
(9, 2, 2, 0, 6),
(10, 2, 1, 0, 7);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `forfaits`
--
ALTER TABLE `forfaits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_forfaits` (`fk_forfaits`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `forfaits`
--
ALTER TABLE `forfaits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_forfaits` FOREIGN KEY (`fk_forfaits`) REFERENCES `forfaits` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
