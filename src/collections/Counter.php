<?php

namespace gone\collections;

use gone\Gone;

use gone\collections\Collection;
use gone\collections\interfaces\CounterInterface;

class Counter extends Collection implements CounterInterface{
    
    public function __construct($values = array()){
        parent::__construct();
        for($i = 0; $i < count($values); $i++){
            $this->__set($values[$i]);
        }
    }

    public function __set($key, $value = null){
        if($value){
            $this->__values[$key] = $value;
        }
        else{
            if(isset($this->__values[$key])){
                $this->__values[$key]++;
            }
            else{
                $this->__values[$key] = 1;
            }
        }
        return $this;
    }

    public function elements($iterable = false) : iterable{
        $result = array();
        foreach($this->__values as $key => $value){
            for($i = 0; $i < $value; $i++){
                array_push($result, $key);
            }
        }
        return $result;
    }

    public function subtract($map){
        if($map instanceof Collection){
            $map = $map->values();
        }
        foreach($this->__values as $key => $value){
            if(isset($map[$key])){
                $this->__values[$key] -= $map[$key];
            }
        }
        return $this;
    }

    public function update($map){
        if($map instanceof Collection){
            $map = $map->values();
        }
        foreach($map as $key => $value){
            $this->__values[$key] = $value;
        }
        return $this;
    }
}