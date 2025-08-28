<?php
require_once __DIR__.'/../entities/Paper.php';

class Paper {

        private PDO $pdo;

        public function __construct(PDO $pdo)
            {
                $this->pdo = $pdo;
            }

    // GET
    public function getAll() {
        
        $stmt = $this->pdo->query("SELECT * FROM paper");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $papers = [];
        foreach ($rows as $row) {
            $papers[] = new PaperEntity([
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
        return $papers;
    }

    public function find($id): ?PaperEntity {
        
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

            // CREATE
            // public function create(PaperEntity $paper) {
        public function create(PaperEntity $paper): ?PaperEntity {

        $sql = "INSERT INTO paper (
                paper_type, 
                title,
                content, 
                overview, 
                is_outdated, 
                parent_id, 
                creation_date, 
                created_by,
                edit_date,
                edited_by
            ) 
            -- VALUES (:paper_type, :title, :content, :overview, :is_outdated, :parent_id, :creation_date, :created_by, :edit_date, :edited_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            $paper->paper_type,
            $paper->title,
            $paper->content,
            $paper->overview,
            $paper->is_outdated,
            $paper->parent_id,
            $paper->creation_date ?? date('Y-m-d H:i:s'),
            $paper->created_by,
            $paper->edit_date,
            $paper->edited_by
        ]);

        if ($success) {
        $lastId = $this->pdo->lastInsertId();
        // return self::find($lastId);
        return $this->find((int)$lastId);
        }
        return null;
    }


    // UPDATE
    // public function update(PaperEntity $paper) { 

    //     $stmt = $this->pdo->prepare("UPDATE paper SET 
    //             title = ?,
    //             content = ?, 
    //             overview = ?, 
    //             is_outdated = ?, 
    //             edit_date = ?,
    //             edited_by = ?
    //             WHERE id_paper = ?
    //     "); 
    //     // TODO: adapt to paper table
    //     $success = $stmt->execute([
    //         $paper->title,
    //         $paper->content,
    //         $paper->overview,
    //         $paper->is_outdated,
    //         $paper->edit_date,
    //         $paper->edited_by,
    //         $paper->id
    //     ]);

    //     if ($success) {
    //         return self::find($paper->id); 
    //     }
    // }


public function update(PaperEntity $paper): ?PaperEntity {
    $stmt = $this->pdo->prepare("
        UPDATE paper SET
            paper_type = :paper_type,
            title = :title,
            content = :content,
            overview = :overview,
            is_outdated = :is_outdated,
            parent_id = :parent_id,
            creation_date = :creation_date,
            created_by = :created_by,
            edit_date = :edit_date,
            edited_by = :edited_by
        WHERE id_paper = :id_paper
    ");

    $success = $stmt->execute([
        ':paper_type' => $paper->paper_type,
        ':title' => $paper->title,
        ':content' => $paper->content,
        ':overview' => $paper->overview,
        ':is_outdated' => $paper->is_outdated,
        ':parent_id' => $paper->parent_id,
        ':creation_date' => $paper->creation_date,
        ':created_by' => $paper->created_by,
        ':edit_date' => $paper->edit_date,
        ':edited_by' => $paper->edited_by,
        ':id_paper' => $paper->id_paper
    ]);

    return $success ? $this->find($paper->id_paper) : null;
}


    // DELETE
    public function delete($id) { // WIP
        
        $stmt = $this->pdo->prepare("DELETE FROM paper WHERE id_paper = ?");
        $success = $stmt->execute([$id]);
        return $success; 
    }

    // get notes

    // get one thread by paper id

    // vote_for_one_paper

}


?>