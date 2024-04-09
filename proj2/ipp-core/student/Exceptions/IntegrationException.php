<?php

namespace IPP\student\Exceptions;

use IPP\Core\Exception\IPPException;
use IPP\Core\ReturnCode;

class IntegrationException extends IPPException
{
    public function __construct(string $message = "Integration error", ?Throwable $previous = null)
    {
        parent::__construct($message, ReturnCode::INTEGRATION_ERROR, $previous, false);
    }
}