<?php

$router->route('/settings', function($request){
    return array(
        'code' => 0,
        'message' => 'settings'
    );
});