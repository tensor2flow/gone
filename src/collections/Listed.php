<?php

namespace gone\collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use gone\collections\Collection;
use gone\collections\interfaces\ListedInterface;

class Listed extends Collection implements ListedInterface, IteratorAggregate, ArrayAccess, Countable{
    
    public function __construct(array $__values = array())
    {
        parent::__construct($__values);
    }
    
    public function keys($mask = null, $fill_with_nulls = true)
    {
        if (null !== $mask) {
            if (!is_array($mask)) {
                $mask = func_get_args();
            }
            
            if ($fill_with_nulls) {
                $keys = $mask;
            } else {
                $keys = array();
            }
            
            return array_intersect(
                array_keys($this->__values),
                $mask
            ) + $keys;
        }
        return array_keys($this->__values);
    }
    
    public function all($mask = null, $fill_with_nulls = true)
    {
        if (null !== $mask) {
            if (!is_array($mask)) {
                $mask = func_get_args();
            }
            if ($fill_with_nulls) {
                $__values = array_fill_keys($mask, null);
            } else {
                $__values = array();
            }
            return array_intersect_key(
                $this->__values,
                array_flip($mask)
            ) + $__values;
        }
        return $this->__values;
    }
    
    public function get($key, $default_val = null)
    {
        if (isset($this->__values[$key])) {
            return $this->__values[$key];
        }
        return $default_val;
    }
    
    public function set($key, $value)
    {
        $this->__values[$key] = $value;
        return $this;
    }
    
    public function replace(array $__values = array())
    {
        $this->__values = $__values;
        return $this;
    }
    
    public function merge(array $__values = array(), $hard = false)
    {
        if (!empty($__values)) {
            if ($hard) {
                $this->__values = array_replace(
                    $this->__values,
                    $__values
                );
            } else {
                $this->__values = array_merge(
                    $this->__values,
                    $__values
                );
            }
        }
        return $this;
    }
    
    public function exists($key)
    {
        return array_key_exists($key, $this->__values);
    }
    
    public function remove($key)
    {
        unset($this->__values[$key]);
    }
    
    public function clear()
    {
        return $this->replace();
    }
    
    public function isEmpty()
    {
        return empty($this->__values);
    }
    
    public function cloneEmpty()
    {
        $clone = clone $this;
        $clone->clear();
        return $clone;
    }
    
    public function __get($key)
    {
        return $this->get($key);
    }
    
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }
    
    public function __isset($key)
    {
        return $this->exists($key);
    }
    
    public function __unset($key)
    {
        $this->remove($key);
    }
    
    public function getIterator()
    {
        return new ArrayIterator($this->__values);
    }
    
    public function offsetGet($key)
    {
        return $this->get($key);
    }
    
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }
    
    public function offsetExists($key)
    {
        return $this->exists($key);
    }
    
    public function offsetUnset($key)
    {
        $this->remove($key);
    }
    
    public function count()
    {
        return count($this->__values);
    }
}