<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\BadOperandTypeException;
use IPP\Student\Frames\FrameController;

class InstrucEQ extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();

        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $arg1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $arg2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if (CheckSymbol::getType($arg1) != CheckSymbol::getType($arg2)){
            throw new BadOperandTypeException("Types in relation operation were not the same.");
        }

        if (CheckSymbol::getType($arg1) == 'string'){
            $value1 = CheckSymbol::getValue($arg1);
            $value2 = CheckSymbol::getValue($arg2);

            $result = strcmp($value1, $value2);
            $variable->setType('bool');
            if ($result == 0){
                $variable->setValue('true');
            } else {
                $variable->setValue('false');
            }
        }

        if (CheckSymbol::getType($arg1) == 'int'){
            $value1 = CheckSymbol::getValue($arg1);
            $value2 = CheckSymbol::getValue($arg2);

            $variable->setType('bool');
            if ($value1 == $value2){
                $variable->setValue('true');
            } else {
                $variable->setValue('false');
            }
        }

        if (CheckSymbol::getType($arg1) == 'bool'){
            $value1 = (int)CheckSymbol::getValue($arg1);
            $value2 = (int)CheckSymbol::getValue($arg2);

            $variable->setType('bool');
            if ($value1 == $value2){
                $variable->setValue('true');
            } else {
                $variable->setValue('false');
            }
        }
    }
}