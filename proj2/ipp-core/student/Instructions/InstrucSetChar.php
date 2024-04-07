<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\student\Exceptions\WrongStringUsageException;
use IPP\Student\Frames\FrameController;

class InstrucSetChar extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        // Edit the value of the variable on index of symbol1 with the first character stored in symbol2
        $args = $this->getArgs();
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if($variable->getType() != "string" || CheckSymbol::getType($symbol1) != "int" || CheckSymbol::getType($symbol2) != "string") {
            throw new BadOperandTypeException("Invalid type of variable or symbols.");
        }

        if(strlen($variable->getValue()) <= CheckSymbol::getValue($symbol1)) {
            throw new WrongStringUsageException("Index out of range.");
        }

        if (strlen(CheckSymbol::getValue($symbol2)) == 0) {
            throw new WrongStringUsageException("Empty string.");
        }

        $value = CheckSymbol::getValue($symbol2)[0];
        $variable->setType("string");
        $variable->setValue(substr_replace($variable->getValue(), $value, CheckSymbol::getValue($symbol1), 1));
    }
}