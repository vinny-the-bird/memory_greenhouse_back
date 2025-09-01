<?php
require_once __DIR__.'/../models/Tag.php';

class TagController {

    private Tag $tagModel;

    public function __construct(PDO $pdo) {
        $this->tagModel = new Tag($pdo);
    }

    public function getAllTags() {

        $tags = $this->tagModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($tags);
    }
    
    public function getTagById($id) {

        $tag = $this->tagModel->find($id);
        header('Content-Type: application/json');

        if($tag) {
            echo json_encode($tag);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Tag not found"]);
        }
    }

    // public function getTagSByUser() {
    //     // display all tags one user can see
    // }

    public function createTag() {

        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['name']) || empty($data['category'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields: name, category']);
            return;
        }

        $tagEntity = new TagEntity(
            null,
            $data['name'],
            $data['category']
        );
        
        $newTag = $this->tagModel->create($tagEntity);
        
        if ($newTag) {
            http_response_code(201);
            echo json_encode($newTag);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to create tag"]);
        }
    }

    public function updateTag($id) {

        $existing = $this->tagModel->find($id);

        if(!$existing) {
            http_response_code(404);
            echo json_encode(['error' => 'Tag not found']);
            return;
        }

        $data =json_decode(file_get_contents("php://input"), true);

        $name = $data["name"] ?? $existing->name;
        $category = $data["category"] ?? $existing->category;

        $updatedTag = new TagEntity($id, $name, $category);

        if ($this->tagModel->update($updatedTag)) {
            echo json_encode($updatedTag);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update tag']);
        }
    }

    public function deleteTag($id) {

        $existing = $this->tagModel->find($id);

        if (!$existing) {
            http_response_code(404);
            echo json_encode(['error' => 'Tag not found']);
            return;
        }

        if ($this->tagModel->delete($id)) {
            echo json_encode(['message' => 'Tag deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete tag']);
            }
        }
    }

?> 