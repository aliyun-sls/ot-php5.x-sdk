<?php


namespace OpenTelemetry\SDK\Trace\SpanProcessor;

use InvalidArgumentException;
use OpenTelemetry\SDK\Behavior\LogsMessagesTrait;
use OpenTelemetry\SDK\Common\Time\ClockFactory;
use OpenTelemetry\SDK\Trace\SpanDataInterface;
use OpenTelemetry\SDK\Trace\SpanProcessorInterface;
use SplQueue;
use function assert;
use function count;
use function sprintf;

class BatchSpanProcessor implements SpanProcessorInterface
{
    use LogsMessagesTrait;

    const DEFAULT_SCHEDULE_DELAY = 5000;
    const DEFAULT_EXPORT_TIMEOUT = 30000;
    const DEFAULT_MAX_QUEUE_SIZE = 2048;
    const DEFAULT_MAX_EXPORT_BATCH_SIZE = 512;

    private $exporter;
    private $clock;
    private $maxQueueSize;
    private $scheduledDelayNanos;
    private $maxExportBatchSize;
    private $autoFlush;

    private $nextScheduledRun = null;
    private $running = false;
    private $batchId = 0;
    private $queueSize = 0;
    /** @var list<SpanDataInterface> */
    private $batch = [];
    /** @var SplQueue<list<SpanDataInterface>> */
    private $queue;
    /** @var SplQueue<array{int, string, ?CancellationInterface, bool}> */
    private $flush;

    private $closed = false;

    public function __construct($exporter, $clock = null, $maxQueueSize = self::DEFAULT_MAX_QUEUE_SIZE, $scheduledDelayMillis = self::DEFAULT_SCHEDULE_DELAY,
                                $exportTimeoutMillis = self::DEFAULT_EXPORT_TIMEOUT, $maxExportBatchSize = self::DEFAULT_MAX_EXPORT_BATCH_SIZE, $autoFlush = true)
    {
        if ($maxQueueSize <= 0) {
            throw new InvalidArgumentException(sprintf('Maximum queue size (%d) must be greater than zero', $maxQueueSize));
        }
        if ($scheduledDelayMillis <= 0) {
            throw new InvalidArgumentException(sprintf('Scheduled delay (%d) must be greater than zero', $scheduledDelayMillis));
        }
        if ($exportTimeoutMillis <= 0) {
            throw new InvalidArgumentException(sprintf('Export timeout (%d) must be greater than zero', $exportTimeoutMillis));
        }
        if ($maxExportBatchSize <= 0) {
            throw new InvalidArgumentException(sprintf('Maximum export batch size (%d) must be greater than zero', $maxExportBatchSize));
        }
        if ($maxExportBatchSize > $maxQueueSize) {
            throw new InvalidArgumentException(sprintf('Maximum export batch size (%d) must be less than or equal to maximum queue size (%d)', $maxExportBatchSize, $maxQueueSize));
        }

        $this->exporter = $exporter;
        $this->clock = isset($clock) ? $clock : ClockFactory::getDefault();
        $this->maxQueueSize = $maxQueueSize;
        $this->scheduledDelayNanos = $scheduledDelayMillis * 1000000;
        $this->maxExportBatchSize = $maxExportBatchSize;
        $this->autoFlush = $autoFlush;

        $this->queue = new SplQueue();
        $this->flush = new SplQueue();
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

        if ($this->queueSize === $this->maxQueueSize) {
            return;
        }

        $this->queueSize++;
        $this->batch[] = $span->toSpanData();
        $this->nextScheduledRun = isset($this->nextScheduledRun) ? $this->nextScheduledRun : $this->clock->now() + $this->scheduledDelayNanos;

        if (count($this->batch) === $this->maxExportBatchSize) {
            $this->enqueueBatch();
        }
        if ($this->autoFlush) {
            $this->flush();
        }
    }

    public function forceFlush($cancellation = null)
    {
        if ($this->closed) {
            return false;
        }

        return $this->flush(__FUNCTION__, $cancellation);
    }

    public function shutdown($cancellation = null)
    {
        if ($this->closed) {
            return false;
        }

        $this->closed = true;

        return $this->flush(__FUNCTION__, $cancellation);
    }

    private function flush($flushMethod = null, $cancellation = null)
    {
        if ($flushMethod !== null) {
            $flushId = $this->batchId + $this->queue->count() + (int)(bool)$this->batch;
            $this->flush->enqueue([$flushId, $flushMethod, $cancellation, !$this->running]);
        }

        if ($this->running) {
            return false;
        }

        $success = true;
        $exception = null;
        $this->running = true;

        try {
            for (; ;) {
                while (!$this->flush->isEmpty() && $this->flush->bottom()[0] <= $this->batchId) {
                    $arrayResult = $this->flush->dequeue();
                    $flushMethod = $arrayResult[0];
                    $cancellation = $arrayResult[1];
                    $propagateResult = $arrayResult[2];

                    try {
                        $result = $this->exporter->$flushMethod($cancellation);
                        if ($propagateResult) {
                            $success = $result;
                        }
                    } catch (Throwable $e) {
                        if ($propagateResult) {
                            $exception = $e;

                            continue;
                        }
                        self::logError(sprintf('Unhandled %s error', $flushMethod), ['exception' => $e]);
                    }
                }

                if (!$this->shouldFlush()) {
                    break;
                }

                if ($this->queue->isEmpty()) {
                    $this->enqueueBatch();
                }
                $batchSize = count($this->queue->bottom());
                $this->batchId++;

                try {
                    $this->exporter->export($this->queue->dequeue())->await();
                } catch (Throwable $e) {
                    self::logError('Unhandled export error', ['exception' => $e]);
                } finally {
                    $this->queueSize -= $batchSize;
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

    private function shouldFlush()
    {
        return !$this->flush->isEmpty()
            || $this->autoFlush && !$this->queue->isEmpty()
            || $this->autoFlush && $this->nextScheduledRun !== null && $this->clock->now() > $this->nextScheduledRun;
    }

    private function enqueueBatch()
    {
        assert($this->batch !== []);

        $this->queue->enqueue($this->batch);
        $this->batch = [];
        $this->nextScheduledRun = null;
    }
}
