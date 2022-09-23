<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace as API;
use OpenTelemetry\SDK\Common\Attribute\AttributesInterface;

final class Link implements LinkInterface
{
    private $attributes;
    private $context;

    public function __construct($context, $attributes)
    {
        $this->context = $context;
        $this->attributes = $attributes;
    }

    public function getSpanContext()
    {
        return $this->context;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
