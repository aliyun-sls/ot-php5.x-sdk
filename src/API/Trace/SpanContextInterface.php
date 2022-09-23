<?php



namespace OpenTelemetry\API\Trace;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#spancontext
 */
interface SpanContextInterface
{
    const TRACE_FLAG_SAMPLED = 0x01;
    const TRACE_FLAG_DEFAULT = 0x00;

    /** @todo Implement this in the API layer */
    public static function createFromRemoteParent($traceId, $spanId, $traceFlags = TRACE_FLAG_DEFAULT,  $traceState = null);

    /** @todo Implement this in the API layer */
    public static function getInvalid();

    /** @todo Implement this in the API layer */
    public static function create($traceId, $spanId, $traceFlags = TRACE_FLAG_SAMPLED,  $traceState = null);

    /** @psalm-mutation-free */
    public function getTraceId();

    /** @psalm-mutation-free */
    public function getSpanId();
    public function getTraceFlags();
    public function getTraceState();
    public function isValid();
    public function isRemote();
    public function isSampled();
}
