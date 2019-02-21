<?php

namespace gone\exceptions;

use OverflowException;
use gone\exceptions\interfaces\ExceptionInterface;

class DuplicateServiceException extends OverflowException implements ExceptionInterface{
}