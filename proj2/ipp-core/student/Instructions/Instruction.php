<?php

namespace IPP\Student\Instructions;

use IPP\Student\Frames\FrameController;

abstract Class Instruction
{
    // Instructions data
    private string $opCode;

    // https://phpstan.org/blog/solving-phpstan-no-value-type-specified-in-iterable-type
    /**
     * @var array<string> $args
     */
    private array $args;

    /**
     * Handler constructor.
     * @param string $opCode
     * @param array<string> $args
     */
    public function __construct(string $opCode, array $args)
    {
        $this->opCode = $opCode;
        $this->args = $args;
    }

    public function getOpCode(): string
    {
        return $this->opCode;
    }

    /**
     * @return array<string>
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    public function getHelpPrint(): string
    {
        return "Operation: " . $this->opCode . " \t Args: " . implode(", ", $this->args) . "\n";
    }

    public abstract function execute(FrameController $frameController): void;
}