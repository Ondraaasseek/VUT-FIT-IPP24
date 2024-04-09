<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucType extends Instruction
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
        // Dynamic type checking
        $args = $this->getArgs();
        if (count($args) != 2){
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 2, got " . count($args) . ".");
        }

        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $symbol = CheckSymbol::checkValidity($frameController, $args[1]);

        $type = CheckSymbol::getType($symbol);
        $variable->setType('string');
        if ($type == 'int' || $type == 'integer'){
            $variable->setValue('int');
        } else if ($type == 'bool'){
            $variable->setValue('bool');
        } else if ($type == 'string'){
            $variable->setValue('string');
        } else if ($type == 'nil'){
            $variable->setValue('nil');
        } else {
            $variable->setValue('');
        }
    }
}