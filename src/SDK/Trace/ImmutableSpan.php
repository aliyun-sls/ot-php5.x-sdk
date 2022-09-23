<?php



namespace OpenTelemetry\SDK\Trace;

use function max;
use OpenTelemetry\API\Trace as API;
use OpenTelemetry\SDK\Common\Attribute\AttributesInterface;
use OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScopeInterface;
use OpenTelemetry\SDK\Resource\ResourceInfo;

/**
 * @psalm-immutable
 */
final class ImmutableSpan implements SpanDataInterface
{
    private $span;

    /** @var non-empty-string */
    private $name;

    /** @var list<EventInterface> */
    private $events;

    /** @var list<LinkInterface> */
    private $links;

    private $attributes;
    private $totalRecordedEvents;
    private $status;
    private $endEpochNanos;
    private $hasEnded;

    /**
     * @param non-empty-string $name
     * @param list<LinkInterface> $links
     * @param list<EventInterface> $events
     */
    public function __construct($span, $name, $links, $events, $attributes, $totalRecordedEvents, $status, $endEpochNanos, $hasEnded) {
        $this->span = $span;
        $this->name = $name;
        $this->links = $links;
        $this->events = $events;
        $this->attributes = $attributes;
        $this->totalRecordedEvents = $totalRecordedEvents;
        $this->status = $status;
        $this->endEpochNanos = $endEpochNanos;
        $this->hasEnded = $hasEnded;
    }

    public function getKind()
    {
        return $this->span->getKind();
    }

    public function getContext()
    {
        return $this->span->getContext();
    }

    public function getParentContext()
    {
        return $this->span->getParentContext();
    }

    public function getTraceId()
    {
        return $this->getContext()->getTraceId();
    }

    public function getSpanId()
    {
        return $this->getContext()->getSpanId();
    }

    public function getParentSpanId()
    {
        return $this->getParentContext()->getSpanId();
    }

    public function getStartEpochMicroSecond()
    {
        return $this->span->getStartEpochNanos();
    }

    public function getEndEpochEpochMicroSecond()
    {
        return $this->endEpochNanos;
    }

    public function getInstrumentationScope()
    {
        return $this->span->getInstrumentationScope();
    }

    public function getResource()
    {
        return $this->span->getResource();
    }

    public function getName()
    {
        return $this->name;
    }

    /** @inheritDoc */
    public function getLinks()
    {
        return $this->links;
    }

    /** @inheritDoc */
    public function getEvents()
    {
        return $this->events;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getTotalDroppedEvents()
    {
        return max(0, $this->totalRecordedEvents - count($this->events));
    }

    public function getTotalDroppedLinks()
    {
        return max(0, $this->span->getTotalRecordedLinks() - count($this->links));
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function hasEnded()
    {
        return $this->hasEnded;
    }
}
