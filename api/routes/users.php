<?php 

require_once __DIR__.'/../controllers/UserController.php';

function handleUsersRequest(PDO $pdo, $method, $id_user = null) {

    $controller = new UserController($pdo);

    switch($method) {
        case "GET":
            $id_user ? $controller->getUserById($id_user) : $controller->getAllUsers(); 
            break;
        
        case "POST": 
            $controller->createUser();
            break;

        case "PATCH": 
            if ($id_user) {
                $controller->updateUser($id_user);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'ID is required for update']);
            }
            break;

        case "DELETE": 
            if ($id_user) {
                $controller->deleteUser($id_user);
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