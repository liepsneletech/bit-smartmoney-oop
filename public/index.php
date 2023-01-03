<?php

require DIR . '/../vendor/autoload.php';

use App\Controllers\SitesController;

$app = new SitesController;

echo $app->greet();
