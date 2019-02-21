<?php

namespace gone\utils;

use gone\collections\Listed;

class Cookies extends Listed{
    
    public function __construct(array $cookies = array())
    {
        foreach ($cookies as $key => $value) {
            $this->set($key, $value);
        }
    }
    
    public function set($key, $value)
    {
        if (!$value instanceof ResponseCookie) {
            $value = new ResponseCookie($key, $value);
        }
        return parent::set($key, $value);
    }
}