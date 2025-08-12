<?php
require_once __DIR__.'/../../database.php';
require_once __DIR__.'/../entities/Paper.php';

class Paper {

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
        
        return new PaperEntity(
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

}


?>