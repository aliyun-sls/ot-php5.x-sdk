<?php

use OpenTelemetry\API\Trace\Propagation\TraceContextPropagator;
use OpenTelemetry\Context\Propagation\ArrayAccessGetterSetter;
use OpenTelemetry\Context\Propagation\SanitizeCombinedHeadersPropagationGetter;
use OpenTelemetry\SDK\Trace\SpanExporter\SlsSdkSpanExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;

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

// 将 headers 中的内容传递给下游服务
$traceID = $span->getContext()->getTraceId();
$getter = new SanitizeCombinedHeadersPropagationGetter(new ArrayAccessGetterSetter());
// 下游服务从 headers 中获取 traceparent
$extractedContext = $traceCtxPropagator->extract($headers, $getter);
// 下游服务创建 span，并设置父 spanContext
$span = $tracer->spanBuilder("extracted span")->setParent($extractedContext)->startSpan();

$tracerProvider->shutdown();
