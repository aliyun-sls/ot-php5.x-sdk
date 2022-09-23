<?php

namespace OpenTelemetry\SDK\Common\Time;

final class ClockFactory implements ClockFactoryInterface
{
    private static $default = null;

    public static function create()
    {
        return new self();
    }

    public function build()
    {
        return new SystemClock();
    }

    public static function getDefault()
    {
        if (!isset(self::$default)) {
            self::$default = self::create()->build();
        }
        return self::$default;
    }

    public static function setDefault($clock)
    {
        self::$default = $clock;
    }
}
