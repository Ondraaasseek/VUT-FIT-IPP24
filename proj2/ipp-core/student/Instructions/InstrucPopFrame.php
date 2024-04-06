<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;

class InstrucPopFrame extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $frameController->popFrame();
    }
}