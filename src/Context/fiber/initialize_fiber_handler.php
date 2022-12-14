<?php

/** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
/** @phan-file-suppress PhanUndeclaredClassReference */



namespace OpenTelemetry\Context;

use Fiber;

if (!class_exists(Fiber::class)) {
    return;
}

$observer = new ZendObserverFiber();

if ($observer->isEnabled() && $observer->init()) {
    // ffi fiber support enabled
} else {
    Context::setStorage(new FiberBoundContextStorage(Context::storage()));
}
