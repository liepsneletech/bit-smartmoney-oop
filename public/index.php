<?php

require __DIR__ . '/../vendor/autoload.php';

use app\Controllers\Application;

$root = str_replace('\\', '/', dirname(__DIR__));
$app = new Application($root);

$response = $app->resolve();
echo $response;
