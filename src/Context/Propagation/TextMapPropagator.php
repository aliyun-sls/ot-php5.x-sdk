<?php



namespace OpenTelemetry\Context\Propagation;

if (!function_exists('array_key_first')) {
    function array_key_first(array $arr) {
        foreach($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}
use function count;

final class TextMapPropagator
{
    public static function composite(...$propagators)
    {
        switch (count($propagators)) {
            case 0:
                return NoopTextMapPropagator::getInstance();
            case 1:
                /** @psalm-suppress PossiblyNullArrayOffset */
                return $propagators[array_key_first($propagators)];
            default:
               return new MultiTextMapPropagator($propagators);
        }
    }

    private function __construct()
    {
    }
}
