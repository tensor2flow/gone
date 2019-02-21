<?php

namespace gone\exceptions;

use RuntimeException;
use gone\exceptions\interfaces\ExceptionInterface;

class DispatchHaltedException extends RuntimeException implements ExceptionInterface
{
    
    
    const SKIP_THIS = 1;
    
    
    const SKIP_NEXT = 2;
    
    
    const SKIP_REMAINING = 0;
    
    
    protected $number_of_skips = 1;
    
    
    public function getNumberOfSkips()
    {
        return $this->number_of_skips;
    }
    
    public function setNumberOfSkips($number_of_skips)
    {
        $this->number_of_skips = (int) $number_of_skips;
        return $this;
    }
}