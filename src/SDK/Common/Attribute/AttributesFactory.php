<?php

namespace OpenTelemetry\SDK\Common\Attribute;

/**
 * @internal
 */
final class AttributesFactory implements AttributesFactoryInterface
{
    private $attributeCountLimit;
    private $attributeValueLengthLimit;

    public function __construct($attributeCountLimit = null, $attributeValueLengthLimit = null)
    {
        $this->attributeCountLimit = $attributeCountLimit;
        $this->attributeValueLengthLimit = $attributeValueLengthLimit;
    }

    public function builder($attributes = [])
    {
        $builder = new AttributesBuilder(
            [],
            $this->attributeCountLimit,
            $this->attributeValueLengthLimit,
            0
        );
        foreach ($attributes as $key => $value) {
            $builder[$key] = $value;
        }

        return $builder;
    }
}
