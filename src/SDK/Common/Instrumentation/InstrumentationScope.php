<?php


namespace OpenTelemetry\SDK\Common\Instrumentation;

use OpenTelemetry\SDK\Common\Attribute\AttributesInterface;

/**
 * Represents the instrumentation scope information associated with the Tracer or Meter
 */
final class InstrumentationScope implements InstrumentationScopeInterface
{
    private $name;
    private $version;
    private $schemaUrl;
    private $attributes;

    public function __construct($name, $version, $schemaUrl, $attributes)
    {
        $this->name = $name;
        $this->version = $version;
        $this->schemaUrl = $schemaUrl;
        $this->attributes = $attributes;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getSchemaUrl()
    {
        return $this->schemaUrl;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}
