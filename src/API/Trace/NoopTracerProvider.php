<?php



namespace OpenTelemetry\API\Trace;

class NoopTracerProvider implements TracerProviderInterface
{
    public function getTracer($name, $version = null, $schemaUrl = null, $attributes = null) {
        return NoopTracer::getInstance();
    }
}
