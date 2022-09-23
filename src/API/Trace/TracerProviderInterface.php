<?php



namespace OpenTelemetry\API\Trace;

/** @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/api.md#tracerprovider */
interface TracerProviderInterface
{
    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.7.0/specification/trace/api.md#get-a-tracer
     */
    public function getTracer($name, $version = null, $schemaUrl = null, $attributes = null);
}
