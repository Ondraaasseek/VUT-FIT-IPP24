<?php

namespace IPP\Student\Instructions;

use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucCall extends Instruction
{
    /**
     * @throws SemanticExceptionException
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement Call logic.
        $args = $this->getArgs();
        if (count($args) != 1) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 1, got " . count($args) . ".");
        }
        // Check if the label is valid
        $label = CheckLabel::checkValidity(explode('@', $args[0])[1]);

        // Push the under Call to the stack to be executed
        $callIndex = $frameController->getInstructionIndex($frameController->getInstructionsArray(), $this);
        $instructionsArray = $frameController->getInstructionsArray();
        $idx = (int)$callIndex + 1;

        if ($idx <= count($instructionsArray)) {
            $frameController->pushCallStack($idx);
        }

        $idx = $frameController->findLabel($label);
        if ($idx != 0){
            // Push instruction after the label to the stack
            $instructionsArray = $frameController->getInstructionsArray();
            $idx = (int)$idx + 1;

            if ($idx <= count($instructionsArray)) {
                $frameController->pushCallStack($idx);
            }
        } else {
            // Label not found
            throw new SemanticExceptionException("Label not found.");
        }
    }
}