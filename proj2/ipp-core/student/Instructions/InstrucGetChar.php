<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Exceptions\WrongStringUsageException;
use IPP\Student\Frames\FrameController;

class InstrucGetChar extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws BadOperandTypeException
     * @throws WrongStringUsageException
     * @throws SemanticExceptionException
     * @throws BadOperandValueException
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) != 3) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 3, got " . count($args) . ".");
        }
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if (CheckSymbol::getType($symbol1) != "string" || CheckSymbol::getType($symbol2) != "int") {
            throw new BadOperandTypeException("Invalid type of symbol, expected string and int.");
        }

        if (strlen((string)CheckSymbol::getValue($symbol1)) <= CheckSymbol::getValue($symbol2)) {
            throw new WrongStringUsageException("Index out of range.");
        }

        // get value from symbol1 with index from symbol2
        $value = substr((string)CheckSymbol::getValue($symbol1), (int)CheckSymbol::getValue($symbol2), 1);
        $variable->setType("string");
        $variable->setValue($value);

    }
}