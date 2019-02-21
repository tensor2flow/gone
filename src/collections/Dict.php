<?php

namespace gone\collections;

use gone\Gone;
use gone\collections\Collection;
use gone\collections\interfaces\DictInterface;

class Dict extends Collection implements DictInterface{

    public function __construct($values = array()){
        parent::__construct($values);
    }

    public function items() : iterable{
        return $this->__values;
    }

    public function keys() : iterable{
        return array_keys($this->__values);
    }

    public function values() : iterable{
        return array_values($this->__values);
    }

    public function clear(){
        $this->__values = array();
    }
}