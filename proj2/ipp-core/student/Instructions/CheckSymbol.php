<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\FrameDoesNotExistsException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class CheckSymbol
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws SemanticExceptionException
     * @throws BadOperandTypeException
     * @throws FrameDoesNotExistsException
     */
    public static function checkValidity(FrameController $frameController, Instruction|string $arg): string|int|Variable
    {
        if ($arg instanceof Instruction){
            throw new SemanticExceptionException("Instruction on normal stack.");
        }
        $variable = null;
        $frameOrType = explode('@', $arg)[0];
        $nameOrValue = explode('@', $arg)[1];
        switch ($frameOrType) {
            case 'GF':
                if (!$frameController->getGlobalFrame()->hasVariable($nameOrValue)) {
                    throw new NonExistentVariableException("Variable ". $nameOrValue . " not found in " . $frameOrType . " frame.");
                }
                $variable = $frameController->getGlobalFrame()->getVariable($nameOrValue);
                break;
            case 'LF':
                if (!$frameController->getLocalFrame()->hasVariable($nameOrValue)) {
                    throw new NonExistentVariableException("Variable ". $nameOrValue . " not found in " . $frameOrType . " frame.");
                }
                $variable = $frameController->getLocalFrame()->getVariable($nameOrValue);
                break;
            case 'TF':
                if (!$frameController->getTemporaryFrame()->hasVariable($nameOrValue)) {
                    throw new NonExistentVariableException("Variable ". $nameOrValue . " not found in " . $frameOrType . " frame.");
                }
                $variable = $frameController->getTemporaryFrame()->getVariable($nameOrValue);
                break;
            case 'int':
            case 'integer':
                if (!is_numeric($nameOrValue)) {
                    throw new UnexpectedFileStructureException("Invalid integer value: " . $nameOrValue);
                }
                $variable = (int)$nameOrValue;
                break;
            case 'nil':
            case 'string':
                $variable = $nameOrValue;
                break;
            case 'bool':
                if (!in_array($nameOrValue, ['true', 'false'], true)) {
                    throw new UnexpectedFileStructureException("Invalid boolean value: " . $nameOrValue);
                }
                $variable = $nameOrValue;
                break;
            case 'float':
                if (!is_numeric($nameOrValue)) {
                    throw new UnexpectedFileStructureException("Invalid float value: " . $nameOrValue);
                }
                throw new NotImplementedException("Float is not implemented.");
            default:
                throw new NonExistentVariableException("Variable " . $nameOrValue . " was not found in " . $frameOrType . " frame.");
        }
        if ($variable === null){
            throw new BadOperandTypeException("Variable " . $nameOrValue . " is bad Type.");
        }
        return $variable;
    }

    public static function getValue(string|int|bool|Variable $symbol): string|int|bool
    {
        if ($symbol instanceof Variable){
            return $symbol->getValue();
        }
        else return $symbol;
    }

    /**
     * @throws BadOperandValueException
     */
    public static function getType(string|int|bool|Variable $symbol): string
    {
        if ($symbol instanceof Variable){
            $return = $symbol->getType();
            if ($return == null){
                return '';
            }
        }
        else if ($symbol == 'true' || $symbol == 'false'){
            return 'bool';
        }
        else if ($symbol == 'nil' || $symbol == ''){
            return 'nil';
        }
        else
            $return = gettype($symbol);
            if ($return == null) {
                return '';
            }
        return $return;
    }
}