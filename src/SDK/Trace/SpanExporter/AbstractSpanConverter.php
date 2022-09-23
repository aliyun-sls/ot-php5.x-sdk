<?php

namespace OpenTelemetry\SDK\Trace\SpanExporter;

use OpenTelemetry\API\Trace\SpanContextInterface;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\SDK\Resource\ResourceInfo;
use OpenTelemetry\SDK\Trace\EventInterface;
use OpenTelemetry\SDK\Trace\LinkInterface;
use OpenTelemetry\SDK\Trace\SpanConverterInterface;
use OpenTelemetry\SDK\Trace\StatusDataInterface;

abstract class AbstractSpanConverter implements SpanConverterInterface
{
    const NAME_ATTR = 'name';
    const CONTEXT_ATTR = 'context';
    const TRACE_ID_ATTR = 'trace_id';
    const SPAN_ID_ATTR = 'span_id';
    const TRACE_STATE_ATTR = 'trace_state';
    const RESOURCE_ATTR = 'resource';
    const PARENT_SPAN_ATTR = 'parent_span_id';
    const KIND_ATTR = 'kind';
    const START_ATTR = 'start';
    const END_ATTR = 'end';
    const ATTRIBUTES_ATTR = 'attributes';
    const STATUS_ATTR = 'status';
    const CODE_ATTR = 'code';
    const DESCRIPTION_ATTR = 'description';
    const EVENTS_ATTR = 'events';
    const TIMESTAMP_ATTR = 'timestamp';
    const LINKS_ATTR = 'links';

    /**
     * @param SpanContextInterface $context
     * @return array
     */
    protected function convertContext($context)
    {
        return [
            self::TRACE_ID_ATTR => $context->getTraceId(),
            self::SPAN_ID_ATTR => $context->getSpanId(),
            self::TRACE_STATE_ATTR => (string)$context->getTraceState(),
        ];
    }

    /**
     * @param ResourceInfo $resource
     * @return array
     */
    protected function convertResource($resource)
    {
        return $resource->getAttributes()->toArray();
    }

    /**
     * @param SpanContextInterface $context
     * @return string
     */
    protected function covertParentContext($context)
    {
        return $context->isValid() ? $context->getSpanId() : '';
    }

    /**
     * Translates SpanKind from its integer representation to a more human friendly string.
     *
     * @param int $kind
     * @return string
     */
    protected function convertKind($kind)
    {
        return array_flip(
            (new \ReflectionClass(SpanKind::class))
                ->getConstants()
        )[$kind];
    }

    /**
     * @param \OpenTelemetry\SDK\Common\Attribute\AttributesInterface $attributes
     * @return array
     */
    protected function convertAttributes($attributes)
    {
        return $attributes->toArray();
    }

    /**
     * @param StatusDataInterface $status
     * @return array
     */
    protected function covertStatus($status)
    {
        return [
            self::CODE_ATTR => $status->getCode(),
            self::DESCRIPTION_ATTR => $status->getDescription(),
        ];
    }

    /**
     * @param array<EventInterface> $events
     * @return array
     */
    protected function convertEvents($events)
    {
        $result = [];

        foreach ($events as $event) {
            $result[] = [
                self::NAME_ATTR => $event->getName(),
                self::TIMESTAMP_ATTR => $event->getEpochNanos(),
                self::ATTRIBUTES_ATTR => $this->convertAttributes($event->getAttributes())
            ];
        }

        return $result;
    }

    /**
     * @param array<LinkInterface> $links
     * @return array
     */
    protected function convertLinks($links)
    {
        $result = [];

        foreach ($links as $link) {
            $result[] = [
                "traceID" => $link->getContext()->getTraceId(),
                "spanID" => $this->convertContext($link->getSpanContext()),
                self::ATTRIBUTES_ATTR => $this->convertAttributes($link->getAttributes())
            ];
        }

        return $result;
    }
}