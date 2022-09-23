<?php

namespace OpenTelemetry\SDK\Common\Time;

final class StopWatchFactory implements StopWatchFactoryInterface
{
    private static $default = null;

    private $clock;
    private $initialStartTime;

    public function __construct($clock = null, $initialStartTime = null)
    {
        $this->clock = isset($clock) ? $clock : ClockFactory::getDefault();
        $this->initialStartTime = $initialStartTime;
    }

    public static function create($clock = null, $initialStartTime = null)
    {
        return new self($clock, $initialStartTime);
    }

    public static function fromClockFactory($factory, $initialStartTime = null)
    {
        return self::create($factory->build(), $initialStartTime);
    }

    public function build()
    {
        return new StopWatch($this->clock, $this->initialStartTime);
    }

    public static function getDefault()
    {
        return isset(self::$default) ? self::$default : self::$default = self::create()->build();
    }

    public static function setDefault($default)
    {
        self::$default = $default;
    }
}
