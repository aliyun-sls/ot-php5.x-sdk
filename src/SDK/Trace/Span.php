<?php


namespace OpenTelemetry\SDK\Trace;

use Exception;
use OpenTelemetry\API\Trace as API;
use OpenTelemetry\SDK\Common\Dev\Compatibility\Util as BcUtil;
use OpenTelemetry\SDK\Common\Exception\StackTraceFormatter;
use OpenTelemetry\SDK\Common\Time\ClockFactory;
use function get_class;

final class Span extends API\AbstractSpan implements ReadWriteSpanInterface
{

    /** @readonly */
    private $context;

    /** @readonly */
    private $parentSpanContext;

    /** @readonly */
    private $spanLimits;

    /** @readonly */
    private $spanProcessor;

    /**
     * @readonly
     *
     * @var list<LinkInterface>
     */
    private $links;

    /** @readonly */
    private $totalRecordedLinks;

    /** @readonly */
    private $kind;

    /** @readonly */
    private $resource;

    /** @readonly */
    private $instrumentationScope;

    /** @readonly */
    private $startEpochNanos;

    /** @var non-empty-string */
    private $name;

    /** @var list<EventInterface> */
    private $events = [];

    private $attributesBuilder;
    private $totalRecordedEvents = 0;
    private $status;
    private $endEpochNanos = 0;
    private $hasEnded = false;

    /**
     * @param non-empty-string $name
     * @param list<LinkInterface> $links
     */
    private function __construct($name, $context, $instrumentationScope, $kind, $parentSpanContext, $spanLimits, $spanProcessor,
                                 $resource, $attributesBuilder, $links, $totalRecordedLinks, $startEpochNanos)
    {
        $this->context = $context;
        $this->instrumentationScope = $instrumentationScope;
        $this->parentSpanContext = $parentSpanContext;
        $this->links = $links;
        $this->totalRecordedLinks = $totalRecordedLinks;
        $this->name = $name;
        $this->kind = $kind;
        $this->spanProcessor = $spanProcessor;
        $this->resource = $resource;
        $this->startEpochNanos = $startEpochNanos;
        $this->attributesBuilder = $attributesBuilder;
        $this->status = StatusData::unset0();
        $this->spanLimits = $spanLimits;
    }

    /**
     * This method _MUST_ not be used directly.
     * End users should use a {@see API\TracerInterface} in order to create spans.
     *
     * @param non-empty-string $name
     * @psalm-param API\SpanKind::KIND_* $kind
     * @param list<LinkInterface> $links
     *
     * @internal
     * @psalm-internal OpenTelemetry
     */
    public static function startSpan($name, $context, $instrumentationScope, $kind, $parentSpan, $parentContext, $spanLimits, $spanProcessor,
                                     $resource, $attributesBuilder, $links, $totalRecordedLinks, $startEpochNanos)
    {

        $span = new self(
            $name,
            $context,
            $instrumentationScope,
            $kind,
            $parentSpan->getContext(),
            $spanLimits,
            $spanProcessor,
            $resource,
            $attributesBuilder,
            $links,
            $totalRecordedLinks,
            $startEpochNanos !== 0 ? $startEpochNanos : ClockFactory::getDefault()->now()
        );

        // Call onStart here to ensure the span is fully initialized.
        $spanProcessor->onStart($span, $parentContext);

        return $span;
    }

    /** @inheritDoc */
    public function getContext()
    {
        return $this->context;
    }

    /** @inheritDoc */
    public function isRecording()
    {
        return !$this->hasEnded;
    }

    /** @inheritDoc */
    public function setAttribute($key, $value)
    {
        if ($this->hasEnded) {
            return $this;
        }

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

    /** @inheritDoc */
    public function addEvent($name, $attributes = [], $timestamp = null)
    {
        if ($this->hasEnded) {
            return $this;
        }
        if (++$this->totalRecordedEvents > $this->spanLimits->getEventCountLimit()) {
            return $this;
        }

        $timestamp = isset($timestamp) ? $timestamp : ClockFactory::getDefault()->now();
        $eventAttributesBuilder = $this->spanLimits->getEventAttributesFactory()->builder($attributes);

        $this->events[] = new Event($name, $timestamp, $eventAttributesBuilder->build());

        return $this;
    }

    /** @inheritDoc */
    public function recordException($exception, $attributes = [], $timestamp = null)
    {
        if ($this->hasEnded) {
            return $this;
        }
        if (++$this->totalRecordedEvents > $this->spanLimits->getEventCountLimit()) {
            return $this;
        }

        $timestamp = isset($timestamp) ? $timestamp : ClockFactory::getDefault()->now();
        $eventAttributesBuilder = $this->spanLimits->getEventAttributesFactory()->builder([
            'exception.type' => get_class($exception),
            'exception.message' => $exception->getMessage(),
            'exception.stacktrace' => StackTraceFormatter::format($exception),
        ]);

        foreach ($attributes as $key => $value) {
            $eventAttributesBuilder[$key] = $value;
        }

        $this->events[] = new Event('exception', $timestamp, $eventAttributesBuilder->build());

        return $this;
    }

    /** @inheritDoc */
    public function updateName($name)
    {
        if ($this->hasEnded) {
            return $this;
        }
        $this->name = $name;

        return $this;
    }

    /** @inheritDoc */
    public function setStatus($code, $description = null)
    {
        if ($this->hasEnded) {
            return $this;
        }

        $this->status = StatusData::create($code, $description);

        return $this;
    }

    /** @inheritDoc */
    public function end($endEpochNanos = null)
    {
        if ($this->hasEnded) {
            return;
        }

        $this->endEpochNanos = isset($endEpochNanos) ? $endEpochNanos : ClockFactory::getDefault()->now();
        $this->hasEnded = true;

        $this->spanProcessor->onEnd($this);
    }

    /** @inheritDoc */
    public function getName()
    {
        return $this->name;
    }

    public function getParentContext()
    {
        return $this->parentSpanContext;
    }

    public function getInstrumentationScope()
    {
        return $this->instrumentationScope;
    }

    public function hasEnded()
    {
        return $this->hasEnded;
    }

    public function toSpanData()
    {
        return new ImmutableSpan(
            $this,
            $this->name,
            $this->links,
            $this->events,
            $this->attributesBuilder->build(),
            $this->totalRecordedEvents,
            $this->status,
            $this->endEpochNanos,
            $this->hasEnded
        );
    }

    /** @inheritDoc */
    public function getDuration()
    {
        return ($this->hasEnded ? $this->endEpochNanos : ClockFactory::getDefault()->now()) - $this->startEpochNanos;
    }

    /** @inheritDoc */
    public function getKind()
    {
        return $this->kind;
    }

    /** @inheritDoc */
    public function getAttribute($key)
    {
        return $this->attributesBuilder[$key];
    }

    public function getStartEpochNanos()
    {
        return $this->startEpochNanos;
    }

    public function getTotalRecordedLinks()
    {
        return $this->totalRecordedLinks;
    }

    public function getTotalRecordedEvents()
    {
        return $this->totalRecordedEvents;
    }

    public function getResource()
    {
        return $this->resource;
    }
}
