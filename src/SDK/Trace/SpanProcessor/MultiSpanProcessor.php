<?php



namespace OpenTelemetry\SDK\Trace\SpanProcessor;

use OpenTelemetry\Context\Context;
use OpenTelemetry\SDK\Common\Future\CancellationInterface;
use OpenTelemetry\SDK\Trace\ReadableSpanInterface;
use OpenTelemetry\SDK\Trace\ReadWriteSpanInterface;
use OpenTelemetry\SDK\Trace\SpanProcessorInterface;

/**
 * Class SpanMultiProcessor is a SpanProcessor that forwards all events to an
 * array of SpanProcessors.
 */
final class MultiSpanProcessor implements SpanProcessorInterface
{
    /** @var list<SpanProcessorInterface> */
    private $processors = [];

    public function __construct(...$spanProcessors)
    {
        foreach ($spanProcessors as $processor) {
            $this->addSpanProcessor($processor);
        }
    }

    public function addSpanProcessor($processor)
    {
        $this->processors[] = $processor;
    }

    /** @return list<SpanProcessorInterface> */
    public function getSpanProcessors()
    {
        return $this->processors;
    }

    /** @inheritDoc */
    public function onStart($span, $parentContext)
    {
        foreach ($this->processors as $processor) {
            $processor->onStart($span, $parentContext);
        }
    }

    /** @inheritDoc */
    public function onEnd($span)
    {
        foreach ($this->processors as $processor) {
            $processor->onEnd($span);
        }
    }

    /** @inheritDoc */
    public function shutdown($cancellation = null)
    {
        $result = true;

        foreach ($this->processors as $processor) {
            $result = $result && $processor->shutdown();
        }

        return $result;
    }

    /** @inheritDoc */
    public function forceFlush($cancellation = null)
    {
        $result = true;

        foreach ($this->processors as $processor) {
            $result = $result && $processor->forceFlush();
        }

        return $result;
    }
}
