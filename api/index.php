<?php

header('Content-Type: application/json');

$request = $_SERVER['REQUEST_URI'];
$basePath = '/greenhouse_back/api'; 

$route = str_replace($basePath, '', $request);
$route = trim($route, '/');

// Basic router
switch ($route) {
    case 'users':
        require 'get_users.php';
        break;

    case 'tags':
        require 'get_tags.php';
        break;

    case 'categories':
        require 'get_categories.php';
        break;

    case 'notes':
        require 'get_full_notes.php';
        break;

    case 'threads':
        require 'get_thread.php';
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
}


?>