<?php
require_once __DIR__.'/../models/Tag.php';

class TagController {

    public function getAllTags() {

        $tags = Tag::getAll();
        header('Content-Type: application/json');
        echo json_encode($tags);
    }
    
    public function getTagById($id) {

        $tag = Tag::find($id);
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
        
        $newTag = Tag::create($tagEntity);
        
        if ($newTag) {
            http_response_code(201);
            echo json_encode($newTag);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to create tag"]);
        }
    }

    public function updateTag($id) {
        $existing = Tag::find($id);

        if(!$existing) {
            http_response_code(404);
            echo json_encode(['error' => 'Tag not found']);
            return;
        }

        $data =json_decode(file_get_contents("php://input"), true);

        $name = $data["name"] ?? $existing->name;
        $category = $data["category"] ?? $existing->category;

        $updatedTag = new TagEntity($id, $name, $category);

        if (Tag::update($updatedTag)) {
            echo json_encode($updatedTag);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update tag']);
        }
    }

    public function deleteTag($id) {
    $existing = Tag::find($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(['error' => 'Tag not found']);
            return;
        }

        if (Tag::delete($id)) {
            echo json_encode(['message' => 'Tag deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete tag']);
            }
        }
    }

?> 