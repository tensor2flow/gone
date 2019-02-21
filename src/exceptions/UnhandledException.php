<?php

namespace gone\exceptions;

use RuntimeException;
use gone\exceptions\interfaces\ExceptionInterface;

class UnhandledException extends RuntimeException implements ExceptionInterface{
    
}