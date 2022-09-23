<?php


namespace OpenTelemetry\Context;

final class ContextKey
{
    private $name;

    public function __construct($name = null)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }
}
