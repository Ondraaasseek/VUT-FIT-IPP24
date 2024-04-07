<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Student\Frames\FrameController;
use IPP\Core\StreamWriter;

class InstrucWrite extends Instruction
{
    public function handleEscapeSequences($string) : string {
        for ($i = 0; $i <= 32; $i++) {
            $string = str_replace('\\' . str_pad($i, 3, '0', STR_PAD_LEFT), chr($i), $string);
        }
        $string = str_replace('\\035', chr(035), $string);
        $string = str_replace('\\092', '\\', $string);
        return stripcslashes($string);
    }

    public function execute(FrameController $frameController): void
    {
        // TODO: Replace echo with propper $this->stdout->writeString("stdout"); but in the correct context
        // Should be only one argument
        $streamWriter = new StreamWriter(STDOUT);
        $args = $this->getArgs();
        $symbol = CheckSymbol::checkValidity($frameController, $args[0]);

        if (CheckSymbol::getType($symbol) == 'bool') {
            $streamWriter->writeBool(CheckSymbol::getValue($symbol));
        }
        else if (CheckSymbol::getType($symbol) == 'nil') {
            $streamWriter->writeString('');
        }
        else if (CheckSymbol::getType($symbol) == 'int') {
            $streamWriter->writeInt(CheckSymbol::getValue($symbol));
        }
        else if (CheckSymbol::getType($symbol) == 'float') {
            throw new NotImplementedException;
        }
        else if (CheckSymbol::getType($symbol) == 'string') {
            $streamWriter->writeString($this->handleEscapeSequences(CheckSymbol::getValue($symbol)));
        }
    }
}