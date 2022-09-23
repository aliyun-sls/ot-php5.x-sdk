<?php


namespace OpenTelemetry\SDK\Common\Time;

final class StopWatch implements StopWatchInterface
{
    const INITIAL_ELAPSED_TIME = 0;

    private $clock;
    private $running = false;
    private $initialStartTime;
    private $startTime = null;
    private $stopTime = null;

    public function __construct($clock, $initialStartTime = null)
    {
        $this->clock = $clock;
        $this->initialStartTime = $initialStartTime;
    }

    public function isRunning()
    {
        return $this->running;
    }

    public function start()
    {
        // resolve start time as early as possible
        $startTime = $this->time();

        if ($this->isRunning()) {
            return;
        }

        $this->startTime = $startTime;
        if (!$this->hasBeenStarted()) {
            $this->initialStartTime = $startTime;
        }
        $this->running = true;
    }

    public function stop()
    {
        if (!$this->isRunning()) {
            return;
        }

        $this->stopTime = $this->time();
        $this->running = false;
    }

    public function reset()
    {
        $this->startTime = $this->initialStartTime = $this->isRunning() ? $this->time() : null;
    }

    public function getElapsedTime()
    {
        if (!$this->hasBeenStarted()) {
            return self::INITIAL_ELAPSED_TIME;
        }

        return $this->calculateElapsedTime();
    }

    public function getLastElapsedTime()
    {
        if (!$this->hasBeenStarted()) {
            return self::INITIAL_ELAPSED_TIME;
        }

        return $this->calculateLastElapsedTime();
    }

    private function time()
    {
        return $this->clock->now();
    }

    private function hasBeenStarted()
    {
        return $this->initialStartTime !== null;
    }

    private function calculateElapsedTime()
    {
        $referenceTime = $this->isRunning()
            ? $this->time()
            : $this->getStopTime();

        return $referenceTime - $this->getInitialStartTime();
    }

    private function calculateLastElapsedTime()
    {
        $referenceTime = $this->isRunning()
            ? $this->time()
            : $this->getStopTime();

        return $referenceTime - $this->getStartTime();
    }

    private function getInitialStartTime()
    {
        return $this->initialStartTime;
    }

    private function getStartTime()
    {
        return $this->startTime;
    }

    private function getStopTime()
    {
        return $this->stopTime;
    }
}
