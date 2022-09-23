<?php

namespace OpenTelemetry\SDK\Common\Time;

use function microtime;

final class SystemClock implements ClockInterface
{
    private static $instance = null;
    private static $referenceTime = 0;

    public function __construct()
    {
        self::init();
    }

    /**
     * @deprecated
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function create()
    {
        return new self();
    }

    /** @inheritDoc */
    public function now()
    {
        // PHP 7.3+ has hrtime() which is a better choice for measuring elapsed time
        return self::$referenceTime  * 1000000;
    }

    /**
     * @deprecated
     */
    public function nanoTime()
    {
        return $this->now();
    }

    private static function init()
    {
        if (self::$referenceTime > 0) {
            return;
        }

        self::$referenceTime = microtime(true);
    }
}
