<?php

namespace OpenTelemetry\SDK\Common\Instrumentation;

use OpenTelemetry\SDK\Common\Attribute\AttributesFactoryInterface;

final class InstrumentationScopeFactory implements InstrumentationScopeFactoryInterface
{
    private $attributesFactory;

    public function __construct($attributesFactory)
    {
        $this->attributesFactory = $attributesFactory;
    }

    public function create($name, $version = null, $schemaUrl = null, $attributes = [])
    {
        return new InstrumentationScope(
            $name,
            $version,
            $schemaUrl,
            $this->attributesFactory->builder($attributes)->build()
        );
    }
}
