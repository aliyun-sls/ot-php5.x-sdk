<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace\SpanContextInterface;
use OpenTelemetry\SDK\Common\Attribute\AttributesInterface;

interface LinkInterface
{
    public function getSpanContext();
    public function getAttributes();
}
