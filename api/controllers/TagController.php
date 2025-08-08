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
}

?> 