<?php
header('Content-Type: application/json');

require '../database.php';

$stmt = $pdo->query('SELECT * FROM tag');
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($tags);

?>