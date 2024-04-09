<?php

namespace IPP\Student\Instructions;

use IPP\Student\Exceptions\UnexpectedFileStructureException;

class InstructionFactory
{
    /**
     * Create instance of instruction based on opcode
     * @param string $opCode
     * @param array<string> $args
     * @return Instruction
     * @throws UnexpectedFileStructureException
     */
    public static function createInstance(string $opCode, array $args): Instruction
    {
        // based on opcode create instance of instruction
        switch ($opCode) {
            case 'ADD':
                $instruction = new InstrucAdd($opCode, $args);
                break;
            case 'SUB':
                $instruction = new InstrucSub($opCode, $args);
                break;
            case 'MUL':
                $instruction = new InstrucMul($opCode, $args);
                break;
            case 'IDIV':
                $instruction = new InstrucIDiv($opCode, $args);
                break;
            case 'LT':
                $instruction = new InstrucLT($opCode, $args);
                break;
            case 'GT':
                $instruction = new InstrucGT($opCode, $args);
                break;
            case 'EQ':
                $instruction = new InstrucEQ($opCode, $args);
                break;
            case 'AND':
                $instruction = new InstrucAnd($opCode, $args);
                break;
            case 'OR':
                $instruction = new InstrucOr($opCode, $args);
                break;
            case 'NOT':
                $instruction = new InstrucNot($opCode, $args);
                break;
            case 'INT2CHAR':
                $instruction = new InstrucInt2Char($opCode, $args);
                break;
            case 'STRI2INT':
                $instruction = new InstrucStri2Int($opCode, $args);
                break;
            case 'READ':
                $instruction = new InstrucRead($opCode, $args);
                break;
            case 'WRITE':
                $instruction = new InstrucWrite($opCode, $args);
                break;
            case 'CONCAT':
                $instruction = new InstrucConcat($opCode, $args);
                break;
            case 'STRLEN':
                $instruction = new InstrucStrLen($opCode, $args);
                break;
            case 'GETCHAR':
                $instruction = new InstrucGetChar($opCode, $args);
                break;
            case 'SETCHAR':
                $instruction = new InstrucSetChar($opCode, $args);
                break;
            case 'TYPE':
                $instruction = new InstrucType($opCode, $args);
                break;
            case 'LABEL':
                $instruction = new InstrucLabel($opCode, $args);
                break;
            case 'JUMP':
                $instruction = new InstrucJump($opCode, $args);
                break;
            case 'JUMPIFEQ':
                $instruction = new InstrucJumpIfEq($opCode, $args);
                break;
            case 'JUMPIFNEQ':
                $instruction = new InstrucJumpIfNEq($opCode, $args);
                break;
            case 'DPRINT':
                $instruction = new InstrucDPrint($opCode, $args);
                break;
            case 'BREAK':
                $instruction = new InstrucBreak($opCode, $args);
                break;
            case 'DEFVAR':
                $instruction = new InstrucDefVar($opCode, $args);
                break;
            case 'POPS':
                $instruction = new InstrucPopS($opCode, $args);
                break;
            case 'PUSHFRAME':
                $instruction = new InstrucPushFrame($opCode, $args);
                break;
            case 'POPFRAME':
                $instruction = new InstrucPopFrame($opCode, $args);
                break;
            case 'CALL':
                $instruction = new InstrucCall($opCode, $args);
                break;
            case 'RETURN':
                $instruction = new InstrucReturn($opCode, $args);
                break;
            case 'EXIT':
                $instruction = new InstrucExit($opCode, $args);
                break;
            case 'CREATEFRAME':
                $instruction = new InstrucCreateFrame($opCode, $args);
                break;
            case 'MOVE':
                $instruction = new InstrucMove($opCode, $args);
                break;
            case 'PUSHS':
                $instruction = new InstrucPushS($opCode, $args);
                break;
            default:
                throw new UnexpectedFileStructureException("Unknown opcode: " . $opCode);
        }
        return $instruction;
    }
}