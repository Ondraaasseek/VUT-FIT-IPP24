<?php

namespace IPP\student\Exceptions;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

class UnexpectedInputStructureException extends IPPException
{
    public function __construct(string $message = "Invalid input", ?Throwable $previous = null)
    {
        parent::__construct($message, ReturnCode::INVALID_XML_ERROR, $previous, false);
    }
}