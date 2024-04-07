<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;

class InstrucType extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        // Dynamic type checking
        $args = $this->getArgs();
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $args[1]);

        $type = CheckSymbol::getType($symbol);
        $variable->setType('string');
        if ($type == 'int'){
            $variable->setValue('int');
        } else if ($type == 'bool'){
            $variable->setValue('bool');
        } else if ($type == 'string'){
            $variable->setValue('string');
        } else {
            $variable->setValue('');
        }
    }
}