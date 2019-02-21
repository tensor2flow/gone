<?php
require __DIR__ . '/vendor/autoload.php';

use gone\applications\Application;
use gone\routes\Router;

$app = new Application();
$router = new Router();

$app->use(new Router('routers'));

$app->run();