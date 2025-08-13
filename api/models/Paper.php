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
            'id'            => $row['id_paper'],
            'paper_type'    => $row['paper_type'],
            'title'         => $row['title'],
            'content'       => $row['content'],
            'overview'      => $row['overview'],
            'is_outdated'   => $row['is_outdated'],
            'parent_id'     => $row['parent_id'],
            'creation_date' => $row['creation_date'],
            'created_by'    => $row['created_by'],
            'edit_date'     => $row['edit_date'],
            'edited_by'     => $row['edited_by'],
            ]

            );
        }
        return $papers;
    }

    public function find($id) {
        
        $stmt = $this->pdo->prepare("SELECT * FROM paper WHERE id_paper = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return [];
        }
        
        return new PaperEntity([
            'id'            => $row['id_paper'],
            'paper_type'    => $row['paper_type'],
            'title'         => $row['title'],
            'content'       => $row['content'],
            'overview'      => $row['overview'],
            'is_outdated'   => $row['is_outdated'],
            'parent_id'     => $row['parent_id'],
            'creation_date' => $row['creation_date'],
            'created_by'    => $row['created_by'],
            'edit_date'     => $row['edit_date'],
            'edited_by'     => $row['edited_by'],
        ]);
    }

    // CREATE
    public function create(PaperEntity $paperEntity) {

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
            VALUES (:paper_type, :title, :content, :overview, :is_outdated, :parent_id, :creation_date, :created_by, :edit_date, :edited_by)
        ";

        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            ':paper_type'    => $paperEntity->paper_type,
            ':title'         => $paperEntity->title,
            ':content'       => $paperEntity->content,
            ':overview'      => $paperEntity->overview,
            ':is_outdated'   => $paperEntity->is_outdated,
            ':parent_id'     => $paperEntity->parent_id,
            ':creation_date' => $paperEntity->creation_date,
            ':created_by'    => $paperEntity->created_by,
            ':edit_date'     => $paperEntity->edit_date,
            ':edited_by'     => $paperEntity->edited_by,
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

    //     $stmt = $pdo->prepare("UPDATE paper SET name = ?, id_category = ? WHERE id_paper = ?"); // TODO: adapt to paper table
    //     $success = $stmt->execute([
    //         $paper->paper_type, 
    //         $paper->title,
    //         $paper->content,
    //         $paper->overview,
    //         $paper->is_outdated,
    //         $paper->parent_id,
    //         $paper->edit_date,
    //         $paper->edited_by,
    //         $paper->id
    //     ]);

    //     if ($success) {
    //         return self::find($paper->id); 
    //     }
    // }
    // DELETE
    // public function delete($id) {
    //     
    //     $stmt = $pdo->prepare("DELETE FROM paper WHERE id_tag = ?");
    //     $success = $stmt->execute([$id]);
    //     return $success; 
    // }

    // get notes

    // get one thread by paper id

    // vote_for_one_paper

}


?>