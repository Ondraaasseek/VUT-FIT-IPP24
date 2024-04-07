<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\SemanticExceptionException;
use IPP\Student\Frames\FrameController;

class InstrucLabel extends Instruction
{
    /**
     * @throws SemanticExceptionException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        $label = CheckLabel::checkValidity($args[0]);

        // TODO: Check if the label already exists
        /*if ($frameController->labelExists($label)) {
            throw new SemanticExceptionException("Label $label already exists");
        }*/
    }
}