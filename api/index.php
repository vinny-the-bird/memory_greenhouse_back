<?php

// Force all errors and exceptions to be returned as JSON

// Turn off default error display (no HTML errors)
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

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
        $functionName = "handle" . ucfirst($resource) . "Request";

        if(function_exists($functionName)) {
            $functionName($method, $id);
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