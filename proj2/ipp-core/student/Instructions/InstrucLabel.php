<?php

namespace IPP\Student\Instructions;

use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucLabel extends Instruction
{
    /**
     * @throws SemanticExceptionException
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) !== 1) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 1, got " . count($args) . ".");
        }
        $label = CheckLabel::checkValidity(explode('@',$args[0])[1]);
        if ($frameController->findLabel($label)) {
            throw new SemanticExceptionException("Label $label already exists");
        }

        $frameController->addLabel($label, (int)$frameController->getInstructionIndex($frameController->getInstructionsArray(), $this));
    }
}