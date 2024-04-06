<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;
use IPP\Student\Exceptions\NonExistentVariableException;
class InstrucMove extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement Move logic.
        // First argument is where to move the value
        // Second argument is the value to move we need to resolve the type
        $args = $this->getArgs();
        $variable = null;
        $frame = explode('@', $args[0])[0]; // Frame
        $var = explode('@', $args[0])[1]; // Variable
        // find the variable in the frame
        switch ($frame) {
            case 'GF':
                $variable = $frameController->getGlobalFrame()->getVariable($var);
                break;
            case 'LF':
                $variable = $frameController->getLocalFrame()->getVariable($var);
                break;
            case 'TF':
                $variable = $frameController->getTemporaryFrame()->getVariable($var);
                break;
            default:
                // Should not happen
                break;
        }
        if ($variable === null) {
            throw new NonExistentVariableException("did not found variable name: " . $var . " in frame: " . $frame);
        }
        // Asign the value to the variable
        $type = explode('@', $args[1])[0];
        $value = explode('@', $args[1])[1];

        $variable->setValue($value);
        $variable->setType($type);
    }
}