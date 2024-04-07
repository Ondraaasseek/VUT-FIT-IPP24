<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\student\Exceptions\WrongStringUsageException;
use IPP\Student\Frames\FrameController;

class InstrucInt2Char extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $args[1]);

        if (CheckSymbol::getType($symbol) != 'int'){
            throw new BadOperandTypeException("Argument 2 must be of type int.");
        }

        $value = CheckSymbol::getValue($symbol);

        if ($value < 0 || $value > 255){
            throw new WrongStringUsageException("Value must be in range 0-255.");
        }

        $char = chr($value);
        $variable->setType('string');
        $variable->setValue($char);
    }
}