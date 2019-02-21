<?php

namespace gone\exceptions;

use UnexpectedValueException;
use gone\exceptions\interfaces\ExceptionInterface;

class ValidationException extends UnexpectedValueException implements ExceptionInterface{
}