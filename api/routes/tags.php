<?php 

require_once __DIR__.'/../controllers/TagController.php';

function handleTagsRequest($method, $id = null) {

    $controller = new TagController();

    switch($method) {
        case "GET":
            // $id ? getTag($id) : getAllTags();
            if ($id) {
                $controller->getTagById($id);
            } else {
                $controller->getAllTags();
            }
            break;
        
        case "POST": 
            $controller->createTag();
            break;

        case "PUT": 
            $controller->updateTag($id);
            break;

        case "DELETE": 
            $controller->deleteTag($id);
            break;

        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]); 
    }   
}

    // Future CRUD operations:
    // case 'POST': $controller->createTag(); break;
    // case 'PUT': $controller->updateTag($parts[1]); break;
    // case 'DELETE': $controller->deleteTag($parts[1]); break;

?>