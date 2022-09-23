<?php



namespace OpenTelemetry\Context;

interface ContextStorageInterface
{
    public function scope();

    public function current();

    public function attach($context);
}
