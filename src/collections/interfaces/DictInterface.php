<?php

namespace gone\collections\interfaces;

interface DictInterface{
    public function __set($index, $value);

    public function __get($index);

    public function __isset($content);

    public function __unset($content);

    public function __toString();

    public function items() : iterable;

    public function keys() : iterable;

    public function values() : iterable;

    public function clear();
}