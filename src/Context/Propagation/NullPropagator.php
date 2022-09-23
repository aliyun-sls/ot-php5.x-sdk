<?php



namespace OpenTelemetry\Context\Propagation;

use OpenTelemetry\Context\Context;

class NullPropagator implements TextMapPropagatorInterface
{
    public function fields()
    {
        return [];
    }

    public function inject(&$carrier, $setter = null, $context = null)
    {
    }

    public function extract($carrier, $getter = null, $context = null)
    {
        return isset($context) ? $context : Context::getCurrent();
    }
}
