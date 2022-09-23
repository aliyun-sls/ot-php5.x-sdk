<?php


namespace OpenTelemetry\SDK\Common\Attribute;

interface AttributesFactoryInterface
{
    public function builder($attributes = []);
}
