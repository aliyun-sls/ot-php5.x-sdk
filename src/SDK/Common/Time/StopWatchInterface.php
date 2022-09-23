<?php


namespace OpenTelemetry\SDK\Common\Time;

interface StopWatchInterface
{
    public function isRunning();

    public function start();

    public function stop();

    public function reset();

    public function getElapsedTime();

    public function getLastElapsedTime();
}
