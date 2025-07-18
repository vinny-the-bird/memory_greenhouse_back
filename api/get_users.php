<?php
header('Content-Type: application/json');

// echo "API reached"; exit;

require '../database.php';

$stmt = $pdo->query('SELECT * FROM _user');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($users);

?>