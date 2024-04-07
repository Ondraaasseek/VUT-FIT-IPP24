<?php

namespace IPP\student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\student\Exceptions\NonExistentVariableException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class CheckSymbol
{
    public static function checkValidity(FrameController $frameController, string $arg): string|int|bool|Variable
    {
        $frameOrType = explode('@', $arg)[0];
        $nameOrValue = explode('@', $arg)[1];
        switch ($frameOrType) {
            case 'GF':
                $variable = $frameController->getGlobalFrame()->getVariable($nameOrValue);
                break;
            case 'LF':
                $variable = $frameController->getLocalFrame()->getVariable($nameOrValue);
                break;
            case 'TF':
                $variable = $frameController->getTemporaryFrame()->getVariable($nameOrValue);
                break;
            case 'int':
                $variable = (int)$nameOrValue;
                break;
            case 'string':
                $variable = $nameOrValue;
                break;
            case 'bool':
                $variable = (bool)$nameOrValue;
                break;
            case 'nil':
                $variable = $nameOrValue;
            case 'float':
                throw new NotImplementedException("Float is not implemented.");
                break;
        }
        if ($variable === null){
            throw new NonExistentVariableException("Variable " . $nameOrValue . "was not found in " . $frameOrType . " frame.");
        }

        return $variable;
    }

    public static function getValue(string|int|bool|Variable $symbol){
        if ($symbol instanceof Variable){
            return $symbol->getValue();
        }
        else return $symbol;
    }

    public static function getType(string|int|bool|Variable $symbol){
        if ($symbol instanceof Variable){
            return $symbol->getType();
        }
        else if ($symbol == 'nil'){
            return 'nil';
        }
        else return gettype($symbol);
    }
}