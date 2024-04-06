<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;

class InstrucCreateFrame extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $frameController->createFrame();
    }
}