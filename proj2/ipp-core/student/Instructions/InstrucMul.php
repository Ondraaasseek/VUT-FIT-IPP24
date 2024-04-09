<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucMul extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws SemanticExceptionException
     * @throws BadOperandValueException
     * @throws BadOperandTypeException
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

        if ((CheckSymbol::getType($symbol1) == 'integer' || CheckSymbol::getType($symbol1) == 'int') && (CheckSymbol::getType($symbol2) == 'integer' || CheckSymbol::getType($symbol2) == 'int')) {
            $sum = (int)CheckSymbol::getValue($symbol1) * (int)CheckSymbol::getValue($symbol2);
        } else {
            throw new BadOperandTypeException("Both arguments must be of type int.");
        }
        $variable->setType('int');
        $variable->setValue($sum);
    }
}