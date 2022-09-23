<?php



namespace OpenTelemetry\API\Trace;

interface TracerInterface
{
    /** @param non-empty-string $spanName */
    public function spanBuilder($spanName);
}
