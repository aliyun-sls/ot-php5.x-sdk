<?php


namespace OpenTelemetry\SDK\Trace\SpanExporter;

use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\SDK\Trace\SpanDataInterface;

class SLSSpanConverter extends AbstractSpanConverter
{

    public function convert($spans)
    {
        $aggregate = [];
        foreach ($spans as $span) {
            $aggregate[] = $this->convertSpan($span);
        }

        return $aggregate;
    }

    /**
     * friendlySpan does the heavy lifting converting a span into an array
     *
     * @param SpanDataInterface $span
     * @return array
     */
    private function convertSpan($span)
    {
        $logItem = new \Aliyun_Log_Models_LogItem();
        $logItem->setTime(time());
        $logItem->setContents($this->convertSpanContent($span));
        return $logItem;
    }

    private function convertSpanContent($span)
    {
        return [
            "traceID" => $span->getContext()->getTraceId(),
            self::NAME_ATTR => $span->getName(),
            "parentSpanID" => $this->covertParentContext($span->getParentContext()),
            self::KIND_ATTR => SpanKind::convertToString($span->getKind()),
            "spanID" => $this->covertParentContext($span->getContext()),
            self::START_ATTR => sprintf('%.0f',$span->getStartEpochMicroSecond()),
            self::END_ATTR => sprintf('%.0f',$span->getEndEpochEpochMicroSecond()),
            "duration" => sprintf('%.0f',($span->getEndEpochEpochMicroSecond() - $span->getStartEpochMicroSecond())),
            "statusCode" => $span->getStatus()->getCode(),
            "service" => $span->getResource()->getAttributes()->get("service.name") !== null ? $span->getResource()->getAttributes()->get("service.name"): "Your Application",
            self::RESOURCE_ATTR => json_encode($this->convertResource($span->getResource())),
            "attribute" => json_encode($this->convertAttributes($span->getAttributes())),
            self::EVENTS_ATTR => json_encode($this->convertEvents($span->getEvents())),
            self::LINKS_ATTR => json_encode($this->convertLinks($span->getLinks()))
        ];
    }
}
