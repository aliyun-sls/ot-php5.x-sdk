<?php

namespace OpenTelemetry\SDK\Common\Time;

interface ClockFactoryInterface
{
    public static function create();

    public function build();

    public static function getDefault();

    public static function setDefault($clock);
}
