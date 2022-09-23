<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\SDK\Common\Attribute\AttributesInterface;

interface EventInterface
{
    public function getName();
    public function getAttributes();
    public function getEpochNanos();
    public function getTotalAttributeCount();
}
