<?php

namespace IPP\Student\Frames;

use IPP\Core\FileInputReader;
use IPP\Core\Interface\InputReader;
use IPP\Core\StreamWriter;
use IPP\Student\Exceptions\FrameDoesNotExistsException;
use IPP\Student\Exceptions\MissingValueException;
use IPP\Student\Instructions\Instruction;

class FrameController
{
    /**
     * @var Frame $globalFrame
     **/
    private $globalFrame;

    /**
     * @var Frame $temporaryFrame
     **/
    private $temporaryFrame;

    /** Array of local frames implemented as stack
     * @var array<Frame> $localFrame
     **/
    private array $localFrame;

    private Stack $stack;

    private Stack $CallStack;

    /** Array of instructions
     * @var array<Instruction> $instructionsArray
     **/
    private array $instructionsArray;

    /** Array of labels
     * @var array<string> $labelArray
     **/
    private array $labelArray;

    private int $instructionCounter;

    private InputReader $inputReader;

    public function __construct()
    {
        $this->globalFrame = new Frame();
        $this->localFrame = [];
        $this->stack = new Stack();
        $this->CallStack = new Stack();
        $this->instructionsArray = [];
        $this->labelArray = [];
        $this->instructionCounter = 1;
    }

    public function setInputReader(InputReader $inputReader): void
    {
        $this->inputReader = $inputReader;
    }

    public function getInputReader(): InputReader
    {
        return $this->inputReader;
    }

    public function getGlobalFrame(): Frame
    {
        return $this->globalFrame;
    }

    public function getTemporaryFrame(): Frame
    {
        $return = $this->temporaryFrame;
        if ($return === null) {
            throw new FrameDoesNotExistsException("No temporary frame.");
        }
        return $return;
    }

    public function getLocalFrame(): Frame
    {
        // Get the first frame from stack
        return $this->localFrame[0];
    }

    public function pushLocalFrame(Frame $frame): void
    {
        // Create a new frame and push it to stack
        array_unshift($this->localFrame, $frame);
    }

    /**
     * @throws FrameDoesNotExistsException
     */
    public function popLocalFrame(): Frame
    {
        // Remove first frame from stack
        $return = array_shift($this->localFrame);
        if ($return === null) {
            throw new FrameDoesNotExistsException("No frame to pop.");
        }
        return $return;
    }

    public function createFrame(): void
    {
        $this->temporaryFrame = new Frame();
    }

    public function popFrame(): void
    {
        $this->temporaryFrame = $this->popLocalFrame();
    }

    public function pushFrame(): void
    {
        if ($this->temporaryFrame === null) {
            throw new FrameDoesNotExistsException("No temporary frame.");
        }
        $this->pushLocalFrame($this->temporaryFrame);
        // remove temporary frame
        $this->temporaryFrame = null;
    }

    public function popStack(): string|Instruction
    {
        $out = $this->stack->pop();
        if ($out === null) {
            throw new MissingValueException("Stack is empty");
        }
        return $out;
    }

    public function pushStack(string $arg): void
    {
        $this->stack->push($arg);
    }

    public function stackIsEmpty(): bool
    {
        return $this->stack->isEmpty();
    }

    public function pushCallStack(int $arg): void
    {
        $this->CallStack->push($arg);
    }

    public function popCallStack(): int|string
    {
        $out = $this->CallStack->pop();
        if ($out === null) {
            throw new MissingValueException("CallStack is empty");
        }
        return $out;
    }

    public function callStackIsEmpty(): bool
    {
        return $this->CallStack->isEmpty();
    }

    public function callStackTop(): int|string|null
    {
        return $this->CallStack->top();
    }

    public function getCallStackSize(): int
    {
        return $this->CallStack->getSize();
    }

    public function getInstructionCounter(): int
    {
        return $this->instructionCounter;
    }

    public function IncrementInstructionCounter(): void
    {
        $this->instructionCounter++;
    }

    /**
     * @param array<Instruction> $instructionsArray
     */
    public function setInstructionsArray(array $instructionsArray): void
    {
        $this->instructionsArray = $instructionsArray;
    }
    /**
     * @return array<Instruction>
     */

    public function getInstructionsArray(): array
    {
        return $this->instructionsArray;
    }

    /**
     * @param array<Instruction> $instructionArray
     * @param Instruction $instruction
     * @return int
     */
    public function getInstructionIndex(array $instructionArray, Instruction $instruction): int|string|false
    {
        return array_search($instruction, $instructionArray);
    }

    public function addLabel(string $label, int $instructionArrayPos): void
    {
        $this->labelArray[$instructionArrayPos] = $label;
    }

    public function findLabel(string $label): int|string|false
    {
        return array_search($label, $this->labelArray);
    }

    public function getStatistics(Instruction $instruction): void{
        $streamWriter = new StreamWriter(STDERR);
        $streamWriter->writeString("\nInstruction: " . $instruction->getOpCode() . " instruction index: ". $this->getInstructionIndex($this->instructionsArray, $instruction) . "\n");
        $streamWriter->writeString("Instruction Counter: " . $this->getInstructionCounter() . "\n");
        $streamWriter->writeString("Global Frame: \n" . $this->getGlobalFrame()->__toString() . "\n");
        foreach ($this->localFrame as $frame) {
            $streamWriter->writeString("Local Frame: " . $frame->__toString() . "\n");
        }
        if ($this->temporaryFrame !== null) {
            $streamWriter->writeString("Temporary Frame: " . $this->getTemporaryFrame()->__toString() . "\n");
        }
    }
}