<?php

namespace gone\collections;

use gone\Gone;

class Collection{
    protected $__values = array();

    public function __construct($values = array()){
        $this->__values = $values;
    }

    public function __set($key, $value){
        $this->__values[$key] = $value;
        return $this;
    }

    public function __get($key){
        return isset($this->__values[$key]) ? $this->__values[$key] : Gone::$nan;
    }

    public function __toString(){
        return json_encode($this->__values);
    }

    public function __isset($content){
        return isset($this->__values[$content]);
    }

    public function __unset($content){
        if($this->__isset($content)){
            unset($this->__values[$content]);
        }
    }

    public function values(){
        return $this->__values;
    }

    public function clear(){
        $this->__values = array();
        return $this;
    }

    public function items(){
        return $this->values();
    }

    public function count(){
        return count($this->__values);
    }

    public function iter(){
        foreach($this->__values as $value){
            yield $value;
        }
    }
}