<?php

namespace IPP\Student\Instructions;

use IPP\student\Exceptions\MissingValueException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Variables\Variable;

class InstrucPopS extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        // TODO: Implement PopS logic.
        $arg = $this->getArgs();
        $output = $frameController->popStack();
        $frame = explode("@", $arg[0])[0];
        $var = explode("@", $arg[0])[1];
        switch ($frame) {
            case "GF":
                $variable = $frameController->getGlobalFrame()->getVariable($var);
                break;
            case "LF":
                $variable = $frameController->getLocalFrame()->getVariable($var);
                break;
            case "TF":
                $variable = $frameController->getTemporaryFrame()->getVariable($var);
                break;
            default:
                // This should not happen
                break;
        }
        if ($variable === null){
            throw new MissingValueException("Variable ". $var . " does not exist in frame " . $frame . " .");
        }

        $type = explode("@", $output)[0];
        $value = explode("@", $output)[1];
        switch ($type) {
            case "GF":
                $variable2 = $frameController->getGlobalFrame()->getVariable($value);
                break;
            case "LF":
                $variable2 = $frameController->getLocalFrame()->getVariable($value);
                break;
            case "TF":
                $variable2 = $frameController->getTemporaryFrame()->getVariable($value);
                break;
            default:
                // Its type
                $variable->setType($type);
                $variable->setValue($value);
                return;
        }
        if ($variable2 === null){
            throw new MissingValueException("Variable ". $value . " does not exist in frame " . $type . " .");
        }
        $variable->setType($variable2->getType());
        $variable->setValue($variable2->getValue());
    }
}