<?php

namespace gone\collections;

use gone\collections\Collection;
use gone\collections\interfaces\MappingInterface;

class Mapping extends Collection implements MappingInterface{
    public function __construct($values = array()){
        parent::__construct($values);
    }
}