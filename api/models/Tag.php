<?php
require_once __DIR__.'/../entities/Tag.php';

class Tag {
    
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll() {
        

        $stmt = $this->pdo->query("SELECT * FROM tag");
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

    public function find($id) {
        
        $stmt = $this->pdo->prepare("SELECT * FROM tag WHERE id_tag = ?");
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

    public function create(TagEntity $tag) {
        
        $stmt = $this->pdo->prepare("INSERT INTO tag (name, id_category) VALUES (?, ?)");
        $success = $stmt->execute([$tag->name, $tag->category]);

        if ($success) {
        $lastId = $this->pdo->lastInsertId();
        return self::find($lastId);
        }
        return null;
    }

    public function update(TagEntity $tag) {
        
        $stmt = $this->pdo->prepare("UPDATE tag SET name = ?, id_category = ? WHERE id_tag = ?");
        $success = $stmt->execute([$tag->name, $tag->category, $tag->id]);

        if ($success) {
            return self::find($tag->id); 
        }
    }

    public function delete($id) {
        
        $stmt = $this->pdo->prepare("DELETE FROM tag WHERE id_tag = ?");
        $success = $stmt->execute([$id]);
        return $success; 
    }
    
}

?>