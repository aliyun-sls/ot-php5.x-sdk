<?php

namespace OpenTelemetry\SDK\Common\Attribute;

use IteratorAggregate;
use function array_key_exists;

final class Attributes implements IteratorAggregate
{
    private $attributes;
    private $droppedAttributesCount;

    /**
     * @internal
     */
    public function __construct($attributes = [], $droppedAttributesCount = null)
    {
        $this->attributes = $attributes;
        $this->droppedAttributesCount = $droppedAttributesCount;
    }

    public static function create($attributes)
    {
        return self::factory()->builder($attributes)->build();
    }

    public static function factory($attributeCountLimit = null, $attributeValueLengthLimit = null)
    {
        return new AttributesFactory($attributeCountLimit, $attributeValueLengthLimit);
    }

    public function has($name)
    {
        return array_key_exists($name, $this->attributes);
    }

    public function get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /** @psalm-mutation-free */
    public function count()
    {
        return \count($this->attributes);
    }

    public function getIterator()
    {
        foreach ($this->attributes as $key => $value) {
            yield (string)$key => $value;
        }
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function getDroppedAttributesCount()
    {
        return $this->droppedAttributesCount;
    }
}
