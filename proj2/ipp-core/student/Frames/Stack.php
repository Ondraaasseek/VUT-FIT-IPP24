<?php

namespace IPP\student\Frames;

use IPP\Student\Instructions\Instruction;

class Stack
{
    private array $stack;

    public function __construct()
    {
        $this->stack = [];
    }

    public function push(string|Instruction $arg): void
    {
        array_push($this->stack, $arg);
    }

    public function pop(): string|Instruction|null
    {
        return array_pop($this->stack);
    }

    public function top(): string|Instruction|null
    {
        return ($this->stack[0]);
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }
}