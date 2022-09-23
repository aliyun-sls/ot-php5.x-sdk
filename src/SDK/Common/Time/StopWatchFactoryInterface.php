<?php

namespace OpenTelemetry\SDK\Common\Time;

interface StopWatchFactoryInterface
{
    public static function create($clock = null, $initialStartTime = null);

    public static function fromClockFactory($factory, $initialStartTime = null);

    public function build();

    public static function getDefault();

    public static function setDefault($default);
}
