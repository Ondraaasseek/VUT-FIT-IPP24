<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class InstrucOr extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();

        $var = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if (CheckSymbol::getType($symbol1) == 'bool' && CheckSymbol::getType($symbol2) == 'bool'){
            $var->setType('bool');
            $var->setValue(CheckSymbol::getValue($symbol1) || CheckSymbol::getValue($symbol2));
        }
        else{
            throw new BadOperandTypeException("Arguments must be of type bool.");
        }
    }
}