<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class InstrucDefVar extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        // Get before the @ part from the string
        $frame = explode('@', $args[0])[0]; // Frame
        $var = explode('@', $args[0])[1]; // Variable
        $var = new Variable($var, null, null);
        switch ($frame) {
            case 'GF':
                $frameController->getGlobalFrame()->addVariable($var);
                break;
            case 'LF':
                $frameController->getLocalFrame()->addVariable($var);
                break;
            case 'TF':
                $frameController->getTemporaryFrame()->addVariable($var);
                break;
            default:
                // Should not happen
                break;
        }
    }
}