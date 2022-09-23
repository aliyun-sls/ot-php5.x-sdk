<?php



namespace OpenTelemetry\SDK\Trace;

interface IdGeneratorInterface
{
    public function generateTraceId();

    public function generateSpanId();
}
