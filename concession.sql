-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 12 nov. 2020 à 09:22
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `concession`
--

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `ville` varchar(20) NOT NULL,
  `code_postal` int(5) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `statut` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES
(0, 'admin', '$2y$10$1rsJLpoPSwbweCGuQzAhhe6/0C4TLe8YrO3EH/pT4Q/e1FvmillB2', 'REGHIS', 'LILIA', 'lilia.reghis212@gmail.com', 'f', 'NANTERRE', 92000, '16?4, rue de l\'abbé Glatz', 1);

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id_voiture` int(11) NOT NULL,
  `marque` varchar(20) NOT NULL,
  `kilometrage` int(6) NOT NULL,
  `tarif` int(5) NOT NULL,
  `photo` varchar(250) NOT NULL,
  `fiche` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id_voiture`, `marque`, `kilometrage`, `tarif`, `photo`, `fiche`) VALUES
(1, 'Renault Megane', 12000, 25000, 'photo/fiche_1602832184.pdf', 'photo/fiche_1602841460.jpg'),
(3, 'Bmw Serie 598', 12000, 37000, 'photo/photo_1602847876.jpg', 'photo/fiche_1602832346.pdf'),
(4, 'Peugeot', 150000, 25000, 'photo/fiche_1602832914.pdf', 'photo/fiche_1602832914.pdf'),
(5, 'Renault Megane 3', 120300, 12000, 'photo/photo_1602833008.jpg', 'photo/fiche_1602841526.jpg'),
(6, 'Renault Clio', 120000, 2300, 'photo/fiche_1602833209.pdf', 'photo/fiche_1602833209.pdf'),
(7, 'Fiat 500', 120005, 25000, 'photo/fiche_1602834149.odt', 'photo/fiche_1602834149.odt'),
(10, 'Fiat 500', 1250, 12000, 'photo/photo_1602841675.jpg', ''),
(11, 'Ford M321', 13500, 13500, 'photo/photo_1602841784.png', 'photo/fiche_1602841784.odt'),
(12, 'Mercedes serie 4', 1200, 89500, 'photo/fiche_1602841955.pdf', 'photo/fiche_1602841955.pdf'),
(14, 'Citroen C3', 125000, 12000, 'photo/fiche_1603352119.png', 'photo/fiche_1603352119.png'),
(15, 'Citroen C3 Gris', 12000, 11500, 'photo/fiche_1603352176.odt', 'photo/fiche_1603352176.odt'),
(16, 'Citroen  C4', 15000, 14500, 'photo/fiche_1603352236.odt', 'photo/fiche_1603352236.odt'),
(17, 'Citroen  C4 Rouge', 15000, 14500, 'photo/fiche_1603352274.odt', 'photo/fiche_1603352274.odt'),
(18, 'Mercedes Benz', 125660, 39000, 'photo/fiche_1603352578.odt', 'photo/fiche_1603352578.odt'),
(19, 'Mercedes Classe B', 123000, 2500, 'photo/fiche_1603352621.odt', 'photo/fiche_1603352621.odt'),
(20, 'Peugeot 206', 2500, 12500, '', ''),
(21, 'Peugeot 206', 2500, 12500, '', ''),
(22, 'Fiat 500', 1200, 45000, '', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id_voiture`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id_voiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
