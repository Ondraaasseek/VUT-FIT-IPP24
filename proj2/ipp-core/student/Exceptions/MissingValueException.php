<?php

namespace IPP\student\Exceptions;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class MissingValueException extends IPPException
{
    public function __construct(string $message = "Missing value", ?Throwable $previous = null)
    {
        parent::__construct($message, ReturnCode::VALUE_ERROR, $previous, false);
    }
}