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
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $args[1]);

        $variable->setType(CheckSymbol::getType($symbol));
        $variable->setValue(CheckSymbol::getValue($symbol));
    }
}