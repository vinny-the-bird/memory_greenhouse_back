DROP TABLE IF EXISTS paper;

CREATE TABLE paper (
    id_paper INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    paper_type ENUM('note', 'comment') NOT NULL,
    title VARCHAR(100) UNIQUE,
    content TEXT NOT NULL,
    overview TEXT DEFAULT NULL,
    is_outdated TINYINT(1) DEFAULT 0,
    parent_id INT DEFAULT NULL,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_by INT NOT NULL,
    edit_date DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    edited_by INT DEFAULT NULL,
    KEY idx_parent (parent_id),
    KEY idx_type_parent (paper_type, parent_id),
    KEY idx_created_by (created_by),
    FULLTEXT KEY ft_title_content (title, content),
    CONSTRAINT fk_parent FOREIGN KEY (parent_id) REFERENCES paper(id_paper) ON DELETE CASCADE
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE paper
ADD CONSTRAINT fk_paper_created_by
FOREIGN KEY (created_by) REFERENCES `_user`(id_user),

ADD CONSTRAINT fk_paper_edited_by
FOREIGN KEY (edited_by)  REFERENCES `_user`(id_user),

ADD CONSTRAINT chk_is_outdated_boolean CHECK (is_outdated IN (0,1)),

ADD CONSTRAINT chk_parent_rule CHECK (
    (`paper_type` = 'note'    AND `parent_id` IS NULL)
    OR
    (`paper_type` = 'comment' AND `parent_id` IS NOT NULL)
),


ADD CONSTRAINT chk_title_for_notes CHECK (
    (paper_type = 'note'    AND title IS NOT NULL)
    OR
    (paper_type = 'comment' AND title IS NULL)
);