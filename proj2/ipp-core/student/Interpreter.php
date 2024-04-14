<?php

namespace IPP\Student;

use DOMElement;
use IPP\Core\AbstractInterpreter;
use IPP\Student\Exceptions\BadOperandValueException;
use IPP\Student\Exceptions\MissingValueException;
use IPP\Student\Exceptions\SemanticExceptionException;
use IPP\Student\Exceptions\UnexpectedFileStructureException;
use IPP\Student\Frames\FrameController;
use IPP\Student\Instructions\Instruction;
use IPP\Student\Instructions\InstructionFactory;

class Interpreter extends AbstractInterpreter
{
    /**
     * @throws MissingValueException
     * @throws SemanticExceptionException
     * @throws UnexpectedFileStructureException
     */
    public function execute(): int
    {
        $dom = $this->source->getDOMDocument();
        $root = $dom->documentElement;

        // Check if the root element is correct
        if ($root !== null && ($root->nodeName !== 'program' || $root->getAttribute('language') !== 'IPPcode24')) {
            throw new UnexpectedFileStructureException('Invalid root element. Expected <program language="IPPcode24">.');
        }

        $instructionsArray = [];
        $frameController = new FrameController();
        $frameController->setInputReader($this->input);
        // Check if the root element has only instruction elements
        if ($root !== null) {
            foreach ($root->childNodes as $element) {
                if ($element instanceof DOMElement && $element->nodeName !== 'instruction') {
                    throw new UnexpectedFileStructureException('Unknown element found: ' . $element->nodeName);
                }
            }
        }

        // Parse the XML document for instructions
        $orderNumbers = [];
        $instructions = $dom->getElementsByTagName('instruction');
        foreach ($instructions as $instruction) {
            if (!$instruction instanceof DOMElement || !$instruction->hasAttribute('opcode')) {
                throw new UnexpectedFileStructureException('Invalid element found in the file. Expected only instructions.');
            }
            // Check for duplicate order numbers
            $orderNumber = (int)$instruction->getAttribute('order');
            if ($orderNumber < 1) {
                throw new UnexpectedFileStructureException('Invalid or missing order number found: ' . $orderNumber);
            }
            if (in_array($orderNumber, $orderNumbers)) {
                throw new UnexpectedFileStructureException('Duplicate order number found: ' . $orderNumber);
            }
            $orderNumbers[] = $orderNumber;
            // Get the instruction opCode
            $opCode = $instruction->getAttribute('opcode');
            $opCode = strtoupper($opCode);
            // Get the instruction arguments
            $args = [];
            $argNodes = [];
            foreach ($instruction->childNodes as $arg) {
                if ($arg instanceof DOMElement && preg_match("/^arg([1-3])$/", $arg->nodeName, $matches)) {
                    $index = (int)$matches[1];
                    if (isset($argNodes[$index])) {
                        throw new UnexpectedFileStructureException('Duplicate argument found: ' . $arg->nodeName);
                    }
                    if (!$arg->hasAttribute('type')) {
                        throw new UnexpectedFileStructureException('Missing type attribute in argument: ' . $arg->nodeName);
                    }
                    $argNodes[$index] = $arg;
                } else if ($arg instanceof DOMElement) {
                    throw new UnexpectedFileStructureException('Invalid argument element found: ' . $arg->nodeName);
                }
            }

            if (count($argNodes) > 0) {
                // Check if the arguments are in increasing order
                $isIncreasing = array_keys($argNodes) === range(1, count($argNodes));

                // Check if the arguments are in decreasing order
                $isDecreasing = array_keys($argNodes) === range(count($argNodes), 1);

                if (!$isIncreasing && !$isDecreasing) {
                    throw new UnexpectedFileStructureException('Arguments are not in consistent order.');
                }

                // If the order is decreasing, reverse the array
                if ($isDecreasing) {
                    $argNodes = array_reverse($argNodes, true);
                }
            }

            foreach ($argNodes as $argNum => $arg) {
                if ($arg->getAttribute('type') != 'var') {
                    $args[] = $arg->getAttribute('type') . '@' . trim($arg->nodeValue);
                } else {
                    // If argument is var type, add it to the args array
                    $args[] = trim($arg->nodeValue);
                }
            }

            $args = array_filter($args, function ($value) {
                return !is_null($value) && $value !== '';
            });

            // Create an instance of the instruction
            $instructionObj = InstructionFactory::createInstance($opCode, $args);
            $instructionsArray[(int)$instruction->getAttribute('order')] = $instructionObj;
        }
        // Sort in different desc order and push into callstack
        ksort($instructionsArray);

        // Check if there are any instructions
        if (empty($instructionsArray)) {
            return 0;
        }

        // Set the instruction array to the frame controller from 1 to n
        $instructionsArray = array_combine(range(1, count($instructionsArray)), array_values($instructionsArray));
        // Set the instruction array to the frame controller
        $frameController->setInstructionsArray($instructionsArray);

        //go through the instructions and set the labels
        foreach ($instructionsArray as $instruction) {
            if ($instruction->getOpCode() == 'LABEL') {
                $instruction->execute($frameController);
            }
        }

        // Input the first instruction to the call stack
        $i = 1;
        $frameController->pushCallStack($i);
        while (!$frameController->callStackIsEmpty() || $i <= count($instructionsArray)) {
            if ($i > count($instructionsArray)) {
                return 0;
            }
            $instruction = $frameController->getInstructionsArray()[$frameController->popCallStack()];
            //$frameController->getStatistics($instruction);
            if ($instruction instanceof Instruction && $instruction->getOpCode() == 'RETURN') {
                if ($frameController->callStackIsEmpty()) {
                    throw new MissingValueException("RETURN instruction without a call stack.");
                }
            }
            if ($instruction instanceof Instruction && $instruction->getOpCode() != 'LABEL') {
                $instruction->execute($frameController);
                $frameController->incrementInstructionCounter();
            }

            if ($frameController->getCallStackSize() > 0) {
                // We have call or multiple calls in the call stack
                $topInstruction = $frameController->callStackTop();
                $i = (int)$topInstruction;
                while ($i <= count($instructionsArray) && $instructionsArray[$i]->getOpCode() != 'RETURN') {
                    $instruction = $frameController->getInstructionsArray()[$frameController->popCallStack()];
                    if ($instruction instanceof Instruction && $instruction->getOpCode() != 'LABEL') {
                        $instruction->execute($frameController);
                    }
                    $i++;
                    $frameController->pushCallStack($i);
                }
            }

            if ($frameController->callStackIsEmpty()) {
                $i++;
                if ($i <= count($instructionsArray)) {
                    $frameController->pushCallStack($i);
                }
            } else {
                // We have something that changed the call stack, so we have to find that new label and edit the $i by it
                $topInstruction = $frameController->callStackTop();
                $i = (int)$topInstruction;
            }
        }
        return 0;
    }
}
