<?php 
require_once __DIR__.'/../models/Thread.php';
require_once __DIR__ . '/../entities/Paper.php';

class ThreadController { 

    private Thread $threadModel;

    public function __construct(PDO $pdo) {
        $this->threadModel = new Thread($pdo);
    }

    
    public function getAllNotes() {

        $notes = $this->threadModel->getAllNotes();
        header('Content-Type: application/json');
        echo json_encode($notes);
    }

    public function getThreadById($id) {

        $thread = $this->threadModel->findThread($id);
        header('Content-Type: application/json');

        if($thread) {
            echo json_encode($thread);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Thread not found"]);
        }
    }

    }

?>