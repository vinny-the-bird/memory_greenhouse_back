<?php 
require_once __DIR__.'/../models/Paper.php';

class PaperController {

    public function getAllPapers() {

        $papers = Paper::getAll();
        header('Content-Type: application/json');
        echo json_encode($papers);
    }
    
    public function getPaperById($id) {

        $paper = Paper::find($id);
        header('Content-Type: application/json');

        if($paper) {
            echo json_encode($paper);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Tag not found"]);
        }
    }
}

?>