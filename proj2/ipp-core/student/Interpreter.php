<?php

namespace IPP\Student;

use IPP\Core\AbstractInterpreter;
use IPP\Student\Frames\FrameController;
use IPP\Student\Instructions\InstructionFactory;
use IPP\Core\Exception\NotImplementedException;

class Interpreter extends AbstractInterpreter
{
    public function execute(): int
    {
        $dom = $this->source->getDOMDocument();
        // $val = $this->input->readString();
        // $this->stdout->writeString("stdout");
        // $this->stderr->writeString("stderr");

        $instructionsArray = [];
        $frameController = new FrameController();

        // Parse the XML document for instructions
        $instructions = $dom->getElementsByTagName('instruction');
        foreach ($instructions as $instruction){
            // Get the instruction opCode
            $opCode = $instruction->getAttribute('opcode');
            // Get the instruction arguments
            $args = [];
            foreach ($instruction->childNodes as $arg){
                if ($arg->nodeType == XML_ELEMENT_NODE){
                    // If argument is not and var type edit this argument with a type gotten
                    // from arg type attribute and concat with @ as delimiter
                    if ($arg->getAttribute('type') != 'var'){
                        $args[] = $arg->getAttribute('type') . '@' . $arg->nodeValue;
                    } else {
                        // If argument is var type, add it to the args array
                        $args[] = $arg->nodeValue;
                    }
                }
            }
            // rotate the args array to have the correct order
            $args = array_reverse($args);
            // Create an instance of the instruction
            $instructionObj = InstructionFactory::createInstance($opCode, $args);
            $instructionsArray[(int)$instruction->getAttribute('order')] = $instructionObj;
        }
        // Sort in different desc order and push into callstack
        ksort($instructionsArray);
        // Fix the order of the instructions
        $instructionsArray = array_values($instructionsArray);
        // Set the instruction array to the frame controller
        $frameController->setInstructionsArray($instructionsArray);

        while (!empty($instructionsArray) || !$frameController->callStackIsEmpty()){
            if ($frameController->callStackIsEmpty()){
                $frameController->pushCallStack($instructionsArray[0]);
                $instructionsArray = array_slice($instructionsArray, 1);
            }
            $instruction = $frameController->popCallStack();
            $instruction->execute($frameController);
        }
        return 0;
    }
}
