<?php
require_once __DIR__.'/../entities/Paper.php';

class Thread {

        private PDO $pdo;

        public function __construct(PDO $pdo)
            {
                $this->pdo = $pdo;
            }


    // GET all notes
    public function getAllNotes() {
        
        $stmt = $this->pdo->query("SELECT * FROM paper WHERE paper_type = 'note'");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $notes = [];
        foreach ($rows as $row) {
            $notes[] = new PaperEntity([
            'id_paper' => $row['id_paper'],
            'paper_type' => $row['paper_type'],
            'title' => $row['title'],
            'content' => $row['content'],
            'overview' => $row['overview'],
            'is_outdated' => $row['is_outdated'],
            'parent_id' => $row['parent_id'],
            'creation_date' => $row['creation_date'],
            'created_by' => $row['created_by'],
            'edit_date' => $row['edit_date'],
            'edited_by' => $row['edited_by'],
            ]

            );
        }
        return $notes;
    }

    public function findThread($id): ?PaperEntity {
        $stmt = $this->pdo->prepare("
        
        WITH RECURSIVE thread (
            id_paper,
            paper_type,
            parent_id,
            title,
            content,
            overview,
            is_outdated,
            creation_date,
            created_by,
            depth,
            path
        ) AS (
            SELECT
                paper.id_paper,
                paper.paper_type,
                paper.parent_id,
                paper.title,
                paper.content,
                paper.overview,
                paper.is_outdated,
                paper.creation_date,
                paper.created_by,
                0 AS depth,
                LPAD(paper.id_paper, 10, '0') AS path
            FROM paper
            WHERE paper.id_paper = ? AND paper.paper_type = 'note'

        UNION ALL

        SELECT
            paper.id_paper,
            paper.paper_type,
            paper.parent_id,
            paper.title,
            paper.content,
            paper.overview,
            paper.is_outdated,
            paper.creation_date,
            paper.created_by,
            thread.depth + 1 AS depth,
            CONCAT(thread.path, '/', LPAD(paper.id_paper, 10, '0')) AS path
        FROM paper
        JOIN thread ON paper.parent_id = thread.id_paper
    )
        SELECT
            thread.id_paper,
            thread.paper_type,
            thread.parent_id,
            thread.title,
            thread.content,
            thread.overview,
            thread.is_outdated,
            thread.creation_date,
            thread.created_by,
            thread.depth,
            thread.path
        FROM thread
        ORDER BY thread.path;
        ");


        $stmt->execute([$id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$rows) {
            return null;
        }
        
        $papersById = [];
        foreach ($rows as $row) {
            $papersById[$row['id_paper']] = new PaperEntity($row);
        }

        $rootNote = null;
        foreach ($papersById as $paper) {
            if ($paper->parent_id && isset($papersById[$paper->parent_id])) {
                $papersById[$paper->parent_id]->comments[] = $paper;
            } else {
                        
            if ($paper->paper_type === 'note') {
                $rootNote = $paper;
                }
            }
        }

        return $rootNote;
            }
        }

?>