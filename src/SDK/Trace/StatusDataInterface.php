<?php



namespace OpenTelemetry\SDK\Trace;

interface StatusDataInterface
{
    public static function ok();

    public static function error();

    public static function unset0();

    public function getCode();

    public function getDescription();
}
