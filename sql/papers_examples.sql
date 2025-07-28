-- examples populate paper table

INSERT INTO `paper` (`id_paper`, `paper_type`, `title`, `content`, `overview`, `is_outdated`, `parent_id`, `creation_date`, `created_by`, `edit_date`, `edited_by`) 
VALUES (NULL, 'note', '1st note title', 'Text of my first note', NULL, '0', NULL, CURRENT_TIMESTAMP, '6', NULL, NULL);

INSERT INTO `paper` (`id_paper`, `paper_type`, `title`, `content`, `overview`, `is_outdated`, `parent_id`, `creation_date`, `created_by`, `edit_date`, `edited_by`) 
VALUES (NULL, 'comment', NULL, 'Yeah man! Welcome aboard!', NULL, '0', '1', CURRENT_TIMESTAMP, '15', NULL, NULL);

INSERT INTO `paper` (`id_paper`, `paper_type`, `title`, `content`, `overview`, `is_outdated`, `parent_id`, `creation_date`, `created_by`, `edit_date`, `edited_by`) 
VALUES (NULL, 'comment', NULL, 'Sweet as bro, welcome!', NULL, '0', '1', CURRENT_TIMESTAMP, '12', NULL, NULL);