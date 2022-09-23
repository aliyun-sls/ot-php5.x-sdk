<?php

namespace OpenTelemetry\API\Trace;
/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#wrapping-a-spancontext-in-a-span
 *
 * @internal
 * @psalm-internal OpenTelemetry
 */
final class NonRecordingSpan extends AbstractSpan
{
    private $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

    /** @inheritDoc */
    public function getContext()
    {
        return $this->context;
    }

    /** @inheritDoc */
    public function isRecording()
    {
        return false;
    }

    /** @inheritDoc */
    public function setAttribute($key, $value)
    {
        return $this;
    }

    /** @inheritDoc */
    public function setAttributes($attributes)
    {
        return $this;
    }

    /** @inheritDoc */
    public function addEvent($name, $attributes = null, $timestamp = null)
    {
        return $this;
    }

    /** @inheritDoc */
    public function recordException($exception, $attributes = null)
    {
        return $this;
    }

    /** @inheritDoc */
    public function updateName($name)
    {
        return $this;
    }

    /** @inheritDoc */
    public function setStatus($code, $description = null)
    {
        return $this;
    }

    /** @inheritDoc */
    public function end($endEpochNanos = null)
    {
    }
}
