<?php


namespace OpenTelemetry\Context\Propagation;

use OpenTelemetry\Context\Context;

final class NoopTextMapPropagator implements TextMapPropagatorInterface
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function fields()
    {
        return [];
    }

    public function extract($carrier, $getter = null, $context = null)
    {
        return isset($context) ? $context : Context::getRoot();
    }

    public function inject(&$carrier, $setter = null, $context = null)
    {
    }
}
