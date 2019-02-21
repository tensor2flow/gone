<?php

namespace gone\routes;

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