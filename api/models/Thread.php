<?php
require_once __DIR__.'/../entities/Paper.php';

class Thread {

        private PDO $pdo;

        public function __construct(PDO $pdo)
            {
                $this->pdo = $pdo;
            }


    public function getAllNotes() {
        
        // $stmt = $this->pdo->query("SELECT * FROM paper WHERE paper_type = 'note'");
        $stmt = $this->pdo->query("SELECT 
        paper.id_paper,
        paper.paper_type,
        paper.title, 
        paper.content, 
        paper.overview, 
        paper.is_outdated,
        paper.parent_id,
        paper.creation_date,
        concat(_user.first_name, ' ', _user.last_name) as created_by, 
        paper.edit_date,
        paper.edited_by
        FROM paper 
        JOIN _user ON _user.id_user = paper.created_by
        WHERE paper_type = 'note'
        ORDER BY creation_date DESC");
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

public function findThread($id_paper): ?PaperEntity {
    // 1. Get the root note with creator name
    $stmt = $this->pdo->prepare("
        SELECT 
            paper.id_paper,
            paper.paper_type,
            paper.title, 
            paper.content, 
            paper.overview, 
            paper.is_outdated,
            paper.parent_id,
            paper.creation_date,
            CONCAT(u.first_name, ' ', u.last_name) AS created_by,
            paper.edit_date,
            paper.edited_by
        FROM paper
        JOIN _user u ON u.id_user = paper.created_by
        WHERE paper.id_paper = :id AND paper.paper_type = 'note'
    ");
    $stmt->execute(['id' => $id_paper]);
    $rootRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$rootRow) {
        return null; // not a note or doesn't exist
    }

    $rootNote = new PaperEntity($rootRow);
    $rootNote->comments = [];

    // 2. Breadth-first search (BFS) to fetch only children of this note
    $papersById = [$rootNote->id_paper => $rootNote];
    $queue = [$rootNote->id_paper];

    while (!empty($queue)) {
        $currentParentId = array_shift($queue);

        $stmt = $this->pdo->prepare("
            SELECT 
                paper.id_paper,
                paper.paper_type,
                paper.title, 
                paper.content, 
                paper.overview, 
                paper.is_outdated,
                paper.parent_id,
                paper.creation_date,
                CONCAT(u.first_name, ' ', u.last_name) AS created_by,
                paper.edit_date,
                paper.edited_by
            FROM paper
            JOIN _user u ON u.id_user = paper.created_by
            WHERE paper.parent_id = :parent_id
            ORDER BY paper.creation_date ASC
        ");
        $stmt->execute(['parent_id' => $currentParentId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $comment = new PaperEntity($row);
            $comment->comments = [];

            // attach to its parent
            $papersById[$currentParentId]->comments[] = $comment;

            // store in map and queue for further traversal
            $papersById[$comment->id_paper] = $comment;
            $queue[] = $comment->id_paper;
        }
    }

    return $rootNote;
    }

}
?>