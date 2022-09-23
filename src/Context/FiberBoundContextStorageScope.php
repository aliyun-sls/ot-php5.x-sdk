<?php

/** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */



namespace OpenTelemetry\Context;

use function assert;
use function class_exists;
use Fiber;

/**
 * @internal
 *
 * @phan-file-suppress PhanUndeclaredClassReference
 * @phan-file-suppress PhanUndeclaredClassMethod
 */
final class FiberBoundContextStorageScope implements ScopeInterface, ContextStorageScopeInterface
{
    private $scope;

    public function __construct($scope)
    {
        $this->scope = $scope;
    }

    public function offsetExists($offset)
    {
        return $this->scope->offsetExists($offset);
    }

    /**
     * @phan-suppress PhanUndeclaredClassAttribute
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->scope->offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->scope->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->scope->offsetUnset($offset);
    }

    public function context()
    {
        return $this->scope->context();
    }

    public function detach()
    {
        $flags = $this->scope->detach();
        assert(class_exists(Fiber::class, false));
        if ($this->scope[Fiber::class] !== Fiber::getCurrent()) {
            $flags |= ScopeInterface::INACTIVE;
        }

        return $flags;
    }
}
