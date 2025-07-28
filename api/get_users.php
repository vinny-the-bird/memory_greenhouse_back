<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../database.php';

// $stmt = $pdo->query('SELECT * FROM _user');
// $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// echo json_encode($users);

$sql = "SELECT * FROM _user";

try {

    $stmt = $pdo->query($sql); 
    // $stmt = $pdo->prepare($sql);    
    // $stmt->execute(['id_paper' => $id_paper]);

    $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tags);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

?>