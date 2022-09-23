<?php


namespace OpenTelemetry\API\Trace;

use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ContextStorageInterface;

final class NoopSpanBuilder implements SpanBuilderInterface
{
    private $contextStorage;

    private $parent = null;

    public function __construct(ContextStorageInterface $contextStorage)
    {
        $this->contextStorage = $contextStorage;
    }

    public function setParent($parentContext)
    {
        $this->parent = $parentContext;

        return $this;
    }

    public function setNoParent()
    {
        $this->parent = Context::getRoot();

        return $this;
    }

    public function addLink($context, $attributes = null)
    {
        return $this;
    }

    public function setAttribute($key, $value)
    {
        return $this;
    }

    public function setAttributes($attributes)
    {
        return $this;
    }

    public function setStartTimestamp($timestamp)
    {
        return $this;
    }

    public function setSpanKind($spanKind)
    {
        return $this;
    }

    public function startSpan()
    {
        $span = AbstractSpan::fromContext(isset($this->parent) ? $this->parent : $this->contextStorage->current());
        if ($span->isRecording()) {
            $span = AbstractSpan::wrap($span->getContext());
        }

        return $span;
    }
}
