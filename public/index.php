<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\{
    Router,
    Container,
    Helpers
};

session_start();

try {
    Helpers::loadEnv(__DIR__ . '/../.env');
    $container = new Container();
    $router = new Router($container);
    require_once __DIR__ . '/../routes/web.php';
    $router->resolve();
} catch (Exception $e) {
    http_response_code(500);
    echo "An internal server error occurred.";
}