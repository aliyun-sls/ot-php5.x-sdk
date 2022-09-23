<?php

namespace OpenTelemetry\SDK\Common\Instrumentation;


interface InstrumentationScopeInterface
{
    public function getName();

    public function getVersion();

    public function getSchemaUrl();

    public function getAttributes();
}
