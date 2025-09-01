<?php
require_once __DIR__.'/../entities/Vote.php';

class Vote {
    
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll() {
        

        $stmt = $this->pdo->query("SELECT * FROM vote");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $votes = [];
        foreach ($rows as $row) {
            $votes[] = new VoteEntity(
                $row['id_user'],
                $row['id_paper'],
                $row['vote']
            );
        }
        return $votes;
    }

    public function find($id) {
        
        $stmt = $this->pdo->prepare("SELECT * FROM vote WHERE id_paper = ?");
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(!$rows) {
            return null;
        }
        
        $votes = [];
        foreach ($rows as $row) {
            $votes[] = new VoteEntity(
                $row['id_user'],
                $row['id_paper'],
                $row['vote']
            );
        }
        return $votes;
    }

    public function create(VoteEntity $vote) {
        
        $stmt = $this->pdo->prepare("INSERT INTO vote (id_user, id_paper, vote) VALUES (?, ?, ?)");
        $success = $stmt->execute([
            $vote->id_user, 
            $vote->id_paper,
            $vote->vote
        ]);

        if ($success) {
        $lastId = $this->pdo->lastInsertId();
        return self::find($lastId);
        }
        return null;
    }

    public function update(VoteEntity $vote) {
        
        $stmt = $this->pdo->prepare("UPDATE vote SET vote = ? WHERE id_tag = ?");
        $success = $stmt->execute([
            // $vote->id_user, 
            // $vote->id_paper,
            $vote->vote
        ]);

        if ($success) {
            return self::find($vote->id_paper); 
        }
    }

    public function delete($id) {
        // TODO: delete must use both id_paper and id_user
        $stmt = $this->pdo->prepare("DELETE FROM vote WHERE id_paper = ?");
        $success = $stmt->execute([$id]);
        return $success; 
    }
    
}

?>