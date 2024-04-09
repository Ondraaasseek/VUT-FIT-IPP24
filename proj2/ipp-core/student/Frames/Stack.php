<?php

namespace IPP\Student\Frames;

use IPP\Student\Instructions\Instruction;

class Stack
{
    /**
     * @var array<string|int> $stack
     */
    private array $stack;

    public function __construct()
    {
        $this->stack = [];
    }

    public function push(string|int $arg): void
    {
        array_push($this->stack, $arg);
    }

    public function pop(): string|int|null
    {
        return array_pop($this->stack);
    }

    public function top(): string|int|null
    {
        return ($this->stack[count($this->stack) - 1]);
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }

    public function getSize(): int
    {
        return count($this->stack);
    }
}