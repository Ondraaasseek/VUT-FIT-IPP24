<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\Student\Frames\FrameController;

class InstrucStrLen extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $args[1]);

        // Save the length of the symbol to the variable
        if (CheckSymbol::getType($symbol) == "string") {
            $variable->setType('int');
            $variable->setValue(strlen($symbol->getValue()));
        } else {
            throw new BadOperandTypeException("The symbol is not a string.");
        }
    }
}