<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucNot extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws BadOperandTypeException
     * @throws UnexpectedFileStructureException
     * @throws SemanticExceptionException
     * @throws BadOperandValueException
     */
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement Not logic.
        $args = $this->getArgs();
        if (count($args) != 2){
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 2, got " . count($args) . ".");
        }
        $var = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $args[1]);

        if (CheckSymbol::getType($symbol) == 'bool'){
            $var->setType('bool');
            $var->setValue(!CheckSymbol::getValue($symbol));
        }
        else{
            throw new BadOperandTypeException("Argument must be of type bool.");
        }
    }
}