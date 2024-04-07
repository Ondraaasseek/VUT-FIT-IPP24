<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\student\Exceptions\WrongStringUsageException;
use IPP\Student\Frames\FrameController;

class InstrucStri2Int extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement Stri2Int logic.
        $args = $this->getArgs();
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if (CheckSymbol::getType($symbol1) == 'string' && CheckSymbol::getType($symbol2) == 'int') {
            $string = CheckSymbol::getValue($symbol1);
            $index = CheckSymbol::getValue($symbol2);

            if ($index < 0 || $index >= strlen($string)){
                throw new WrongStringUsageException("Index out of range.");
            }

            $char = $string[$index];
            $ascii = ord($char);

            $variable->setType('int');
            $variable->setValue($ascii);
        } else {
            throw new BadOperandTypeException("Argument 1 must be of type string and argument 2 must be of type int.");
        }
    }
}