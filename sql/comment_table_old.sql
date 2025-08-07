-- id_paper_2 => id_comment_link (ID = entrée unique dans la table comment)
-- id_paper => id_comment_in_paper (id du commentaire 'son contenu' dans la table paper)
-- id_paper_1 => id_parent_paper (Le parent du comment = un autre comment ou paper)

CREATE TABLE `comment` (
  `id_comment_link` int(11) NOT NULL,
  `id_comment_in_paper` int(11) NOT NULL,
  `id_parent_paper` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_comment_link`),
  ADD KEY `id_comment_in_paper` (`id_comment_in_paper`),
  ADD KEY `id_parent_paper` (`id_parent_paper`);
  
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_comment_link`) REFERENCES `paper` (`id_paper`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_comment_in_paper`) REFERENCES `comment` (`id_comment_link`),
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`id_parent_paper`) REFERENCES `note` (`id_paper`);