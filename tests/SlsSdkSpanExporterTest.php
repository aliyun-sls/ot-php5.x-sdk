<?php

use OpenTelemetry\API\SpanKind;
use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\Context\Context;
use OpenTelemetry\Context\Propagation\ArrayAccessGetterSetter;
use OpenTelemetry\Context\Propagation\SanitizeCombinedHeadersPropagationGetter;
use OpenTelemetry\SDK\Trace\SpanExporter\SlsSdkSpanExporter;
use OpenTelemetry\SDK\Trace\SpanExporterInterface;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\TestCase;

final class SlsSdkSpanExporterTest extends TestCase
{
    function testEmptySpanExporter()
    {
        $accessKeyId = getenv('ACCESS_KEY_ID');
        $accessSec = getenv('ACCESS_SEC');
        $project = getenv('PROJECT');
        $logstore = getenv('LOGSTORE');
        $spans = array();
        $spanExporter = new SlsSdkSpanExporter("cn-beijing.log.aliyuncs.com", $project, $logstore, $accessKeyId, $accessSec);
        $response = $spanExporter->doExport($spans);
        $this->assertEquals(SpanExporterInterface::STATUS_SUCCESS, $response);
    }

    function testSpanExporter()
    {
        $accessKeyId = getenv('ACCESS_KEY_ID');
        $accessSec = getenv('ACCESS_SEC');
        $project = getenv('PROJECT');
        $logstore = getenv('LOGSTORE');

        $Exporter = new SlsSdkSpanExporter("cn-beijing.log.aliyuncs.com", $project, $logstore, $accessKeyId, $accessSec);
        $tracerProvider = new TracerProvider(new SimpleSpanProcessor($Exporter));
        $tracer = $tracerProvider->getTracer('io.opentelemetry.contrib.php');
        $span = $tracer
            ->spanBuilder('get-user')
            ->setAttribute('db.system', 'mysql')
            ->setAttribute('db.name', 'users')
            ->setAttribute('db.user', 'some_user')
            ->setAttribute('db.statement', 'select * from users where username = :1')
            ->startSpan();
        usleep((int)(0.3 * 1e6));
        $span->setStatus(StatusCode::STATUS_OK)->end();
        $tracerProvider->shutdown();
    }


    function testInjectAndExtract()
    {
        $accessKeyId = getenv('ACCESS_KEY_ID');
        $accessSec = getenv('ACCESS_SEC');
        $project = getenv('PROJECT');
        $logstore = getenv('LOGSTORE');

        $Exporter = new SlsSdkSpanExporter("cn-beijing.log.aliyuncs.com", $project, $logstore, $accessKeyId, $accessSec);
        $tracerProvider = new TracerProvider(new SimpleSpanProcessor($Exporter));
        $tracer = $tracerProvider->getTracer('io.opentelemetry.contrib.php');
        $span = $tracer
            ->spanBuilder('get-user')
            ->setAttribute('db.system', 'mysql')
            ->setAttribute('db.name', 'users')
            ->setAttribute('db.user', 'some_user')
            ->setAttribute('db.statement', 'select * from users where username = :1')
            ->startSpan();

        $headers = [];

        $traceCtxPropagator = TraceContextPropagator::getInstance();
        $context = $span->storeInContext(Context::getCurrent());
        $traceCtxPropagator->inject($headers, null, $context);

        self::assertArrayHasKey("traceparent", $headers);

        $traceID = $span->getContext()->getTraceId();
        $getter = new SanitizeCombinedHeadersPropagationGetter(new ArrayAccessGetterSetter());
        $extractedContext = $traceCtxPropagator->extract($headers, $getter);
        $span = $tracer->spanBuilder("extracted span")->setParent($extractedContext)->startSpan();

        self::assertEquals($traceID, $span->getParentContext()->getTraceId());
        $tracerProvider->shutdown();
    }
}