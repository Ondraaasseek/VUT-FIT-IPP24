<?php

namespace IPP\student\Instructions;

use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class AritmeticArgumetsCheck
{
    public static function checkValidity(FrameController $frameController, array $arguments){
        $arg1 = $arguments[0];
        $arg2 = $arguments[1];
        $arg3 = $arguments[2];

        // First is 100% variable
        $frame = explode('@', $arg1)[0];
        $name = explode('@', $arg1)[1];
        switch($frame){
            case 'GF':
                $variable1 = $frameController->getGlobalFrame()->getVariable($name);
                break;
            case 'LF':
                $variable1 = $frameController->getLocalFrame()->getVariable($name);
                break;
            case 'TF':
                $variable1 = $frameController->getTemporaryFrame()->getVariable($name);
                break;
            default:
                // This should not happen
                break;
        }
        if ($variable1 === null){
            throw new NonExistentVariableException("Variable " . $name . "does not exists in " . $frame . " frame.");
        }

        // The Second and third parameter can be variable or symbol but has to be int
        $frame = explode('@', $arg2)[0];
        $name = explode('@', $arg2)[1];
        switch ($frame){
            case 'GF':
                $variable2 = $frameController->getGlobalFrame()->getVariable($name);
                break;
            case 'LF':
                $variable2 = $frameController->getLocalFrame()->getVariable($name);
                break;
            case 'TF':
                $variable2  = $frameController->getTemporaryFrame()->getVariable($name);
                break;
            case 'int':
                $variable2 = (int)$name;
                break;
            default:
                throw new BadOperandTypeException("Ve scitani nebyl vyuzit int");
        }

        if ($variable2 === null){
            throw new NonExistentVariableException("Variable " . $name . "does not exists in " . $frame . " frame.");
        }

        $frame = explode('@', $arg3)[0];
        $name = explode('@', $arg3)[1];
        switch ($frame){
            case 'GF':
                $variable3 = $frameController->getGlobalFrame()->getVariable($name);
                break;
            case 'LF':
                $variable3 = $frameController->getLocalFrame()->getVariable($name);
                break;
            case 'TF':
                $variable3  = $frameController->getTemporaryFrame()->getVariable($name);
                break;
            case 'int':
                $variable3 = (int)$name;
                break;
            default:
                throw new BadOperandTypeException("Ve scitani nebyl vyuzit int");
                break;
        }

        if ($variable3 === null){
            throw new NonExistentVariableException("Variable " . $name . "does not exists in " . $frame . " frame.");
        }
    }
}