<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;

class InstrucPushS extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $arg = $this->getArgs();
        $frameController->pushStack($arg[0]);
    }
}