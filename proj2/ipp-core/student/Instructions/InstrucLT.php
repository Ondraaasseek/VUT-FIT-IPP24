<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucLT extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws BadOperandTypeException
     * @throws UnexpectedFileStructureException
     * @throws BadOperandValueException
     * @throws SemanticExceptionException
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

        if (CheckSymbol::getType($arg1) == 'nil' || CheckSymbol::getType($arg2) == 'nil'){
            throw new BadOperandTypeException("Cannot compare nil value.");
        }

        if (CheckSymbol::getType($arg1) == 'string'){
            $value1 = CheckSymbol::getValue($arg1);
            $value2 = CheckSymbol::getValue($arg2);

            $result = strcmp((string)$value1, (string)$value2);
            $variable->setType('bool');
            if ($result < 0){
                $variable->setValue('true');
            } else {
                $variable->setValue('false');
            }
        }

        if (CheckSymbol::getType($arg1) == 'int' || CheckSymbol::getType($arg1) == 'integer'){
            $value1 = CheckSymbol::getValue($arg1);
            $value2 = CheckSymbol::getValue($arg2);

            $variable->setType('bool');
            if ($value1 < $value2){
                $variable->setValue('true');
            } else {
                $variable->setValue('false');
            }
        }

        if (CheckSymbol::getType($arg1) == 'bool'){
            $value1 = CheckSymbol::getValue($arg1) === 'true' ? 1 : 0;
            $value2 = CheckSymbol::getValue($arg2) === 'true' ? 1 : 0;

            $variable->setType('bool');
            if ($value1 < $value2){
                $variable->setValue('true');
            } else {
                $variable->setValue('false');
            }
        }
    }
}