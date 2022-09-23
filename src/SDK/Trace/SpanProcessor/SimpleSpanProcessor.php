<?php



namespace OpenTelemetry\SDK\Trace\SpanProcessor;

use Closure;
use OpenTelemetry\Context\Context;
use OpenTelemetry\SDK\Behavior\LogsMessagesTrait;
use OpenTelemetry\SDK\Common\Future\CancellationInterface;
use OpenTelemetry\SDK\Trace\ReadableSpanInterface;
use OpenTelemetry\SDK\Trace\ReadWriteSpanInterface;
use OpenTelemetry\SDK\Trace\SpanExporterInterface;
use OpenTelemetry\SDK\Trace\SpanProcessorInterface;
use SplQueue;
use function sprintf;
use Exception;

class SimpleSpanProcessor implements SpanProcessorInterface
{
    use LogsMessagesTrait;

    private $exporter;

    private $running = false;
    /** @var SplQueue<array{Closure, string, bool}> */
    private $queue;

    private $closed = false;

    public function __construct($exporter)
    {
        $this->exporter = $exporter;

        $this->queue = new SplQueue();
    }

    public function onStart($span, $parentContext)
    {
    }

    public function onEnd($span)
    {
        if ($this->closed) {
            return;
        }
        if (!$span->getContext()->isSampled()) {
            return;
        }

        $spanData = $span->toSpanData();
        $this->flush(function()use($spanData){
            $this->exporter->export([$spanData])->await();
        }, 'export');
    }


    public function forceFlush($cancellation = null)
    {
        if ($this->closed) {
            return false;
        }

        return $this->flush(function ()use($cancellation){
            return $this->exporter->forceFlush($cancellation);
        }, __FUNCTION__, true);
    }

    public function shutdown($cancellation = null)
    {
        if ($this->closed) {
            return false;
        }

        $this->closed = true;

        return $this->flush(function ()use($cancellation) {
            return $this->exporter->shutdown($cancellation);
        }, __FUNCTION__, true);
    }

    private function flush($task, $taskName, $propagateResult = false)
    {
        $this->queue->enqueue([$task, $taskName, $propagateResult && !$this->running]);

        if ($this->running) {
            return false;
        }

        $success = true;
        $exception = null;
        $this->running = true;

        try {
            while (!$this->queue->isEmpty()) {
                $resultArray = $this->queue->dequeue();
                $task = $resultArray[0];
                $taskName = $resultArray[1];
                $propagateResult = $resultArray[2];

                try {
                    $result = $task();
                    if ($propagateResult) {
                        $success = $result;
                    }
                } catch (Throwable $e) {
                    if ($propagateResult) {
                        $exception = $e;

                        continue;
                    }
                    self::logError(sprintf('Unhandled %s error', $taskName), ['exception' => $e]);
                }
            }
        } finally {
            $this->running = false;
        }

        if ($exception !== null) {
            throw $exception;
        }

        return $success;
    }
}
