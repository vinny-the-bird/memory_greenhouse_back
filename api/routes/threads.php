<?php
require_once __DIR__.'/../controllers/ThreadController.php';

function handleThreadsRequest(PDO $pdo, $method, $id = null) {

    $controller = new ThreadController($pdo);

    switch($method) {
        case "GET":
            $id ? $controller->getThreadById($id) : $controller->getAllNotes(); 
            break;
        

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