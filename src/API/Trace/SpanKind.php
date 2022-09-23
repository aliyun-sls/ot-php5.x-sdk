<?php



namespace OpenTelemetry\API\Trace;

/**
 * @see https://github.com/open-telemetry/opentelemetry-specification/blob/v1.6.1/specification/trace/api.md#spankind
 */
final class SpanKind
{
    const KIND_INTERNAL = 0;
    const KIND_CLIENT = 1;
    const KIND_SERVER = 2;
    const KIND_PRODUCER = 3;
    const KIND_CONSUMER = 4;

    public static function getChoices()
    {
        return [
            self::KIND_INTERNAL,
            self::KIND_CLIENT,
            self::KIND_SERVER,
            self::KIND_PRODUCER,
            self::KIND_CONSUMER,
        ];
    }

    private function __construct()
    {
    }

    public static function convertToString($kind){
        switch ($kind){
            case 0 :
                return "internal";
            case 1:
                return "client";
            case 2:
                return "server";
            case 3:
                return "producer";
            case 4:
                return "consumer";
            default:
                return "unknown";
        }
    }
}
