<?php

require __DIR__ . '/vendor/autoload.php';

use gone\applications\Application;
use gone\routes\Router;

$app = new Application();
$router = new Router();

$router->route('GET', '/:name', function($request){
    print($request->name);
    return array(
        'google' => 'google'
    );
});

$app->use($router);
$app->use(new Router('routers'));

$app->run();