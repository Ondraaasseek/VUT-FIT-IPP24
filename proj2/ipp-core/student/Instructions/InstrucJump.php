<?php

namespace IPP\Student\Instructions;

use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucJump extends Instruction
{
    /**
     * @throws SemanticExceptionException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) != 1){
            // Invalid number of arguments
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 1, got " . count($args) . ".");
        }
        $label = CheckLabel::checkValidity(explode('@', $args[0])[1]);
        $idx = $frameController->findLabel($label);
        if ($idx != 0){
            // Push instruction after the label to the stack
            $frameController->pushCallStack((int)$idx + 1);
        } else {
            // Label not found
            throw new SemanticExceptionException("Label not found.");
        }
    }
}