<?php



namespace OpenTelemetry\API\Trace;

use OpenTelemetry\Context\Context;

final class NoopTracer implements TracerInterface
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function spanBuilder($spanName)
    {
        return new NoopSpanBuilder(Context::storage());
    }
}
