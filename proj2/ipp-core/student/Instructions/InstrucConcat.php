<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\Student\Frames\FrameController;

class InstrucConcat extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        // To $variable set the concatenated value of $symbol1 and $symbol2
        if (CheckSymbol::getType($symbol1) == 'string' && CheckSymbol::getType($symbol2) == 'string') {
            $variable->setType('string');
            $variable->setValue(CheckSymbol::getValue($symbol1) . CheckSymbol::getValue($symbol2));
        } else {
            throw new BadOperandTypeException("Invalid type used. Expected strings.");
        }
    }
}