<?php

namespace OpenTelemetry\API\Trace;

use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ImplicitContextKeyedInterface;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#span-operations
 */
interface SpanInterface extends ImplicitContextKeyedInterface
{
    /**
     * Returns the {@see SpanInterface} from the provided *$context*,
     * falling back on {@see SpanInterface::getInvalid()} if there is no span in the provided context.
     */
    public static function fromContext($context);

    /**
     * Returns the current {@see SpanInterface} from the current {@see Context},
     * falling back on {@see SpanInterface::getEmpty()} if there is no span in the current context.
     */
    public static function getCurrent();

    /**
     * Returns an invalid {@see SpanInterface} that is used when tracing is disabled, such s when there is no available SDK.
     */
    public static function getInvalid();

    /**
     * Returns a non-recording {@see SpanInterface} that hold the provided *$spanContext* but has no functionality.
     * It will not be exported and al tracing operations are no-op, but can be used to propagate a valid {@see SpanContext} downstream.
     *
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#wrapping-a-spancontext-in-a-span
     */
    public static function wrap($spanContext);

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#get-context
     */
    public function getContext();

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#isrecording
     */
    public function isRecording();

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#set-attributes
     * Adding attributes at span creation is preferred to calling SetAttribute later, as samplers can only consider information
     * already present during span creation
     * @param non-empty-string $key
     * @param bool|int|float|string|array|null $value Note: the array MUST be homogeneous, i.e. it MUST NOT contain values of different types.
     */
    public function setAttribute($key, $value);

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#set-attributes
     */
    public function setAttributes($attributes);

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#add-events
     */
    public function addEvent($name, $attributes = [], $timestamp = null);

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#record-exception
     */
    public function recordException($exception, $attributes = []);

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#updatename
     *
     * @param non-empty-string $name
     */
    public function updateName($name);

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#set-status
     *
     * @psalm-param StatusCode::STATUS_* $code
     */
    public function setStatus($code, $description = null);

    /**
     * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#end
     */
    public function end($endEpochNanos = null);
}
