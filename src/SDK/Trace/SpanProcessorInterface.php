<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\Context\Context;
use OpenTelemetry\SDK\Common\Future\CancellationInterface;

/** @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/sdk.md#span-processor */
interface SpanProcessorInterface
{
    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/sdk.md#onstart
     */
    public function onStart($span, $parentContext);

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/sdk.md#onendspan
     */
    public function onEnd($span);

    /**
     * Export all ended spans to the configured Exporter that have not yet been exported.
     * Returns `true` if the flush was successful, otherwise `false`.
     *
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/sdk.md#forceflush-1
     */
    public function forceFlush($cancellation = null);

    /**
     * Cleanup; after shutdown, calling onStart, onEnd, or forceFlush is invalid
     * Returns `false` is the processor is already shutdown, otherwise `true`.
     *
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/sdk.md#shutdown-1
     */
    public function shutdown($cancellation = null);
}
