<?php 
require_once __DIR__.'/../models/Paper.php';
require_once __DIR__ . '/../entities/Paper.php';

class PaperController {

    private Paper $paperModel;

    public function __construct(PDO $pdo) {
        $this->paperModel = new Paper($pdo);
    }

    public function getAllPapers() {

        $papers = $this->paperModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($papers);
    }
    
    public function getPaperById($id) {

        $paper = $this->paperModel->find($id);
        header('Content-Type: application/json');

        if($paper) {
            echo json_encode($paper);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Paper not found"]);
        }
    }

    public function createPaper() {

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            empty($data['paper_type']) 
            || empty($data['content'])
            || empty($data['creation_date'])
            || empty($data['created_by'])
            ) 
        {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }
        
        $paperEntity = new PaperEntity($data);

        $newPaper = $this->paperModel->create($paperEntity);
        
        if ($newPaper) {
            http_response_code(201);
            echo json_encode($newPaper);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to create paper"]);
        }
    }
}

?>