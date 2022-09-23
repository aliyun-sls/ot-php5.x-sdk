<?php


namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace\NoopTracer;
use OpenTelemetry\SDK\Common\Attribute\Attributes;
use OpenTelemetry\SDK\Common\Instrumentation\InstrumentationScopeFactory;
use OpenTelemetry\SDK\Resource\ResourceInfoFactory;
use OpenTelemetry\SDK\Trace\Sampler\AlwaysOnSampler;
use OpenTelemetry\SDK\Trace\Sampler\ParentBased;
use function is_array;

final class TracerProvider implements TracerProviderInterface
{
    /** @readonly */
    private $tracerSharedState;
    private $instrumentationScopeFactory;

    /** @param list<SpanProcessorInterface>|SpanProcessorInterface|null $spanProcessors */
    public function __construct($spanProcessors = [], $sampler = null, $resource = null,
                                $spanLimits = null, $idGenerator = null, $instrumentationScopeFactory = null)
    {
        if (null === $spanProcessors) {
            $spanProcessors = [];
        }

        $spanProcessors = is_array($spanProcessors) ? $spanProcessors : [$spanProcessors];
        $resource = isset($resource) ? $resource : ResourceInfoFactory::defaultResource();
        $sampler = isset($sampler) ? $sampler : new ParentBased(new AlwaysOnSampler());
        $idGenerator = isset($idGenerator) ? $idGenerator : new RandomIdGenerator();
        $spanLimits = isset($spanLimits) ? $spanLimits : (new SpanLimitsBuilder())->build();

        $this->tracerSharedState = new TracerSharedState(
            $idGenerator,
            $resource,
            $spanLimits,
            $sampler,
            $spanProcessors
        );
        $this->instrumentationScopeFactory = isset($instrumentationScopeFactory) ? $instrumentationScopeFactory : new InstrumentationScopeFactory(Attributes::factory());
    }

    public function forceFlush($cancellation = null)
    {
        return $this->tracerSharedState->getSpanProcessor()->forceFlush($cancellation);
    }

    /**
     * @inheritDoc
     */
    public function getTracer($name, $version = null, $schemaUrl = null, $attributes = null)
    {
        $attributes = isset($attributes) ? $attributes : [];
        if ($this->tracerSharedState->hasShutdown()) {
            return NoopTracer::getInstance();
        }

        return new Tracer(
            $this->tracerSharedState,
            $this->instrumentationScopeFactory->create($name, $version, $schemaUrl, $attributes)
        );
    }

    public function getSampler()
    {
        return $this->tracerSharedState->getSampler();
    }

    /**
     * Returns `false` is the provider is already shutdown, otherwise `true`.
     */
    public function shutdown($cancellation = null)
    {
        if ($this->tracerSharedState->hasShutdown()) {
            return true;
        }

        return $this->tracerSharedState->shutdown($cancellation);
    }
}
