<?php


namespace OpenTelemetry\SDK\Trace;

use function in_array;
use OpenTelemetry\API\Trace as API;
use OpenTelemetry\Context\Context;
use OpenTelemetry\SDK\Common\Attribute\AttributesBuilderInterface;
use OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScopeInterface;

final class SpanBuilder implements API\SpanBuilderInterface
{
    /**
     * @var non-empty-string
     * @readonly
     */
    private $spanName;

    /** @readonly */
    private $instrumentationScope;

    /** @readonly */
    private $tracerSharedState;

    private $parentContext = null; // Null means use current context.

    /**
     * @psalm-var API\SpanKind::KIND_*
     */
    private $spanKind = API\SpanKind::KIND_INTERNAL;

    /** @var list<LinkInterface> */
    private $links = [];

    private $attributesBuilder;
    private $totalNumberOfLinksAdded = 0;
    private $startEpochNanos = 0;

    /** @param non-empty-string $spanName */
    public function __construct($spanName, $instrumentationScope, $tracerSharedState)
    {
        $this->spanName = $spanName;
        $this->instrumentationScope = $instrumentationScope;
        $this->tracerSharedState = $tracerSharedState;
        $this->attributesBuilder = $tracerSharedState->getSpanLimits()->getAttributesFactory()->builder();
    }

    /** @inheritDoc */
    public function setParent($parentContext)
    {
        $this->parentContext = $parentContext;

        return $this;
    }

    /** @inheritDoc */
    public function setNoParent()
    {
        $this->parentContext = Context::getRoot();

        return $this;
    }

    /** @inheritDoc */
    public function addLink($context, $attributes)
    {
        $attributes = isset($attributes) ? $attributes : [];
        if (!$context->isValid()) {
            return $this;
        }

        $this->totalNumberOfLinksAdded++;

        if (count($this->links) === $this->tracerSharedState->getSpanLimits()->getLinkCountLimit()) {
            return $this;
        }

        $this->links[] = new Link(
            $context,
            $this->tracerSharedState
                ->getSpanLimits()
                ->getLinkAttributesFactory()
                ->builder($attributes)
                ->build()
        );

        return $this;
    }

    /** @inheritDoc */
    public function setAttribute($key, $value)
    {
        $this->attributesBuilder[$key] = $value;

        return $this;
    }

    /** @inheritDoc */
    public function setAttributes($attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->attributesBuilder[$key] = $value;
        }

        return $this;
    }

    /**
     * @inheritDoc
     *
     * @psalm-param API\SpanKind::KIND_* $spanKind
     */
    public function setSpanKind($spanKind)
    {
        $this->spanKind = $spanKind;

        return $this;
    }

    /** @inheritDoc */
    public function setStartTimestamp($timestamp)
    {
        if (0 > $timestamp) {
            return $this;
        }

        $this->startEpochNanos = $timestamp;

        return $this;
    }

    /** @inheritDoc */
    public function startSpan()
    {
        $parentContext = isset($this->parentContext)? $this->parentContext: Context::getCurrent();
        $parentSpan = Span::fromContext($parentContext);
        $parentSpanContext = $parentSpan->getContext();

        $spanId = $this->tracerSharedState->getIdGenerator()->generateSpanId();

        if (!$parentSpanContext->isValid()) {
            $traceId = $this->tracerSharedState->getIdGenerator()->generateTraceId();
        } else {
            $traceId = $parentSpanContext->getTraceId();
        }

        $samplingResult = $this
            ->tracerSharedState
            ->getSampler()
            ->shouldSample(
                $parentContext,
                $traceId,
                $this->spanName,
                $this->spanKind,
                $this->attributesBuilder->build(),
                $this->links
            );
        $samplingDecision = $samplingResult->getDecision();
        $samplingResultTraceState = $samplingResult->getTraceState();

        $spanContext = API\SpanContext::create(
            $traceId,
            $spanId,
            SamplingResult::RECORD_AND_SAMPLE === $samplingDecision ? API\SpanContextInterface::TRACE_FLAG_SAMPLED : API\SpanContextInterface::TRACE_FLAG_DEFAULT,
            $samplingResultTraceState
        );

        if (!in_array($samplingDecision, [SamplingResult::RECORD_AND_SAMPLE, SamplingResult::RECORD_ONLY], true)) {
            return Span::wrap($spanContext);
        }

        $attributesBuilder = clone $this->attributesBuilder;
        foreach ($samplingResult->getAttributes() as $key => $value) {
            $attributesBuilder[$key] = $value;
        }

        return Span::startSpan(
            $this->spanName,
            $spanContext,
            $this->instrumentationScope,
            $this->spanKind,
            $parentSpan,
            $parentContext,
            $this->tracerSharedState->getSpanLimits(),
            $this->tracerSharedState->getSpanProcessor(),
            $this->tracerSharedState->getResource(),
            $attributesBuilder,
            $this->links,
            $this->totalNumberOfLinksAdded,
            $this->startEpochNanos
        );
    }
}
