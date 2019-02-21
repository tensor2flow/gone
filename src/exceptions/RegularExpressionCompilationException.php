<?php

namespace gone\exceptions;

use RuntimeException;
use gone\exceptions\interfaces\ExceptionInterface;

class RegularExpressionCompilationException extends RuntimeException implements ExceptionInterface{
    
}