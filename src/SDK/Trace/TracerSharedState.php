<?php


namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace as API;

/** @phan-suppress-current-line PhanUnreferencedUseNormal */

use OpenTelemetry\SDK\Common\Future\CancellationInterface;
use OpenTelemetry\SDK\Resource\ResourceInfo;
use OpenTelemetry\SDK\Trace\SpanProcessor\MultiSpanProcessor;
use OpenTelemetry\SDK\Trace\SpanProcessor\NoopSpanProcessor;

/**
 * Stores shared state/config between all {@see API\TracerInterface} created via the same {@see API\TracerProviderInterface}.
 */
final class TracerSharedState
{
    /** @readonly */
    private $idGenerator;

    /** @readonly */
    private $resource;

    /** @readonly */
    private $spanLimits;

    /** @readonly */
    private $sampler;

    /** @readonly */
    private $spanProcessor;

    private $shutdownResult = null;

    public function __construct($idGenerator, $resource, $spanLimits, $sampler, $spanProcessors)
    {
        $this->idGenerator = $idGenerator;
        $this->resource = $resource;
        $this->spanLimits = $spanLimits;
        $this->sampler = $sampler;

        switch (count($spanProcessors)) {
            case 0:
                $this->spanProcessor = NoopSpanProcessor::getInstance();

                break;
            case 1:
                $this->spanProcessor = $spanProcessors[0];

                break;
            default:
                $this->spanProcessor = new MultiSpanProcessor(...$spanProcessors);

                break;
        }
    }

    public function hasShutdown()
    {
        return null !== $this->shutdownResult;
    }

    public function getIdGenerator()
    {
        return $this->idGenerator;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getSpanLimits()
    {
        return $this->spanLimits;
    }

    public function getSampler()
    {
        return $this->sampler;
    }

    public function getSpanProcessor()
    {
        return $this->spanProcessor;
    }

    /**
     * Returns `false` is the provider is already shutdown, otherwise `true`.
     */
    public function shutdown($cancellation = null)
    {
        return isset($this->shutdownResult) ? $this->shutdownResult : ($this->shutdownResult = $this->spanProcessor->shutdown($cancellation));
    }
}
