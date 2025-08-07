<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../database.php';


// $id_paper = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// if ($id_paper <= 0) {
//     echo json_encode(['error' => 'Missing or invalid id parameter']);
//     exit;
// }


// TODO: the GET id from URL is not working
// TODO: apply 'WITH RECURSIVE thread' to get all comments and subcomments
$id_paper = 9;

$sql = "
SELECT * FROM paper
WHERE paper.id_paper = :id_paper
";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_paper' => $id_paper]);
    $full_thread = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($full_thread);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

?>


