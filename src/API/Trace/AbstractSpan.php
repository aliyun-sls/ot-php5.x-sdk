<?php


namespace OpenTelemetry\API\Trace;

use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\ScopeInterface;

abstract class AbstractSpan implements SpanInterface
{
    private static $invalidSpan = null;

    /** @inheritDoc */
    final public static function fromContext($context)
    {
        if ($span = $context->get(SpanContextKey::instance())) {
            return $span;
        }

        return NonRecordingSpan::getInvalid();
    }

    /** @inheritDoc */
    final public static function getCurrent()
    {
        return self::fromContext(Context::getCurrent());
    }

    /** @inheritDoc */
    final public static function getInvalid()
    {
        if (null === self::$invalidSpan) {
            self::$invalidSpan = new NonRecordingSpan(SpanContext::getInvalid());
        }

        return self::$invalidSpan;
    }

    /** @inheritDoc */
    final public static function wrap($spanContext)
    {
        if (!$spanContext->isValid()) {
            return self::getInvalid();
        }

        return new NonRecordingSpan($spanContext);
    }

    /** @inheritDoc */
    final public function activate()
    {
        return Context::getCurrent()->withContextValue($this)->activate();
    }

    /** @inheritDoc */
    final public function storeInContext($context)
    {
        return $context->with(SpanContextKey::instance(), $this);
    }
}
