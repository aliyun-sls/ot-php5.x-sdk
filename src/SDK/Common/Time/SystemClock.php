<?php

namespace OpenTelemetry\SDK\Common\Time;

use function microtime;

final class SystemClock implements ClockInterface
{
    public function __construct()
    {
    }

    /**
     * @deprecated
     */
    public static function getInstance()
    {
        return new self();
    }

    public static function create()
    {
        return new self();
    }

    /** @inheritDoc */
    public function now()
    {
        // PHP 7.3+ has hrtime() which is a better choice for measuring elapsed time
        return microtime(true)  * 1000000;
    }

    /**
     * @deprecated
     */
    public function nanoTime()
    {
        return $this->now();
    }
}
