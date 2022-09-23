<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace as API;
use OpenTelemetry\SDK\Common\Attribute\AttributesInterface;
use OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScopeInterface;
use OpenTelemetry\SDK\Resource\ResourceInfo;

/**
 * Represents an immutable snapshot of a {@see API\SpanInterface}.
 *
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/sdk.md#additional-span-interfaces
 */
interface SpanDataInterface
{
    public function getName();
    public function getKind();
    public function getContext();
    public function getParentContext();
    public function getTraceId();
    public function getSpanId();
    public function getParentSpanId();
    public function getStatus();
    public function getStartEpochMicroSecond();
    public function getAttributes();

    /** @return list<EventInterface> */
    public function getEvents();

    /** @return list<LinkInterface> */
    public function getLinks();

    public function getEndEpochEpochMicroSecond();
    public function hasEnded();
    public function getInstrumentationScope();
    public function getResource();

    /** @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/sdk_exporters/non-otlp.md#dropped-events-count */
    public function getTotalDroppedEvents();

    /** @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/sdk_exporters/non-otlp.md#dropped-links-count */
    public function getTotalDroppedLinks();
}
