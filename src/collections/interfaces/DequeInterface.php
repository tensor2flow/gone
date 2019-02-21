<?php

namespace gone\collections\interfaces;

interface DequeInterface{
    public function append($x);

    public function appendleft($x);

    public function clear();

    public function count();

    public function extend($iterable);

    public function extendleft($iterable);

    public function pop();

    public function popleft();

    public function remove($value);

    public function reverse();
}