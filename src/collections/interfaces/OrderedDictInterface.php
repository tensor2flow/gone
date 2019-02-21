<?php
namespace gone\collections\interfaces;

interface OrderedDictInterface{
    public function __set($key, $value);
    
    public function __get($key);

    public function items();

    public function keys();

    public function values();

    public function clear();
    
    public function remove();
}