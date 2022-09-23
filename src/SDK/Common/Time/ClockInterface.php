<?php

namespace OpenTelemetry\SDK\Common\Time;

interface ClockInterface
{
    const MILLIS_PER_SECOND = 1000;
    const MICROS_PER_SECOND = 1000000;
    const NANOS_PER_SECOND = 1000000000;
    const NANOS_PER_MILLISECOND = 1000000;
    const NANOS_PER_MICROSECOND = 1000;

    /**
     * Returns the current epoch wall-clock timestamp in nanoseconds
     */
    public function now();

    /**
     * @deprecated
     */
    public function nanoTime();
}
