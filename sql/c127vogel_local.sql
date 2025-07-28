-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 juil. 2025 à 08:36
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `c127vogel`
--

-- --------------------------------------------------------

--
-- Structure de la table `carry_out`
--

DROP TABLE IF EXISTS `carry_out`;
CREATE TABLE IF NOT EXISTS `carry_out` (
  `id_project` int NOT NULL,
  `id_team` int NOT NULL,
  PRIMARY KEY (`id_project`,`id_team`),
  KEY `id_team` (`id_team`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `carry_out`
--

INSERT INTO `carry_out` (`id_project`, `id_team`) VALUES
(1, 1),
(2, 2),
(1, 3),
(4, 3),
(1, 4),
(3, 5),
(3, 6),
(4, 6);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id_category`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_category`, `name`) VALUES
(3, 'context'),
(1, 'notification'),
(2, 'objective'),
(4, 'stage'),
(5, 'state');

-- --------------------------------------------------------

--
-- Structure de la table `evaluate`
--

DROP TABLE IF EXISTS `evaluate`;
CREATE TABLE IF NOT EXISTS `evaluate` (
  `id_user` int NOT NULL,
  `id_paper` int NOT NULL,
  `score` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_user`,`id_paper`),
  KEY `id_paper` (`id_paper`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `is_identified_with`
--

DROP TABLE IF EXISTS `is_identified_with`;
CREATE TABLE IF NOT EXISTS `is_identified_with` (
  `id_tag` int NOT NULL,
  `id_paper` int NOT NULL,
  PRIMARY KEY (`id_tag`,`id_paper`),
  KEY `id_paper` (`id_paper`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `is_member`
--

DROP TABLE IF EXISTS `is_member`;
CREATE TABLE IF NOT EXISTS `is_member` (
  `id_user` int NOT NULL,
  `id_team` int NOT NULL,
  PRIMARY KEY (`id_user`,`id_team`),
  KEY `id_team` (`id_team`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `is_member`
--

INSERT INTO `is_member` (`id_user`, `id_team`) VALUES
(6, 1),
(14, 1),
(8, 2),
(9, 2),
(11, 2),
(12, 3),
(13, 3),
(15, 3),
(17, 3),
(7, 4),
(8, 4),
(18, 4),
(19, 4),
(7, 5),
(10, 5),
(13, 5),
(14, 5),
(19, 5),
(9, 6),
(11, 6),
(12, 6),
(14, 6),
(15, 6),
(16, 6);

-- --------------------------------------------------------

--
-- Structure de la table `paper`
--

DROP TABLE IF EXISTS `paper`;
CREATE TABLE IF NOT EXISTS `paper` (
  `id_paper` int NOT NULL AUTO_INCREMENT,
  `paper_type` enum('note','comment') NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `overview` text,
  `is_outdated` tinyint(1) DEFAULT '0',
  `parent_id` int DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `edit_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `edited_by` int DEFAULT NULL,
  PRIMARY KEY (`id_paper`),
  UNIQUE KEY `title` (`title`),
  KEY `idx_parent` (`parent_id`),
  KEY `idx_type_parent` (`paper_type`,`parent_id`),
  KEY `idx_created_by` (`created_by`),
  KEY `fk_paper_edited_by` (`edited_by`)
) ;

--
-- Déchargement des données de la table `paper`
--

INSERT INTO `paper` (`id_paper`, `paper_type`, `title`, `content`, `overview`, `is_outdated`, `parent_id`, `creation_date`, `created_by`, `edit_date`, `edited_by`) VALUES
(1, 'note', 'Ajouter un calendrier de l\'avent sur notre page d\'accueil', 'J\'ai eu cette idée pour l\'amélioration de l\'attractivité de notre page web : avec la décoration de fin d\'année, pourquoi ne pas proposer quelque chose de changeant chaque jour, du 1er au 25 Décembre, voire jusqu\'au 31 ? Cela pourrait être seulement de la décoration changeante ou un élément qui se construit petit à petit. Une case à ouvrir avec un élément sympa à découvrir, sur le produit et/ou l\'équipe. L\'idée peut être assez vaste : j\'aimerais savoir si cela vous semble cohérent, et éventuellement faisable.', NULL, 0, NULL, '2025-07-25 11:18:07', 19, NULL, NULL),
(2, 'note', 'Appel à idées de questions pour la prochaine journée client', 'La traditionnelle journée client et son quizz ! Comme d\'habitude, merci de remplir le tableau suivant avec vos questions techniques, produits et fun. On fera ensuite deux rondes de lecture et affinage pour garder les meilleures.\r\nCette année c\'est @jenny_fraireniseur qui sera en charge de l\'organisation, merci de vous rapprocher d\'elle pour toute question.\r\n\r\nPour les techs : gardez à l\'esprit que certains ne sont pas familier de nos produits. La réponse, quelle que soit sa facilité, et un argument de vente. On compte toujours sur vous le département \"rigolade\" @tom_bellachemiz et @jim_ilesbieraufrai pour les questions rigolotes.', NULL, 0, NULL, '2025-07-25 11:32:55', 14, NULL, NULL),
(3, 'note', 'Retour sur l\'atelier \"Expérience Utilisateur\" avec nos partenaires', 'Jeudi dernier s\'est tenu dans les locaux de notre partenaire un atelier dédié à l\'expérience utilisateur. Durant 2 heures, nous avons travaillé par équipes à la réalisation et au design d\'un petit projet improvisé, avec toutes les 15mn un check des avancées. C\'était rapide, nerveux et tellement compact qu\'il n\'y avait pas le temps pour de longues réflexions. On se fait bousculer au début, mais on se prend également vite au jeu et tous les participants, nous compris, avons beaucoup apprécié le coté pratique et ludique. Nous prévoyons d\'en organiser d\'autre avec les partenaires, n\'hésitez pas à venir lors d\'un prochain atelier !', NULL, 0, NULL, '2025-07-25 11:32:55', 6, NULL, NULL),
(4, 'note', 'Brouillon mémo perso db', '$host = \'localhost\';\r\n$db = \'exoLMDBcine\';\r\n$user = \'cybersecurityexpert\';\r\n$pass = \'1234\';', NULL, 0, NULL, '2025-07-25 11:32:55', 9, NULL, NULL),
(5, 'note', 'Note cachée 0001', 'Ceci est un test pour une note cachée.', NULL, 0, NULL, '2025-07-25 11:32:55', 18, NULL, NULL),
(6, 'note', 'Inauguration nouveau co-working : qui vient ?', 'Le bâtiment voisin a fini ses rénovations et inaugure ses nouveau locaux de co-working la semaine prochaine. Du coup vendredi ils font un apéro pour la pré-ouverture. Avec @nick_aragua on prévoit d\'y aller pour 18h30. Signalez vous si ça vous branche, comme ça on y va tous en même temps !', NULL, 0, NULL, '2025-07-25 11:32:55', 14, NULL, NULL),
(7, 'note', 'Listing des litiges clients majeures 2024', 'Comme vous l\'avez vu passé, on documente actuellement les litiges pour 2024 afin de faire un dossier béton sur lequel s\'appuyer pour les futures améliorations. L\'équipe orange s\'occupe déjà de reprendre tous les éléments officiels et archivés. Nous souhaitons cependant prendre l\'avis de tous concernant l\'année passée, afin d\'être certains de ratisser tous les événements passés importants. Donnez votre avis dans ce fil, d\'un seul bloc svp, avec les problèmes et litiges qui vous ont le plus marqué, ainsi que les améliorations que vous souhaiteriez voir.', NULL, 0, NULL, '2025-07-25 11:32:55', 11, NULL, NULL),
(8, 'note', 'Comment timez-vous votre travail ?', 'Salut ! C\'est de notoriété publique que je perd constamment du temps pendant et entre mes tâches. J\'ai testée le pomodoro mais je n\'y trouve pas vraiment de gain. Je perd souvent mon focus jusqu\'à ce que la sonnerie retentisse. Pouvez vous me partagez, pour ceux qui veulent bien, votre façon de mesurer et diviser votre temps de travail ? C\'est pas simple pour moi. Il faut probablement que je teste plusieurs méthodes jusqu\'à trouver la mienne.', NULL, 0, NULL, '2025-07-25 11:32:55', 15, NULL, NULL),
(9, 'note', 'J\'aimerais monter mon propre premier PC', 'Oui je me lance enfin, après des semaines à en parler à tout le monde. Je me suis lancée... la semaine dernière. Et j\'y comprends rien !! J\'ai suivi un cours de base sur OpenClassroom, relativement clair, mais j\'arrive pas à distinguer les éléments importants. Quelqu\'un aurait une source sympa et débutant-friendly à me partager ? Ou qui pourrait même me donner un coup de main directement ? Pitié ! ><', NULL, 0, NULL, '2025-07-25 11:32:55', 16, NULL, NULL),
(10, 'note', 'Impossible de sauvegarder un menu (Client : Party People )', 'Retour d\'infos du client : suite à sa dernière mise à jour de l\'ERP, il ne peut plus sauvegarder de menu, nourriture et boissons. C\'est le seul élément qui ne fonctionne pas. J\'ai regardé vite fait, mais je ne vois aucune anomalie. Pouvez vous rapidement regarder svp @equipe_verte ?', NULL, 0, NULL, '2025-07-25 11:32:55', 13, NULL, NULL),
(11, 'note', 'Dépassement sur projet précédent . Remise au client ou bonus sur le dév suivant ? ', 'Suite au litige concernant le désaccord sur le temps passé du dernier développement + rallonge SAV, j\'aimerais que l\'on facture quand même 100% de la presta + SAV, ni plus ni moins, mais qu\'on leur propose une ristourne sur le prochain module qu\'ils ont demandé. De mon point de vue cela me semble le plus simple, car j\'aimerais éviter un malentendu avec le client sur le fait que le SAV est optionnel / gratuit si on se plaint.. J\'aimerais vos avis avant qu\'on ne recontacte le client. Merci d\'avance pour vos avis, avant le 15 svp', NULL, 0, NULL, '2025-07-25 11:32:55', 8, NULL, NULL),
(12, 'note', 'Basketball demain soir ? On joue avec l\'équipe Smyths', 'Hey ! J\'ai discuté ce midi avec Julio-de-chez-Smyths-en-face. Il m\'a dit qu\'ils ont installé un panneau de basket dans l\'arrière-cour de leur bâtiment (coté opposé à nous). Vous êtes chauds pour faire un petit 3vs3 avec eux ? Si oui indiquez le moi et j\'organise ça asap avec lui ! Il faut au moins 2 personnes.', NULL, 0, NULL, '2025-07-25 11:49:26', 7, NULL, NULL),
(13, 'note', 'Quelqu\'un peut aider les 2 stagiaires sur la mise en place de leur API ?', 'Je suis passé les voir ce matin, et j\'ai l\'impression qu\'ils sont bien en galère. Je sais qu\'on a tous été beaucoup sollicités dans tous les sens ces derniers jours, mais il ne faut pas qu\'on les laissent trop en suspens non plus. Est-ce que quelqu\'un peut faire un check avec eux sur comment ils vont et ce qu\'ils font, ainsi que leurs difficultés. Ca serait cool et c\'est nécessaire surtout. S\'il y a besoin d\'un échange plus long avec eux, prenez le temps nécessaire.', NULL, 0, NULL, '2025-07-25 11:49:26', 14, NULL, NULL),
(14, 'note', 'J\'ai rédigé un document sur le sujet \"enseignement et IA\". Pouvez vous me faire des retours svp?', 'C\'est un document rédigé à la base pour documenter mes propres recherches. J\'ai eu l\'occasion de discuter avec mon ancien prof de programmation de la Fac, et j\'ai eu envie d\'améliorer ce doc pour en faire un outil. Voici le lien pour le consulter : drive/lien', NULL, 0, NULL, '2025-07-25 11:49:26', 12, NULL, NULL),
(15, 'note', 'Une super série vidéo sur les développement récent en quantum', 'Made in IBM. C\'est très bien fait et tourné - j\'ai eu l\'impression de regarder une série Netflix !', NULL, 0, NULL, '2025-07-25 11:49:26', 14, NULL, NULL),
(16, 'note', 'Annonce des nominées sur ux-design-awards !!', 'Update et suivi sur https://ux-design-awards.com/ \r\nPour ceux qui ne connaissent pas, comme son nom l\'indique, c\'est une remise de prix pour les les meilleures UX de l\'année. C\'est super intéressant et souvent hyper impressionnant !', NULL, 0, NULL, '2025-07-25 11:49:26', 13, NULL, NULL),
(17, 'note', 'J\'aimerais qu\'on pousse le critère de curiosité et de participation pour les stagiaires', 'Comme indiqué dans le titre : un \'bon\' stagiaire, ce n\'est pas forcément le meilleur en compétence. Ils sont là pour découvrir, apprendre, pratiquer et s\'intégrer. J\'aimerais donc qu\'on prête tout autant, voire plus, d\'attention au fait qu\'un stagiaire soir curieux, pose des questions, propose des solutions, même complètement à coté de la plaque. N\'oublions jamais que certains peuvent devenir nos futurs collaborateurs. Je compte sur vous ;)', NULL, 0, NULL, '2025-07-25 11:49:26', 8, NULL, NULL),
(18, 'note', 'Il faut qu\'on discute des tests unitaires générés par IA, ça va pas le faire là', 'Je sais pas avec quel degré de sérieux, de vérification ou d\'humour vous avez fait vos derniers tests, mais là c\'est pas la gloire. Je suis à distance cette semaine, mais filez moi déjà vos infos ici concernant vos process, car vous avez vraiment, vraiment piqué ma curiosité.', NULL, 0, NULL, '2025-07-25 11:49:26', 6, NULL, NULL),
(19, 'note', 'Super drôle d\'avoir fait un gros nœud rose autour de ma voiture ce midi pour mon anniversaire', '... mais en fait c\'était pas la mienne hahaha :D', NULL, 0, NULL, '2025-07-25 11:49:26', 19, NULL, NULL),
(20, 'comment', NULL, 'C\'est sympa comme idée ! Une boite à ouvrir ou qui se déballe. Avec une photo d\'un membre déguisé en père ou mère Noël ?', NULL, 0, 1, '2025-07-25 12:09:38', 16, NULL, NULL),
(21, 'comment', NULL, 'On a pas tous le physique parfait du Père Noël mais ça peut être sympa :D ', NULL, 0, 1, '2025-07-25 12:10:30', 9, NULL, NULL),
(22, 'comment', NULL, 'Pourquoi pas des pulls de Noël plutôt ?? Plus sympa et plus pratique pour tout le monde ! Avec notre meilleure tête au café du matin.', NULL, 0, 1, '2025-07-25 12:10:55', 17, NULL, NULL),
(23, 'comment', NULL, 'Super idée les pulls !!', NULL, 0, 22, '2025-07-25 12:12:11', 19, NULL, NULL),
(24, 'comment', NULL, 'Le département rigolade est sur le pont !', NULL, 0, 2, '2025-07-25 12:15:22', 7, NULL, NULL),
(25, 'comment', NULL, 'Sir-yes-sir !', NULL, 0, 2, '2025-07-25 12:15:22', 13, NULL, NULL),
(26, 'comment', NULL, 'Toujours ok pour une bière dans le voisinage', NULL, 0, 6, '2025-07-25 13:57:47', 19, NULL, NULL),
(27, 'comment', NULL, 'Je devrais avoir fini juste à l\'heure !', NULL, 0, 6, '2025-07-25 13:58:24', 10, NULL, NULL),
(28, 'comment', NULL, 'Partant !', NULL, 0, 6, '2025-07-25 13:58:58', 11, NULL, NULL),
(29, 'comment', NULL, 'Si tu veux on se prend 1h après le boulot mardi prochain et on regarde ensemble en salle de pause avec un café.', NULL, 0, 9, '2025-07-25 14:01:07', 18, NULL, NULL),
(30, 'comment', NULL, 'Oui, ça serait vraiment super, on fait ça ! ', NULL, 0, 29, '2025-07-25 14:03:32', 16, NULL, NULL),
(31, 'comment', NULL, 'Excellent, je suis chaud !!', NULL, 0, 12, '2025-07-25 14:04:56', 12, NULL, NULL),
(32, 'comment', NULL, 'Partante aussi !', NULL, 0, 12, '2025-07-25 14:14:49', 17, NULL, NULL),
(33, 'comment', NULL, 'Je viens aussi, ça fera un remplaçant si besoin', NULL, 0, 12, '2025-07-25 15:19:10', 9, NULL, NULL),
(34, 'comment', NULL, 'Je peux m\'en occuper, mais je suis encore booké pour les 2 prochains jours. Juste après je prendrais une demi matinée.', NULL, 0, 13, '2025-07-28 09:22:44', 12, NULL, NULL),
(35, 'comment', NULL, 'Je suis dispo demain matin, je vais faire un point avec eux. Si besoin, tu pourras aussi passer les voir quelques jours plus tard pour refaire un check @nick_aragua', NULL, 0, 13, '2025-07-28 10:30:20', 15, NULL, NULL),
(36, 'comment', NULL, 'Super ça, j\'attendais le doc justement, merci ! ', NULL, 0, 18, '2025-07-25 12:05:24', 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id_project` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_project`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id_project`, `name`, `description`) VALUES
(1, 'Projet Pyramide', 'Nouvelle feature permettant de gérer plusieurs événement à partir d\'une seule interface.'),
(2, 'Projet Cube', 'Fortification du système actuel de stockage de données. Vérification et amélioration de la sécurité.'),
(3, 'Projet Sphère', 'Réflexion et mise en place d\'actions pour l\'amélioration de la cohésion et du bien-être sur le lieu de travail.'),
(4, 'Projet Octogone', 'Recherche et développement dans l\'innovation de la gestion des conflits et des plaintes clients.');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id_tag` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `id_category` int NOT NULL,
  PRIMARY KEY (`id_tag`),
  UNIQUE KEY `name` (`name`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`id_tag`, `name`, `id_category`) VALUES
(1, 'luc_sembourg', 1),
(2, 'tom_bellachemiz', 1),
(3, 'melusine_engraiv', 1),
(4, 'tanguy_dondevelo', 1),
(5, 'jenny_fraireniseur', 1),
(6, 'medhi_khaman', 1),
(7, 'nick_aragua', 1),
(8, 'jim_ilesbieraufrai', 1),
(9, 'melanie_netendoenmarche', 1),
(10, 'emma_yonaise', 1),
(11, 'emma_carena', 1),
(12, 'candy_raton', 1),
(13, 'alex_ception', 1),
(14, 'kenji_suijireste', 1),
(15, 'idea', 2),
(16, 'suggestion', 2),
(17, 'sharing', 2),
(18, 'brainstorming', 2),
(19, 'poll', 2),
(20, 'survey', 2),
(21, 'difficulty', 2),
(22, 'help', 2),
(23, 'bug', 2),
(24, 'problem', 2),
(25, 'front_end', 3),
(26, 'back_end', 3),
(27, 'ux', 3),
(28, 'ai', 3),
(29, 'csr', 3),
(30, 'ci', 3),
(31, 'training', 3),
(32, 'tech_watch', 4),
(33, 'r&d', 4),
(34, 'design', 4),
(35, 'test', 4),
(36, 'production', 4),
(37, 'erp', 4),
(38, 'feedback', 4),
(39, 'draft', 5),
(40, 'hidden', 5);

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id_task` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `id_project` int NOT NULL,
  PRIMARY KEY (`id_task`),
  UNIQUE KEY `name` (`name`),
  KEY `id_project` (`id_project`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id_task`, `name`, `description`, `id_project`) VALUES
(1, 'PY-T1-api', 'Créer une API qui servira entre les événements et la nouvelle interface.', 1),
(2, 'PY-T2-feat/new_interface', 'Nouvelle page pour la multigestion des événements.', 1),
(3, 'PY-T3-feat/save_bundle_events', 'Possibilité de créer des paquets d\'événements qui seront sauvegardés.', 1),
(4, 'PY-T4-feat/synchronize_events', 'Synchroniser tous les événements dans la page d\'interface centrale.', 1),
(5, 'CU-T1-produce_global_review', 'Compiler dans un document tous les rapports internes, les retours clients, tickets SAV et rapports de réunion concernant la sécurité pour l\'année 2024.', 2),
(6, 'CU-T2-produce_updated_checklist', 'Basé sur notre expérience actuelle et les dernières mises à jour de normes de sécurités, produire une checklist qui nous servira de cadre de développement.', 2),
(7, 'SP-T1-define_objectives', 'Définir les objectifs précis du projet autour de la cohésion et du bien-être au travail.', 3),
(8, 'SP-T2-team_survey', 'Créer une page de formulaire pour le futur sondage auprès de nos équipiers. Prévoir un système d\'export en xlsx pour RH', 3),
(9, 'OC-T1-produce_current_state_review', 'Pour l\'année 2024, faire un état des lieux généraux de toutes les équipes concernant les litiges et plaintes clients, ainsi que la dimension de conflit interne qui en découle.', 4),
(10, 'OC-T2-2024_major_incidents_list', 'Lister les principaux incidents majeurs survenus en 2024. Il y a pas de nombre limite à la liste. Un incident doit apparaitre si un des critères suivants présente un caractère exceptionnel : temps passé sur l\'incident, ressources consommées, impact négatif sur le client et/ou partenaires, nombre de personnes impliquées', 4),
(11, 'OC-T3-customer_satisfaction_survey', 'Préparer une page de formulaire pour la future campagne de sondage satisfaction de nos clients prévue dans 3 mois. Structurer le questionnaire en fonctione des retours des faits sur l\'année 2024.', 4);

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
  `id_team` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_team`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `team`
--

INSERT INTO `team` (`id_team`, `name`) VALUES
(2, 'Équipe Bleue'),
(4, 'Équipe Jaune'),
(5, 'Équipe Orange'),
(6, 'Équipe Rose'),
(1, 'Équipe Rouge'),
(3, 'Équipe Verte');

-- --------------------------------------------------------

--
-- Structure de la table `working_on`
--

DROP TABLE IF EXISTS `working_on`;
CREATE TABLE IF NOT EXISTS `working_on` (
  `id_user` int NOT NULL,
  `id_task` int NOT NULL,
  PRIMARY KEY (`id_user`,`id_task`),
  KEY `id_task` (`id_task`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `working_on`
--

INSERT INTO `working_on` (`id_user`, `id_task`) VALUES
(6, 1),
(7, 2),
(8, 2),
(13, 3),
(15, 3),
(11, 5),
(9, 6),
(10, 7),
(13, 7),
(14, 7),
(19, 7),
(16, 8),
(15, 9),
(16, 9),
(12, 10),
(17, 11);

-- --------------------------------------------------------

--
-- Structure de la table `_user`
--

DROP TABLE IF EXISTS `_user`;
CREATE TABLE IF NOT EXISTS `_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `_user`
--

INSERT INTO `_user` (`id_user`, `username`, `first_name`, `last_name`, `password`) VALUES
(6, 'luc_sembourg', 'Luc', 'Sembourg', 'pognon'),
(7, 'tom_bellachemiz', 'Tom', 'Béllachemiz', 'mariage'),
(8, 'melusine_engraiv', 'Mélusine', 'Engraiv', 'cgt'),
(9, 'tanguy_dondevelo', 'Tanguy', 'Don Develo', 'bicyclette'),
(10, 'jenny_fraireniseur', 'Jenny', 'Fraireniseur', 'solo'),
(11, 'medhi_khaman', 'Mehdi', 'Khaman', 'doliprane'),
(12, 'nick_aragua', 'Nick', 'Aragua', 'granada'),
(13, 'jim_ilesbieraufrai', 'Jim', 'Ilesbieraufrai', '1664'),
(14, 'melanie_netendoenmarche', 'Mélanie', 'Netendoenmarche', 'mario'),
(15, 'emma_yonaise', 'Emma', 'Yonaise', 'thon'),
(16, 'emma_carena', 'Emma', 'Caréna', 'summer'),
(17, 'candy_raton', 'Candy', 'Raton', 'gossip'),
(18, 'alex_ception', 'Alex', 'Ception', 'only'),
(19, 'kenji_suijireste', 'Kenji', 'Suijireste', 'japon');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `paper`
--
ALTER TABLE `paper` ADD FULLTEXT KEY `ft_title_content` (`title`,`content`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `carry_out`
--
ALTER TABLE `carry_out`
  ADD CONSTRAINT `carry_out_ibfk_1` FOREIGN KEY (`id_project`) REFERENCES `project` (`id_project`),
  ADD CONSTRAINT `carry_out_ibfk_2` FOREIGN KEY (`id_team`) REFERENCES `team` (`id_team`);

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
-- Contraintes pour la table `paper`
--
ALTER TABLE `paper`
  ADD CONSTRAINT `fk_paper_created_by` FOREIGN KEY (`created_by`) REFERENCES `_user` (`id_user`),
  ADD CONSTRAINT `fk_paper_edited_by` FOREIGN KEY (`edited_by`) REFERENCES `_user` (`id_user`),
  ADD CONSTRAINT `fk_parent` FOREIGN KEY (`parent_id`) REFERENCES `paper` (`id_paper`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
