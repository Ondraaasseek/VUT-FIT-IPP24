<?php

namespace IPP\student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\student\Exceptions\NonExistentVariableException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class CheckVariable
{
    public static function checkValidity(FrameController $frameController, string $arg): Variable
    {
        $frame = explode('@', $arg)[0];
        $name = explode('@', $arg)[1];
        switch ($frame){
            case 'GF':
                $variable = $frameController->getGlobalFrame()->getVariable($name);
                break;
            case 'LF':
                $variable = $frameController->getLocalFrame()->getVariable($name);
                break;
            case 'TF':
                $variable = $frameController->getTemporaryFrame()->getVariable($name);
                break;
            default:
                // Should not happen
                throw new BadOperandTypeException("First argument is not variable.");
                break;
        }

        if ($variable === null){
            throw new NonExistentVariableException("Variable ". $name . " not found in " . $frame . " frame.");
        }
        return $variable;
    }
}