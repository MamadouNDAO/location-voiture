-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 04 juil. 2022 à 00:38
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
-- Base de données : `voiture`
--

-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

CREATE TABLE `demande` (
  `id` int(11) NOT NULL,
  `voiture_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220701173321', '2022-07-01 19:33:42', 2029),
('DoctrineMigrations\\Version20220701173942', '2022-07-01 19:39:54', 1029),
('DoctrineMigrations\\Version20220701174533', '2022-07-01 19:45:38', 3669),
('DoctrineMigrations\\Version20220701175225', '2022-07-01 19:52:58', 4473),
('DoctrineMigrations\\Version20220703161004', '2022-07-03 18:10:16', 714);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_voiture`
--

CREATE TABLE `type_voiture` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_voiture`
--

INSERT INTO `type_voiture` (`id`, `libelle`) VALUES
(1, 'particuler'),
(2, 'bus');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `prenom`, `nom`, `telephone`, `photo`) VALUES
(1, 'apptaxi_taxi@mykritek.eu', '[\"ROLE_ADMIN\"]', '$2y$13$N9WGiVPXs8PWZ5BOyqcNsugaujwnIrhgBFijEfj//CCSnh/vxOcZK', 'Mamadou', 'Ndao', '+221 0785824772', 'https://127.0.0.1:8000/uploads/women-guc-62c1b324e9dff.png'),
(2, 'mari@mail.sn', '[\"ROLE_ADMIN\"]', '$2y$13$.yFV5CzhtGnxxmtH1VeBrOLxGUdjRSAwokug9BUQsKmOAo4wNXbN.', 'Marie', 'Anne', '771234567', 'https://127.0.0.1:8000/uploads/women-guc-62c1b324e9dff.png'),
(3, 'anta@mail.sn', '[\"ROLE_ADMIN\"]', '$2y$13$q0ce5r3WhGIO7DwrQgr3yuS6MV6xpVCpyKGN5VJj5RytdXLRskWzO', 'Anta', 'Diop', '772222222', 'https://127.0.0.1:8000/uploads/smiling-woman-writing-notes-on-tablet-digital-device-62c213ced2e6c.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` int(11) NOT NULL,
  `is_disponible` tinyint(1) NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_voiture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id`, `libelle`, `marque`, `matricule`, `prix`, `is_disponible`, `photo`, `type_voiture`) VALUES
(1, 'Toyota', 'Toyota 2018', 'DK00123A', 20000, 1, 'https://127.0.0.1:8000/uploads/RENAULT-CLIOcopiacopia-1-62c1c7967a865.png', 'Particulier'),
(2, 'Hyundai', 'Hyundai 2020', 'DK00122B', 60000, 1, 'https://127.0.0.1:8000/uploads/hyundai-ix-35-62c1c99329cb7.jpg', 'Particulier Climatisé'),
(3, 'Mercedes', 'Mercedes Benz', 'DK333B', 30000, 1, 'https://127.0.0.1:8000/uploads/SUVEconomiqueAutoEA-62c2173e22607.jpg', 'Particulier Climatisé'),
(4, 'Ford', 'Ford Scape 2014', 'TH0123A', 35000, 1, 'https://127.0.0.1:8000/uploads/greek-ecocars-IGMR-HYUNDAI-TUCSON-62c2176f8a028.jpg', 'Particulier Climatisé'),
(5, 'Bus', 'Bus 32 places', 'DK744BA', 45000, 1, 'https://127.0.0.1:8000/uploads/459-4592768-the-toyota-coaster-is-one-of-the-larger-62c2179fa50a3.png', 'bus'),
(6, 'Bus', 'Bus 60 places', 'DK999N', 50000, 1, 'https://127.0.0.1:8000/uploads/6928-62c217cc0c11f.png', 'bus');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `demande`
--
ALTER TABLE `demande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2694D7A5181A8BA` (`voiture_id`),
  ADD KEY `IDX_2694D7A519EB6921` (`client_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `type_voiture`
--
ALTER TABLE `type_voiture`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `demande`
--
ALTER TABLE `demande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_voiture`
--
ALTER TABLE `type_voiture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `demande`
--
ALTER TABLE `demande`
  ADD CONSTRAINT `FK_2694D7A5181A8BA` FOREIGN KEY (`voiture_id`) REFERENCES `voiture` (`id`),
  ADD CONSTRAINT `FK_2694D7A519EB6921` FOREIGN KEY (`client_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
