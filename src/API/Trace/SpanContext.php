<?php


namespace OpenTelemetry\API\Trace;

use OpenTelemetry\API\Trace as API;
use function strlen;
use function strtolower;

final class SpanContext implements API\SpanContextInterface
{
    const INVALID_TRACE = '00000000000000000000000000000000';
    const TRACE_VERSION_REGEX = '/^(?!ff)[\da-f]{2}$/';
    const VALID_TRACE = '/^[0-9a-f]{32}$/';
    const TRACE_LENGTH = 32;
    const INVALID_SPAN = '0000000000000000';
    const VALID_SPAN = '/^[0-9a-f]{16}$/';
    const SPAN_LENGTH = 16;
    const SPAN_LENGTH_BYTES = 8;
    const SAMPLED_FLAG = 1;
    const TRACE_FLAG_LENGTH = 2;

    private static $invalidContext = null;

    /** @inheritDoc */
    public static function createFromRemoteParent($traceId, $spanId, $traceFlags = self::TRACE_FLAG_DEFAULT, $traceState = null)
    {
        return new self(
            $traceId,
            $spanId,
            $traceFlags,
            true,
            $traceState
        );
    }

    /** @inheritDoc */
    public static function create($traceId, $spanId, $traceFlags = self::TRACE_FLAG_SAMPLED, $traceState = null)
    {
        return new self(
            $traceId,
            $spanId,
            $traceFlags,
            false,
            $traceState
        );
    }

    /** @inheritDoc */
    public static function getInvalid()
    {
        if (null === self::$invalidContext) {
            self::$invalidContext = self::create(self::INVALID_TRACE, self::INVALID_SPAN, 0);
        }

        return self::$invalidContext;
    }

    /**
     * @param string $traceVersion
     * @return bool Returns a value that indicates whether a trace version is valid.
     */
    public static function isValidTraceVersion($traceVersion)
    {
        return 1 === preg_match(self::TRACE_VERSION_REGEX, $traceVersion);
    }

    /**
     * @return bool Returns a value that indicates whether a trace id is valid
     */
    public static function isValidTraceId($traceId)
    {
        return ctype_xdigit($traceId) && strlen($traceId) === self::TRACE_LENGTH && $traceId !== self::INVALID_TRACE && $traceId === strtolower($traceId);
    }

    /**
     * @return bool Returns a value that indicates whether a span id is valid
     */
    public static function isValidSpanId($spanId)
    {
        return ctype_xdigit($spanId) && strlen($spanId) === self::SPAN_LENGTH && $spanId !== self::INVALID_SPAN && $spanId === strtolower($spanId);
    }

    /**
     * @return bool Returns a value that indicates whether trace flag is valid
     * TraceFlags must be exactly 1 bytes (1 char) representing a bit field
     */
    public static function isValidTraceFlag($traceFlag)
    {
        return ctype_xdigit($traceFlag) && strlen($traceFlag) === self::TRACE_FLAG_LENGTH;
    }

    /**
     * @see https://www.w3.org/TR/trace-context/#trace-flags
     * @see https://www.w3.org/TR/trace-context/#sampled-flag
     */
    private $isSampled;

    private $traceId;
    private $spanId;
    private $traceState;
    private $isValid;
    private $isRemote;
    private $traceFlags;

    private function __construct($traceId, $spanId, $traceFlags, $isRemote, $traceState = null)
    {
        // TraceId must be exactly 16 bytes (32 chars) and at least one non-zero byte
        // SpanId must be exactly 8 bytes (16 chars) and at least one non-zero byte
        if (!self::isValidTraceId($traceId) || !self::isValidSpanId($spanId)) {
            $traceId = self::INVALID_TRACE;
            $spanId = self::INVALID_SPAN;
        }

        $this->traceId = $traceId;
        $this->spanId = $spanId;
        $this->traceState = $traceState;
        $this->isRemote = $isRemote;
        $this->isSampled = ($traceFlags & self::SAMPLED_FLAG) === self::SAMPLED_FLAG;
        $this->traceFlags = $traceFlags;
        $this->isValid = self::isValidTraceId($this->traceId) && self::isValidSpanId($this->spanId);
    }

    public function getTraceId()
    {
        return $this->traceId;
    }

    public function getSpanId()
    {
        return $this->spanId;
    }

    public function getTraceState()
    {
        return $this->traceState;
    }

    public function isSampled()
    {
        return $this->isSampled;
    }

    public function isValid()
    {
        return $this->isValid;
    }

    public function isRemote()
    {
        return $this->isRemote;
    }

    public function getTraceFlags()
    {
        return $this->traceFlags;
    }
}
