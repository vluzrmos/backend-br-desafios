<?php

require __DIR__ . '/../vendor/autoload.php';

$routes = require __DIR__ . '/../src/Http/Routes/web.php';
$uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$controller = $routes["$method $uri"] ?? null;

if ($controller === null) {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
    exit;
}

if (is_string($controller)) {
    $controller = (new $controller)->__invoke(...);
} elseif (is_array($controller)) {
    $controller = new $controller[0]();
    $controller  = $controler->{$controller[1]}(...);
} 


// Parse JSON body
if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'DELETE', 'PUT', 'PATCH']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') === 0) {
    $data = json_decode(file_get_contents('php://input'), true);

    foreach ($data as $key => $value) {
        $_REQUEST[$key] = $value;
        $_POST[$key] = $value;
    }
}

$response = $controller();

if (isset($response['headers'])) {
    foreach ($response['headers'] as $header => $value) {
        header("$header: $value");
    }
}

if (isset($response['status'])) {
    http_response_code($response['status']);
}

if (isset($response['body'])) {
    echo $response['body'];
}

if (isset($response['json'])) {
    if (empty($response['headers']['Content-Type'])) {
        header('Content-Type: application/json');
    }

    echo json_encode($response['json']);
} elseif (isset($response['text'])) {
    header('Content-Type: text/plain');
    echo $response['text'];
} elseif (isset($response['html'])) {
    header('Content-Type: text/html');
    echo $response['html'];
}