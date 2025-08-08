<?php 

require_once __DIR__.'/../controllers/TagController.php';

function handleTagsRequest($method, $id = null) {
    switch($method) {
        case "GET":
            $id ? getTag($id) : getTags();
    }   
}

?>