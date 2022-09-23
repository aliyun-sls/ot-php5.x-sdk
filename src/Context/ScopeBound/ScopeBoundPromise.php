<?php


namespace OpenTelemetry\Context\ScopeBound;

use InvalidArgumentException;
use function method_exists;
use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ContextStorageInterface;
use stdClass;

/**
 * A promise wrapper that can be used to bind a promise to the current scope.
 *
 * The scope will be propagated in {@see ScopeBoundPromise::then()} chained
 * promises.
 */
final class ScopeBoundPromise
{
    private $storage;
    private $contextHolder;
    private $promise;

    private function __construct($storage, $contextHolder, $promise)
    {
        $this->storage = $storage;
        $this->contextHolder = $contextHolder;
        $this->promise = $promise;
    }

    public static function wrap($promise, $storage = null)
    {
        if (!method_exists($promise, 'then')) {
            throw new InvalidArgumentException();
        }

        $storage = isset($storage) ? $storage : Context::storage();

        return $promise instanceof ScopeBoundPromise && $storage === $promise->storage
            ? $promise
            : new self($storage, new ContextHolder($storage->current()), $promise);
    }

    public function then($onFulfilled = null, $onRejected = null)
    {
        $contextHolder = new ContextHolder($this->storage->current());

        return new self($this->storage, $contextHolder, $this->promise->then(
            $this->wrapCallback($onFulfilled, $contextHolder),
            $this->wrapCallback($onRejected, $contextHolder)
        ));
    }

    private function wrapCallback($callable, $child)
    {
        if (!$callable) {
            return null;
        }

        return function (...$args) use ($callable, $child) {
            $scope = $this->storage->attach($this->contextHolder->context);
            $scope[__CLASS__] = $sentinel = new stdClass();

            try {
                return $callable(...$args);
            } finally {
                $child->context = $this->storage->current();
                while (($s = $this->storage->scope()) && (isset($s[__CLASS__]) ? $s[__CLASS__] : null) !== $sentinel) {
                    $s->detach();
                }

                $scope->detach();
            }
        };
    }
}
