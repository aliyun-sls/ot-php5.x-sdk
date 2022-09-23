<?php



namespace OpenTelemetry\API\Trace;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#set-status
 */
final class StatusCode
{
    const STATUS_UNSET = 'Unset';
    const STATUS_OK = 'Ok';
    const STATUS_ERROR = 'Error';

    public function getChoices()
    {
        return [
            self::STATUS_UNSET,
            self::STATUS_OK,
            self::STATUS_ERROR,
        ];
    }

    private function __construct()
    {
    }
}
