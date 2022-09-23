<?php

namespace OpenTelemetry\SDK\Trace\SpanExporter;

use OpenTelemetry\SDK\Common\Future\CompletedFuture;
use OpenTelemetry\SDK\Trace\SpanExporterInterface;

class SlsSdkSpanExporter implements SpanExporterInterface
{

    private $project;
    private $logstore;
    private $client;
    private $running = true;
    private $converter;


    public function __construct($endpointUrl = null, $project = null, $logstore = null, $accessKeyId = null, $accessKey = null, $token = "")
    {
        $endpoint = isset($endpointUrl) ? $endpointUrl : getenv("OTEL_EXPORTER_OTLP_ENDPOINT");
        $this->project = isset($project) ? $project : getenv("SLS_PROJECT");
        $this->logstore = isset($logstore) ? $logstore : getenv("SLS_LOGSTORE");
        $akId = isset($accessKeyId) ? $accessKeyId : getenv("SLS_ACCESS_KEY_ID");
        $ak = isset($accessKey) ? $accessKey : getenv("SLS_ACCESS_KEY");
        $this->client = new \Aliyun_Log_Client($endpoint, $akId, $ak, $token);
        $this->converter = new SLSSpanConverter();
    }

    public static function fromConnectionString($endpointUrl, $name, $args)
    {
        return "SLS_SPAN_EXPORTER($endpointUrl)";
    }

    public function export($spans, $cancellation = null)
    {
        return new CompletedFuture($this->doExport($spans));
    }

    public function doExport($spans)
    {
        $logitems = $this->converter->convert($spans);
        if (count($logitems) > 0) {
            $request = new \Aliyun_Log_Models_PutLogsRequest($this->project, $this->logstore, "", "", $logitems);
            $this->client->putLogs($request);
        }
        return SpanExporterInterface::STATUS_SUCCESS;
    }

    public function shutdown($cancellation = null)
    {
        $this->running = false;
        return true;
    }

    public function forceFlush($cancellation = null)
    {
        return true;
    }
}