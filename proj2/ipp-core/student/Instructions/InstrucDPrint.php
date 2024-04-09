<?php

namespace IPP\Student\Instructions;

use IPP\Core\Exception\NotImplementedException;
use IPP\Core\StreamWriter;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucDPrint extends Instruction
{
    public function handleEscapeSequences(string $string) : string {
        for ($i = 0; $i <= 32; $i++) {
            $string = str_replace('\\' . str_pad((string)$i, 3, '0', STR_PAD_LEFT), chr($i), $string);        }
        $string = str_replace('\\035', chr(035), $string);
        $string = str_replace('\\092', '\\', $string);
        return stripcslashes($string);
    }

    /**
     * @throws NonExistentVariableException
     * @throws NotImplementedException
     * @throws SemanticExceptionException
     * @throws BadOperandValueException
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {
        $streamWriter = new StreamWriter(STDERR);
        $args = $this->getArgs();
        if (count($args) != 1) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 1, got " . count($args) . ".");
        }
        $symbol = CheckSymbol::checkValidity($frameController, $args[0]);

        if (CheckSymbol::getType($symbol) == 'bool') {
            $streamWriter->writeBool((bool)CheckSymbol::getValue($symbol));
        }
        else if (CheckSymbol::getType($symbol) == 'nil') {
            $streamWriter->writeString('');
        }
        else if (CheckSymbol::getType($symbol) == 'int') {
            $streamWriter->writeInt((int)CheckSymbol::getValue($symbol));
        }
        else if (CheckSymbol::getType($symbol) == 'float') {
            $streamWriter->writeFloat((float)CheckSymbol::getValue($symbol));
        }
        else if (CheckSymbol::getType($symbol) == 'string') {
            $streamWriter->writeString($this->handleEscapeSequences((string)CheckSymbol::getValue($symbol)));
        }

    }
}