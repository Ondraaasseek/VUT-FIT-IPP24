<?php

namespace IPP\Student\Instructions;

use IPP\Student\Exceptions\SemanticExceptionException;

class CheckLabel
{
    /**
     * @throws SemanticExceptionException
     */
    public static function checkValidity(string $label) : string
    {
        // Check if the label is valid Label can be a-Z and 0-9 and _ - $ & % * ! ?
        if (!preg_match('/^[a-zA-Z0-9_\-&%*$!?]*$/', $label)) {
            throw new SemanticExceptionException('Invalid label.');
        }
        return $label;
    }
}