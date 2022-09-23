<?php



namespace OpenTelemetry\SDK\Trace;

interface SpanConverterInterface
{
    public function convert($spans);
}
