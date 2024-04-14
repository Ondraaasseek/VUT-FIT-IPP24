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


        if (CheckSymbol::getType($arg1) != CheckSymbol::getType($arg2) && (CheckSymbol::getType($arg1) != 'nil' && CheckSymbol::getType($arg2) != 'nil')){
            throw new BadOperandTypeException("Types in relation operation were not the same.");

        }

        if (CheckSymbol::getType($arg1) == 'string' || CheckSymbol::getType($arg2) == 'string'){
            $value1 = CheckSymbol::getValue($arg1);
            $value2 = CheckSymbol::getValue($arg2);

            if ($value1 == 'nil'){
                $value1 = '';
            }

            if ($value2 == 'nil'){
                $value2 = '';
            }

            $result = strcmp((string)$value1, (string)$value2);
            $variable->setType('bool');
            if ($result == 0){
                $variable->setValue('true');
            } else {
                $variable->setValue('false');
            }
        }

        if (CheckSymbol::getType($arg1) == 'int' || CheckSymbol::getType($arg1) == 'integer' || CheckSymbol::getType($arg2) == 'int' || CheckSymbol::getType($arg2) == 'integer'){
            $value1 = CheckSymbol::getValue($arg1);
            $value2 = CheckSymbol::getValue($arg2);

            if ($value1 == 'nil'){
                $value1 = 0;
            }

            if ($value2 == 'nil'){
                $value2 = 0;
            }

            $variable->setType('bool');
            if ($value1 == $value2){
                $variable->setValue('true');
            } else {
                $variable->setValue('false');
            }
        }

        if (CheckSymbol::getType($arg1) == 'bool' || CheckSymbol::getType($arg2) == 'bool'){
            $value1 = CheckSymbol::getValue($arg1) === "true";
            $value2 = CheckSymbol::getValue($arg2) === "true";

            if ($value1 != 1){
                $value1 = 0;
            }
            if ($value2 != 1){
                $value2 = 0;
            }

            $variable->setType('bool');
            if ($value1 == $value2){
                $variable->setValue('true');
            } else {
                $variable->setValue('false');
            }
        }

        if (CheckSymbol::getType($arg1) == 'nil' && CheckSymbol::getType($arg2) == 'nil'){
            $variable->setType('bool');
            $variable->setValue('true');
        }
    }
}