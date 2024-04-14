<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucOr extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws BadOperandTypeException
     * @throws SemanticExceptionException
     * @throws UnexpectedFileStructureException
     * @throws BadOperandValueException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) != 3){
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 3, got " . count($args) . ".");
        }

        $var = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if (CheckSymbol::getType($symbol1) == 'bool' && CheckSymbol::getType($symbol2) == 'bool'){
            $var->setType('bool');

            $val1 = CheckSymbol::getValue($symbol1) === "true";
            $val2 = CheckSymbol::getValue($symbol2) === "true";

            if ($val1 != 1){
                $val1 = 0;
            }
            if ($val2 != 1){
                $val2 = 0;
            }

            if ($val1 && $val2){
                $var->setValue("true");
            }
            elseif ($val1 || $val2){
                $var->setValue("true");
            }
            else{
                $var->setValue("false");
            }

        }
        else{
            throw new BadOperandTypeException("Arguments must be of type bool.");
        }
    }
}