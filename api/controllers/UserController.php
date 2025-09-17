<?php
require_once __DIR__.'/../models/User.php';

class UserController {

    private User $userModel;

    public function __construct(PDO $pdo) {
        $this->userModel = new User($pdo);
    }

    public function getAllUsers() {

        $users = $this->userModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($users);
    }
    
    public function getUserById($id_user) {

        $user = $this->userModel->find($id_user);
        header('Content-Type: application/json');

        if($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "User not found"]);
        }
    }

    public function createUser() {

        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

            $firstName = normalizeName($data['first_name']);
            $lastName  = normalizeName($data['last_name']);

        $userEntity = new UserEntity(
            null,
            $data['username'],
            $firstName,
            $lastName,
            password_hash($data['password'], PASSWORD_BCRYPT),
            null
        );

        try {
            $newUser = $this->userModel->create($userEntity);

            if ($newUser) {
                http_response_code(201);
                echo json_encode($newUser);
            } else {
                http_response_code(500);
                echo json_encode(["error" => "Failed to create user"]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }

      public function updateUser($id_user) {
        $existing = $this->userModel->find($id_user);

        if(!$existing) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['first_name']) || empty($data['last_name']) ) 
        {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        return;
    }

        $firstName = normalizeName($data['first_name']);
        $lastName  = normalizeName($data['last_name']);

        $password   = !empty($data["password"])
                    ? password_hash($data["password"], PASSWORD_BCRYPT)
                    : $existing->password;

        $updatedUser = new UserEntity(
            $id_user,
            $data['username'],
            $firstName ?? $existing->first_name,
            $lastName ?? $existing->last_name,
            $password,
            $existing->id_tag
        );


        try {
            $result = $this->userModel->update($updatedUser);
            if ($result) {
                echo json_encode($result);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update user']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function deleteUser($id_user) {

        $existing = $this->userModel->find($id_user);

        if (!$existing) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }

        if ($this->userModel->delete($id_user)) {
            echo json_encode(['message' => 'User and personal tag deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete user']);
            }
        }
    }

    function normalizeName(string $name): string {
        // 1. Trim leading/trailing spaces
        $name = trim($name);

        // 2. Collapse all whitespace into a single space
        $name = preg_replace('/\s+/', ' ', $name);

        // 3. Convert to title case (accents safe)
        $name = mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');

        // 4. Capitalize after apostrophes and hyphens
        $name = preg_replace_callback(
            "/([\'\-])(\p{L})/u",
            function ($matches) {
                return $matches[1] . mb_convert_case($matches[2], MB_CASE_UPPER, "UTF-8");
            },
            $name
        );

        return $name;
    }

?> 