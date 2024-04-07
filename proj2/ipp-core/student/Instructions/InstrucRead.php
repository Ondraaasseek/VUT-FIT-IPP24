<?php

namespace IPP\Student\Instructions;

use _PHPStan_11268e5ee\Nette\NotImplementedException;
use IPP\Core\FileInputReader;
use IPP\Student\Frames\FrameController;

class InstrucRead extends Instruction
{
    public function execute(FrameController $frameController): void
    {

        $inputReader = new FileInputReader(STDIN);
        $args = $this->getArgs();
        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $typeValidity = CheckType::checkValidity($args[1]);

        if (!$typeValidity) {
            throw new NotImplementedException("Invalid type");
        }

        $value = null;
        $type = $args[1];
        switch ($type) {
            case 'int':
                $value = $inputReader->readInt();
                break;
            case 'bool':
                $value = $inputReader->readBool();
                break;
            case 'string':
                $value = $inputReader->readString();
                break;
        }

        if ($value == null) {
            $variable->setType('nil');
            $variable->setValue('nil');
        } else {
            $variable->setType($type);
            $variable->setValue($value);
        }
    }
}