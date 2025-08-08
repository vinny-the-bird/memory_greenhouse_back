<?php

header('Content-Type: application/json');

// Enable error reporting during development
ini_set('display_errors', 1);
error_reporting(E_ALL);

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/greenhouse_back/api'; 

$path = str_replace($basePath, '', $requestUri);
$path = trim($path, '/');
$parts = explode('/', $path);

$resource = $parts[0] ?? null;
$id = $parts[1] ?? null;


if ($resource) {
    $routeFile = __DIR__."/routes/{$resource}.php";
    if(file_exists($routeFile)) {
        require_once $routeFile;
        $handlerFunction = "handle" . ucfirst($resource) . "Request";

        if(function_exists($handlerFunction)) {
            $handlerFunction($method, $id);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Handler function not found for {$resource}"]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Resource not found", $resource, $routeFile]);
    }
} else {
      http_response_code(400);
        echo json_encode(["error" => "No resource specified"]);
}

?>