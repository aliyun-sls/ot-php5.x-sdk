<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace as API;

interface ReadWriteSpanInterface extends API\SpanInterface, ReadableSpanInterface
{
}
