<?php

namespace IPP\student\Instructions;

use IPP\Student\Frames\FrameController;

class CheckType
{
    public static function checkValidity(string $arg): bool
    {
        switch ($arg){
            case 'bool':
            case 'string':
            case 'int':
                return true;
            default:
                return false;
        }
    }
}