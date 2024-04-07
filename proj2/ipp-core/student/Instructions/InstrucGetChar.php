<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\student\Exceptions\WrongStringUsageException;
use IPP\Student\Frames\FrameController;

class InstrucGetChar extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if (CheckSymbol::getType($symbol1) != "string" || CheckSymbol::getType($symbol2) != "int") {
            throw new BadOperandTypeException("Invalid type of symbol, expected string and int.");
        }

        if (strlen(CheckSymbol::getValue($symbol1)) <= CheckSymbol::getValue($symbol2)) {
            throw new WrongStringUsageException("Index out of range.");
        }

        // get value from symbol1 with index from symbol2
        $value = substr($symbol1->getValue(), $symbol2->getValue(), 1);
        $variable->setType("string");
        $variable->setValue($value);

    }
}