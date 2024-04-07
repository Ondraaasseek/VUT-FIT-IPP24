<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\Student\Frames\FrameController;

class InstrucAdd extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if (CheckSymbol::getType($symbol1) == 'int' && CheckSymbol::getType($symbol2) == 'int'){
            $sum = CheckSymbol::getValue($symbol1) + CheckSymbol::getValue($symbol2);
        } else {
            throw new BadOperandTypeException("Both arguments must be of type int.");
        }
        $variable->setType('int');
        $variable->setValue($sum);
    }
}