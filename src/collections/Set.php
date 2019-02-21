<?php

namespace gone\collections;

use gone\collections\Collection;
use gone\collections\interfaces\SetInterface;

class Set extends Collection implements SetInterface{
    protected $is = false;

    public function __construct($values = array()){
        parent::__construct();
        for($i = 0; $i < count($values); $i++){
            if(!in_array($values[$i], $this->__values)){
                array_push($this->__values, $values[$i]);
                $this->is = false;
            }
        }
    }

    public function __set($key = null, $value = null){
        return $this;
    }

    public function __get($key = null){
        return $this;
    }

    public function append($value){
        if(!in_array($value, $this->__values)){
            array_push($this->__values, $value);
            $this->is = false;
        }
        return $this;
    }

    protected function sort(){
        sort($this->__values);
        $this->is = true;
        return $this;
    }

    public function __toString(){
        if(!$this->is){
            $this->sort();
        }
        return parent::__toString();
    }

    public function values(){
        if(!$this->is){
            $this->sort();
        }
        return parent::values();
    }
}