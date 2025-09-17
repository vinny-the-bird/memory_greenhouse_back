<?php
require_once __DIR__.'/../controllers/PaperController.php';

function handlePapersRequest(PDO $pdo, $method, $id_paper = null) {

    $controller = new PaperController($pdo);

    switch($method) {
        case "GET":
            $id_paper ? $controller->getPaperById($id_paper) : $controller->getAllPapers(); 
            break;
        
        case "POST": 
            $controller->createPaper();
            break;

        case "PATCH": 
            if ($id_paper) {
                $controller->updatePaper($id_paper);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required for update']);
            }
            break;

        case "DELETE": 
            if ($id_paper) {
                $controller->deletePaper($id_paper);
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