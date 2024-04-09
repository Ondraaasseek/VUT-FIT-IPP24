<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\MissingValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucPushS extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws UnexpectedFileStructureException
     * @throws BadOperandValueException
     * @throws SemanticExceptionException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) != 1) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 1, got " . count($args) . ".");
        }
        $symbol = CheckSymbol::checkValidity($frameController, $args[0]);
        $output = CheckSymbol::getType($symbol) . "@" . CheckSymbol::getValue($symbol);

        $frameController->pushStack($output);
    }
}