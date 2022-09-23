<?php



namespace OpenTelemetry\SDK\Trace;

use OpenTelemetry\API\Trace as API;
use OpenTelemetry\SDK\Common\Future\CancellationInterface;

interface TracerProviderInterface extends API\TracerProviderInterface
{
    public function forceFlush($cancellation = null);

    public function shutdown($cancellation = null);
}
