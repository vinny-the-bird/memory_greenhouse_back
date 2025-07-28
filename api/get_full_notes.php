<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../database.php';

// get all papers with same id_paper + parent_id. Note + all 
// comments BUT NOT the sub-comments

$sql = "
SELECT * FROM paper WHERE id_paper = 12
UNION ALL
SELECT * FROM paper WHERE parent_id = 12 ORDER BY creation_date;
";

try {
    $stmt = $pdo->query($sql);
    $full_notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($full_notes);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

?>




