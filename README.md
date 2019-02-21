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

 Simple example
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
First create your folder and file, for example as `routers\main.php` and
write here

`routers\main.php`
```php
# $router is available here
$router->route('GET', '/about', function($request){
    ...
});
```

And add the routers folder to `Application` via `Router`

```php
...
$app->use(new Router('routers'));
...
```

### Routing

Router methods

```php
$router->route($method, $url, $callback);
$router->get($url, $callback);
$router->post($url, $callback);
$router->put($url, $callback);
$router->delete($url, $callback);
```

```php
// get url params in request
$router->get('/account/:name', function($request){
    return array(
        'code' => 0,
        'username' => $request->name
    )
});

// in this example, for /root/path/to/file url
// $request->args will be ["path", "to", "file"]
$router->get('/root/*', function($request){
    return array(
        'code' => 0,
        'args' => $request->args
    );
});

$router->get('/profile/:name/files/*', function(){
    return array(
        'code' => 0,
        'username' => $request->name,
        'path_as_array' => $request->args
    );
});

$router->get('/about', function(){
    // in callback, $this is available
    // and instance of \gone\routes\Callback
    $this->response->redirect('/path/to/redirect');
});
```