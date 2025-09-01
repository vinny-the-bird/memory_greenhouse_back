<?php 
require_once __DIR__.'/../models/Vote.php';
require_once __DIR__ . '/../entities/Vote.php';

class VoteController { 

    private Vote $voteModel;

    public function __construct(PDO $pdo) {
        $this->voteModel = new Vote($pdo);
    }

    public function getAllVotes() {

        $votes = $this->voteModel->getAllVotes();
        header('Content-Type: application/json');
        echo json_encode($votes);
    }
    
    // TODO: must calculate the paper score directly
    public function getVotesByPaperId($id_paper) {

        $votes = $this->voteModel->getVotesByPaperId($id_paper);
        header('Content-Type: application/json');

        if($votes) {
            echo json_encode($votes);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Vote not found"]);
        }
    }

    public function getVoteByPaperAndUser($id_paper, $id_user) {

        $vote = $this->voteModel->getVoteByPaperAndUser($id_paper, $id_user);
        header('Content-Type: application/json');

        if($vote) {
            echo json_encode($vote);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Vote not found"]);
        }
    }


    public function createVote() {

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            empty($data['id_user']) 
            || empty($data['id_paper'])
            || empty($data['vote'])
        ) 
        {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields: id_user, id_paper, vote']);
            return;
        }

        $voteEntity = new VoteEntity(
            $data['id_user'],
            $data['id_paper'],
            $data['vote']
        );
        
        $newVote = $this->voteModel->create($voteEntity);
        
        if ($newVote) {
            http_response_code(201);
            echo json_encode($newVote);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to create vote"]);
        }
    }
    

    public function updateVote($id_paper, $id_user) {

        $existing = $this->voteModel->getVoteByPaperAndUser($id_paper, $id_user);

        if(!$existing) {
            http_response_code(404);
            echo json_encode(['error' => 'Vote not found']);
            return;
        }

        $data =json_decode(file_get_contents("php://input"), true);

        // $id_user = $data["id_user"] ?? $existing->id_user;
        // $id_paper = $data["id_paper"] ?? $existing->id_paper;
        $vote = $data["vote"] ?? $existing->vote;

        // $updatedVote = new VoteEntity($id_user, $id_paper, $vote);
        $updatedVote = new VoteEntity($id_user, $id_paper, $vote);

        if ($this->voteModel->update($updatedVote)) {
            echo json_encode($updatedVote);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update vote']);
        }
    }


    // TODO: if deleted paper == 'note", => delete all children comments
    public function deleteVote($id_paper, $id_user) {

        $deleted = $this->voteModel->delete($id_paper, $id_user);

        if ($deleted) {
            http_response_code(204);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Vote not found or could not be deleted']);
        }
    }

    }

?>