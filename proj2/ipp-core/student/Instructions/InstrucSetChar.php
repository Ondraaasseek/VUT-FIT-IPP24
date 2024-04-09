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

class InstrucSetChar extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws SemanticExceptionException
     * @throws BadOperandTypeException
     * @throws WrongStringUsageException
     * @throws BadOperandValueException
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        // Edit the value of the variable on index of symbol1 with the first character stored in symbol2
        $args = $this->getArgs();
        if(count($args) != 3) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 3, got " . count($args) . ".");
        }
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if($variable->getType() != "string" || CheckSymbol::getType($symbol1) != "int" || CheckSymbol::getType($symbol2) != "string") {
            throw new BadOperandTypeException("Invalid type of variable or symbols.");
        }

        if(strlen((string)$variable->getValue()) <= (int)CheckSymbol::getValue($symbol1)) {
            throw new WrongStringUsageException("Index out of range.");
        }

        if (strlen((string)CheckSymbol::getValue($symbol2)) == 0) {
            throw new WrongStringUsageException("Empty string.");
        }

        $value = (string)CheckSymbol::getValue($symbol2);
        $variable->setType("string");
        $variable->setValue(substr_replace((string)$variable->getValue(), $value[0], (int)CheckSymbol::getValue($symbol1), 1));
    }
}