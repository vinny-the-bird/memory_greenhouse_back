<?php
require_once __DIR__.'/../../database.php';
require_once __DIR__.'/../entities/Paper.php';

class Paper {

    // GET
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM paper");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $papers = [];
        foreach ($rows as $row) {
            $papers[] = new PaperEntity(
                $row['id_paper'],
                $row['paper_type'],
                $row['title'],
                $row['content'],
                $row['overview'],
                $row['is_outdated'],
                $row['parent_id'],
                $row['creation_date'],
                $row['created_by'],
                $row['edit_date'],
                $row['edited_by'],
            );
        }
        return $papers;
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM paper WHERE id_paper = ?");
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
    public static function create(PaperEntity $paperEntity) {
        global $pdo;
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

        $stmt = $pdo->prepare($sql);

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
        $lastId = $pdo->lastInsertId();
        return self::find($lastId);
        }
        return null;
    }


    // UPDATE
    public static function update(PaperEntity $paper) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE paper SET name = ?, id_category = ? WHERE id_paper = ?"); // TODO: adapt to paper table
        $success = $stmt->execute([
            $paper->paper_type, 
            $paper->title,
            $paper->content,
            $paper->overview,
            $paper->is_outdated,
            $paper->parent_id,
            $paper->edit_date,
            $paper->edited_by,
            $paper->id
        ]);

        if ($success) {
            return self::find($paper->id); 
        }
    }
    // DELETE
    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM paper WHERE id_tag = ?");
        $success = $stmt->execute([$id]);
        return $success; 
    }

    // get notes

    // get one thread by paper id

    // vote_for_one_paper

}


?>