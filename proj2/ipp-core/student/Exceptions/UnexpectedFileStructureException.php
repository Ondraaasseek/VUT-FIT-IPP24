<?php

namespace IPP\Student\Exceptions;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class UnexpectedFileStructureException extends IPPException
{
    public function __construct(string $message = "Invalid source structure", ?Throwable $previous = null)
    {
        parent::__construct($message, ReturnCode::INVALID_SOURCE_STRUCTURE, $previous, false);
    }
}