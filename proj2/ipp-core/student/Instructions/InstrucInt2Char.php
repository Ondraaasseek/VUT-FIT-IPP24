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

class InstrucInt2Char extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws BadOperandTypeException
     * @throws WrongStringUsageException
     * @throws BadOperandValueException
     * @throws SemanticExceptionException
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) != 2){
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 2, got " . count($args) . ".");
        }
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $args[1]);

        if (CheckSymbol::getType($symbol) != 'int' && CheckSymbol::getType($symbol) != 'integer'){
            throw new BadOperandTypeException("Argument 2 must be of type int.");
        }

        $value = CheckSymbol::getValue($symbol);

        if ($value < 0 || $value > 255){
            throw new WrongStringUsageException("Value must be in range 0-255.");
        }

        $char = chr((int)$value);
        $variable->setType('string');
        $variable->setValue($char);
    }
}