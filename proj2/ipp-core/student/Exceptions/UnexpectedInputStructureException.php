<?php

namespace IPP\Student\Exceptions;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;
use Throwable;

class UnexpectedInputStructureException extends IPPException
{
    public function __construct(string $message = "Invalid input", ?Throwable $previous = null)
    {
        parent::__construct($message, ReturnCode::INVALID_XML_ERROR, $previous, false);
    }
}