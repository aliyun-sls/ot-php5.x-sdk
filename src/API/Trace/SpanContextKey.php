<?php



namespace OpenTelemetry\API\Trace;

use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ContextKey;

/**
 * @psalm-internal \OpenTelemetry
 */
final class SpanContextKey
{
    const KEY_NAME = 'opentelemetry-trace-span-key';

    private static $instance = null;

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = Context::createKey(self::KEY_NAME);
        }

        return self::$instance;
    }
}
