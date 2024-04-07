<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\Student\Frames\FrameController;

class InstrucNot extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement Not logic.
        $args = $this->getArgs();
        $var = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $args[1]);

        if (CheckSymbol::getType($symbol) == 'bool'){
            $var->setType('bool');
            $var->setValue(!CheckSymbol::getValue($symbol));
        }
        else{
            throw new BadOperandTypeException("Argument must be of type bool.");
        }
    }
}