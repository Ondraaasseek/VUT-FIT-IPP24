<?php

namespace IPP\Student\Instructions;

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