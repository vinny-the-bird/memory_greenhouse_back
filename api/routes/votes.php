<?php
require_once __DIR__.'/../controllers/VoteController.php';

function handleVotesRequest(PDO $pdo, $method, $id_user = null, $id_paper = null) {

    $controller = new VoteController($pdo);

    switch($method) {

     case 'GET':
            if ($id_user && $id_paper) {
                // GET /votes/{id_user}/{id_paper} → single vote
                $controller->getVoteByUserAndPaper($id_user, $id_paper);
            } elseif ($id_user && !$id_paper) {
                // GET /votes/{id_paper} → here $id_user is actually id_paper
                $controller->getVotesByPaperId($id_user);
            } else {
                // GET /votes → all votes
                $controller->getAllVotes();
            }
            break;

        case "POST": 
            $controller->createVote();
            break;

        case "PATCH": 
            if ($id_user && $id_paper) {
                $controller->updateVote($id_user, $id_paper);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'id_user and id_paper are required in the URL']);
            }
            break;

        // case "DELETE": 
        //     if ($id) {
        //         $controller->deleteVote($id);
        //     } else {
        //         http_response_code(400);
        //         echo json_encode(['error' => 'ID is required for delete']);
        //     }
        //     break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]); 
    }   
}

?>