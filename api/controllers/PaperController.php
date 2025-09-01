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

    // public function getAllNotes() {

    // $notes = $this->paperModel->getAllNotes();
    // header('Content-Type: application/json');
    // echo json_encode($notes);
    // }


    public function createPaper() {

        $data = json_decode(file_get_contents("php://input"), true);

            // Apply the paper_type rule before entity creation
        if (($data['paper_type'] ?? 'note') === 'note') {
            $data['parent_id'] = null;
        } else {
            $data['title'] = null;
        }


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


    public function updatePaper($id) {

        $existing = $this->paperModel->find($id);

        if (!$existing) {
            http_response_code(404);
            echo json_encode(['error' => 'Paper not found']);
            return;
        }

        $patchData = json_decode(file_get_contents("php://input"), true);
        if (!$patchData || !is_array($patchData)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }

        $mergedData = array_merge((array)$existing, $patchData);
        $updatedPaper = new PaperEntity($mergedData);

        $result = $this->paperModel->update($updatedPaper);

        if ($result) {
            echo json_encode($result);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update paper']);
        }
    }

    // TODO: if deleted paper == 'note", => delete all children comments
    public function deletePaper($id) {

        $existing = $this->paperModel->find($id);

        if (!$existing) {
            http_response_code(404);
            echo json_encode(['error' => 'Paper not found']);
            return;
        }

        if ($this->paperModel->delete($id)) {
            echo json_encode(['message' => 'Paper deleted successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to delete paper']);
            }
        }

    }

?>