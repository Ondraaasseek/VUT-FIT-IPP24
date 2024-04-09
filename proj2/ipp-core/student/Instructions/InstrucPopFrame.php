<?php

namespace IPP\Student\Instructions;

use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucPopFrame extends Instruction
{
    /**
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) !== 0) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 0, got " . count($args) . ".");
        }

        $frameController->popFrame();
    }
}