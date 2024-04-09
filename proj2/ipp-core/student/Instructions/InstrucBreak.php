<?php

namespace IPP\Student\Instructions;

use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucBreak extends Instruction
{
    /**
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        if (count($args) !== 1) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 1, got " . count($args) . ".");
        }
        $frameController->getStatistics($this);
    }
}