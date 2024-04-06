<?php

namespace IPP\Student\Frames;

use IPP\Student\Variables\Variable;

class Frame
{
    /**
     * @var array<Variable> $variables
     **/
    private array $variables;

    public function __construct()
    {
        $this->variables = [];
    }

    public function addVariable(Variable $variable): void
    {
        $this->variables[$variable->getName()] = $variable;
    }

    public function getVariable(string $name): ?Variable
    {
        return $this->variables[$name] ?? null;
    }
}