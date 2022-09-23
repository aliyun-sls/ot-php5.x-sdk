<?php


namespace OpenTelemetry\SDK\Trace;

use function count;
use OpenTelemetry\SDK\Common\Attribute\AttributesInterface;

final class Event implements EventInterface
{
    private $name;
    private $timestamp;
    private $attributes;

    public function __construct($name, $timestamp, $attributes)
    {
        $this->name = $name;
        $this->timestamp = $timestamp;
        $this->attributes = $attributes;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEpochNanos()
    {
        return $this->timestamp;
    }

    public function getTotalAttributeCount()
    {
        return count($this->attributes);
    }

    public function getDroppedAttributesCount()
    {
        return $this->attributes->getDroppedAttributesCount();
    }
}
