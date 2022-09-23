<?php



namespace OpenTelemetry\Context;

/**
 * @internal
 */
final class ContextStorageHead
{
    public $storage;
    public $node = null;

    public function __construct($storage)
    {
        $this->storage = $storage;
    }
}
