<?php

/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedNamespaceInspection */
/** @phan-file-suppress PhanUndeclaredClassReference */
/** @phan-file-suppress PhanUndeclaredClassCatch */
/** @phan-file-suppress PhanUndeclaredClassMethod */
/** @phan-file-suppress PhanUndeclaredMethod */



namespace OpenTelemetry\Context;

use FFI;
use FFI\Exception;

class ZendObserverFiber
{
    protected static $fibers = null;

    public function isEnabled()
    {
        return (
            PHP_VERSION_ID >= 80100 &&
            (in_array(getenv('OTEL_PHP_FIBERS_ENABLED'), ['true', 'on', '1'])) &&
            class_exists(FFI::class)
        );
    }

    /**
     * @psalm-suppress UndefinedClass
     */
    public function init()
    {
        if (null === self::$fibers) {
            try {
                $fibers = FFI::scope('OTEL_ZEND_OBSERVER_FIBER');
            } catch (Exception $e) {
                try {
                    $fibers = FFI::load(__DIR__ . '/fiber/zend_observer_fiber.h');
                } catch (Exception $e) {
                    return false;
                }
            }
            $fibers->zend_observer_fiber_init_register(fiber_init_register_callable); //@phpstan-ignore-line
            $fibers->zend_observer_fiber_switch_register(fiber_switch_register_callable); //@phpstan-ignore-line
            $fibers->zend_observer_fiber_destroy_register(fiber_destroy_register_callable); //@phpstan-ignore-line
            self::$fibers = $fibers;
        }

        return true;
    }


    private function fiber_init_register_callable($initializing){
        return Context::storage()->fork($initializing);
    }

    private function fiber_switch_register_callable($from, $to){
        return Context::storage()->switch($to);
    }

    private function fiber_destroy_register_callable($destroying){
        returnContext::storage()->destroy($destroying);
    }
}
