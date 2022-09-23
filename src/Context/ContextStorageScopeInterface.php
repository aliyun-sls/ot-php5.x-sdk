<?php



namespace OpenTelemetry\Context;

use ArrayAccess;

interface ContextStorageScopeInterface extends ScopeInterface, ArrayAccess
{
    public function context();

    /**
     * @param string $offset
     */
    public function offsetSet($offset, $value);
}
