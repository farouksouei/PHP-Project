-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 29 mai 2022 à 01:26
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
-- Base de données : `sun_motors`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce_matriel`
--

CREATE TABLE `annonce_matriel` (
  `id` int(12) NOT NULL,
  `id_user` int(12) NOT NULL,
  `type` varchar(15) NOT NULL,
  `description` varchar(254) NOT NULL,
  `condition_matriel` varchar(15) NOT NULL,
  `price` int(12) NOT NULL,
  `photo_matriel` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `annonce_voiture`
--

CREATE TABLE `annonce_voiture` (
  `id` int(12) NOT NULL,
  `id_user` int(12) NOT NULL,
  `manifacturer` varchar(25) NOT NULL,
  `nombre_cylindre` int(2) NOT NULL,
  `condition_voiture` varchar(15) NOT NULL,
  `kilometrage` int(10) NOT NULL,
  `litre` varchar(10) NOT NULL,
  `couple` int(4) NOT NULL,
  `photo` varchar(70) NOT NULL,
  `description` varchar(254) NOT NULL,
  `price` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `date_creation` date NOT NULL DEFAULT current_timestamp(),
  `photo_de_profil` varchar(70) NOT NULL,
  `numero` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `location` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `date_creation`, `photo_de_profil`, `numero`, `password`, `location`) VALUES
(1, 'hazem', 'hazemkalifa@gmail.com', '2022-05-24', 'test.jpg', 23451450, 'aaaaaaaa', 'zarzis'),
(15, 'farouk', 'farouksouei@gmail.com', '2022-05-24', '628d3a8a0fe795.16588268.jpg', 2147483647, 'Zla7indaf', 'RUe bahr joua');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce_matriel`
--
ALTER TABLE `annonce_matriel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_matriel` (`id_user`);

--
-- Index pour la table `annonce_voiture`
--
ALTER TABLE `annonce_voiture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_annonce` (`id_user`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce_matriel`
--
ALTER TABLE `annonce_matriel`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `annonce_voiture`
--
ALTER TABLE `annonce_voiture`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce_matriel`
--
ALTER TABLE `annonce_matriel`
  ADD CONSTRAINT `user_matriel` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `annonce_voiture`
--
ALTER TABLE `annonce_voiture`
  ADD CONSTRAINT `user_annonce` FOREIGN KEY (`id_user`) REFERENCES `annonce_voiture` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
