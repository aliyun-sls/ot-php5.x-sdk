<?php

namespace OpenTelemetry\SDK\Common\Attribute;

use ArrayAccess;

interface AttributesBuilderInterface extends ArrayAccess
{
    public function build();
}
