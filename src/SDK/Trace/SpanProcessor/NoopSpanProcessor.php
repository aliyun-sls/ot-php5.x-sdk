<?php



namespace OpenTelemetry\SDK\Trace\SpanProcessor;

use OpenTelemetry\Context\Context;
use OpenTelemetry\SDK\Common\Future\CancellationInterface;
use OpenTelemetry\SDK\Trace\ReadableSpanInterface;
use OpenTelemetry\SDK\Trace\ReadWriteSpanInterface;
use OpenTelemetry\SDK\Trace\SpanProcessorInterface;

class NoopSpanProcessor implements SpanProcessorInterface
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /** @inheritDoc */
    public function onStart($span, $parentContext)
    {
    } //@codeCoverageIgnore

    /** @inheritDoc */
    public function onEnd($span)
    {
    } //@codeCoverageIgnore

    /** @inheritDoc */
    public function forceFlush($cancellation = null)
    {
        return true;
    }

    /** @inheritDoc */
    public function shutdown($cancellation = null)
    {
        return $this->forceFlush();
    }
}
