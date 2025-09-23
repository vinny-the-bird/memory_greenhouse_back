<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header('Content-Type: application/json');

// Handle preflight (OPTIONS request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Turn off default error display (no HTML errors)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Convert PHP errors to exceptions
set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Catch uncaught exceptions and output JSON error
set_exception_handler(function($exception) {
    http_response_code(500);
    echo json_encode([
        "error" => true,
        "message" => $exception->getMessage(),
        "file" => $exception->getFile(),
        "line" => $exception->getLine()
    ]);
    exit;
});

// catch fatal errors on shutdown
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        http_response_code(500);
        echo json_encode([
            "error" => true,
            "message" => $error['message'],
            "file" => $error['file'],
            "line" => $error['line']
        ]);
    }
});

$pdo = require __DIR__ . '/../database.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePrefix = '/greenhouse/api/';

if (strpos($requestUri, $basePrefix) === 0) {
    $path = substr($requestUri, strlen($basePrefix));
} else {
    $path = trim($requestUri, '/');
}

$parts = explode('/', trim($path, '/'));
$resource = $parts[0] ?? null;
$id1 = $parts[1] ?? null;
$id2 = $parts[2] ?? null;

if ($resource) {
    $routeFile = __DIR__ . "/routes/{$resource}.php";

    if (file_exists($routeFile)) {
        require_once $routeFile;
        $functionName = "handle" . ucfirst($resource) . "Request";

        if (function_exists($functionName)) {
            $method = $_SERVER['REQUEST_METHOD'];
            $functionName($pdo, $method, $id1, $id2);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Handler function not found for {$resource}"]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Resource not found", "resource" => $resource, "routeFile" => $routeFile]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "No resource specified"]);
}

?>