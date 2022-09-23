<?php



namespace OpenTelemetry\Context\ScopeBound;

use Closure;
use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ContextStorageInterface;

/**
 * A callable wrapper that can be used to bind a callable to the current scope.
 */
final class ScopeBoundCallable
{
    public static function wrap($callable,  $storage = null)
    {
        $storage = isset($storage)? $storage: Context::storage();
        $context = $storage->current();

        return function (...$args) use ($callable, $context, $storage) {
            $scope = $storage->attach($context);

            try {
                return $callable(...$args);
            } finally {
                $scope->detach();
            }
        };
    }
}
