<?php

namespace OpenTelemetry\SDK\Common\Attribute;

use function array_key_exists;
use function count;
use function is_array;
use function is_string;
use function mb_substr;

/**
 * @internal
 */
final class AttributesBuilder implements AttributesBuilderInterface
{
    private $attributes;
    private $attributeCountLimit;
    private $attributeValueLengthLimit;
    private $droppedAttributesCount;

    public function __construct($attributes, $attributeCountLimit, $attributeValueLengthLimit, $droppedAttributesCount)
    {
        $this->attributes = $attributes;
        $this->attributeCountLimit = $attributeCountLimit;
        $this->attributeValueLengthLimit = $attributeValueLengthLimit;
        $this->droppedAttributesCount = $droppedAttributesCount;
    }

    public function build()
    {
        return new Attributes($this->attributes, $this->droppedAttributesCount);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->attributes);
    }

    /**
     * @phan-suppress PhanUndeclaredClassAttribute
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->attributes[$offset]) ? $this->attributes[$offset] : null;
    }

    /**
     * @phan-suppress PhanUndeclaredClassAttribute
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            return;
        }
        if ($value === null) {
            unset($this->attributes[$offset]);

            return;
        }
        if (count($this->attributes) === $this->attributeCountLimit && !array_key_exists($offset, $this->attributes)) {
            $this->droppedAttributesCount++;

            return;
        }

        $this->attributes[$offset] = $this->normalizeValue($value);
    }

    /**
     * @phan-suppress PhanUndeclaredClassAttribute
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    private function normalizeValue($value)
    {
        if (is_string($value) && $this->attributeValueLengthLimit !== null) {
            return mb_substr($value, 0, $this->attributeValueLengthLimit);
        }

        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $processed = $this->normalizeValue($v);
                if ($processed !== $v) {
                    $value[$k] = $processed;
                }
            }

            return $value;
        }

        return $value;
    }
}
