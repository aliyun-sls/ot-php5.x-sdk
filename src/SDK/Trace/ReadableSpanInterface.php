<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace as API;
use OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScopeInterface;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/sdk.md#additional-span-interfaces
 */
interface ReadableSpanInterface
{
    public function getName();

    public function getContext();

    public function getParentContext();

    public function getInstrumentationScope();

    public function hasEnded();

    /**
     * Returns an immutable representation of this instance.
     */
    public function toSpanData();

    /**
     * Returns the duration of the {@see API\SpanInterface} in nanoseconds.
     * If still active, returns `now() - start`.
     */
    public function getDuration();

    /**
     * @see API\SpanKind
     */
    public function getKind();

    /**
     * Returns the value of the attribute with the provided *key*.
     * Returns `null` if there are no attributes set, or no attribute with that key exists.
     *
     * @return mixed
     */
    public function getAttribute($key);
}
