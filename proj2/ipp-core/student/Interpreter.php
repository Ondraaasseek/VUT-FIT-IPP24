<?php

namespace IPP\Student;

use IPP\Core\AbstractInterpreter;
use IPP\student\Exceptions\SemanticExceptionException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Instructions\InstructionFactory;
use IPP\Core\Exception\NotImplementedException;

class Interpreter extends AbstractInterpreter
{
    public function execute(): int
    {
        $dom = $this->source->getDOMDocument();

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
            //print_r($instructionsArray);
        }
        // Sort in different desc order and push into callstack
        ksort($instructionsArray);
        // Fix the order of the instructions
        $instructionsArray = array_values($instructionsArray);
        // Set the instruction array to the frame controller
        $frameController->setInstructionsArray($instructionsArray);
        // Input the first instruction to the call stack
        $i = 0;
        $frameController->pushCallStack($instructionsArray[$i]);
        while(!$frameController->callStackIsEmpty()){
            $instruction = $frameController->popCallStack();
            $instruction->execute($frameController);
            if ($frameController->callStackIsEmpty()){
                $i++;
                if ($i < count($instructionsArray)){
                    $frameController->pushCallStack($instructionsArray[$i]);
                }
            } else {
                // We have something that changed the call stack, so we have to find that new label and edit the $i by it
                $i = $this->findInstructionIndex($instructionsArray, $frameController->callStackTop());
                if ($i < count($instructionsArray)){
                    $i++;
                }
                $frameController->pushCallStack($instructionsArray[$i]);
            }
        }
        return 0;
    }

    private function findInstructionIndex($instructionsArray, $instruction) : int{
        if ($instruction == null){
            throw new SemanticExceptionException('Instruction not found.');
        }
        foreach ($instructionsArray as $key => $value){
            if ($value == $instruction){
                return $key;
            }
        }
        throw new SemanticExceptionException('Instruction not found.');
    }
}
