<?php

declare(strict_types=1);

session_start();

define('BASE_PATH', __DIR__);

require_once BASE_PATH . '/config/database.php';

$routes = require BASE_PATH . '/routes/web.php';

$method = $_SERVER['REQUEST_METHOD'];

$path = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

$path = rtrim($path, '/');

if ($path === '') {
    $path = '/';
}

$routeKey = $method . ' ' . $path;

if (!isset($routes[$routeKey])) {
    http_response_code(404);

    require BASE_PATH . '/app/views/404.php';
    exit;
}

[$controllerName, $action] = $routes[$routeKey];

$controllerFile =
    BASE_PATH . '/app/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(500);
    exit('Không tìm thấy controller.');
}

require_once $controllerFile;

if (!class_exists($controllerName)) {
    http_response_code(500);
    exit('Controller không hợp lệ.');
}

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    http_response_code(500);
    exit('Action không tồn tại.');
}

$controller->$action();