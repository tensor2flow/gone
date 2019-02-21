<?php

namespace gone\routes;

use gone\collections\Deque;

class Router{
    protected $__methods;
    protected $__endpoints;
    protected $__callbacks;

    public function __construct($path = null){
        $this->__methods = new Deque();
        $this->__endpoints = new Deque();
        $this->__callbacks = new Deque();
        if($path){
            $path = implode('/', [__DIR__ , '..', '..' , $path]);
            $files = array_diff(scandir($path), array('.', '..'));
            foreach($files as $file){
                $file = implode('/', [$path, $file]);
                if(is_file($file)){
                    $router = $this;
                    include($file);
                }
            }
        }
    }

    private function append($method, $endpoint, $callback){
        $this->__methods->append($method);
        $this->__endpoints->append($endpoint);
        $this->__callbacks->append($callback);
    }

    public function route($method, $endpoint, $callback){
        $this->append($method, $endpoint, $callback);
    }

    public function get($endpoint, $callback){
        $this->append('GET', $endpoint, $callback);
    }

    public function post($endpoint, $callback){
        $this->append('POST', $endpoint, $callback);
    }

    public function put($endpoint, $callback){
        $this->append('PUT', $endpoint, $callback);
    }

    public function delete($endpoint, $callback){
        $this->append('DELETE', $endpoint, $callback);
    }

    public function options($endpoint, $callback){
        $this->append('OPTIONS', $endpoint, $callback);
    }

    public function pop(){
        $method = $this->__methods->pop();
        $endpoint = $this->__endpoints->pop();
        $callback = $this->__callbacks->pop();
        return [$method, $endpoint, $callback];
    }

    public function iter() : iterable{
        for($i = 0; $i < $this->__methods->count(); $i++){
            yield $this->pop();
        }
    }
}