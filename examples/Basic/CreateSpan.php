<?php

use OpenTelemetry\SDK\Common\Attribute\Attributes;
use OpenTelemetry\SDK\Resource\ResourceInfo;
use OpenTelemetry\SDK\Trace\Sampler\AlwaysOnSampler;
use OpenTelemetry\SDK\Trace\Sampler\ParentBased;
use OpenTelemetry\SDK\Trace\SpanExporter\SlsSdkSpanExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\BatchSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;

$accessKeyId = getenv('ACCESS_KEY_ID');
$accessSec = getenv('ACCESS_SEC');
$project = getenv('PROJECT');
$logstore = getenv('LOGSTORE');

$Exporter = new SlsSdkSpanExporter("cn-beijing.log.aliyuncs.com", $project, $logstore, $accessKeyId, $accessSec);
$tracerProvider = new TracerProvider(new BatchSpanProcessor($Exporter), new ParentBased(new AlwaysOnSampler()),
    ResourceInfo::create(Attributes::create(['service.name' => 'test'])));
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