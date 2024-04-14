<?php

namespace IPP\Student\Instructions;

use _PHPStan_11268e5ee\Nette\NotImplementedException;
use IPP\Core\FileInputReader;
use IPP\Student\Exceptions\BadOperandTypeException;
use IPP\Student\Exceptions\NonExistentVariableException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;

class InstrucRead extends Instruction
{
    /**
     * @throws NonExistentVariableException
     * @throws BadOperandTypeException
     * @throws UnexpectedFileStructureException
     */
    public function execute(FrameController $frameController): void
    {

        $args = $this->getArgs();
        if (count($args) != 2) {
            throw new UnexpectedFileStructureException("Invalid number of arguments. Expected 2, got " . count($args) . ".");
        }

        $variable = CheckVariable::checkValidity($frameController, $args[0]);
        $typeValidity = CheckType::checkValidity(explode('@', $args[1])[1]);

        if (!$typeValidity) {
            throw new UnexpectedFileStructureException("Invalid type for read instruction\n");
        }

        $value = null;
        $type = explode('@', $args[1])[1];
        switch ($type) {
            case 'int':
            case 'integer':
                $value = $frameController->getInputReader()->readInt();
                break;
            case 'bool':
                $value = $frameController->getInputReader()->readBool();
                if ($value == 1) {
                    $value = 'true';
                } else if ($value == null){
                    $value = 'nil';
                    $type = 'nil';
                } else {
                    $value = 'false';
                }
                break;
            case 'string':
                $value = $frameController->getInputReader()->readString();
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