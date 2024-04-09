<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Core\StreamWriter;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucExit extends Instruction
{
    /**
     * @throws NotImplementedException
     * @throws NonExistentVariableException
     * @throws BadOperandTypeException
     * @throws SemanticExceptionException
     * @throws BadOperandValueException
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement Exit logic.
        $args = $this->getArgs();
        if (count($args) != 1) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 1, got " . count($args) . ".");
        }
        $symbol = CheckSymbol::checkValidity($frameController, $args[0]);

        if (CheckSymbol::getType($symbol) == 'int' || CheckSymbol::getType($symbol) == 'integer'){
            if (CheckSymbol::getValue($symbol) < 0 || CheckSymbol::getValue($symbol) > 9) {
                throw new BadOperandValueException("Exit operand must be in range 0-9.");
            }
        } else {
            throw new BadOperandTypeException("Exit operand must be of type int.");
        }

        $frameController->getStatistics($this);
        exit(CheckSymbol::getValue($symbol));
    }
}