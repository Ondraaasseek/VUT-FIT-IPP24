<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;

class InstrucPushFrame extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $frameController->pushFrame();
    }
}