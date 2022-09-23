<?php



namespace OpenTelemetry\Context\ScopeBound;

use OpenTelemetry\Context\Context;

/**
 * @internal
 */
final class ContextHolder
{
    public $context;

    public function __construct($context)
    {
        $this->context = $context;
    }
}
