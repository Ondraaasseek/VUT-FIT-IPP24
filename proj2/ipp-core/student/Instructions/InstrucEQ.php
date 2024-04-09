<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucEQ extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws BadOperandTypeException
     * @throws SemanticExceptionException
     * @throws BadOperandValueException
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) != 3){
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 3, got " . count($args) . ".");
        }

        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $arg1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $arg2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if (CheckSymbol::getType($arg1) != CheckSymbol::getType($arg2)){
            throw new BadOperandTypeException("Types in relation operation were not the same.");
        }

        if (CheckSymbol::getType($arg1) == 'string'){
            $value1 = CheckSymbol::getValue($arg1);
            $value2 = CheckSymbol::getValue($arg2);

            $result = strcmp((string)$value1, (string)$value2);
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