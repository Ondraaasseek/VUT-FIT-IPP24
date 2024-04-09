<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucJumpIfEq extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws SemanticExceptionException
     * @throws BadOperandValueException
     * @throws UnexpectedFileStructureException
     * @throws BadOperandTypeException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) != 3) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 3, got " . count($args) . ".");
        }
        $label = CheckLabel::checkValidity(explode('@', $args[0])[1]);
        $value1 = CheckSymbol::checkValidity($frameController, $args[1]);
        $value2 = CheckSymbol::checkValidity($frameController, $args[2]);


        if ((CheckSymbol::getType($value1) == 'int' || CheckSymbol::getType($value1) == 'integer') && (CheckSymbol::getType($value2) == 'int' || CheckSymbol::getType($value2) == 'integer')) {
            if (CheckSymbol::getValue($value1) == CheckSymbol::getValue($value2)) {
                // If label exists, jump to it.
                $idx = $frameController->findLabel($label);
                if ($idx != 0){
                    // Push instruction after the label to the stack
                    $frameController->pushCallStack((int)$idx + 1);
                } else {
                    // Label not found
                    throw new SemanticExceptionException("Label not found.");
                }
            }
        } else {
            throw new BadOperandTypeException("Invalid operand type. Expected int, got " . CheckSymbol::getType($value1) . " and " . CheckSymbol::getType($value2) . ".");
        }
    }
}