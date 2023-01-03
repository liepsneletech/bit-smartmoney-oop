<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\SitesController;

$app = new SitesController;

echo $app->greet();
