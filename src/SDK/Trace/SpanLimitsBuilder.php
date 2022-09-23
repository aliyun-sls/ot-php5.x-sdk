<?php


namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\SDK\Common\Attribute\Attributes;
use const PHP_INT_MAX;

class SpanLimitsBuilder
{
    /** @var  Maximum allowed attribute count per record */
    private $attributeCountLimit = null;

    /** @var  Maximum allowed attribute value length */
    private $attributeValueLengthLimit = null;

    /** @var  Maximum allowed span event count */
    private $eventCountLimit = null;

    /** @var  Maximum allowed span link count */
    private $linkCountLimit = null;

    /** @var  Maximum allowed attribute per span event count */
    private $attributePerEventCountLimit = null;

    /** @var  Maximum allowed attribute per span link count */
    private $attributePerLinkCountLimit = null;

    /**
     * @param int $attributeCountLimit Maximum allowed attribute count per record
     */
    public function setAttributeCountLimit($attributeCountLimit)
    {
        $this->attributeCountLimit = $attributeCountLimit;

        return $this;
    }

    /**
     * @param int $attributeValueLengthLimit Maximum allowed attribute value length
     */
    public function setAttributeValueLengthLimit($attributeValueLengthLimit)
    {
        $this->attributeValueLengthLimit = $attributeValueLengthLimit;

        return $this;
    }

    /**
     * @param int $eventCountLimit Maximum allowed span event count
     */
    public function setEventCountLimit($eventCountLimit)
    {
        $this->eventCountLimit = $eventCountLimit;

        return $this;
    }

    /**
     * @param int $linkCountLimit Maximum allowed span link count
     */
    public function setLinkCountLimit($linkCountLimit)
    {
        $this->linkCountLimit = $linkCountLimit;

        return $this;
    }

    /**
     * @param int $attributePerEventCountLimit Maximum allowed attribute per span event count
     */
    public function setAttributePerEventCountLimit($attributePerEventCountLimit)
    {
        $this->attributePerEventCountLimit = $attributePerEventCountLimit;

        return $this;
    }

    /**
     * @param int $attributePerLinkCountLimit Maximum allowed attribute per span link count
     */
    public function setAttributePerLinkCountLimit($attributePerLinkCountLimit)
    {
        $this->attributePerLinkCountLimit = $attributePerLinkCountLimit;

        return $this;
    }

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/main/specification/sdk-environment-variables.md#span-limits-
     */
    public function build()
    {
        $attributeCountLimit = $this->attributeCountLimit ?: SpanLimits::DEFAULT_SPAN_ATTRIBUTE_COUNT_LIMIT;
        $attributeValueLengthLimit = $this->attributeValueLengthLimit ?: SpanLimits::DEFAULT_SPAN_ATTRIBUTE_LENGTH_LIMIT;
        $eventCountLimit = $this->eventCountLimit ?: SpanLimits::DEFAULT_SPAN_EVENT_COUNT_LIMIT;
        $linkCountLimit = $this->linkCountLimit ?: SpanLimits::DEFAULT_SPAN_LINK_COUNT_LIMIT;
        $attributePerEventCountLimit = $this->attributePerEventCountLimit ?: SpanLimits::DEFAULT_EVENT_ATTRIBUTE_COUNT_LIMIT;
        $attributePerLinkCountLimit = $this->attributePerLinkCountLimit ?: SpanLimits::DEFAULT_LINK_ATTRIBUTE_COUNT_LIMIT;

        if ($attributeValueLengthLimit === PHP_INT_MAX) {
            $attributeValueLengthLimit = null;
        }

        return new SpanLimits(
            Attributes::factory($attributeCountLimit, $attributeValueLengthLimit),
            Attributes::factory($attributePerEventCountLimit, $attributeValueLengthLimit),
            Attributes::factory($attributePerLinkCountLimit, $attributeValueLengthLimit),
            $eventCountLimit,
            $linkCountLimit
        );
    }
}
