<?php
require_once __DIR__.'/../../database.php';

class Tag {
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM tag");
        return $stmt->fetchAll();
    }

    public static function find($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM tag WHERE id_tag = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}

?>