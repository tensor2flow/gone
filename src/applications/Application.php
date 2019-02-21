<?php

namespace gone\applications;

use gone\Gone;
use gone\routes\Router;
use gone\requests\Request;
use gone\responses\Response;
use gone\collections\Deque;
use gone\applications\BaseApplication;

class Application extends BaseApplication{
    protected $routes;
    protected $request;
    protected $response;

    public function __construct(){
        $this->request = new Request();
        $this->response = new Response();
        $this->routes = new Deque();
        Gone::$app = $this;
        Gone::$request = $this->request;
        Gone::$response = $this->response;
    }

    public function use($usable){
        if($usable instanceof Router){
            $this->router($usable);
        }
    }

    private function router($router){
        $this->routes->append($router);
    }
}