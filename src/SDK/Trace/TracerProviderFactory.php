<?php


namespace OpenTelemetry\SDK\Trace;

use Exception;
use OpenTelemetry\SDK\Behavior\LogsMessagesTrait;

final class TracerProviderFactory
{
    use LogsMessagesTrait;

    private $exporterFactory;
    private $samplerFactory;
    private $spanProcessorFactory;

    public function __construct($name, $samplerFactory, $spanProcessorFactory, $exporterFactory)
    {
        $this->exporterFactory = $exporterFactory;
        $this->samplerFactory = $samplerFactory;
        $this->spanProcessorFactory = $spanProcessorFactory;
    }

    public function create()
    {
        try {
            $exporter = $this->exporterFactory->fromEnvironment();
        } catch (Exception $t) {
            self::logWarning('Unable to create exporter', ['exception' => $t]);
            $exporter = null;
        }

        try {
            $sampler = $this->samplerFactory->fromEnvironment();
        } catch (Exception $t) {
            self::logWarning('Unable to create sampler', ['exception' => $t]);
            $sampler = null;
        }

        try {
            $spanProcessor = $this->spanProcessorFactory->fromEnvironment($exporter);
        } catch (Exception $t) {
            self::logWarning('Unable to create span processor', ['exception' => $t]);
            $spanProcessor = null;
        }

        return new TracerProvider(
            $spanProcessor,
            $sampler
        );
    }
}
