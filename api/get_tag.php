<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../database.php';

$id_tag = 9;

$sql = "SELECT * FROM tag 
WHERE id_tag = :id_tag
";

try {
    // query ALL
    // $stmt = $pdo->query($sql); 

    // query one by id
    $stmt = $pdo->prepare($sql);    
    $stmt->execute(['id_tag' => $id_tag]);

    $tag = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tag);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

?>