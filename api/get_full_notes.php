<?php
header('Content-Type: application/json');

require '../database.php';

$stmt = $pdo->query('
SELECT  note.id_paper, note.title, id_user, creation_date, created_by, content, edit_date, edited_by, note.is_outdated, note.overview FROM `paper`
JOIN note ON paper.id_paper = note.id_paper
');
$full_notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($full_notes);

?>



