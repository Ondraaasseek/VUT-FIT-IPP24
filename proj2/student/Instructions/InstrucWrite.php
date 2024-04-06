<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class InstrucWrite extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        // TODO: Replace echo with propper $this->stdout->writeString("stdout"); but in the correct context
        // Should be only one argument
        $args = $this->getArgs();

        $frame = explode('@', $args[0])[0];
        if ($frame == 'GF') {
            $variable = $frameController->getGlobalFrame()->getVariable(explode('@', $args[0])[1]);
        } elseif ($frame == 'LF') {
            $variable = $frameController->getLocalFrame()->getVariable(explode('@', $args[0])[1]);
        } elseif ($frame == 'TF') {
            $variable = $frameController->getTemporaryFrame()->getVariable(explode('@', $args[0])[1]);
        } else {
            // it's not a variable so print it
            if ($args[0] == 'nil@nil') {
                echo '';
                return;
            }

            echo explode('@', $args[0])[1];
            return;
        }
        $out = $variable->getValue();
        if ($variable->getType() == 'bool') {
            if ($out == 'true' || $out == 'TRUE' || $out == 'True' || $out == '1') {
                echo 'true';
            } else {
                echo 'false';
            }
        }
        else if ($variable->getType() == 'nil') {
            echo '';
        } else {
            echo $out;
        }
    }
}