<?php

namespace gone\utils;

use gone\collections\Dict;

class Server extends Dict{
    
    protected static $http_header_prefix = 'HTTP_';
    
    protected static $http_nonprefixed_headers = array(
        'CONTENT_LENGTH',
        'CONTENT_TYPE',
        'CONTENT_MD5',
    );

    public function __construct(){
        foreach($_SERVER as $key => $value){
            $this->set($key, $value);
        }
    }

    public function set($key, $value){
        $this->__set($key, $value);
        return $this;
    }

    public function get($key){
        return $this->__get($key);
    }

    public static function hasPrefix($string, $prefix)
    {
        if (strpos($string, $prefix) === 0) {
            return true;
        }
        return false;
    }
    
    public function getHeaders()
    {
        $headers = array();
        foreach ($this->__values as $key => $value) {
            if (self::hasPrefix($key, self::$http_header_prefix)) {
                $headers[
                    substr($key, strlen(self::$http_header_prefix))
                ] = $value;
            } elseif (in_array($key, self::$http_nonprefixed_headers)) {
                $headers[$key] = $value;
            }
        }
        return $headers;
    }
}