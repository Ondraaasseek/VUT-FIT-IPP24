<?php

namespace IPP\Student\Instructions;

use IPP\Student\Exceptions\FrameDoesNotExistsException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class InstrucDefVar extends Instruction
{
    /**
     * @throws FrameDoesNotExistsException
     * @throws UnexpectedFileStructureException
     * @throws SemanticExceptionException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) !== 1) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 1, got " . count($args) . ".");
        }
        // Get before the @ part from the string
        $frame = explode('@', $args[0])[0]; // Frame
        $var = explode('@', $args[0])[1]; // Variable
        $var = new Variable($var, null, null);
        switch ($frame) {
            case 'GF':
                $exists = $frameController->getGlobalFrame()->getVariable($var->getName());
                if ($exists !== null) {
                    throw new SemanticExceptionException("Variable " . $var->getName() . " already exists in the global frame.");
                }
                $frameController->getGlobalFrame()->addVariable($var);
                break;
            case 'LF':
                $exists = $frameController->getLocalFrame()->getVariable($var->getName());
                if ($exists !== null) {
                    throw new SemanticExceptionException("Variable " . $var->getName() . " already exists in the global frame.");
                }
                $frameController->getLocalFrame()->addVariable($var);
                break;
            case 'TF':
                $exists = $frameController->getTemporaryFrame()->getVariable($var->getName());
                if ($exists !== null) {
                    throw new SemanticExceptionException("Variable " . $var->getName() . " already exists in the global frame.");
                }
                $frameController->getTemporaryFrame()->addVariable($var);
                break;
            default:
                // Should not happen
                break;
        }
    }
}