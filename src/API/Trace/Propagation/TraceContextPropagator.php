<?php


namespace OpenTelemetry\API\Trace\Propagation;

use function count;
use function explode;
use function hexdec;
use OpenTelemetry\API\Trace\AbstractSpan;
use OpenTelemetry\API\Trace\SpanContext;
use OpenTelemetry\API\Trace\SpanContextInterface;
use OpenTelemetry\API\Trace\TraceState;
use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\Propagation\ArrayAccessGetterSetter;
use OpenTelemetry\Context\Propagation\PropagationGetterInterface;
use OpenTelemetry\Context\Propagation\PropagationSetterInterface;
use OpenTelemetry\Context\Propagation\TextMapPropagatorInterface;

/**
 * TraceContext is a propagator that supports the W3C Trace Context format
 * (https://www.w3.org/TR/trace-context/)
 *
 * This propagator will propagate the traceparent and tracestate headers to
 * guarantee traces are not broken. It is up to the users of this propagator
 * to choose if they want to participate in a trace by modifying the
 * traceparent header and relevant parts of the tracestate header containing
 * their proprietary information.
 */
final class TraceContextPropagator implements TextMapPropagatorInterface
{
    const TRACEPARENT = 'traceparent';
    const TRACESTATE = 'tracestate';
    const VERSION = '00'; // Currently, only '00' is supported

    const FIELDS = [
        self::TRACEPARENT,
        self::TRACESTATE,
    ];

    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /** {@inheritdoc} */
    public function fields()
    {
        return self::FIELDS;
    }

    /** {@inheritdoc} */
    public function inject(&$carrier, $setter = null, $context = null)
    {
        $setter = isset($setter) ? $setter : ArrayAccessGetterSetter::getInstance();
        $context = isset($context) ? $context : Context::getCurrent();
        $spanContext = AbstractSpan::fromContext($context)->getContext();

        if (!$spanContext->isValid()) {
            return;
        }

        // Build and inject the traceparent header
        $traceparent = self::VERSION . '-' . $spanContext->getTraceId() . '-' . $spanContext->getSpanId() . '-' . ($spanContext->isSampled() ? '01' : '00');
        $setter->set($carrier, self::TRACEPARENT, $traceparent);
        // Build and inject the tracestate header
        // Spec says to avoid sending empty tracestate headers
        if (($tracestate = (string)$spanContext->getTraceState()) !== '') {
            $setter->set($carrier, self::TRACESTATE, $tracestate);
        }
    }

    /** {@inheritdoc} */
    public function extract($carrier, $getter = null, $context = null)
    {
        $getter = isset($setter) ? $setter : ArrayAccessGetterSetter::getInstance();
        $context = isset($context) ? $context : Context::getCurrent();

        $spanContext = self::extractImpl($carrier, $getter);
        if (!$spanContext->isValid()) {
            return $context;
        }

        return $context->withContextValue(AbstractSpan::wrap($spanContext));
    }

    private static function extractImpl($carrier, PropagationGetterInterface $getter)
    {
        $traceparent = $getter->get($carrier, self::TRACEPARENT);
        if ($traceparent === null) {
            return SpanContext::getInvalid();
        }

        // traceParent = {version}-{trace-id}-{parent-id}-{trace-flags}
        $pieces = explode('-', $traceparent);

        // If the header does not have at least 4 pieces, it is invalid -- restart the trace.
        if (count($pieces) < 4) {
            return SpanContext::getInvalid();
        }

        $version = $pieces[0];
        $traceId = $pieces[1];
        $spanId = $pieces[2];
        $traceFlags = $pieces[3];

        /**
         * Return invalid if:
         * - Version is invalid (not 2 char hex or 'ff')
         * - Trace version, trace ID, span ID or trace flag are invalid
         */
        if (!SpanContext::isValidTraceVersion($version)
            || !SpanContext::isValidTraceId($traceId)
            || !SpanContext::isValidSpanId($spanId)
            || !SpanContext::isValidTraceFlag($traceFlags)
        ) {
            return SpanContext::getInvalid();
        }

        // Return invalid if the trace version is not a future version but still has > 4 pieces.
        $versionIsFuture = hexdec($version) > hexdec(self::VERSION);
        if (count($pieces) > 4 && !$versionIsFuture) {
            return SpanContext::getInvalid();
        }

        // Only the sampled flag is extracted from the traceFlags (00000001)
        $convertedTraceFlags = hexdec($traceFlags);
        $isSampled = ($convertedTraceFlags & SpanContext::SAMPLED_FLAG) === SpanContext::SAMPLED_FLAG;

        // Tracestate = 'Vendor1=Value1,...,VendorN=ValueN'
        $rawTracestate = $getter->get($carrier, self::TRACESTATE);
        if ($rawTracestate !== null) {
            $tracestate = new TraceState($rawTracestate);

            return SpanContext::createFromRemoteParent(
                $traceId,
                $spanId,
                $isSampled ? SpanContextInterface::TRACE_FLAG_SAMPLED : SpanContextInterface::TRACE_FLAG_DEFAULT,
                $tracestate
            );
        }

        // Only traceparent header is extracted. No tracestate.
        return SpanContext::createFromRemoteParent(
            $traceId,
            $spanId,
            $isSampled ? SpanContextInterface::TRACE_FLAG_SAMPLED : SpanContextInterface::TRACE_FLAG_DEFAULT
        );
    }
}
