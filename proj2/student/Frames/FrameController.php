<?php

namespace IPP\Student\Frames;

use IPP\student\Exceptions\MissingValueException;

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

    public function __construct()
    {
        $this->globalFrame = new Frame();
        $this->temporaryFrame = new Frame();
        $this->localFrame = [];
        $this->stack = new Stack();
        $this->CallStack = new Stack();
    }

    public function getGlobalFrame(): Frame
    {
        return $this->globalFrame;
    }

    public function getTemporaryFrame(): Frame
    {
        return $this->temporaryFrame;
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

    public function popLocalFrame(): Frame
    {
        // Remove first frame from stack
        $return = array_shift($this->localFrame);
        if ($return === null) {
            throw new \Exception("No frame to pop");
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
        $this->pushLocalFrame($this->temporaryFrame);
    }

    public function popStack(): string
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

    public function pushCallStack(string $arg): void
    {
        $this->CallStack->push($arg);
    }

    public function popCallStack(): string
    {
        $out = $this->CallStack->pop();
        if ($out === null) {
            throw new MissingValueException("CallStack is empty");
        }
        return $out;
    }
}