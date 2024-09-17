-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 17 sep. 2024 à 11:33
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bibliosf5`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonne`
--

CREATE TABLE `abonne` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `adresse` longtext DEFAULT NULL,
  `naissance` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `abonne`
--

INSERT INTO `abonne` (`id`, `pseudo`, `roles`, `password`, `nom`, `prenom`, `adresse`, `naissance`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$GW7Z3YJIFOkQJp.maUDwD.h2lkdaKEtl5PF8R3SkffqXs4nT3yxtS', NULL, NULL, NULL, NULL),
(2, 'biblio0', '[\"ROLE_BIBLIO\"]', '$2y$13$zhiRqGuu0Q1ueNQK1SIFVeRSesWpyfZWscHdZm3IKPtzpK0LdXWlW', NULL, NULL, NULL, NULL),
(3, 'biblio1', '[\"ROLE_BIBLIO\"]', '$2y$13$Ddvj75dYF0ytQDGlB3U0TOEEvPve/lwQC8dQBYQtDGXqjp3.CHM0C', NULL, NULL, NULL, NULL),
(4, 'biblio2', '[\"ROLE_BIBLIO\"]', '$2y$13$xlPF95.xAu3ooeg/E20RouRXpHeHYNJKSnaaACaJ6VwMOGcV3DSi6', NULL, NULL, NULL, NULL),
(5, 'biblio3', '[\"ROLE_BIBLIO\"]', '$2y$13$CYaLqz/pZt3KioEYC/yjVunx999GqwKenzBlRmfBhv0AwRevMicDe', NULL, NULL, NULL, NULL),
(6, 'biblio4', '[\"ROLE_BIBLIO\"]', '$2y$13$OmAkINDd6qelF.0jVE8bp.oJMxqdta1Ee2V7LGS//QpRoqP9HJeEi', NULL, NULL, NULL, NULL),
(7, 'lecteur0', '[\"ROLE_LECTEUR\"]', '$2y$13$VrvC8kTwWt5dhclVH3SjyuLlq4W22jdRMZVOStNkR404CwNwcgxI.', NULL, NULL, NULL, NULL),
(8, 'lecteur1', '[\"ROLE_LECTEUR\"]', '$2y$13$JWAyZpvBu/I41qQP9yYtdO4s9RyUahCddsmOoVEcJwjQ9UbHHNHy2', NULL, NULL, NULL, NULL),
(9, 'lecteur2', '[\"ROLE_LECTEUR\"]', '$2y$13$DgaU4/cPhUGLvQeXhpjzzeEVG9Rupb6XivVHnv6KnTHeJVOyo2cIW', NULL, NULL, NULL, NULL),
(10, 'lecteur3', '[\"ROLE_LECTEUR\"]', '$2y$13$mjUMz729huQndM/MQZEfVOteYPHhQrRaj9jsGmOaqqdLq1Y600vFO', NULL, NULL, NULL, NULL),
(11, 'lecteur4', '[\"ROLE_LECTEUR\"]', '$2y$13$H00ulfG1SxZfXr.oZ0k71ukW/WFaDhAWcffsyE2q.d5WylxaxqBe2', NULL, NULL, NULL, NULL),
(12, 'lecteur5', '[\"ROLE_LECTEUR\"]', '$2y$13$gOlS0DAyybRKY6KmMM0T6Oa8B6uo3ERlNNdywNOCKCZChFFfsDvIq', NULL, NULL, NULL, NULL),
(13, 'lecteur6', '[\"ROLE_LECTEUR\"]', '$2y$13$cekdleMb8jrn.C/4G35Wguus3AJaIpOGW1WUN1RKF1C1rVy4cAyRG', NULL, NULL, NULL, NULL),
(14, 'lecteur7', '[\"ROLE_LECTEUR\"]', '$2y$13$s7Wg0iyM..tZ/IfdiCeOA.K83uX5dfO0hbuCJPPbTj0Zv.m2IzDiS', NULL, NULL, NULL, NULL),
(15, 'lecteur8', '[\"ROLE_LECTEUR\"]', '$2y$13$hNTB7iOGmgrsdVTomdK4S.sg.B1cv4uvSTCVLro/6pxkAvMDSoHYO', NULL, NULL, NULL, NULL),
(16, 'lecteur9', '[\"ROLE_LECTEUR\"]', '$2y$13$mhMKXlZLlM0Qzm/kXWMN5u3k2K/jLx5vTjuh0el.VjK3AdJsLciQ2', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

CREATE TABLE `auteur` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `biographie` longtext DEFAULT NULL,
  `naissance` date DEFAULT NULL,
  `deces` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id`, `nom`, `prenom`, `biographie`, `naissance`, `deces`) VALUES
(1, 'La Fontaine (de)', 'Jean', NULL, '1621-07-08', '1695-04-13'),
(2, 'Maupassant (de)', 'Guy', NULL, '1850-08-05', '1893-07-06'),
(3, 'Daudet', 'Alphonse', NULL, '1840-05-13', '1897-12-16'),
(4, 'Dumas', 'Alexandre', NULL, '1802-07-24', '1870-12-05'),
(5, 'Matheson', 'Richard', NULL, '1926-02-20', '2013-06-23'),
(6, 'Tolkien', 'J.R.R.', NULL, '1892-01-03', '1973-09-02'),
(7, 'Christie', 'Agatha', NULL, '1890-09-15', '1976-01-12'),
(8, 'King', 'Stephen', NULL, '1947-09-21', NULL),
(9, 'Herbert', 'Frank', NULL, '1920-10-08', '1986-02-11'),
(10, 'Asimov', 'Isaac', NULL, '1920-01-02', '1992-04-06'),
(11, 'Otomo', 'Katsuhiro', NULL, '1954-04-14', NULL),
(12, 'Boulle', 'Pierre', NULL, '1912-02-20', '1994-01-31'),
(13, 'Werber', 'Bernard', NULL, '1961-09-18', NULL),
(14, 'Orwell', 'George', NULL, '1903-06-25', '1950-01-21'),
(15, 'Kipling', 'Rudyard', NULL, '1865-12-30', '1936-01-18'),
(16, 'Homère', NULL, NULL, NULL, NULL),
(17, 'Martin', 'G.R.R.', NULL, '1948-09-20', NULL),
(18, 'Keyes', 'Daniel', NULL, '1927-08-09', '2014-06-15'),
(19, 'Hugo', 'Victor', NULL, '1802-02-26', '1885-05-22'),
(20, 'Merle', 'Robert', NULL, '1908-08-29', '2004-03-27'),
(21, 'Stendhal', NULL, NULL, '1783-01-23', '1842-03-23'),
(22, 'Simmons', 'Dan', 'Né en 1948, Dan Simmons a longtemps exercé le métier d\'enseignant avant de se consacrer enttièrement à l\'écriture, publiant une dizaine de romans, dont le célèbre Hypérion. L\'échiquier du mal, considéré comme son chef-d\'oeuvre, a obtenu pratiquement tous les prix littéraires anglo-saxons en matière de fantastique (Bram Stocker Award, Locus Award, British Fantasy Award).', NULL, NULL),
(23, 'Heinlein', 'Robert', 'Robert Anson Heinliein, né en 1097, écrivit en 1939 sa première nouvelle de science-fiction (Life-Line). Pour de nombreux critiques, il pass pour le\'auteur le plus important de l\'âge d\'or. Il détient snas doute le record des \"Hugos\" (érecmpoenses analogues aux \"Oscars\" du cinéma).\r\nOn l\'a souvent comparé à Rudyard Kipling pour la maîtrise de son art narratif. Dans une vaste fresque intitulée Histoire du Futur, écrite entre 1939 et 1967, il a entrepris de raconter l\'histoire des trois prochains siècles. L\'Homme qui vendit la lune est le premiere volume de cet ensemble', '1907-07-07', '1988-05-08'),
(24, 'Verne', 'Jules', NULL, NULL, NULL),
(25, 'Simmons', 'Dan', 'auteur', NULL, NULL),
(26, 'test', NULL, NULL, NULL, NULL),
(27, 'Simmons', 'Dan', NULL, NULL, NULL),
(28, 'Simmons', 'Dan', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `emprunt`
--

CREATE TABLE `emprunt` (
  `id` int(11) NOT NULL,
  `livre_id` int(11) NOT NULL,
  `abonne_id` int(11) NOT NULL,
  `date_emprunt` date NOT NULL,
  `date_retour` date DEFAULT NULL,
  `date_prevue` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `emprunt`
--

INSERT INTO `emprunt` (`id`, `livre_id`, `abonne_id`, `date_emprunt`, `date_retour`, `date_prevue`) VALUES
(1, 1, 7, '2023-12-04', NULL, '2023-12-18'),
(2, 3, 8, '2023-12-01', NULL, '2023-12-15');

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `mots_cles` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `libelle`, `mots_cles`) VALUES
(1, 'science-fiction', 'futur, utopie, dystopie, espace, robot'),
(2, 'fantastique', 'bizarre, magie, étrange, merveilleux');

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `id` int(11) NOT NULL,
  `auteur_id` int(11) DEFAULT NULL,
  `titre` varchar(50) NOT NULL,
  `resume` longtext DEFAULT NULL,
  `couverture` varchar(255) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id`, `auteur_id`, `titre`, `resume`, `couverture`, `url`) VALUES
(1, 10, 'Fondation et Empire', 'sdfghbsfgdhgfhfgds', 'akira-tome-166e93ac0093f5.jpg', '1-Fondation-et-Empire'),
(2, 10, 'Futurs en délire', NULL, NULL, NULL),
(3, 18, 'L\'échiquier du mal, 1', NULL, NULL, NULL),
(4, 10, 'Seconde Fondation', NULL, 'seconde-fondation6573c8a6e77d7.jpg', '4-Seconde-Fondation'),
(5, 10, 'Fondation', NULL, NULL, NULL),
(6, 10, 'L\'aube de Fondation', NULL, NULL, NULL),
(7, 10, 'Prélude à Fondation', NULL, NULL, NULL),
(8, 24, 'Deux ans de vacances', 'Préface de l\'auteur : \r\nBien des Robinsons ont déjà tenu en éveil nos jeunes lecteurs.', 'ldp2049-1976-1_65751296916e6.jpg', '8-Deux-ans-de-vacances'),
(9, 23, 'L\'homme qui vendit la Lune', NULL, 'pp5043-1979-1_65751c957c4e6.jpg', NULL),
(10, 8, 'nouveau', 'nouveau livre', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `livre_genre`
--

CREATE TABLE `livre_genre` (
  `livre_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livre_genre`
--

INSERT INTO `livre_genre` (`livre_id`, `genre_id`) VALUES
(1, 1),
(1, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `abonne`
--
ALTER TABLE `abonne`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_76328BF086CC499D` (`pseudo`);

--
-- Index pour la table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_364071D737D925CB` (`livre_id`),
  ADD KEY `IDX_364071D7C325A696` (`abonne_id`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AC634F9960BB6FE6` (`auteur_id`);

--
-- Index pour la table `livre_genre`
--
ALTER TABLE `livre_genre`
  ADD PRIMARY KEY (`livre_id`,`genre_id`),
  ADD KEY `IDX_1053AB9E37D925CB` (`livre_id`),
  ADD KEY `IDX_1053AB9E4296D31F` (`genre_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `abonne`
--
ALTER TABLE `abonne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `emprunt`
--
ALTER TABLE `emprunt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `livre`
--
ALTER TABLE `livre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `FK_364071D737D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`),
  ADD CONSTRAINT `FK_364071D7C325A696` FOREIGN KEY (`abonne_id`) REFERENCES `abonne` (`id`);

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `FK_AC634F9960BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`id`);

--
-- Contraintes pour la table `livre_genre`
--
ALTER TABLE `livre_genre`
  ADD CONSTRAINT `FK_1053AB9E37D925CB` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1053AB9E4296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
