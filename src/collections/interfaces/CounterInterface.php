<?php

namespace gone\collections\interfaces;

interface CounterInterface{
    public function elements();

    public function subtract($map);

    public function update($map);

    public function values();

    public function clear();

    public function items();
}