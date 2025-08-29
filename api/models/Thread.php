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
        
        $stmt = $this->pdo->prepare("SELECT * FROM paper WHERE id_paper = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return null;
        }
        
        // return $row ? new PaperEntity($row) : null;

        return new PaperEntity([
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
        ]);
    }

}

?>