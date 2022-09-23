<?php

namespace OpenTelemetry\SDK\Common\Instrumentation;

interface InstrumentationScopeFactoryInterface
{
    public function create($name, $version = null, $schemaUrl = null, $attributes = []);
}
