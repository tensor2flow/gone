<?php

namespace gone\applications;

use gone\Gone;

class Callback{
    public $app;
    public $request;
    public $response;

    public function __construct($request){
        $this->app = Gone::$app;
        $this->request = $request;
        $this->response = Gone::$response;
    }

    public function response($response){
        if(is_array($response)){
            $this->response->json($response);
        }
        else{
            $this->response->chunk($response);
        }
    }
}

class BaseApplication extends \stdClass{
    private $closure;
    private $errr404 = true;

    public function setClosure($closure){
        $this->closure = $closure;
    }

    public function getClosure(){
        return $this->closure;
    }

    public function dispatch(){
        $possible_method = $this->request->server()->get('REQUEST_METHOD');
        foreach($this->routes->iter() as $router){
            foreach($router->iter() as $value){
                list($method, $endpoint, $callback) = $value;
                $endpoint_level = 0;
                if($method == '*' || $method == $possible_method){
                    $possible = $this->isPossible($endpoint);
                    if($possible != null){
                        list($request, $arguments) = $possible;
                        $this->runCallback($request, $arguments, $callback);
                    }
                }
            }
        }
    }

    private function isPossible($endpoint){
        $request = array();
        $arguments = array();
        $uri = $this->request->server()->get('REQUEST_URI');
        $endpoint = explode('/', $endpoint);
        $uri = explode('/', $uri);
        for($i = 0; $i < count($endpoint); $i++){
            if(substr($endpoint[$i], 0, 1) == ':'){
                if($i < count($uri)){
                    $name = substr($endpoint[$i], 1);
                    $request[$name] = $uri[$i];
                    $endpoint[$i] = $uri[$i];
                }
            }
        }
        if($endpoint == $uri){
            return [$request, $arguments];
        }
        if(count($endpoint) < count($uri)){
            if($endpoint[count($endpoint) - 1] == '*'){
                for($i = count($endpoint) - 1; $i < count($uri); $i++){
                    array_push($arguments, $uri[$i]);
                }
                return [$request, $arguments];
            }
        }
        return null;
    }

    public function runCallback($request, $arguments, $callback){
        $this->request = Gone::$request;
        $this->request->args = $arguments;

        foreach($request as $key => $value){
            $this->request->__set($key, $value);
        }

        $callbackObject = new Callback($this->request);
        $callback = $callback->bindTo($callbackObject);
        $result = $callback($this->request);
        if($result){
            $callbackObject->response($result);
        }
    }

    public function run(){
        $this->dispatch();
    }
}