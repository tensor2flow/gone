# Gone Rest-API framework, written in PHP

## Installing Gone
```
php composer.phar require gone/gone
```

After installing, you need to require Composer's autoloader:
```php
require 'vendor/autoload.php';
```

You can then later update Gone using composer:
```
php composer.phar update
```

## Quick Started

### Simple example
```php
use gone\applications\Application;
use gone\routes\Router;

$app = new Application();
$router = new Router();

$router->route('GET', '/info', function($request){
    return array(
        'name' => 'gone',
        'type' => 'framework'
    );
});

$app->use($router);
$app->run();
```

### You can load all routers from directory
First create your folder and file, for example `routers\main.php` and
write here

`routers\main.php`
```php
# $router is available here
$router->route('GET', '/about', function($request){
    ...
});
```

And add the router to use
`index.php`
```php
...

$app->use(new Router('routers'))

...
```

