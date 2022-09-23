<?php

namespace OpenTelemetry\SDK\Behavior;

use OpenTelemetry\SDK\Common\Log\LoggerHolder;
use Psr\Log\LogLevel;

trait LogsMessagesTrait
{
    private static function doLog($level, $message, $context)
    {
        $context['source'] = get_called_class();
        LoggerHolder::get()->log($level, $message, $context);
    }

    protected static function logDebug($message, $context = [])
    {
        self::doLog(LogLevel::DEBUG, $message, $context);
    }

    protected static function logInfo($message, $context = [])
    {
        self::doLog(LogLevel::INFO, $message, $context);
    }

    protected static function logNotice($message, $context = [])
    {
        self::doLog(LogLevel::NOTICE, $message, $context);
    }

    protected static function logWarning($message, $context = [])
    {
        self::doLog(LogLevel::WARNING, $message, $context);
    }

    protected static function logError($message, $context = [])
    {
        self::doLog(LogLevel::ERROR, $message, $context);
    }
}
