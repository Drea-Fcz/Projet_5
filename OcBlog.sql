-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : sam. 09 avr. 2022 à 15:57
-- Version du serveur : 5.7.34
-- Version de PHP : 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `OcBlog`
--
CREATE DATABASE IF NOT EXISTS `OcBlog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `OcBlog`;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` longtext NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` tinyint(1) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `fk_commentaire_post1_idx` (`post_id`),
  KEY `fk_commentaire_author` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapo` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT 'blogDefault.webp',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `chapo`, `title`, `user_id`, `body`, `img`, `created_at`) VALUES
(41, 'PHP', 'New features of PHP 8 planned for late 2020', 27, 'New features of PHP 8 expected by the end of 2020\nPHP 8, the next major version of PHP, is expected to be released by the end of 2020.\n\nA lot of development is currently underway, so it is to be assumed that there will be some nice new features. \n\nIn this article, discover a list of the changes expected in the next version: new features, performance improvements, radical changes. \n\nYou can also learn more about the impact these changes may have on your code. \n\nRead more in this technical watch from stitcher.io. \n\nTranslated with www.DeepL.com/Translator (free version)', 'php8.png', '2022-02-04 12:19:04'),
(42, 'Symfony', 'Develop your website with Symfony', 27, 'Do you develop websites regularly and are you tired of reinventing the wheel? Would you like to use the best practices of PHP development to design professional quality websites?\n\nThis course will allow you to get to grips with Symfony, the reference PHP framework. Why use a framework? How to create a new website project with Symfony, set up test and production environments, design controllers, templates, manage translation and communicate with a database via Doctrine?\n\nAlexandre Bacco will show you throughout this course how this powerful framework, supported by a large community, will make you more efficient. Fabien Potencier, Symfony\'s creator, will introduce each chapter with a video explaining the main points covered.\n\nThis course, written by Alexandre Bacco, was designed jointly by SensioLabs, Symfony\'s publisher, and OpenClassrooms. A certificate of completion of the course will be issued by SensioLabs and OpenClassrooms for students who successfully complete all the exercises.\n\nTranslated with www.DeepL.com/Translator (free version)', 'symfony.jpeg', '2022-02-04 13:05:24'),
(43, 'Blockchain', 'Understanding blockchain in 5 minutes', 27, 'Blockchain explained simply\nIn this technical watch, find out what blockchain is, according to jesuisundev.com: \"Blockchain is a technology for storing and exchanging digital data that is decentralised and unforgeable. \".\n\nAlways with an offbeat tone, the author explains the concept of blockchain in a simple way, which may seem complicated at first. \n\nYou will finally be able to understand what blockchain is, how it works and why it has gained so much ground in recent years.  \n\nTranslated with www.DeepL.com/Translator (free version)', 'blockchain.jpeg', '2022-02-04 15:40:40'),
(48, 'What is Twig ?', 'Dynamise your views with Twig', 27, 'Twig is a template engine developed in PHP and included by default with the Symfony 4 framework.\n\nBut PHP is already a template engine: why should we use and learn an additional template engine?\n\nThe PHP language that was a template engine in its early days has now become a full-featured language capable of supporting object, functional and imperative programming.\n\nThe main interest of a template engine is to separate the logic from its representation. Using PHP, how do we define what is logic and what is representation?\n\nYet we still need some dynamic code to integrate web pages:\n\nto loop over a list of items ;\n\nto be able to display a portion of code according to a condition ;\n\nor format a date according to the local date used by the site visitor...\n\nHere\'s why Twig is more suitable than PHP as a template engine:\n\nit has a much more concise and clear syntax;\n\nby default, it supports many useful features, such as inheritance;\n\nand it automatically secures your variables.', 'twig.jpg', '2022-02-04 15:55:33');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(255) NOT NULL DEFAULT '["ROLE_USER"]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(27, 'Audrey', 'fcz.audrey@gmail.com', '$2y$10$/cnj3ImBBObQ6lhj5fcpeuWhLg2DS.QScECBMSmNQqaFkfHSgqn.W', '2022-03-11 09:56:14', '[\"ROLE_ADMIN\"]'),
(28, 'Cassie', 'fcz.cassie@gmail.com', '$2y$10$/cnj3ImBBObQ6lhj5fcpeuWhLg2DS.QScECBMSmNQqaFkfHSgqn.W', '2022-03-11 09:56:14', '[\"ROLE_USER\"]');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
