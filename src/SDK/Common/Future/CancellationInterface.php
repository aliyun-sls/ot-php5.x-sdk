<?php

namespace OpenTelemetry\SDK\Common\Future;

use Closure;
use Exception;

interface CancellationInterface
{
    /**
     * @param Closure(Exception): void $callback
     */
    public function subscribe($callback);

    public function unsubscribe($id);
}
