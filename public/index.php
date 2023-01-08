<?php

session_start();

use app\Controllers\Application;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/assets/inc/functions.php';

$root = str_replace('\\', '/', dirname(__DIR__));
$app = new Application($root);

if (!isset($_SESSION['admin']) && $_SERVER['REQUEST_URI'] !== '/login') {
    Application::redirect('/login');
};

if (isset($_SESSION['admin']) && $_SERVER['REQUEST_URI'] === '/login') {
    Application::redirect('/accounts');
};

$response = $app->resolve();
echo $response;

