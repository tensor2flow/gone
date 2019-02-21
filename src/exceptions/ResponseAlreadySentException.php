<?php

namespace gone\exceptions;

use RuntimeException;
use gone\exceptions\interfaces\ExceptionInterface;

class ResponseAlreadySentException extends RuntimeException implements ExceptionInterface{
    
}