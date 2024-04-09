<?php

namespace IPP\Student\Variables;

class Variable
{
    private string $name;
    private ?string $type;
    private string|int|bool|null $value;

    public function __construct(string $name, ?string $type, string|int|bool|null $value)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->name . ' = ' . $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string|null
    {
        return $this->type;
    }

    public function getValue() : string|bool|int
    {
        if($this->value != null) {
            return $this->value;
        } else {
            return '';
        }
    }

    public function setValue(bool|int|string $value): void
    {
        $this->value = $value;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }
}