<?php

namespace gone\exceptions;

use RuntimeException;
use gone\exceptions\interfaces\ExceptionInterface;

class LockedResponseException extends RuntimeException implements ExceptionInterface{

}