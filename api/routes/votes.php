<?php
require_once __DIR__.'/../controllers/VoteController.php';

function handleVotesRequest(PDO $pdo, $method, $id = null) {

    $controller = new VoteController($pdo);

    switch($method) {
        case "GET":
            $id ? $controller->getVoteByPaperId($id) : $controller->getAllVotes(); 
            break;
        
        case "POST": 
            $controller->createVote();
            break;

        case "PATCH": 
            if ($id) {
                $controller->updateVote($id);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required for update']);
            }
            break;

        case "DELETE": 
            if ($id) {
                $controller->deleteVote($id);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required for delete']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]); 
    }   
}

?>