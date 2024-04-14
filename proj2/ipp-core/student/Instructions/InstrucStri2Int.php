<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\FrameDoesNotExistsException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Exceptions\WrongStringUsageException;
use IPP\Student\Frames\FrameController;

class InstrucStri2Int extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws SemanticExceptionException
     * @throws BadOperandTypeException
     * @throws WrongStringUsageException
     * @throws BadOperandValueException
     * @throws UnexpectedFileStructureException
     * @throws FrameDoesNotExistsException
     */
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement Stri2Int logic.
        $args = $this->getArgs();
        if (count($args) != 3) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 3, got " . count($args) . ".");
        }
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $symbol2 = CheckSymbol::checkValidity($frameController, $args[2]);

        if (CheckSymbol::getType($symbol1) == 'string' && ( CheckSymbol::getType($symbol2) == 'int' || CheckSymbol::getType($symbol2) == 'integer' )) {
            $string = (string)CheckSymbol::getValue($symbol1);
            $index = CheckSymbol::getValue($symbol2);
            if ($index == null){
                $index = 0;
            }
            if ($index < 0 || $index >= strlen($string)){
                throw new WrongStringUsageException("Index out of range.");
            }

            $char = $string[(int)$index];
            $ascii = ord($char);

            $variable->setType('int');
            $variable->setValue($ascii);
        } else {
            throw new BadOperandTypeException("Argument 1 must be of type string and argument 2 must be of type int.");
        }
    }
}