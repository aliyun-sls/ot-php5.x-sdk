<?php

namespace OpenTelemetry\SDK\Common\Future;

/**
 * @template T
 */
interface FutureInterface
{
    /**
     * @psalm-return T
     */
    public function await();
}
