<?php

namespace IPP\student\Exceptions;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class WrongStringUsageException extends IPPException
{
    public function __construct(string $message = "Wrong string usage", ?Throwable $previous = null)
    {
        parent::__construct($message, ReturnCode::STRING_OPERATION_ERROR, $previous);
    }
}