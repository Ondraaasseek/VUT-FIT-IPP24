<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;

class InstrucSub extends Instruction
{
    public function execute(FrameController $frameController): void
    {
        $args = $this->getArgs();
        AritmeticArgumetsCheck::checkValidity($frameController, $args);

        $arg1 = $args[0];
        $arg2 = $args[1];
        $arg3 = $args[2];

        $frame = explode('@', $arg1)[0];
        $name = explode('@', $arg1)[1];
        switch($frame){
            case 'GF':
                $variable1 = $frameController->getGlobalFrame()->getVariable($name);
                break;
            case 'LF':
                $variable1 = $frameController->getLocalFrame()->getVariable($name);
                break;
            case 'TF':
                $variable1 = $frameController->getTemporaryFrame()->getVariable($name);
                break;
            default:
                // this should not happen
                break;
        }

        $frame = explode('@', $arg2)[0];
        $name = explode('@', $arg2)[1];
        switch($frame){
            case 'GF':
                $variable2 = $frameController->getGlobalFrame()->getVariable($name);
                break;
            case 'LF':
                $variable2 = $frameController->getLocalFrame()->getVariable($name);
                break;
            case 'TF':
                $variable2 = $frameController->getTemporaryFrame()->getVariable($name);
                break;
            case 'int':
                $variable2 = (int)$name;
                break;
            default:
                // This should have been already handled
                break;
        }

        $frame = explode('@', $arg3)[0];
        $name = explode('@', $arg3)[1];
        switch($frame){
            case 'GF':
                $variable3 = $frameController->getGlobalFrame()->getVariable($name);
                break;
            case 'LF':
                $variable3 = $frameController->getLocalFrame()->getVariable($name);
                break;
            case 'TF':
                $variable3 = $frameController->getTemporaryFrame()->getVariable($name);
                break;
            case 'int':
                $variable3 = (int)$name;
                break;
            default:
                // This should have been already handled
                break;
        }

        // Now just do the addition
        $sum = 0;
        if($variable2 instanceof Variable){
            $sum = $variable2->getValue();
        } else {
            $sum = $variable2;
        }
        if ($variable3 instanceof Variable){
            $sum -= $variable3->getValue();
        } else {
            $sum -= $variable3;
        }
        $variable1->setType('int');
        $variable1->setValue($sum);
    }
}