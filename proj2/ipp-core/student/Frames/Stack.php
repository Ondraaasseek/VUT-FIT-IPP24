<?php

namespace IPP\student\Frames;

class Stack
{
    private array $stack;

    public function __construct()
    {
        $this->stack = [];
    }

    public function push(string $arg): void
    {
        array_push($this->stack, $arg);
    }

    public function pop(): ?string
    {
        return array_pop($this->stack);
    }

    public function top(): ?string
    {
        return ($this->stack[0]);
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }
}