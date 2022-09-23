<?php


namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\SDK\Common\Attribute\AttributesFactoryInterface;

final class SpanLimits
{
    const DEFAULT_SPAN_ATTRIBUTE_LENGTH_LIMIT = PHP_INT_MAX;
    const DEFAULT_SPAN_ATTRIBUTE_COUNT_LIMIT = 128;
    const DEFAULT_SPAN_EVENT_COUNT_LIMIT = 128;
    const DEFAULT_SPAN_LINK_COUNT_LIMIT = 128;
    const DEFAULT_EVENT_ATTRIBUTE_COUNT_LIMIT = 128;
    const DEFAULT_LINK_ATTRIBUTE_COUNT_LIMIT = 128;

    private $attributesFactory;
    private $eventAttributesFactory;
    private $linkAttributesFactory;
    private $eventCountLimit;
    private $linkCountLimit;

    public function getAttributesFactory()
    {
        return $this->attributesFactory;
    }

    public function getEventAttributesFactory()
    {
        return $this->eventAttributesFactory;
    }

    public function getLinkAttributesFactory()
    {
        return $this->linkAttributesFactory;
    }

    /** @return int Maximum allowed span event count */
    public function getEventCountLimit()
    {
        return $this->eventCountLimit;
    }

    /** @return int Maximum allowed span link count */
    public function getLinkCountLimit()
    {
        return $this->linkCountLimit;
    }

    /**
     * @internal Use {@see SpanLimitsBuilder} to create {@see SpanLimits} instance.
     */
    public function __construct($attributesFactory, $eventAttributesFactory, $linkAttributesFactory, $eventCountLimit, $linkCountLimit)
    {
        $this->attributesFactory = $attributesFactory;
        $this->eventAttributesFactory = $eventAttributesFactory;
        $this->linkAttributesFactory = $linkAttributesFactory;
        $this->eventCountLimit = $eventCountLimit;
        $this->linkCountLimit = $linkCountLimit;
    }
}
