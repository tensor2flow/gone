<?php

namespace gone\collections;

use gone\collections\Collection;
use gone\collections\interfaces\DequeInterface;

class Deque extends Collection implements DequeInterface{
    public function __construct($array = array()){
        parent::__construct($array);
    }

    public function append($x){
        array_push($this->__values, $x);
        return $this;
    }

    public function appendleft($x){
        array_unshift($this->__values, $x);
        return $this;
    }

    public function extend($iterable){
        foreach($iterable as $value){
            array_push($this->__values, $value);
        }
        return $this;
    }

    public function extendleft($iterable){
        foreach($this->__values as $value){
            array_push($iterable, $value);
        }
        $this->__values = $iterable;
        return $this;
    }

    public function pop(){
        return array_pop($this->__values);
    }

    public function popleft(){
        return array_shift($this->__values);
    }

    public function remove($value){
        if(in_array($value)){
            $index = array_search($this->__values, $value);
            $this->__unset($index);
        }
        return $this;
    }

    public function reverse(){
        return array_reverse($this->__values);
    }

    public function count(){
        return count($this->__values);
    }
}