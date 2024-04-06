<?php

namespace IPP\Student\Variables;

class Variable
{
    private string $name;
    private ?string $type;
    private mixed $value;

    public function __construct(string $name, ?string $type, mixed $value)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}