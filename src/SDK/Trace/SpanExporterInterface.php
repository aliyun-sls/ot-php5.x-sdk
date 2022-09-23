<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\SDK\Common\Future\CancellationInterface;
use OpenTelemetry\SDK\Common\Future\FutureInterface;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/sdk.md#span-exporter
 */
interface SpanExporterInterface
{
    /**
     * Possible return values as outlined in the OpenTelemetry spec
     */
    const STATUS_SUCCESS = 0;
    const STATUS_FAILED_NOT_RETRYABLE = 1;
    const STATUS_FAILED_RETRYABLE = 2;

    public static function fromConnectionString($endpointUrl,$name, $args);

    /**
     * @param iterable<SpanDataInterface> $spans Batch of spans to export
     *
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/sdk.md#exportbatch
     *
     * @psalm-return FutureInterface<int>
     */
    public function export($spans,$cancellation = null);

    /** @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/sdk.md#shutdown-2 */
    public function shutdown($cancellation = null);

    /** @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/sdk.md#forceflush-2 */
    public function forceFlush($cancellation = null);
}
