<?php

require_once __DIR__ . '/load_env.php';

loadEnv(__DIR__ . '/.env');

$host = $_ENV['DB_DATABASE'];
$db = $_ENV['SERVER_NAME'];
$user = $_ENV['USERNAME'];
$pass = $_ENV['PASSWORD'];
// $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    return new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new Exception("Database connection failed: " . $e->getMessage());
}

?>