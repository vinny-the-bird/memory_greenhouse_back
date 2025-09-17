<?php
require_once __DIR__.'/../controllers/ThreadController.php';

function handleThreadsRequest(PDO $pdo, $method, $id_paper = null) {

    $controller = new ThreadController($pdo);

    switch($method) {
        case "GET":
            $id_paper ? $controller->getThreadById($id_paper) : $controller->getAllNotes(); 
            break;
        

        //TODO: using delete for thread? Delete root note = delete all childs? or safety: at least 1 comment => can't be deleted anymore
        // case "DELETE": 
        //     if ($id) {
        //         $controller->deletePaper($id);
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