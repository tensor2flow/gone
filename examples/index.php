<?php
require __DIR__ . '/vendor/autoload.php';

use gone\applications\Application;
use gone\routes\Router;

$app = new Application();
$router = new Router();

$router->route('GET', '/hello', function($request){
    return array(
        'code' => 0,
        'message' => 'Hello'
    );
});

$app->use($router);

$app->run();