<?php
require_once __DIR__.'/../../database.php';
require_once __DIR__.'/../entities/Tag.php';

class Tag {
    
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM tag");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tags = [];
        foreach ($rows as $row) {
            $tags[] = new TagEntity(
                $row['id_tag'],
                $row['name'],
                $row['id_category']
            );
        }
        return $tags;
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM tag WHERE id_tag = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return [];
        }
        
        return new TagEntity(
            $row['id_tag'],
            $row['name'],
            $row['id_category']
        );
    }

    public static function create(TagEntity $tag) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO tag (name, id_category) VALUES (?, ?)");
        $success = $stmt->execute([$tag->name, $tag->category]);

        if ($success) {
        $lastId = $pdo->lastInsertId();
        return self::find($lastId);
        }
        return null;
    }

    public static function update(TagEntity $tag) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE tag SET name = ?, id_category = ? WHERE id_tag = ?");
        $success = $stmt->execute([$tag->name, $tag->category, $tag->id]);

        if ($success) {
            return self::find($tag->id); 
        }
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM tag WHERE id_tag = ?");
        $success = $stmt->execute([$id]);
        return $success; 
    }
    
}

?>