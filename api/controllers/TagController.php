<?php

require_once __DIR__.'/../models/Tag.php';

function getTags() {
    $tags = Tag::getAll();
    echo json_encode($tags);
}

function getTag($id) {
    $tag = Tag::find($id);
    if($tag) {
        echo json_encode($tag);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Tag not found"]);
    }
}
?> 