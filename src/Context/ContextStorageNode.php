<?php


namespace OpenTelemetry\Context;

use function assert;

/**
 * @internal
 */
final class ContextStorageNode implements ScopeInterface, ContextStorageScopeInterface
{
    public $context;
    public $head;
    private $previous;
    private $localStorage = [];

    public function __construct($context, $head, $previous = null)
    {
        $this->context = $context;
        $this->head = $head;
        $this->previous = $previous;
    }

    public function offsetExists($offset)
    {
        return isset($this->localStorage[$offset]);
    }

    /**
     * @phan-suppress PhanUndeclaredClassAttribute
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->localStorage[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->localStorage[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->localStorage[$offset]);
    }

    public function context()
    {
        return $this->context;
    }

    public function detach()
    {
        $flags = 0;
        if ($this->head !== $this->head->storage->current) {
            $flags |= ScopeInterface::INACTIVE;
        }

        if ($this === $this->head->node) {
            assert($this->previous !== $this);
            $this->head->node = $this->previous;
            $this->previous = $this;

            return $flags;
        }

        if ($this->previous === $this) {
            return $flags | ScopeInterface::DETACHED;
        }

        assert($this->head->node !== null);
        for ($n = $this->head->node, $depth = 1;
             $n->previous !== $this;
             $n = $n->previous, $depth++) {
            assert($n->previous !== null);
        }
        $n->previous = $this->previous;
        $this->previous = $this;

        return $flags | ScopeInterface::MISMATCH | $depth;
    }

    private function __clone()
    {
    }
}
