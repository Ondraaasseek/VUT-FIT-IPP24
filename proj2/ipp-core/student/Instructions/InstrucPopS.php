<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\MissingValueException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class InstrucPopS extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement PopS logic.
        $arg = $this->getArgs();
        $output = $frameController->popStack();

        $variable = CheckVariable::checkValidity($frameController, $arg[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $output);

        $variable->setType(CheckSymbol::getType($symbol));
        $variable->setValue(CheckSymbol::getValue($symbol));
    }
}