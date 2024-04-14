<?php

namespace IPP\Student\Instructions;

use IPP\Student\Exceptions\FrameDoesNotExistsException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class CheckVariable
{
    /**
     * @throws NonExistentVariableException
     * @throws FrameDoesNotExistsException
     * @throws UnexpectedFileStructureException
     */
    public static function checkValidity(FrameController $frameController, string $arg): Variable
    {
        $frame = explode('@', $arg)[0];
        $name = explode('@', $arg)[1];
        switch ($frame){
            case 'GF':
                if (!$frameController->getGlobalFrame()->hasVariable($name)) {
                    throw new NonExistentVariableException("Variable ". $name . " not found in " . $frame . " frame.");
                }
                $variable = $frameController->getGlobalFrame()->getVariable($name);
                break;
            case 'LF':
                if (!$frameController->getLocalFrame()->hasVariable($name)) {
                    throw new NonExistentVariableException("Variable ". $name . " not found in " . $frame . " frame.");
                }
                $variable = $frameController->getLocalFrame()->getVariable($name);
                break;
            case 'TF':
                if (!$frameController->getTemporaryFrame()->hasVariable($name)) {
                    throw new NonExistentVariableException("Variable ". $name . " not found in " . $frame . " frame.");
                }
                $variable = $frameController->getTemporaryFrame()->getVariable($name);
                break;
            default:
                throw new UnexpectedFileStructureException("First argument is not variable. Expected GF, LF or TF.");
        }

        return $variable;
    }
}