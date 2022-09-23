<?php


namespace OpenTelemetry\SDK\Trace;

use function ctype_space;
use OpenTelemetry\API\Trace as API;
use OpenTelemetry\Context\Context;
use OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScopeInterface;

class Tracer implements API\TracerInterface
{
    const FALLBACK_SPAN_NAME = 'empty';

    /** @readonly */
    private $tracerSharedState;

    /** @readonly */
    private $instrumentationScope;

    public function __construct($tracerSharedState, $instrumentationScope)
    {
        $this->tracerSharedState = $tracerSharedState;
        $this->instrumentationScope = $instrumentationScope;
    }

    /** @inheritDoc */
    public function spanBuilder($spanName)
    {
        if (ctype_space($spanName)) {
            $spanName = self::FALLBACK_SPAN_NAME;
        }

        if ($this->tracerSharedState->hasShutdown()) {
            return new API\NoopSpanBuilder(Context::storage());
        }

        return new SpanBuilder(
            $spanName,
            $this->instrumentationScope,
            $this->tracerSharedState
        );
    }

    public function getInstrumentationScope()
    {
        return $this->instrumentationScope;
    }
}
