<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../database.php';

$sql = "SELECT * FROM category";

try {

    $stmt = $pdo->query($sql); 
    // $stmt = $pdo->prepare($sql);    
    // $stmt->execute(['id_paper' => $id_paper]);

    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categories);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}


?>