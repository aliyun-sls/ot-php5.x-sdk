<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace\SpanContext;
use Exception;

class RandomIdGenerator implements IdGeneratorInterface
{
    const TRACE_ID_HEX_LENGTH = 32;
    const SPAN_ID_HEX_LENGTH = 16;

    public function generateTraceId()
    {
        do {
            $traceId = $this->randomHex(self::TRACE_ID_HEX_LENGTH);
        } while (!SpanContext::isValidTraceId($traceId));

        return $traceId;
    }

    public function generateSpanId()
    {
        do {
            $spanId = $this->randomHex(self::SPAN_ID_HEX_LENGTH);
        } while (!SpanContext::isValidSpanId($spanId));

        return $spanId;
    }

    /**
     * @psalm-suppress ArgumentTypeCoercion $hexLength is always a positive integer
     */
    private function randomHex($hexLength)
    {
        try {
            return bin2hex(random_bytes((int)floor(abs($hexLength/2))));
        } catch (Throwable $e) {
            return $this->fallbackAlgorithm($hexLength);
        }
    }

    private function fallbackAlgorithm($hexLength)
    {
        return substr(str_shuffle(str_repeat('0123456789abcdef', $hexLength)), 1, $hexLength);
    }
}
