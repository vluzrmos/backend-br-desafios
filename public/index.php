<?php

use Vluzrmos\BackendBr\Desafios\Http\Response;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

Dotenv::createImmutable(__DIR__ . '/../')->load();

$routes = require __DIR__ . '/../src/Http/Routes/web.php';
$uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$controller = null;

// params are in the format {paramname} and should be replaced with a regex

$routeParamPrefix = 'route_param_';
foreach ($routes as $route => $handler) {
    $route = preg_replace('/\{(.*?)\}/', '(?P<'.$routeParamPrefix.'$1>.*?[^/])', $route);
    
    $matches = [];

    error_log('Route: ' . $route);
    error_log('Request: ' . $method . ' ' . $uri);
    error_log('Regex: ' . '#^' . $route . '$#i');
    if (preg_match('#^' . $route . '$#i', $method . ' ' . $uri, $matches)) {
        $controller = $handler;
        
        foreach($matches as $key => $value) {
            if (is_string($key) && strpos($key, $routeParamPrefix) === 0) {
                $paramName = substr($key, strlen($routeParamPrefix));
                $_REQUEST[$paramName] = $value;
                $_GET[$paramName] = $value;
            }
        }

        break;
    }
}

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
if (in_array($_SERVER['REQUEST_METHOD'], ['POST', 'DELETE', 'PUT', 'PATCH']) && strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === 0) {
    $data = json_decode(file_get_contents('php://input'), true);

    foreach ($data as $key => $value) {
        $_REQUEST[$key] = $value;
        $_POST[$key] = $value;
    }
}

$response = $controller();

if ($response instanceof Response) {
    $response->send();
    exit;
} 

error_log('Invalid response type: ' . gettype($response));
http_response_code(500);
echo json_encode(['error' => 'Internal Server Error']);