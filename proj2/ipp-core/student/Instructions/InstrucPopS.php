<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\MissingValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucPopS extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws MissingValueException
     * @throws NotImplementedException
     * @throws BadOperandTypeException
     * @throws UnexpectedFileStructureException
     * @throws SemanticExceptionException
     * @throws BadOperandValueException
     */
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement PopS logic.
        $args = $this->getArgs();
        if (count($args) !== 1) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 1, got " . count($args) . ".");
        }
        $output = $frameController->popStack();

        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $output);

        $variable->setType(CheckSymbol::getType($symbol));
        $variable->setValue(CheckSymbol::getValue($symbol));
    }
}