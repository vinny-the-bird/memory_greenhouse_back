<?php 

require_once __DIR__.'/../controllers/TagController.php';

function handleTagsRequest(PDO $pdo, $method, $id_tag = null) {

    $controller = new TagController($pdo);

    switch($method) {
        case "GET":
            $id_tag ? $controller->getTagById($id_tag) : $controller->getAllTags(); 
            break;
        
        case "POST": 
            $controller->createTag();
            break;

        case "PATCH": 
            if ($id_tag) {
                $controller->updateTag($id_tag);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required for update']);
            }
            break;

        case "DELETE": 
            if ($id_tag) {
                $controller->deleteTag($id_tag);
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