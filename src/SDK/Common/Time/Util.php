<?php

namespace OpenTelemetry\SDK\Common\Time;

if (!function_exists('intdiv')) {
    function intdiv($a, $b){
        return (int)floor(abs($a/$b));
    }
}

class Util
{
    /** @psalm-pure */
    public static function nanosToMicros($nanoseconds)
    {
        return intdiv($nanoseconds, ClockInterface::NANOS_PER_MICROSECOND);
    }

    /** @psalm-pure */
    public static function nanosToMillis($nanoseconds)
    {
        return intdiv($nanoseconds, ClockInterface::NANOS_PER_MILLISECOND);
    }

    /** @psalm-pure */
    public static function secondsToNanos($seconds)
    {
        return $seconds * ClockInterface::NANOS_PER_SECOND;
    }

    /** @psalm-pure */
    public static function millisToNanos($milliSeconds)
    {
        return $milliSeconds * ClockInterface::NANOS_PER_MILLISECOND;
    }
}
