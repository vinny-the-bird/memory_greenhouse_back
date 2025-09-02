<?php
require_once __DIR__.'/../entities/Vote.php';

class Vote {
    
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllVotes() {
        
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

    public function getVotesByPaperId($id_paper) {
        
        $stmt = $this->pdo->prepare("SELECT * FROM vote WHERE id_paper = ?");
        $stmt->execute([$id_paper]);
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

    public function getVoteStatsByPaperId($id_paper) {
        $stmt = $this->pdo->prepare("
            SELECT
            COUNT(*) AS total_vote,
            COUNT(CASE WHEN vote = '-1' THEN 1 END) AS total_downvote,
            COUNT(CASE WHEN vote = '1' THEN 1 END) AS total_upvote
            FROM vote
            WHERE id_paper = ?;
        ");
        $stmt->execute([$id_paper]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // returns array with total_votes, upvotes, downvotes
    }

    public function getVoteByPaperAndUser($id_paper, $id_user) {
        
        $stmt = $this->pdo->prepare("SELECT * FROM vote WHERE id_paper = ? AND id_user = ?");
        $stmt->execute([$id_paper, $id_user]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row) {
            return null;
        }
        
        return new VoteEntity(
            $row['id_user'],
            $row['id_paper'],
            $row['vote']
        );

    }

    public function create(VoteEntity $vote) {
        
        $stmt = $this->pdo->prepare("INSERT INTO vote (id_user, id_paper, vote) VALUES (?, ?, ?)");
        $success = $stmt->execute([
            $vote->id_user, 
            $vote->id_paper,
            $vote->vote
        ]);

        if ($success) {
            return [
                'id_user'  => $vote->id_user,
                'id_paper' => $vote->id_paper,
                'vote'     => $vote->vote
                ];
        }
        return null;
    }

    public function update(VoteEntity $vote) {
        
        $stmt = $this->pdo->prepare("UPDATE vote SET vote = ? WHERE id_paper = ? AND id_user = ?");
        $success = $stmt->execute([
            $vote->vote,
            $vote->id_paper,
            $vote->id_user, 
        ]);

        if ($success) {
            return self::getVoteByPaperAndUser($vote->id_paper, $vote->id_user); 
        }
    }

    public function delete($id_paper, $id_user) {
        // TODO: delete must use both id_paper and id_user
        $stmt = $this->pdo->prepare("DELETE FROM vote WHERE id_paper = ? AND id_user = ?");
        $success = $stmt->execute([$id_paper, $id_user]);
        return $success; 
    }
    
}

?>