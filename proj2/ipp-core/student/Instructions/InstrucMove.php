<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Exceptions\NonExistentVariableException;
class InstrucMove extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws SemanticExceptionException
     * @throws BadOperandValueException
     * @throws BadOperandTypeException
     */
    public function execute(FrameController $frameController): void
    {
        // First argument is where to move the value
        // Second argument is the value to move we need to resolve the type
        $args = $this->getArgs();
        if (count($args) !== 2) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 2, got " . count($args) . ".");
        }

        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $args[1]);

        $variable->setType(CheckSymbol::getType($symbol));
        $variable->setValue(CheckSymbol::getValue($symbol));
    }
}