<?php
require_once __DIR__.'/../controllers/VoteController.php';

function handleVotesRequest(PDO $pdo, $method, $id1 = null, $id2 = null) {

    $id_paper = $id1;
    $id_user  = $id2;

    $controller = new VoteController($pdo);

    switch($method) {

     case 'GET':
            if ($id_paper && $id_user) {
                $controller->getVoteByPaperAndUser($id_paper, $id_user);
            } elseif ($id_paper) {
                $controller->getVotesByPaperId($id_paper);
            } else {
                $controller->getAllVotes();
            }
            break;

        case "POST": 
            $controller->createVote();
            break;

        case "PATCH": 
            if ($id_paper && $id_user) {
                $controller->updateVote($id_paper, $id_user);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'id_user and id_paper are required in the URL']);
            }
            break;

        case "DELETE": 
            if ($id_paper && $id_user) {
                $controller->deleteVote($id_paper, $id_user);
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