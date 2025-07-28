-- phpMyAdmin SQL Dump
-- version 4.6.6deb4+deb9u2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Ven 18 Juillet 2025 à 12:52
-- Version du serveur :  10.1.48-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-47+0~20210223.51+debian9~1.gbp7f60a9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `c127vogel`
--

-- --------------------------------------------------------

--
-- Structure de la table `carry_out`
--

CREATE TABLE `carry_out` (
  `id_project` int(11) NOT NULL,
  `id_team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id_category`, `name`) VALUES
(3, 'context'),
(1, 'notification'),
(2, 'objective'),
(4, 'stage'),
(5, 'state');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id_paper_2` int(11) NOT NULL,
  `id_paper` int(11) NOT NULL,
  `id_paper_1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `evaluate`
--

CREATE TABLE `evaluate` (
  `id_user` int(11) NOT NULL,
  `id_paper` int(11) NOT NULL,
  `score` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `is_identified_with`
--

CREATE TABLE `is_identified_with` (
  `id_tag` int(11) NOT NULL,
  `id_paper` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `is_member`
--

CREATE TABLE `is_member` (
  `id_user` int(11) NOT NULL,
  `id_team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_paper` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `is_outdated` tinyint(4) NOT NULL,
  `overview` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `paper`
--

CREATE TABLE `paper` (
  `id_paper` int(11) NOT NULL,
  `content` varchar(2000) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(50) DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

CREATE TABLE `project` (
  `id_project` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `id_tag` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tag`
--

INSERT INTO `tag` (`id_tag`, `name`, `id_category`) VALUES
(1, 'luc_sembourg', 1),
(2, 'tom_bellachemiz', 1),
(3, 'melusine_engraiv', 1),
(4, 'tanguy_dondevelo', 1),
(5, 'jenny_fraireniseur', 1),
(6, 'medhi_khaman', 1);

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `id_task` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `id_project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE `team` (
  `id_team` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `working_on`
--

CREATE TABLE `working_on` (
  `id_user` int(11) NOT NULL,
  `id_task` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `_user`
--

CREATE TABLE `_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `_user`
--

INSERT INTO `_user` (`id_user`, `username`, `first_name`, `last_name`, `password`) VALUES
(6, 'luc_sembourg', 'Luc', 'Sembourg', 'pognon'),
(7, 'tom_bellachemiz', 'Tom', 'béllachemiz', 'mariage'),
(8, 'melusine_engraiv', 'Mélusine', 'Engraiv', 'cgt'),
(9, 'tanguy_dondevelo', 'Tanguy', 'Don Develo', 'bicyclette'),
(10, 'jenny_fraireniseur', 'Jenny', 'Fraireniseur', 'solo'),
(11, 'medhi_khaman', 'Mehdi', 'Khaman', 'doliprane');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `carry_out`
--
ALTER TABLE `carry_out`
  ADD PRIMARY KEY (`id_project`,`id_team`),
  ADD KEY `id_team` (`id_team`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_paper_2`),
  ADD KEY `id_paper` (`id_paper`),
  ADD KEY `id_paper_1` (`id_paper_1`);

--
-- Index pour la table `evaluate`
--
ALTER TABLE `evaluate`
  ADD PRIMARY KEY (`id_user`,`id_paper`),
  ADD KEY `id_paper` (`id_paper`);

--
-- Index pour la table `is_identified_with`
--
ALTER TABLE `is_identified_with`
  ADD PRIMARY KEY (`id_tag`,`id_paper`),
  ADD KEY `id_paper` (`id_paper`);

--
-- Index pour la table `is_member`
--
ALTER TABLE `is_member`
  ADD PRIMARY KEY (`id_user`,`id_team`),
  ADD KEY `id_team` (`id_team`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_paper`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Index pour la table `paper`
--
ALTER TABLE `paper`
  ADD PRIMARY KEY (`id_paper`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id_project`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id_tag`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `id_category` (`id_category`);

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id_task`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `id_project` (`id_project`);

--
-- Index pour la table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id_team`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `working_on`
--
ALTER TABLE `working_on`
  ADD PRIMARY KEY (`id_user`,`id_task`),
  ADD KEY `id_task` (`id_task`);

--
-- Index pour la table `_user`
--
ALTER TABLE `_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `paper`
--
ALTER TABLE `paper`
  MODIFY `id_paper` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `id_project` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `team`
--
ALTER TABLE `team`
  MODIFY `id_team` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `_user`
--
ALTER TABLE `_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `carry_out`
--
ALTER TABLE `carry_out`
  ADD CONSTRAINT `carry_out_ibfk_1` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`),
  ADD CONSTRAINT `carry_out_ibfk_2` FOREIGN KEY (`id_team`) REFERENCES `team` (`id_team`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_paper_2`) REFERENCES `paper` (`id_paper`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_paper`) REFERENCES `comment` (`id_paper_2`),
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`id_paper_1`) REFERENCES `note` (`id_paper`);

--
-- Contraintes pour la table `evaluate`
--
ALTER TABLE `evaluate`
  ADD CONSTRAINT `evaluate_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `_user` (`id_user`),
  ADD CONSTRAINT `evaluate_ibfk_2` FOREIGN KEY (`id_paper`) REFERENCES `paper` (`id_paper`);

--
-- Contraintes pour la table `is_identified_with`
--
ALTER TABLE `is_identified_with`
  ADD CONSTRAINT `is_identified_with_ibfk_1` FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id_tag`),
  ADD CONSTRAINT `is_identified_with_ibfk_2` FOREIGN KEY (`id_paper`) REFERENCES `paper` (`id_paper`);

--
-- Contraintes pour la table `is_member`
--
ALTER TABLE `is_member`
  ADD CONSTRAINT `is_member_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `_user` (`id_user`),
  ADD CONSTRAINT `is_member_ibfk_2` FOREIGN KEY (`id_team`) REFERENCES `team` (`id_team`);

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`id_paper`) REFERENCES `paper` (`id_paper`);

--
-- Contraintes pour la table `paper`
--
ALTER TABLE `paper`
  ADD CONSTRAINT `paper_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `_user` (`id_user`);

--
-- Contraintes pour la table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`);

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`);

--
-- Contraintes pour la table `working_on`
--
ALTER TABLE `working_on`
  ADD CONSTRAINT `working_on_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `_user` (`id_user`),
  ADD CONSTRAINT `working_on_ibfk_2` FOREIGN KEY (`id_task`) REFERENCES `task` (`id_task`);

--
-- Contraintes pour la table `_user`
--
ALTER TABLE `_user`
  ADD CONSTRAINT `_user_ibfk_1` FOREIGN KEY (`username`) REFERENCES `tag` (`name`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
