<?php

namespace OpenTelemetry\SDK\Common\Attribute;

use Countable;
use Traversable;

interface AttributesInterface extends Traversable, Countable
{
    public function has($name);

    public function get($name);

    public function getDroppedAttributesCount();

    public function toArray();
}
