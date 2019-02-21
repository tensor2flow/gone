<?php

namespace gone\exceptions;

use OutOfBoundsException;
use gone\exceptions\interfaces\ExceptionInterface;

class UnknownServiceException extends OutOfBoundsException implements ExceptionInterface{
}