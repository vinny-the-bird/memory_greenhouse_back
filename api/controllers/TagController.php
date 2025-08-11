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

        if (!isset($data['name'], $data['category'])) {
            http_response_code(400);
            echo json_encode(["error" => "Missing required fields: name, category"]);
            return;
        }

        $tagEntity = new TagEntity(
            null,
            $data['name'],
            $data['category']
        );

        $createdTag = Tag::create($tagEntity);

        if ($createdTag) {
            http_response_code(201);
            echo json_encode($createdTag);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to create tag"]);
        }
    }

    public function updateTag() {

    }
    public function deleteTag() {

    }
}

?> 