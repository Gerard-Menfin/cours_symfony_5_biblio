-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 12 avr. 2022 à 20:21
-- Version du serveur :  10.4.16-MariaDB
-- Version de PHP : 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `coursbibliosf5`
--

--
-- Déchargement des données de la table `auteur`
--

INSERT INTO `auteur` (`id`, `nom`, `prenom`, `biographie`) VALUES
(1, 'nom0', 'prenom0', NULL),
(2, 'nom1', 'prenom1', NULL),
(3, 'nom2', 'prenom2', NULL),
(4, 'nom3', 'prenom3', NULL),
(5, 'nom4', 'prenom4', NULL),
(6, 'nom5', 'prenom5', NULL),
(7, 'nom6', 'prenom6', NULL),
(8, 'nom7', 'prenom7', NULL),
(9, 'nom8', 'prenom8', NULL),
(10, 'nom9', 'prenom9', NULL);


--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id`, `titre`, `couverture`, `url`, `auteur_id`, `resume`) VALUES
(1, '1984', 'couverture0.jpg', NULL, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(2, 'titre 1', 'couverture1.jpg', NULL, 6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(3, 'titre 2', 'couverture2.jpg', NULL, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(4, 'titre 3', 'couverture3.jpg', NULL, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(5, 'titre 4', 'couverture4.jpg', NULL, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(6, 'titre 5', 'couverture5.jpg', NULL, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(7, 'titre 6', 'couverture6.jpg', NULL, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(8, 'titre 7', 'couverture7.jpg', NULL, 10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(9, 'titre 8', 'couverture8.jpg', NULL, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(10, 'titre 9', 'couverture9.jpg', NULL, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(11, 'titre 10', 'couverture10.jpg', NULL, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(12, 'titre 11', 'couverture11.jpg', NULL, 6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(13, 'titre 12', 'couverture12.jpg', NULL, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(14, 'titre 13', 'couverture13.jpg', NULL, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(15, 'titre 14', 'couverture14.jpg', NULL, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(16, 'titre 15', 'couverture15.jpg', NULL, 9, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(17, 'titre 16', 'couverture16.jpg', NULL, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(18, 'Le jour des fourmis', 'couverture17.jpg', NULL, 6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(19, 'titre 18', 'couverture18.jpg', NULL, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(20, 'titre 19', 'couverture19.jpg', NULL, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(21, 'titre 20', 'couverture20.jpg', NULL, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(22, 'titre 21', 'couverture21.jpg', NULL, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(23, 'titre 22', 'couverture22.jpg', NULL, 9, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(24, 'titre 23', 'couverture23.jpg', NULL, 6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(25, 'titre 24', 'couverture24.jpg', NULL, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(26, 'titre 25', 'couverture25.jpg', NULL, 7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(27, 'titre 26', 'couverture26.jpg', NULL, 9, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(28, 'titre 27', 'couverture27.jpg', NULL, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(29, 'titre 28', 'couverture28.jpg', NULL, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(30, 'titre 29', 'couverture29.jpg', NULL, 7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(31, 'titre 30', 'couverture30.jpg', NULL, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(32, 'titre 31', 'couverture31.jpg', NULL, 7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(33, 'titre 32', 'couverture32.jpg', NULL, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(34, 'titre 33', 'couverture33.jpg', NULL, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(35, 'titre 34', 'couverture34.jpg', NULL, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(36, 'titre 35', 'couverture35.jpg', NULL, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(37, 'titre 36', 'couverture36.jpg', NULL, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(38, 'titre 37', 'couverture37.jpg', NULL, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(39, 'titre 38', 'couverture38.jpg', NULL, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(40, 'titre 39', 'couverture39.jpg', NULL, 10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(41, 'titre 40', 'couverture40.jpg', NULL, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(42, 'titre 41', 'couverture41.jpg', NULL, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(43, 'titre 42', 'couverture42.jpg', NULL, 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(44, 'titre 43', 'couverture43.jpg', NULL, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(45, 'titre 44', 'couverture44.jpg', NULL, 10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(46, 'titre 45', 'couverture45.jpg', NULL, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(47, 'titre 46', 'couverture46.jpg', NULL, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(48, 'titre 47', 'couverture47.jpg', NULL, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(49, 'titre 48', 'couverture48.jpg', NULL, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum'),
(50, 'titre 49', 'couverture49.jpg', NULL, 4, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum');

--
-- Déchargement des données de la table `abonne`
--

INSERT INTO `abonne` (`id`, `pseudo`, `roles`, `password`, `nom`, `prenom`, `adresse`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$ICSmlhGfBzSG.T0n01w90e9sk8Gt5.VmUsxkB35AGRq.qr2erFbd.', NULL, NULL, NULL),
(2, 'biblio0', '[\"ROLE_BIBLIO\"]', '$2y$13$zhiRqGuu0Q1ueNQK1SIFVeRSesWpyfZWscHdZm3IKPtzpK0LdXWlW', NULL, NULL, NULL),
(3, 'biblio1', '[\"ROLE_BIBLIO\"]', '$2y$13$Ddvj75dYF0ytQDGlB3U0TOEEvPve/lwQC8dQBYQtDGXqjp3.CHM0C', NULL, NULL, NULL),
(4, 'biblio2', '[\"ROLE_BIBLIO\"]', '$2y$13$xlPF95.xAu3ooeg/E20RouRXpHeHYNJKSnaaACaJ6VwMOGcV3DSi6', NULL, NULL, NULL),
(5, 'biblio3', '[\"ROLE_BIBLIO\"]', '$2y$13$CYaLqz/pZt3KioEYC/yjVunx999GqwKenzBlRmfBhv0AwRevMicDe', NULL, NULL, NULL),
(6, 'biblio4', '[\"ROLE_BIBLIO\"]', '$2y$13$OmAkINDd6qelF.0jVE8bp.oJMxqdta1Ee2V7LGS//QpRoqP9HJeEi', NULL, NULL, NULL),
(7, 'lecteur0', '[\"ROLE_LECTEUR\"]', '$2y$13$VrvC8kTwWt5dhclVH3SjyuLlq4W22jdRMZVOStNkR404CwNwcgxI.', NULL, NULL, NULL),
(8, 'lecteur1', '[\"ROLE_LECTEUR\"]', '$2y$13$JWAyZpvBu/I41qQP9yYtdO4s9RyUahCddsmOoVEcJwjQ9UbHHNHy2', NULL, NULL, NULL),
(9, 'lecteur2', '[\"ROLE_LECTEUR\"]', '$2y$13$DgaU4/cPhUGLvQeXhpjzzeEVG9Rupb6XivVHnv6KnTHeJVOyo2cIW', NULL, NULL, NULL),
(10, 'lecteur3', '[\"ROLE_LECTEUR\"]', '$2y$13$mjUMz729huQndM/MQZEfVOteYPHhQrRaj9jsGmOaqqdLq1Y600vFO', NULL, NULL, NULL),
(11, 'lecteur4', '[\"ROLE_LECTEUR\"]', '$2y$13$H00ulfG1SxZfXr.oZ0k71ukW/WFaDhAWcffsyE2q.d5WylxaxqBe2', NULL, NULL, NULL),
(12, 'lecteur5', '[\"ROLE_LECTEUR\"]', '$2y$13$gOlS0DAyybRKY6KmMM0T6Oa8B6uo3ERlNNdywNOCKCZChFFfsDvIq', NULL, NULL, NULL),
(13, 'lecteur6', '[\"ROLE_LECTEUR\"]', '$2y$13$cekdleMb8jrn.C/4G35Wguus3AJaIpOGW1WUN1RKF1C1rVy4cAyRG', NULL, NULL, NULL),
(14, 'lecteur7', '[\"ROLE_LECTEUR\"]', '$2y$13$s7Wg0iyM..tZ/IfdiCeOA.K83uX5dfO0hbuCJPPbTj0Zv.m2IzDiS', NULL, NULL, NULL),
(15, 'lecteur8', '[\"ROLE_LECTEUR\"]', '$2y$13$hNTB7iOGmgrsdVTomdK4S.sg.B1cv4uvSTCVLro/6pxkAvMDSoHYO', NULL, NULL, NULL),
(16, 'lecteur9', '[\"ROLE_LECTEUR\"]', '$2y$13$mhMKXlZLlM0Qzm/kXWMN5u3k2K/jLx5vTjuh0el.VjK3AdJsLciQ2', NULL, NULL, NULL);

--
-- Déchargement des données de la table `emprunt`
--

INSERT INTO `emprunt` (`id`, `livre_id`, `abonne_id`, `date_emprunt`, `date_retour`) VALUES
(1, 6, 8, '2021-12-01', '2021-12-16'),
(2, 2, 7, '2021-12-01', '2021-12-16'),
(3, 17, 7, '2021-12-16', NULL),
(4, 1, 7, '2021-12-16', NULL),
(5, 1, 7, '2021-12-16', '2021-12-16'),
(6, 18, 7, '2021-12-16', '2021-12-16'),
(7, 18, 7, '2021-12-16', '2021-12-16'),
(8, 18, 7, '2021-12-16', '2021-12-16'),
(9, 18, 7, '2021-12-16', '2021-12-16'),
(10, 18, 7, '2021-12-16', NULL),
(11, 34, 7, '2021-12-16', NULL),
(12, 19, 7, '2021-12-17', NULL),
(13, 35, 7, '2021-12-17', NULL),
(14, 4, 9, '2021-12-17', NULL),
(15, 36, 7, '2021-12-17', NULL);

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `libelle`, `mots_cles`) VALUES
(1, 'Libelle 0', NULL),
(2, 'Libelle 1', NULL),
(3, 'Libelle 2', NULL),
(4, 'Libelle 3', NULL),
(5, 'Libelle 4', NULL),
(6, 'Libelle 5', NULL);

--
-- Déchargement des données de la table `livre_genre`
--

INSERT INTO `livre_genre` (`livre_id`, `genre_id`) VALUES
(1, 4),
(1, 5),
(2, 3),
(2, 4),
(3, 3),
(3, 5),
(4, 1),
(4, 4),
(5, 3),
(5, 5),
(5, 6),
(6, 1),
(6, 5),
(6, 6),
(7, 4),
(7, 6),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(9, 2),
(9, 4),
(9, 5),
(10, 1),
(10, 2),
(10, 3),
(10, 6),
(11, 2),
(11, 5),
(12, 1),
(12, 6),
(13, 4),
(14, 1),
(14, 4),
(14, 5),
(15, 5),
(16, 1),
(16, 6),
(17, 1),
(17, 4),
(18, 3),
(19, 2),
(19, 3),
(19, 6),
(20, 2),
(20, 4),
(21, 4),
(21, 5),
(22, 4),
(23, 1),
(23, 2),
(23, 6),
(24, 2),
(24, 4),
(24, 6),
(25, 1),
(25, 2),
(26, 1),
(26, 3),
(26, 4),
(27, 1),
(27, 2),
(27, 3),
(27, 4),
(28, 4),
(28, 6),
(29, 1),
(29, 5),
(29, 6),
(30, 4),
(30, 5),
(31, 4),
(32, 3),
(32, 4),
(32, 5),
(33, 3),
(33, 5),
(34, 1),
(34, 2),
(35, 2),
(35, 3),
(36, 2),
(36, 5),
(37, 1),
(37, 3),
(37, 4),
(38, 1),
(38, 3),
(38, 4),
(39, 3),
(39, 4),
(39, 5),
(40, 2),
(40, 6),
(41, 3),
(41, 4),
(41, 6),
(42, 3),
(42, 5),
(43, 6),
(44, 6),
(45, 1),
(45, 4),
(46, 1),
(46, 3),
(47, 2),
(47, 3),
(48, 1),
(48, 2),
(48, 5),
(48, 6),
(49, 6),
(50, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
